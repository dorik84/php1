CLIENT
+get_id
+get_fname
+get_lname
+get_email
+get_phone
+get_address
+get_city
+get_province
+get_postal
+get_dob

+set_id(string)
+set_fname(string)
+set_lname(string)
+set_email(string)
+set_phone(string)
+set_address(string)
+set_city(string)
+set_province(string)
+set_postal(string)
+set_dob(string)

-validate(string)
+hasErrors()
+reset_client()
+get_client_array()

==========================
ClientManager

+errors:array
+message:string
-_tbl_name:string
-_tbl_name_auth:string
-_sql:string
-_conn: mysqli
+client: Client
+file: File
+login_info: LoginPassword
+newsLetter: NewsLetter


+show_msg ()
+hasErrors()
+create_tbl()
+create_tbl_auth()
+add_one_client()
+get_client_from_POST ()
+get_client_from_ARRAY (array)
+show_birthday_people ()
+show_client_byID (string)
+delete_by_ID (string)
+get_client_by_ID (string)
+export_clients_db ()
+show_db()
+import_db_from_file (string)
+authenticate()
+update_by_ID(string)
+create_account ()
+send_news_letter()

===================
FILE


-errors:array
-file_name:string
-new_file_name:string
-file_size:int
-file_tmp:string
-file_type:string
-file_error:string
-file_ext:string

+hasErrors()
+file_check()
+safe_file()
===================
LoginPassword

+errors:array
-_email:string
-_password:string

+get_email()
+get_password()
+set_email(string)
+set_password(string)

-validate(string)
+hasErrors() 
===================
NewsLetter

+errors:array
-_subject:string    
-_msg:string


+get_subject()
+get_msg()
+set_subject(string)
+set_msg(string)

-validate(string)
+hasErrors()


