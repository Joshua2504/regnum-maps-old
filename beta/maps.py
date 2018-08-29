#!/usr/bin/python
import os
__dir__ = os.path.dirname(__file__)
import sys
sys.path += [__dir__]
from include import Map
from include import DB
from include import UI

def index():
	return main()

def main(err = None):
	DB.cursor.execute("SELECT * FROM map")
	maps = DB.cursor.fetchall()
	
	page = UI.get_template('page')

	pagevars = {}
	pagevars['title'] = "Maps - Index"
	pagevars['dir'] = "../"
	pagevars['style'] = ''
	pagevars['tag'] = 'mapindex'
	pagevars['content'] = ''
	
	if err == 404:
		pagevars['content'] += '<p class="error">No such map</p>'
	if err == 'nomap':
		pagevars['content'] += '<p class="error">Please select a map</p>'

	if any(maps):
		pagevars['content'] += '\n<ul class="links">';
		for map in maps:
			template = '\n<li><a href="showmap?map=%(tag)s">%(name)s <span class="extra">%(description)s</span></a></li>'
			pagevars['content'] += template % map
		pagevars['content'] += '\n</ul>'

	return page % pagevars

def showmap(req,map = None,**opts):
	DB.cursor.execute("SELECT * FROM map WHERE tag = %s",(map,))
	info = DB.cursor.fetchone()

	if opts == None:
		opts = {}

	if map == None:
		return main('nomap');
	if info == None:
		return main(404);
	
	labeltypes = Map.get_types(info['tag'])
	labels = Map.fetchlabels(info['tag'])

	for type in labeltypes:
		if opts.has_key(type) != True or opts[type] in ['true','yes','on',True]:
			opts[type] = True;
		else:
			opts[type] = False

	opts = dict([(type,(opts[type],'checkbox')) for type in labeltypes])
	
	optform = """\
	<form action="" method="get" id="mapopts">
	<fieldset><legend>Options</legend>

	</fieldset>""";

	pagevars = {}
	pagevars['title'] = info['name']
	pagevars['dir'] =  "../";
	pagevars['tag'] = info['tag']
	pagevars['style'] = """\
		body,html { background:black; }
		#mapbox {
			width:%(sizex)dpx;
			height:%(sizey)dpx;
		}
""" % info
	pagevars['content'] = """\
	<!--[if IE]><p class="error">This page is not supported in your browser. Please consider upgrading to firefox or opera.</p><[endif]-->"""
	pagevars['content'] += """\
	<div id="mapbox">
		<a class="homelink" href=".">Map index</a>
		<img src="/stuff/regnum/beta/images/map/%(tag)s.jpg" alt="%(description)s" class="map">
		<img src="/stuff/regnum/beta/images/map/%(tag)s-overlay.png" alt="" class="overlay">
	""" % info

	# Styles
	for label in labels:
		pagevars['style'] += label.css()
		if label.type in ['fort','city']:
			pagevars['content'] += label.display('major');
		elif label.type in ['area','landmark']:
			pagevars['content'] += label.display('minor');
		elif label.type in ['npc','altar','teleport','market']:
			pagevars['content'] += label.display('icon');

	pagevars['content'] += "</div>"

	page = UI.get_template('page');
	return page % pagevars
	
