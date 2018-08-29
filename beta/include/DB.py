import MySQLdb
import MySQLdb.cursors

db = MySQLdb.connect(reconnect=1,user="regnum",passwd="ROL MySQL P4SS",db="regnum",cursorclass=MySQLdb.cursors.DictCursor)
cursor = db.cursor()
