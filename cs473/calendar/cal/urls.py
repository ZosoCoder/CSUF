from django.conf.urls import *
from cal.models import *
from django.core.urlresolvers import reverse

urlpatterns = patterns('cal.views',

    url(r"^(\d+)/(\d+)/(\d+)/week", "week"),    
    url(r'^week$', "week", name='week'),

    url(r'^day$', "day", name='day'),
    url(r"^(\d+)/(\d+)/(\d+)$", "day"),

    url(r'^event$', "event", name='event'),
    url(r"^(\d+)/(\d+)/(\d+)/(\w+(?:_\w+)+)$", "event", name='event'),

    url(r'^month$', "month", name='month'),
    url(r"^month/(?P<year>\d+)/(?P<month>\d+)/$", "month"),
    url(r"^month/(?P<year>\d+)/(?P<month>\d+)/(prev|next)/$", "month"),
    url(r"^(\d+)/(\d+)", "month"),

    url(r'^year$', "year", name='year'),
    url(r"^(\d+)$", "year", name='year'),
    

    url(r'^week/(?P<year>\d+)/(?P<month>\d+)/(?P<day>\d+)/$', "week", name='week'),   
    
    url(r"", "year"),
    
)
