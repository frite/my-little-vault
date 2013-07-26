import MySQLdb as mdb
user=''
passwd=''
host=''
db=''

class MySQLService:
	connection=None
	cursor=None
	query=None
	result=None
	numResults=None;
	fetchedResults=None;

	def __init__(self):
		'''Do Nothing'''

	def connect(self):
		if self.db is None:
                        self.connection=_mysql.connect(host,user,passwd,db)
			self.cursor = self.connection.cursor()
			self.cursor.execute("SET NAMES UTF8")
		return self.connection
		
	def disconnect(self):
		if self.db is not None:
			self.connection.close()
	##
	
        def select(self,table=None,rows=None,where=None,order=None,limit=None):
                szQuery='SELECT '+rows+' FROM '+table
                if where is not None:
                        szQuery+=' WHERE '.where
                if order is not None:
                        szQuery+=' ORDER BY '.where
                if limit is not None:
                        szQuery+=' LIMIT '.where
                self.query=szQuery

        def insert(self,table=None,columns=None,values=None):
                szQuery='INSERT INTO '+table+' ('
                i=0
		for column in columns:
                        i+=1
                        if(i==columns.__len__()):
                                szQuery+=column
                        else:
                                szQuery+=column+','
                szQuery+=') VALUES('
                for value in values:
                        i+=1
                        if(i==values.__len__()):
                                szQuery+=value
                        else:
                                szQuery+=value+','
                self.query=szQuery

        def update(self,table=None,columns=None,values=None,where=None,limit=None):
                szQuery="UPDATE "+table+" SET "
                i=0
                for column in columns:
                        if(i==(columns.__len__()-1)):
                                szQuery+=column+"="+values[i]
                        else:
                                szQuery+=column+"="+values[i]+','
                        i+=1
                self.query=szQuery
        def delete(self,table=None,column=None,value=None):
                szQuery='DELETE FROM '+table+' WHERE '+column+'='+value;
                self.query=szQuery

        def query(self,szQuery):
                self.query=szQuery
        #
        def execute(self):
                try:
                        self.cursor.execute(self.szQuery)
                except MySQLdb.Error, e:
                    try:
                        print "MySQL Error [%d]: %s" % (e.args[0], e.args[1])
                    except IndexError:
                        print "MySQL Error: %s" % str(e)
        def numResults(self):
                self.numResults=self.cursor.rowcount
        def fetchResults(self):
                self.fetchedResults=self.cursor.fetchall()
                return self.fetchedResults
