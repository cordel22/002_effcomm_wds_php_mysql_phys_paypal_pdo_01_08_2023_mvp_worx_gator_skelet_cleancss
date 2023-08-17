
this version was downloaded straight from server, 

one needs to change the pdo and htdocs/includes/config and should

work with the hostgator server

and the hostgator needs the https, cgi-bin a vsetky extra fies

---

on localhost

wouldnt be able to add to cart with that stupid long 0000-00-00 00:00:00 error

you changed the myphp date_modified to CURRENT TIME and it works


---

however, one only can connect to hostgator database from their own server
connected to server from localhost regurgitates acces denied error:



Connection failed: SQLSTATE[HY000] [1045] Access denied for user 'vladkome_cordel'@'localhost' (using password: YES)
An error occurred in script 'C:\wamp\www\002_effcomm_php_mysql_phys_paypal_pdo_06_02_2023_mvp_worx_gator\index.php' on line
15:
Undefined variable: pdo
Array

(

    [0] => Array

        (

            [file] => C:\wamp\www\002_effcomm_php_mysql_phys_paypal_pdo_06_02_2023_mvp_worx_gator\index.php

            [line] => 15

            [function] => my_error_handler

            [args] => Array

                (

                    [0] => 8

                    [1] => Undefined variable: pdo

                    [2] => C:\wamp\www\002_effcomm_php_mysql_phys_paypal_pdo_06_02_2023_mvp_worx_gator\index.php

                    [3] => 15

                    [4] => Array

                        (

                            [_GET] => Array

                                (

                                )



                            [_POST] => Array

                                (

                                )



                            [_COOKIE] => Array

                                (

                                    [SESSION] => d9e2995f4ede828b9567ec5794ee0fbf

                                    [PHPSESSID] => d9e2995f4ede828b9567ec5794ee0fbf

                                )



                            [_SERVER] => Array

                                (

                                    [DOCUMENT_ROOT] => C:\wamp\www\002_effcomm_php_mysql_phys_paypal_pdo_06_02_2023_mvp_worx_gator

                                    [REMOTE_ADDR] => ::1

                                    [REMOTE_PORT] => 56694

                                    [SERVER_SOFTWARE] => PHP 5.6.40 Development Server

                                    [SERVER_PROTOCOL] => HTTP/1.1

                                    [SERVER_NAME] => localhost

                                    [SERVER_PORT] => 3000

                                    [REQUEST_URI] => /index.php

                                    [REQUEST_METHOD] => GET

                                    [SCRIPT_NAME] => /index.php

                                    [SCRIPT_FILENAME] => C:\wamp\www\002_effcomm_php_mysql_phys_paypal_pdo_06_02_2023_mvp_worx_gator\index.php

                                    [PHP_SELF] => /index.php

                                    [HTTP_HOST] => localhost:3000

                                    [HTTP_CONNECTION] => keep-alive

                                    [HTTP_SEC_CH_UA] => "Not_A Brand";v="99", "Microsoft Edge";v="109", "Chromium";v="109"

                                    [HTTP_SEC_CH_UA_MOBILE] => ?0

                                    [HTTP_SEC_CH_UA_PLATFORM] => "Windows"

                                    [HTTP_UPGRADE_INSECURE_REQUESTS] => 1

                                    [HTTP_USER_AGENT] => Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 Edg/109.0.1518.78

                                    [HTTP_ACCEPT] => text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9

                                    [HTTP_SEC_FETCH_SITE] => none

                                    [HTTP_SEC_FETCH_MODE] => navigate

                                    [HTTP_SEC_FETCH_USER] => ?1

                                    [HTTP_SEC_FETCH_DEST] => document

                                    [HTTP_ACCEPT_ENCODING] => gzip, deflate, br

                                    [HTTP_ACCEPT_LANGUAGE] => sk,en;q=0.9,en-GB;q=0.8,en-US;q=0.7

                                    [HTTP_COOKIE] => SESSION=d9e2995f4ede828b9567ec5794ee0fbf; PHPSESSID=d9e2995f4ede828b9567ec5794ee0fbf

                                    [REQUEST_TIME_FLOAT] => 1675708044.7903

                                    [REQUEST_TIME] => 1675708044

                                )



                            [_ENV] => Array

                                (

                                )



                            [_REQUEST] => Array

                                (

                                )



                            [_FILES] => Array

                                (

                                )



                            [path] => /index.php

                            [relativePath] => .

                            [fullPath] => C:\wamp\www\002_effcomm_php_mysql_phys_paypal_pdo_06_02_2023_mvp_worx_gator./index.php

                            [live] => 

                            [contact_email] => cordelfenevall@gmail.com

                            [page_title] => Coffee - Wouldn't You Love a Cup Right Now?

                            [e] => PDOException Object

                                (

                                    [message:protected] => SQLSTATE[HY000] [1045] Access denied for user 'vladkome_cordel'@'localhost' (using password: YES)

                                    [string:Exception:private] => 

                                    [code:protected] => 1045

                                    [file:protected] => C:\wamp\www\002_effcomm_php_mysql_phys_paypal_pdo_06_02_2023_mvp_worx_gator\pdo.php

                                    [line:protected] => 29

                                    [trace:Exception:private] => Array

                                        (

                                            [0] => Array

                                                (

                                                    [file] => C:\wamp\www\002_effcomm_php_mysql_phys_paypal_pdo_06_02_2023_mvp_worx_gator\pdo.php

                                                    [line] => 29

                                                    [function] => __construct

                                                    [class] => PDO

                                                    [type] => ->

                                                    [args] => Array

                                                        (

                                                            [0] => mysql:host=localhost;dbname=vladkome_002_effcomm_php_mysql_phys_paypal_online; charset=utf8mb4

                                                            [1] => vladkome_cordel

                                                            [2] => DoPsejMatere123!

                                                        )



                                                )



                                            [1] => Array

                                                (

                                                    [file] => C:\wamp\www\002_effcomm_php_mysql_phys_paypal_pdo_06_02_2023_mvp_worx_gator\index.php

                                                    [line] => 6

                                                    [args] => Array

                                                        (

                                                            [0] => C:\wamp\www\002_effcomm_php_mysql_phys_paypal_pdo_06_02_2023_mvp_worx_gator\pdo.php

                                                        )



                                                    [function] => require

                                                )



                                        )



                                    [previous:Exception:private] => 

                                    [errorInfo] => 

                                )



                            [select_cat_coffee] => SELECT * FROM general_coffees ORDER by category

                            [select_cat_other] => SELECT * FROM non_coffee_categories ORDER by category

                            [select_prod_coffee] => SELECT gc.description, gc.image, CONCAT('C', sc.id) AS sku,

	CONCAT_WS(' - ', s.size, sc.caf_decaf, sc.ground_whole, sc.price)

	AS name, sc.stock, sc.price, sales.price AS sale_price

	FROM specific_coffees AS sc INNER JOIN sizes

	AS s ON s.id=sc.size_id INNER JOIN general_coffees AS gc ON

	gc.id=sc.general_coffee_id 

	LEFT OUTER JOIN sales ON (sales.product_id=sc.id

	AND sales.product_type='coffee' AND

	((NOW( ) BETWEEN sales.start_date AND sales.end_date)

	OR (NOW( ) > sales.start_date AND sales.end_date IS NULL)) )

	WHERE general_coffee_id=:cat AND

	stock>0

	ORDER by name ASC

                            [select_prod_other] => SELECT ncc.description AS g_description, ncc.image AS g_image, 

	CONCAT('O', ncp.id) AS sku, ncp.name, ncp.description,

	ncp.image, ncp.price, ncp.stock, sales.price AS sale_price

	FROM non_coffee_products AS

	ncp INNER JOIN non_coffee_categories AS ncc ON

	ncc.id=ncp.non_coffee_category_id

	LEFT OUTER JOIN sales ON (sales.product_id=ncp.id

	AND sales.product_type='other' AND

	((NOW( ) BETWEEN sales.start_date AND sales.end_date) OR (NOW( ) >

		sales.start_date AND sales.end_date IS NULL)) )

	WHERE non_coffee_category_id=:cat ORDER by date_created DESC

                            [select_sale_all] => SELECT CONCAT("O", ncp.id) AS sku, sa.price AS sale_price, ncc.category,

		ncp.image, ncp.name, ncp.price, ncp.stock, ncp.description FROM sales

		AS sa INNER JOIN non_coffee_products AS ncp ON

		sa.product_id=ncp.id INNER JOIN non_coffee_categories AS ncc ON

		ncc.id=ncp.non_coffee_category_id WHERE sa.product_type="other"

		AND ((NOW( ) BETWEEN sa.start_date AND sa.end_date) OR (NOW( ) >

		sa.start_date AND sa.end_date IS NULL) )

	UNION SELECT CONCAT("C", sc.id), sa.price, gc.category, gc.image,

	CONCAT_WS(" - ", s.size, sc.caf_decaf, sc.ground_whole), sc.price,

	sc.stock, gc.description FROM sales AS sa INNER JOIN specific_coffees

	AS sc ON sa.product_id=sc.id INNER JOIN sizes AS s ON s.id=sc.size_id

	INNER JOIN general_coffees AS gc ON gc.id=sc.general_coffee_id WHERE

	sa.product_type="coffee" AND ((NOW( ) BETWEEN sa.start_date AND

	sa.end_date) OR (NOW( ) > sa.start_date AND sa.end_date IS NULL) )

                            [select_sale_nall] => (SELECT CONCAT("O", ncp.id) AS sku, sa.price AS sale_price,

		ncc.category, ncp.image, ncp.name FROM sales AS sa INNER JOIN

		non_coffee_products AS ncp ON sa.product_id=ncp.id INNER JOIN

		non_coffee_categories AS ncc ON ncc.id=ncp.non_coffee_category_id

		WHERE sa.product_type="other" AND ((NOW( ) BETWEEN sa.start_date

		AND sa.end_date) OR (NOW( ) > sa.start_date AND sa.end_date

		IS NULL) ) ORDER BY RAND( ) LIMIT 2) UNION (SELECT CONCAT("C",

		sc.id), sa.price, gc.category, gc.image, CONCAT_WS(" - ", s.size,

		sc.caf_decaf, sc.ground_whole) FROM sales AS sa INNER JOIN

		specific_coffees AS sc ON sa.product_id=sc.id INNER JOIN sizes AS s

		ON s.id=sc.size_id INNER JOIN general_coffees AS gc ON

		gc.id=sc.general_coffee_id WHERE sa.product_type="coffee" AND

		((NOW( ) BETWEEN sa.start_date AND sa.end_date) OR (NOW( ) >

		sa.start_date AND sa.end_date IS NULL) ) ORDER BY RAND( ) LIMIT 2)

                            [find_cid] => SELECT id FROM carts WHERE user_session_id=:uid AND

	product_type=:type AND product_id=:pid

                            [cart_setup] => INSERT INTO carts (user_session_id, product_type, product_id,

	quantity) VALUES (:uid, :type, :pid, :qty);

                            [cart_update] => UPDATE carts SET quantity=quantity+:qty, date_modified=NOW( )

	WHERE id=:cid

                            [remove_from_cart] => DELETE FROM carts WHERE user_session_id=:uid AND product_type=:type

		AND product_id=:pid;

                            [update_cart_some] => UPDATE carts SET quantity=:qty, date_modified=NOW( ) WHERE

	user_session_id=:uid AND product_type=:type AND product_id=:pid;

                            [update_cart_none] => DELETE FROM carts WHERE user_session_id=:uid AND product_type=:type

	AND product_id=:pid;

                            [get_shopping_cart_contents] => SELECT CONCAT('O', ncp.id) AS sku, c.quantity, ncc.category,

	ncp.name, ncp.price, ncp.stock, sales.price AS sale_price

	FROM carts AS c

	INNER JOIN non_coffee_products AS ncp ON c.product_id=ncp.id

	INNER JOIN non_coffee_categories AS ncc ON ncc.id=ncp.non_coffee_category_id

	LEFT OUTER JOIN sales ON

	(sales.product_id=ncp.id AND sales.product_type='other' AND

	((NOW( ) BETWEEN sales.start_date AND sales.end_date) OR (NOW( ) >

		sales.start_date AND sales.end_date IS NULL)) )

	WHERE c.product_type='other' AND c.user_session_id=:uid

	UNION 

	SELECT CONCAT('C', sc.id), c.quantity, gc.category,

	CONCAT_WS(' - ', s.size, sc.caf_decaf, sc.ground_whole), sc.price,

	sc.stock, sales.price

	FROM carts AS c

	INNER JOIN specific_coffees AS sc ON c.product_id=sc.id

	INNER JOIN sizes AS s ON s.id=sc.size_id

	INNER JOIN general_coffees AS gc ON gc.id=sc.general_coffee_id

	LEFT OUTER JOIN sales ON

	(sales.product_id=sc.id AND sales.product_type='coffee' AND

	((NOW( ) BETWEEN sales.start_date AND sales.end_date) OR (NOW( ) >

		sales.start_date AND sales.end_date IS NULL)) )

	WHERE c.product_type='coffee' AND c.user_session_id=:uid;

                            [remove_from_wish_list] => DELETE FROM wish_lists WHERE user_session_id=:uid AND product_type=:type

		AND product_id=:pid;

                            [wish_cid] => SELECT id FROM carts WHERE user_session_id=:uid AND

	product_type=:type AND product_id=:pid

                            [wish_setup] => INSERT INTO wish_lists (user_session_id, product_type, product_id,

	quantity) VALUES (:uid, :type, :pid, :qty);

                            [wish_update] => UPDATE wish_lists SET quantity=quantity+:qty, date_modified=NOW( )

	WHERE id=:cid

                            [update_wish_some] => UPDATE wish_lists SET quantity=:qty, date_modified=NOW( ) WHERE

	user_session_id=:uid AND product_type=:type AND product_id=:pid;

                            [update_wish_none] => DELETE FROM wish_lists WHERE user_session_id=:uid AND product_type=:type

	AND product_id=:pid;

                            [get_wish_list_contents] => SELECT CONCAT('O', ncp.id) AS sku, c.quantity, ncc.category,

	ncp.name, ncp.price, ncp.stock, sales.price AS sale_price

	FROM wish_lists AS c

	INNER JOIN non_coffee_products AS ncp ON c.product_id=ncp.id

	INNER JOIN non_coffee_categories AS ncc ON ncc.id=ncp.non_coffee_category_id

	LEFT OUTER JOIN sales ON

	(sales.product_id=ncp.id AND sales.product_type='other' AND

	((NOW( ) BETWEEN sales.start_date AND sales.end_date) OR (NOW( ) >

		sales.start_date AND sales.end_date IS NULL)) )

	WHERE c.product_type='other' AND c.user_session_id=:uid

	UNION 

	SELECT CONCAT('C', sc.id), c.quantity, gc.category,

	CONCAT_WS(' - ', s.size, sc.caf_decaf, sc.ground_whole), sc.price,

	sc.stock, sales.price

	FROM wish_lists AS c

	INNER JOIN specific_coffees AS sc ON c.product_id=sc.id

	INNER JOIN sizes AS s ON s.id=sc.size_id

	INNER JOIN general_coffees AS gc ON gc.id=sc.general_coffee_id

	LEFT OUTER JOIN sales ON

	(sales.product_id=sc.id AND sales.product_type='coffee' AND

	((NOW( ) BETWEEN sales.start_date AND sales.end_date) OR (NOW( ) >

		sales.start_date AND sales.end_date IS NULL)) )

	WHERE c.product_type='coffee' AND c.user_session_id=:uid;

                            [add_customer] => INSERT INTO customers VALUE (NULL,:e,:f,:l,:a1,:a2,:c,:s,:z,:p,NOW());

                            [out_cid] => SELECT LAST_INSERT_ID() FROM customers

                            [add_order] => INSERT INTO orders (customer_id,shipping,credit_card_number,

		order_date) VALUES (:cid,:ship,:cc,NOW());

                            [out_oid] => SELECT LAST_INSERT_ID() FROM orders

                            [add_order_continues] => INSERT INTO order_contents(order_id,product_type,product_id,

		quantity,price_per) SELECT :oid,c.product_type,c.product_id,

		c.quantity,IFNULL(sales.price,ncp.price) FROM carts AS c INNER JOIN

		non_coffee_products AS ncp ON c.product_id=ncp.id LEFT OUTER JOIN

		sales ON (sales.product_id=ncp.id AND sales.product_type='other'

		AND ((NOW() BETWEEN sales.start_date AND sales.end_date)

		OR (NOW() > sales.start_date AND sales.end_date IS NULL))) WHERE

		c.product_type='other' AND c.user_session_id=:uid UNION SELECT

		:oid, c.product_type,c.product_id,c.quantity,IFNULL(sales.price,

		sc.price)FROM carts AS c INNER JOIN specific_coffees AS sc ON

		c.product_id=sc.id LEFT OUTER JOIN sales ON (sales.product_id=sc.id

		AND sales.product_type='coffee' AND ((NOW() BETWEEN

		sales.start_date AND sales.end_date) OR (NOW() > sales.start_date

		AND sales.end_date IS NULL)))WHERE c.product_type='coffee' AND

		c.user_session_id=:uid;

                            [out_subtotal] => SELECT SUM(quantity*price_per) FROM order_contents

		WHERE order_id=:oid

                            [update_order] => UPDATE orders SET total = (:subtotal + :ship) WHERE id=:oid

                            [clear_cart] => DELETE FROM carts WHERE user_session_id=:uid;

                        )



                )



        )



)



Fatal error
: Call to a member function query() on null in
C:\wamp\www\002_effcomm_php_mysql_phys_paypal_pdo_06_02_2023_mvp_worx_gator\index.php
on line
15