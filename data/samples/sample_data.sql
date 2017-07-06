INSERT INTO `oauth_user` (identifier,username,password) VALUES ('1','alex','whisky');
INSERT INTO `oauth_scope` (identifier) VALUES ('basic'), ('email');
INSERT INTO `oauth_refresh_token` (identifier) VALUES
 ('fbebfd262b8f5a01975fc2db46879622ca1aba4d5408b4eb390b9e99d124fec4547f1e8569056ba3');
INSERT INTO `oauth_client` (identifier,secret,name,redirect_uri,is_confidential) VALUES
('myawesomeapp','$2y$10$BrpBDfblQyLYv24dNiW85uor7RybsTeSOjnN4zCiyqqQKjCKqC8IG','whisky','',0);
INSERT INTO `oauth_access_token` (identifier,expire_date,user_id) VALUES
 ('a68dba157728b3239c48d03e11ffa65d870ae3da47294e07aaf1445a7c1fe235f3397ae68cc61a61','2016-08-18 21:36:07','myawesomeapp'),
 ('d06f36d4e6d80077cba33c321bdf0bf7a69b70859804d44672511e4184fd30e8dcb9c3a0ce454f77','2016-08-18 21:55:51','myawesomeapp'),
 ('9a6d799c1ac6a8264b0a2274824f896890ed151dfaf60b33ede592f4bf76919b563c3b4ac951ef4c','2016-08-18 22:14:25','myawesomeapp');
INSERT INTO `access_token_scopes` (scope_id,access_token_scope_id) VALUES
 ('a68dba157728b3239c48d03e11ffa65d870ae3da47294e07aaf1445a7c1fe235f3397ae68cc61a61','basic'),
 ('a68dba157728b3239c48d03e11ffa65d870ae3da47294e07aaf1445a7c1fe235f3397ae68cc61a61','email'),
 ('9a6d799c1ac6a8264b0a2274824f896890ed151dfaf60b33ede592f4bf76919b563c3b4ac951ef4c','email');
