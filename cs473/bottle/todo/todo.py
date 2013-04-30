from bottle import debug, template, request, static_file, Bottle
from bottle.ext import redis
from pprint import pprint
from urllib2 import HTTPError

app = Bottle()
#plugin = sqlite.Plugin(dbfile='todo.db')
plugin = redis.RedisPlugin(host='localhost')
app.install(plugin)

@app.route('/')
@app.route('/todo')
def todo_list(rdb):
    result = rdb.lrange('tasks', -1, -1)
    if len(result) == 1:
        tasks = {}
        last_id = int(result[0]) + 1
        for i in range(1, last_id):
            task = rdb.hmget('tasks:%s' % i, 'title', 'status')
            pprint(task)
            if task[1] == 'open':
                tasks[i] = task
        return template('make_table', tasks=tasks, status='open')
    return HTTPError(404, "Tasks not found")

@app.route('/rss')
def rss(rdb):
    result = rdb.lrange('tasks', -1, -1)
    if len(result) == 1:
        tasks = {}
        last_id = int(result[0]) + 1
        for i in range(1, last_id):
            tasks[i] = rdb.hmget('tasks:%s' % i, 'title', 'status')
        return template('rss.xml', tasks=tasks)
    return HTTPError(404, "Tasks not found")

@app.route('/completed')
def completed(rdb):
    result = rdb.lrange('tasks', -1, -1)
    if len(result) == 1:
        tasks = {}
        last_id = int(result[0]) + 1
        for i in range(1, last_id):
            task = rdb.hmget('tasks:%s' % i, 'title', 'status')
            if task[1] == 'closed':
                tasks[i] = task
        return template('make_table', tasks=tasks, status='closed')
    return HTTPError(404, "Tasks not found")

@app.route('/new')
def new():
    return template('new_task')

@app.route('/new', method='POST')
def new_item(rdb):
    if request.headers.get('Content-Type') == 'application/json':
        body = request.json
        new = body['task']
    else:
        new = request.forms.get('task')

    result = rdb.lrange('tasks', -1, -1)
    new_id = 1
    if len(result) == 1:
        new_id = int(result[0]) + 1
    rdb.rpush('tasks', str(new_id))
    rdb.hmset('tasks:%d' % (new_id), {'title': new, 'status': 'open'})

    return '''<p>The new task was inserted into the database, theID is %s</p>
            <a href="/">ToDo List</a>''' % new_id

@app.route('/edit/<no:re:(\d+)>')
def edit(no, rdb):
    result = rdb.hmget('tasks:%s' % no, 'title', 'status')
    if result[1] is not None:
        return template('edit_task', old=result[0], open=result[1], no=no)
    return HTTPError(404, "Task not found")

@app.route('/edit/<no:re:(\d+)>', method='POST')
def edit_item(no, rdb):
    if request.headers.get('Content-Type') == 'application/json':
        pprint('In the right place!')
        body = request.json
        edit = body['task']
        status = body['status']
        pprint(body)
    else:
        edit = request.forms.get('task')
        status = request.forms.get('status')

    rdb.hmset('tasks:%s' % no, {'title': edit, 'status': status})

    return '''<p>The item number %s was successfully updated</p>
            <a href="/">ToDo List</a>''' % no

@app.route("/item/<item:re:(\d+)>")
def show_item(item, rdb):
    max_id = int(rdb.lrange('tasks', -1, -1)[0])
    if (int(item) <= max_id) and (int(item) > 0):
        result = rdb.hmget('tasks:%s' % item, 'title')
        return 'Task: %s' % result[0]
    return 'This item number does not exist!'

@app.route('/help')
def help():
    return static_file('help.html', root='.')

@app.route('/json/<json:re:(\d+)>')
def show_json(json, rdb):
    max_id = int(rdb.lrange('tasks', -1, -1)[0])
    if (int(json) <= max_id) and (int(json) > 0):
        result = rdb.hmget('tasks:%s' % json, 'title')
        return {'Task': result[0]}
    return {'Task': 'This item number does not exist!'}

@app.error(403)
def mistake403(code):
    return 'The parameter you passed has the wrong format!'

@app.error(404)
def mistake404(code):
    return 'Sorry, this page does not exist!'

debug(True)
app.run(reloader=True)
