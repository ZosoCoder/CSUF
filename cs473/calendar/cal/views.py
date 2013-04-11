import time
from calendar import HTMLCalendar
from datetime import date, datetime, timedelta

from django.core.urlresolvers import reverse
from django.contrib.auth.decorators import login_required
from django.http import HttpResponseRedirect, HttpResponse
from django.shortcuts import get_object_or_404, render_to_response
from django.core.context_processors import csrf
from django.forms.models import modelformset_factory
from pprint import pprint

from django.shortcuts import render

from cal.models import *

mnames = "January February March April May June July August September October November December"
mnames = mnames.split()
days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']

from itertools import groupby
from django.utils.html import conditional_escape as esc
from django.utils.safestring import mark_safe

class WorkoutCalendar(HTMLCalendar):

    globalyear = 0
    globalmonth = 0

    def __init__(self, entries, year, month):
        super(WorkoutCalendar, self).__init__()
        self.entries = self.group_by_day(entries)
        self.setfirstweekday(6)
        global globalyear, globalmonth
        globalyear = year
        globalmonth = month

    def formatday(self, day, weekday):
        if day != 0:
            cssclass = self.cssclasses[weekday]
            if date.today() == date(self.year, self.month, day):
                cssclass += ' today'
            if date(self.year, self.month, day) in self.entries:
                cssclass += ' filled'
                body = ['<ul>']
                for entry in self.entries[date(self.year, self.month, day)]:
                    body.append('<li>')
                    body.append('<a href="/%d/%d/%d/%s">' % (self.year,self.month,day,entry.title.replace(' ','_')))
                    body.append(esc(entry.title))
                    body.append('</a></li>')
                body.append('</ul>')
                return self.day_cell(cssclass, '%d %s' % (day, ''.join(body)), day)
            return self.day_cell(cssclass, day, day)
        return self.day_cell('noday', '&nbsp;', day)

    def formatmonth(self, year, month):
        self.year, self.month = year, month
        return super(WorkoutCalendar, self).formatmonth(year, month)

    def group_by_day(self, entries):
        field = lambda entry: entry.date
        return dict([(day, list(items)) for day, items in groupby(entries, field)])

    def day_cell(self, cssclass, body, day):
        return '<td class="%s"><a href="/%d/%d/%d">%s</a></td>' % (cssclass, globalyear, globalmonth, day, body)

    
def year(request, year=None, month=None, day=None):
    if year: year = int(year)
    else:    year = time.localtime()[0]
    
    if month: month = int(month)
    else:    month = time.localtime()[1]
    
    if day: day = int(day)
    else: day = time.localtime()[2]       
    
    ent = Entry.objects.order_by('date').filter(date__year=year)
    entrydict = {}
    for m in mnames:
        entrydict[m] = ent.filter(date__month=(mnames.index(m)+1))
    cal = ''
    for m in mnames:
        cal += '<div class="monthdiv"><span class="monthlabel"><a href="/%d/%d">%s</a></span>' % (year,mnames.index(m)+1,m)
        cal += '<ul>'
        for e in entrydict[m]:
            cal += '<li><a href="/%d/%d/%d/%s">' % (year,mnames.index(m)+1,e.date.timetuple()[2],e.title.replace(' ','_'))
            cal += '%02d | %s</a></li>' % (e.date.timetuple()[2], e.title)
        cal += '</ul></div><br>'
    return render(request, 'cal/year.html', {   'year' : year,
                                                'month': month,
                                                'day': day,
                                                'calendar': mark_safe(cal),     
                                            })

def month(request, year=None, month=None, day=None, change=None):
    if year: year = int(year)
    else:    year = time.localtime()[0]
    
    if month: month = int(month)
    else:    month = time.localtime()[1]
    
    if day: day = int(day)
    else: day = time.localtime()[2]    

    dayindex = date(year,month,1)

    prev = dayindex - timedelta(days=2)
    next = dayindex + timedelta(days=32)
    
    entries = Entry.objects.order_by('date').filter(date__year=year, date__month=month)
    cal = WorkoutCalendar(entries, year, month).formatmonth(year, month)
    l = cal.split('\n')
    header = l[1]
    header = header[:17] + '5' + header[18:]
    prev_link = '''<th colspan="1"><a href="/%i/%i/">&lt;&lt; Prev</a></th>''' % (prev.timetuple()[0], prev.timetuple()[1])
    next_link = '''<th colspan="1"><a href="/%i/%i/">Next &gt;&gt;</a></th>''' % (next.timetuple()[0], next.timetuple()[1])
    header = header[:4] + prev_link + header[4:len(header)-5] + next_link + header[len(header)-5:]
    header.replace('%%','%')
    l[1] = header
    cal = '\n'.join(l)
    return render(request, 'cal/month.html', {  'calendar': mark_safe(cal),
                                                'year':year,
                                                'month': month,
                                                'day' : day,
                                                'monthstring' : mnames[month-1] 
                                            })
    
    
def week(request, year=None, month=None, day=None, change=None):    
    if year: year = int(year)
    else: year = time.localtime()[0]

    if month: month = int(month)
    else: month = time.localtime()[1]

    if day: day = int(day)
    else: day = time.localtime()[2]
    
    daynum = day

    if change in ('next', 'prev'):
        day, wdelta = date(year,month,day), timedelta(days=7)
        if change == 'next': mod = wdelta
        elif change == 'prev': mod = -wdelta
        day = day + wdelta
    else:
        day = date(year,month,day)
    prev = day - timedelta(days=7)
    next = day + timedelta(days=7)
    sun = day - timedelta(days=day.weekday()+1)
    sat = sun + timedelta(days=6)
    week = 'Week of %s - %s' % (str(sun).replace('-','/'), str(sat).replace('-','/'))
    calendar = '<tr><th>%s<br>' % (days[0])
    calendar += '<a href="/%d/%d/%d">%s %i</a></th>' % (sun.timetuple()[0], sun.timetuple()[1], sun.timetuple()[2], \
                                                  mnames[sun.timetuple()[1]-1][:3], sun.timetuple()[2])
    for i in range(1,6):
        day = sun + timedelta(days=i)
        calendar += '<th>%s<br>' % (days[i])
        calendar += '<a href="/%d/%d/%d">%s %i</a></th>' % (day.timetuple()[0], day.timetuple()[1], day.timetuple()[2], \
                                                            mnames[day.timetuple()[1]-1][:3], day.timetuple()[2])
    calendar += '<th>%s<br>' % (days[6])
    calendar += '<a href="/%d/%d/%d">%s %i</a></th>' % (sat.timetuple()[0], sat.timetuple()[1], sat.timetuple()[2], \
                                                       mnames[sat.timetuple()[1]-1][:3], sat.timetuple()[2])
    calendar += '</tr><tr>'
    entries = Entry.objects.filter(date__range=[sun,sat])
    field = lambda entry: entry.date
    entries = dict([(day, list(items)) for day, items in groupby(entries, field)])
    for i in range(7):
        day = sun + timedelta(days=i)
        if day in entries:
            calendar += '<td class="filled"><ul>'
            for entry in entries[day]:
                calendar += '<li><a href="/%d/%d/%d/%s">' % (year,month,day.timetuple()[2],entry.title.replace(' ','_'))
                calendar += esc(entry.title) + '</a></li>'
            calendar += '</ul></td>'
        else:
            calendar += '<td></td>'
    calendar += '</tr>'

    return render(request, 'cal/week.html', {   'calendar': mark_safe(calendar),
                                                'year':year,
                                                'month': month,
                                                'day' : daynum, 
                                                'curr_week': week,
                                                'prevyear': prev.timetuple()[0],
                                                'prevmonth': prev.timetuple()[1],
                                                'prevday': prev.timetuple()[2],
                                                'nextyear': next.timetuple()[0],
                                                'nextmonth': next.timetuple()[1],
                                                'nextday': next.timetuple()[2] 
                                            })
    
def day(request, year=None, month=None, day=None):
    if year: year = int(year)
    else:    year = time.localtime()[0]
    
    if month: month = int(month)
    else:    month = time.localtime()[1]
    
    if day: day = int(day)
    else:   day = time.localtime()[2]
    
    if day == 1:        dayString = "1st"
    elif day == 2:      dayString = "2nd"
    elif day == 3:      dayString = "3rd"
    else:               dayString = str(day) + "th" 
    
    #Week day returns Sunday=6, are array of days has Sunday=0.  We can fix this by adding 8 and moding by 7.
    weekDay = days[((datetime(year, month, day).weekday())+8)%7]
    
    prevDay = datetime(year, month, day) - timedelta(days=1)
    nextDay = datetime(year, month, day) + timedelta(days=1)
    prevlink = '/%i/%i/%i' % (prevDay.year, prevDay.month, prevDay.day)
    nextlink = '/%i/%i/%i' % (nextDay.year, nextDay.month, nextDay.day)

    entries = Entry.objects.order_by('date').filter(date__year=year, date__month=month, date__day=day)
    
    
    return render(request, 'cal/day.html', {    'entries' : entries,
                                                'year':year,
                                                'month': month,
                                                'monthString' : mnames[month-1],
                                                'day' : day, 
                                                'dayString' : dayString,
                                                'weekDay' : weekDay,
                                                'prevlink' : prevlink,
                                                'nextlink' : nextlink,
                                                 
                                            }) 

def event(request, year=None, month=None, day=None, event=None):
    if year: year = int(year)
    else:    year = time.localtime()[0]
    
    if month: month = int(month)
    else:    month = time.localtime()[1]
    
    if day: day = int(day)
    else:   day = time.localtime()[2]
    pprint('Hello There!')
    event=event.replace('_', ' ')
    pprint(event)
    ent = Entry.objects.order_by('date').filter(title=event)
    
    if day == 1:        dayString = "1st"
    elif day == 2:      dayString = "2nd"
    elif day == 3:      dayString = "3rd"
    else:               dayString = str(day) + "th" 
    
    if year: year = int(year)
    else:    year = time.localtime()[0]
    
    return render(request, 'cal/event.html', {  'entries' : ent,
                                                'year':year,
                                                'month': month,
                                                'monthString' : mnames[month-1],
                                                'day' : day, 
                                                'dayString' : dayString,
                                                'event' : event
                                            }) 