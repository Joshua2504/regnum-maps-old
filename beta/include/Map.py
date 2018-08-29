import DB 
import os
import re
import random
import UI
os.chdir(os.path.dirname(__file__))

def fetchlabels(map):
	DB.cursor.execute("""SELECT * FROM label WHERE map = %s""",(map,))
	results = DB.cursor.fetchall()

	labels = []

	for label in results:
		labels += [ Label( label['labeltext'], label['type'], \
		    label['objid'], label['posx'], label['posy'] ) ];

	return labels
		
def get_types(map):
	DB.cursor.execute("""SELECT type FROM label WHERE map = %s GROUP BY type""",(map,))
	results = DB.cursor.fetchall()

	types = []
	for type in results:
		types += type['type']
	return types

class Label:
	# A lot of the functions in here should have parts moved to the UI
	# module
	def __init__(self,text,type,typeid,posx,posy):
		DB.cursor.execute("""SELECT * FROM `%s` WHERE id = %d LIMIT 1""" % (type,typeid))
		info = DB.cursor.fetchone();

		# Shuffle names around 
		if not info.has_key('name'):
			info['name'] = '';

		if len(info['name']) == 0 and info.has_key('nickname'):
			info['name'] = info['nickname']

		if len(text) == 0:
			text = info['name']

		# Set the given args
		self.text = text
		self.posx = posx
		self.posy = posy

		# Set the object info
		self.type = type

		# Things all types have
		self.name = info['name']
		self.tag = info['tag']
		self.realm = info['realm']

		# Things some types have
		if info.has_key('notes'):
			self.notes = info['notes']
		else:
			self.notes = None

		if info.has_key('nickname'):
			self.nickname = info['nickname']
		else:
			self.nickname = ''

		# Things specific to one type
		if type == 'npc':
			self.coordx = info['coordx']
			self.coordy = info['coordy']
			self.profession = info['profession']
			self.quests = int(info['quests'])

		if type == "teleport":
			self.coordx = info['coordx']
			self.coordy = info['coordy']
			self.exitx = info['exitx']
			self.exity = info['exity']


	def getshots(self):
		shots = []
		os.chdir('../images')
		dir = ''
		if self.type != 'teleport':
			dir = 'screenshots/'
		dir += self.type+'/'
		if os.path.isdir(dir) == False:
			return False
		files = os.listdir(dir)
		pattern = '%s(-[\d]*)?\.(png|jpg|jpeg|gif)' % self.tag
		shots = [dir+file for file in files if re.match(pattern,file)]
		if shots == []:
			return False
		return shots


	def getextra(self):
		# Cheat function to save repeating myself
		extra = []

		# Npc specific
		if self.type == 'npc':
			extra.append("""<span class="profession">%s</span>\n"""% self.profession.title())
			extra.append("""<span class="coords">%d %d</span>\n"""
			    % (self.coordx,self.coordy))
			if self.quests > 0:
				extra['quests'].append(\
				    """<a class="quests" href="http://www.regnumzg.com.ar/index.php?option=com_rzgquests&amp;Itemid=43">Gives %d quests</a>\n"""\
					% self.quests)

		# Teleport specific
		if self.type =="teleport":
			extra.append("""<span class="coords">TP: %d %d</span>""" % (self.coordx,self.coordy))
			extra.append("""<span class="exitcoords">Exit: %d %d</span>""" % (self.exitx,self.exity))

		# Notes
		if self.notes != None and len(self.notes) > 0:
			extra.append("""<span class="notes">%s</span>""" % self.notes)

		# Images
		imgs = self.getshots()
		if imgs != False:
			alt = "A view of %s" % self.name
			if self.type == "teleport":
				alt = "Exit point of %s" % self.name
			extra.append("""<img src="%s/show.py?image=%s&amp;width=150" alt="%s">""" % (UI.imgdir,imgs[random.randrange(0,len(imgs))],alt))
		

		return extra;



	def css(self):
		info = {}
		info['type'] = self.type
		info['tag'] = self.tag
		info['posx'] = self.posx
		info['posy'] = self.posy

		css = """\
		#%(type)s-%(tag)s {
			position:absolute;
			top:%(posy)dpx;
			left:%(posx)dpx;
		}""" % info
		return css;
	
	def display(self,type,extra = True):
		info = {}
		info['type'] = self.type
		info['tag'] = self.tag
		info['text'] = self.text
		info['nickname'] = self.nickname
		info['realm'] = self.realm
		info['extra'] = '';
		# Subtypes.. For npcs == profession. May include other things in
		# future
		info['subtype'] = info['type']
		if info['type'] == 'npc':
			# Should look at a more reliable way to do this
			info['subtype'] = self.profession.lower();

		# Define extra info if the option is turned on
		if extra == True:
			extravars = []
			if type == 'icon':
				extravars.append('<span class="name">'+self.text+'</span>')
			extravars += self.getextra()
			# Fill in extra info
			if any(extravars):
				info['extra'] = '<span class="extra">\n'
				for exvar in extravars:
					info['extra'] += exvar+'\n'
				info['extra'] += '</span>'

		# Define templates for label types
		if type == 'minor':
			html = """\
	<a href="#" class="label minor %(type)s %(realm)s" id="%(type)s-%(tag)s">
		<span class="name">%(text)s</span>
		%(extra)s 
	</a>"""
		elif type == 'major':
			html = """ \
	<a href="#" class="label major %(type)s %(realm)s" id="%(type)s-%(tag)s">
		<span class="name">%(text)s</span>
		<span class="nickname">%(nickname)s</span>
		%(extra)s
	</a>"""
		elif type == 'icon':
			html = '\
	<a href="#" '
			if extra == False:
				html += 'title="%(text)s" '
			html += """class="label icon %(type)s %(realm)s" id="%(type)s-%(tag)s">
		<img src="../images/icons/%(subtype)s.png" alt="%(text)s">
		%(extra)s
	</a>"""
		else:
			return '';
		return html % info;
