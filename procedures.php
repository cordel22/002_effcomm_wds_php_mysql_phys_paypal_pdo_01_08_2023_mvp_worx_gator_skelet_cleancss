
<?php

    $select_cat_coffee = "SELECT * FROM general_coffees ORDER by category";

    $select_cat_other = "SELECT * FROM non_coffee_categories ORDER by category";

/*    
    $select_prod_coffee = "SELECT gc.description, gc.image, CONCAT('C', sc.id) AS sku,
	CONCAT_WS(' - ', s.size, sc.caf_decaf, sc.ground_whole, sc.price)
	AS name, sc.stock FROM specific_coffees AS sc INNER JOIN sizes
	AS s ON s.id=sc.size_id INNER JOIN general_coffees AS gc ON
	gc.id=sc.general_coffee_id WHERE general_coffee_id=:cat AND
	stock>0
ORDER by name ASC";

    $select_prod_other = "SELECT ncc.description AS g_description, ncc.image AS g_image, 
	CONCAT('O', ncp.id) AS sku, ncp.name, ncp.description,
	ncp.image, ncp.price, ncp.stock FROM non_coffee_products AS
	ncp INNER JOIN non_coffee_categories AS ncc ON
	ncc.id=ncp.non_coffee_category_id
WHERE non_coffee_category_id=:cat ORDER by date_created DESC";
*/

	$select_prod_coffee = "SELECT gc.description, gc.image, CONCAT('C', sc.id) AS sku,
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
	ORDER by name ASC";

	$select_prod_other = "SELECT ncc.description AS g_description, ncc.image AS g_image, 
	CONCAT('O', ncp.id) AS sku, ncp.name, ncp.description,
	ncp.image, ncp.price, ncp.stock, sales.price AS sale_price
	FROM non_coffee_products AS
	ncp INNER JOIN non_coffee_categories AS ncc ON
	ncc.id=ncp.non_coffee_category_id
	LEFT OUTER JOIN sales ON (sales.product_id=ncp.id
	AND sales.product_type='other' AND
	((NOW( ) BETWEEN sales.start_date AND sales.end_date) OR (NOW( ) >
		sales.start_date AND sales.end_date IS NULL)) )
	WHERE non_coffee_category_id=:cat ORDER by date_created DESC";

	$select_sale_all = 'SELECT CONCAT("O", ncp.id) AS sku, sa.price AS sale_price, ncc.category,
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
	sa.end_date) OR (NOW( ) > sa.start_date AND sa.end_date IS NULL) )';

	$select_sale_nall = '(SELECT CONCAT("O", ncp.id) AS sku, sa.price AS sale_price,
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
		sa.start_date AND sa.end_date IS NULL) ) ORDER BY RAND( ) LIMIT 2)';

	//	CART
	
	
		/*
	$add_to_cart_posit = "SELECT id INTO cid FROM carts WHERE user_session_id=:uid AND
			product_type=:type AND product_id=:pid;
		IF cid > 0 THEN
		UPDATE carts SET quantity=quantity+:qty, date_modified=NOW( )
			WHERE id=:cid";

	$add_to_cart_negat = "SELECT id INTO cid FROM carts WHERE user_session_id=:uid AND
			product_type=:type AND product_id=:pid;
		IF cid <= 0 THEN
		INSERT INTO carts (user_session_id, product_type, product_id,
			quantity) VALUES (:uid, :type, :pid, :qty)";
	*/


	$find_cid = "SELECT id FROM carts WHERE user_session_id=:uid AND
	product_type=:type AND product_id=:pid";

	$cart_setup = "INSERT INTO carts (user_session_id, product_type, product_id,
	quantity) VALUES (:uid, :type, :pid, :qty);";

	$cart_update = "UPDATE carts SET quantity=quantity+:qty, date_modified=NOW( )
	WHERE id=:cid";
	


	$remove_from_cart = "DELETE FROM carts WHERE user_session_id=:uid AND product_type=:type
		AND product_id=:pid;";

	/*	take it apart like with add_to_cart 	
	$update_cart = "IF :qty > 0 THEN
			UPDATE carts SET quantity=:qty, date_modified=NOW( ) WHERE
				user_session_id=:uid AND product_type=:type AND product_id=:pid;
		ELSEIF :qty = 0 THEN
			DELETE FROM carts WHERE user_session_id=:uid AND product_type=:type
			AND product_id=:pid;
		END IF";
		take it apart like with add_to_cart 	*/

	//	modified updte cart split in two
	$update_cart_some = "UPDATE carts SET quantity=:qty, date_modified=NOW( ) WHERE
	user_session_id=:uid AND product_type=:type AND product_id=:pid;";

	$update_cart_none = "DELETE FROM carts WHERE user_session_id=:uid AND product_type=:type
	AND product_id=:pid;";

	$get_shopping_cart_contents = "SELECT CONCAT('O', ncp.id) AS sku, c.quantity, ncc.category,
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
	WHERE c.product_type='coffee' AND c.user_session_id=:uid;";

	//		WISHLIST

	
	$remove_from_wish_list = "DELETE FROM wish_lists WHERE user_session_id=:uid AND product_type=:type
		AND product_id=:pid;";

	//	see if wish list exists
	$wish_cid = "SELECT id FROM carts WHERE user_session_id=:uid AND
	product_type=:type AND product_id=:pid";


	$wish_setup = "INSERT INTO wish_lists (user_session_id, product_type, product_id,
	quantity) VALUES (:uid, :type, :pid, :qty);";

	$wish_update = "UPDATE wish_lists SET quantity=quantity+:qty, date_modified=NOW( )
	WHERE id=:cid";

	//	update_wish_list after update_cart which got split as well
	$update_wish_some = "UPDATE wish_lists SET quantity=:qty, date_modified=NOW( ) WHERE
	user_session_id=:uid AND product_type=:type AND product_id=:pid;";

	$update_wish_none = "DELETE FROM wish_lists WHERE user_session_id=:uid AND product_type=:type
	AND product_id=:pid;";
	//	update_wish_list after update_cart which got split as well

	//	from get_shoopig_cart_contents just replaced carts with wish_list

	$get_wish_list_contents = "SELECT CONCAT('O', ncp.id) AS sku, c.quantity, ncc.category,
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
	WHERE c.product_type='coffee' AND c.user_session_id=:uid;";




	//	CHECKOUT

	
	
	$add_customer = "INSERT INTO customers VALUE (NULL,:e,:f,:l,:a1,:a2,:c,:s,:z,:p,NOW());";


	$out_cid = "SELECT LAST_INSERT_ID() FROM customers";

	/*
	DELIMITER $$
	CREATE PROCEDURE add_customer (e VARCHAR(80),f VARCHAR(20),
		l VARCHAR(40),a1 VARCHAR(80),a2 VARCHAR(80),c VARCHAR(60),
		s CHAR(2),z MEDIUMINT,p INT,OUT cid INT)
	BEGIN
		INSERT INTO customers VALUE (NULL,e,f,l,a1,a2,c,s,z,p,NOW());
		SELECT LAST_INSERT_ID() INTO cid;
	END$$
	DELIMITER ;
	*/

	//	BILLING

	
	$find_cid = "SELECT id FROM carts WHERE user_session_id=:uid AND
	product_type=:type AND product_id=:pid";
	

	$cart_setup = "INSERT INTO carts (user_session_id, product_type, product_id,
	quantity) VALUES (:uid, :type, :pid, :qty);";

	$cart_update = "UPDATE carts SET quantity=quantity+:qty, date_modified=NOW( )
	WHERE id=:cid";
	

	//	from checkout

	$add_customer = "INSERT INTO customers VALUE (NULL,:e,:f,:l,:a1,:a2,:c,:s,:z,:p,NOW());";


	$out_cid = "SELECT LAST_INSERT_ID() FROM customers";

	/*
	DELIMITER $$
	CREATE PROCEDURE add_customer (e VARCHAR(80),f VARCHAR(20),
		l VARCHAR(40),a1 VARCHAR(80),a2 VARCHAR(80),c VARCHAR(60),
		s CHAR(2),z MEDIUMINT,p INT,OUT cid INT)
	BEGIN
		INSERT INTO customers VALUE (NULL,e,f,l,a1,a2,c,s,z,p,NOW());
		SELECT LAST_INSERT_ID() INTO cid;
	END$$
	DELIMITER ;
	*/

	$add_order = "INSERT INTO orders (customer_id,shipping,credit_card_number,
		order_date) VALUES (:cid,:ship,:cc,NOW());";


	$out_oid = "SELECT LAST_INSERT_ID() FROM orders";


	$add_order_continues = "INSERT INTO order_contents(order_id,product_type,product_id,
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
		c.user_session_id=:uid;";


	$out_subtotal = "SELECT SUM(quantity*price_per) FROM order_contents
		WHERE order_id=:oid";

	$update_order = "UPDATE orders SET total = (:subtotal + :ship) WHERE id=:oid";

	//	FINAL

	$clear_cart = "DELETE FROM carts WHERE user_session_id=:uid;";

    //  ???
	'DELIMITER $$
	CREATE PROCEDURE clear_cart (uid CHAR(32))
	BEGIN
		DELETE FROM carts WHERE user_session_id=uid;
	END$$
	DELIMITER ;';



