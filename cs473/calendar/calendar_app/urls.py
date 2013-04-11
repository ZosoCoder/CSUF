from django.conf.urls import patterns, include, url

# Uncomment the next two lines to enable the admin:
from django.contrib import admin
admin.autodiscover()

urlpatterns = patterns('',
    # Examples:
    url(r'^admin/', include(admin.site.urls)),   
    url(r'^admin/doc/', include('django.contrib.admindocs.urls')), 
    (r"", include('cal.urls', namespace='cal')),
)
