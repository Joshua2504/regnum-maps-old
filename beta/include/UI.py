import os
os.chdir(os.path.dirname(__file__))

rootpath = '/home/kiirani/www/public_html'
rooturl = 'http://www.kiirani.com/'
imgdir = '/stuff/regnum/beta/images'
templatedir = '/stuff/regnum/beta/templates'

def get_template(tname):
	file = rootpath+templatedir+'/'+tname
	f = open(file)
	return f.read()
	
