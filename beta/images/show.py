from PIL import Image
from cStringIO import StringIO
import os

os.chdir(os.path.dirname(__file__))

def index(req,image,**opts):
	dir = './'

	s = StringIO()
	types = ['gif','jpg','png']

	# Open image
	img = Image.open(dir+image);

	# Default size 
	size = list(img.size)

	if opts.has_key('width'):
		size[0] = int(opts['width'])
	if opts.has_key('height'):
		size[1] = int(opts['height'])

	size = tuple(size)
	# Scale image 
	if size != img.size:
		img.thumbnail(size,Image.ANTIALIAS)

	format = img.format
	if opts.has_key('format') and opts['format'] in types:
		format = opts['format']

	if format == 'jpg':
		format = 'jpeg'

	img.save(s,format)

	req.content_type = 'image/'+format
	img = s.getvalue()
	s.close()
	return img
