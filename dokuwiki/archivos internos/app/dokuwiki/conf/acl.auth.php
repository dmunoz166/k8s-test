# That tells you that people who aren't registered 
#can read, but not write (@ALL = 1). People who have 
#registered (users) can read, edit, and create new pages (4).
#And, members of the admins group, which includes your superuser, 
#can do everything that's possible in dokuwiki (255). And all of 
#this applies to everything in your wiki instance, as designated by the *.*/
*    @ALL    1
*    @user    4
*    @admins    255
