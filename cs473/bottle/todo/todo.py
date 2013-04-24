import sqlite3
from bottle import route, run, debug, template, request, validate, static_file, error, Bottle
from bottle.ext import sqlite
from pprint import pprint

app = Bottle()
plugin = sqlite.Plugin(dbfile='todo.db')
app.install(plugin)

@app.route('/')
@app.route('/todo')
def todo_list(db):
	result = db.execute("SELECT id, task FROM todo WHERE status LIKE '1'").fetchall()
	if result:
		return template('make_table', rows=result, status='open')
	return HTTPError(404, "Tasks not found")

@app.route('/rss')
def rss(db):
	result = db.execute("SELECT id, task FROM todo WHERE status LIKE '1'").fetchall()
	if result:
		return template('rss.xml', rows=result)
	return HTTPError(404, "Tasks not found")

@app.route('/completed')
def completed(db):
	result = db.execute("SELECT id, task FROM todo WHERE status LIKE '0'").fetchall()
	if result:
		return template('make_table', rows=result, status='closed')
	return HTTPError(404, "Tasks not found")

@app.route('/new')
def new():
	return template('new_task')

@app.route('/new', method='POST')
def new_item(db):
	if request.headers.get('Content-Type') == 'application/json':
		body = request.json
		new = body['task']
	else:
		new = request.forms.get('task')
	r = db.execute("INSERT INTO todo (task,status) VALUES (?,?)", (new,1))
	new_id = r.lastrowid
	db.commit()

	return '''<p>The new task was inserted into the database, theID is %s</p>
			<a href="/">ToDo List</a>''' % new_id

@app.route('/edit/<no:re:(\d+)>')
def edit(no, db):
	result = db.execute("SELECT task,status FROM todo WHERE id LIKE ?", [str(no)]).fetchone()
	if result:
		return template('edit_task', old=result[0], open=result[1], no=no)
	return HTTPError(404, "Task not found")

@app.route('/edit/<no:re:(\d+)>', method='POST')
def edit_item(no, db):
	
	if request.headers.get('Content-Type') == 'application/json':
		pprint('In the right place!')
		body = request.json
		edit = body['task']
		status = body['status']
		pprint(body)
	else:
		edit = request.forms.get('task')
		status = request.forms.get('status')

	if status == 'open':
		status = 1
	else:
		status = 0

	db.execute("UPDATE todo SET task = ?, status = ? WHERE id LIKE ?", [edit,status,no])
	db.commit()
	return '''<p>The item number %s was successfully updated</p>
			<a href="/">ToDo List</a>''' % no

@app.route("/item/<item:re:(\d+)>")
def show_item(item, db):
	result = db.execute("SELECT task FROM todo WHERE id LIKE ?", [item]).fetchall()
	if not result:
		return 'This item number does not exist!'
	else:
		return 'Task: %s' % result[0][0]

@app.route('/help')
def help():
	return static_file('help.html', root='.')

@app.route('/json/<json:re:(\d+)>')
def show_json(json, db):
	result = db.execute("SELECT task FROM todo WHERE id LIKE ?", [json]).fetchall()

	if not result:
		return {'task': 'This item number does not exist!'}
	else:
		return {'Task': result[0][0]}

@app.error(403)
def mistake403(code):
	return 'The parameter you passed has the wrong format!'

@app.error(404)
def mistake404(code):
	return 'Sorry, this page does not exist!'

debug(True)
app.run(reloader=True)