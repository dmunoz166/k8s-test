<?php

$conf['title'] = 'HTP3 Wiki';
$conf['lang'] = 'en';
$conf['license'] = 'cc-by-sa';
$conf['useacl'] = 1;
$conf['superuser'] = '@admin';
$conf['disableactions'] = 'register';

$conf['authtype'] = 'authpdo';
$conf['passcrypt'] = 'smd5';

$conf['plugin']['authpdo']['debug']='1';
$conf['plugin']['authpdo']['dsn']='mysql:host=service-dokuwiki-db;dbname=dokuwikidb;charset=utf8';
$conf['plugin']['authpdo']['user']=dokuuser;
$conf['plugin']['authpdo']['pass']='secretpassword';

#  This statement is used to grant or deny access to the wiki
$conf['plugin']['authpdo']['select-user']='
SELECT  login    AS user
       ,name
       ,pass     AS hash
       ,mail
       ,id              AS uid
  FROM user
  WHERE login = :user
';

# This statement is used to get all groups a user is member of
$conf['plugin']['authpdo']['select-user-groups']='
SELECT groups.group AS `group`
  FROM member JOIN groups
       ON member.gid = groups.id
  WHERE member.uid = :uid
';

# This statement takes no place holders. It should return all groups currently available in the database.
$conf['plugin']['authpdo']['select-groups']='
SELECT id AS gid,
           `group`
  FROM groups
';

/* This statement should add a user to the database. Minimum information
 * to store are: login name, password, email address and full name.*/
$conf['plugin']['authpdo']['insert-user']='
INSERT INTO user (login, pass, name, mail)
     VALUES (:user, :hash, :name, :mail)
';

# This statement should remove a user fom the database.
$conf['plugin']['authpdo']['delete-user']='
DELETE FROM user WHERE id = :uid
';

# This statement is used to list and optionally filter the user list in the user manager.
$conf['plugin']['authpdo']['list-users']='
SELECT DISTINCT login AS user
  FROM user   AS U,
         member AS M,
         groups  AS G
 WHERE U.id  = M.uid
     AND M.gid = G.id
     AND G.`group` LIKE :group
     AND U.login LIKE :user
     AND U.name  LIKE :name
     AND U.mail  LIKE :mail
ORDER BY login
   LIMIT :start,:limit
';

/* This is similar to 'list-users' and should handle the same input, but instead of returning
 a list of users it should return only the number of users matching the given filter.*/
 $conf['plugin']['authpdo']['count-users']='
SELECT COUNT(DISTINCT login) AS count
  FROM user   AS U,
       member AS M,
       groups  AS G
 WHERE U.id  = M.uid
   AND M.gid = G.id
   AND G.group LIKE :group
   AND U.login LIKE :user
   AND U.name  LIKE :name
   AND U.mail  LIKE :mail
';

# This statement updates the login name of a single user.
$conf['plugin']['authpdo']['update-user-login']='
UPDATE user
   SET login = :newlogin
 WHERE id    = :uid
';

# This statement updates the profile information of a single user.
$conf['plugin']['authpdo']['update-user-info']='
UPDATE user
   SET name = :name,
       mail = :mail
 WHERE id   = :uid
';

# This statement updates the password of a single user.
$conf['plugin']['authpdo']['update-user-pass']='
UPDATE user
   SET pass = :hash
 WHERE id   = :uid
';

# This statement updates the password of a single user.
$conf['plugin']['authpdo']['insert-group']='
INSERT INTO groups (`group`)
     VALUES (:group)
';

# This statement updates the password of a single user.
$conf['plugin']['authpdo']['join-group']='
INSERT INTO member (uid, gid)
     VALUES (:uid, :gid)
';

# This statement removes a user from a group.
$conf['plugin']['authpdo']['leave-group']='
DELETE FROM member
      WHERE uid = :uid
        AND gid = :gid
';
