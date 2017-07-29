<?php
require('../model/database.php');
require('../model/category.php');
require('../model/category_db.php');
require('../model/product.php');
require('../model/product_db.php');

require('../model/fields.php');
require('../model/validate.php');


$validate = new Validate();
$fields = $validate->getFields();
$fields->addField('code');
$fields->addField('name');
$fields->addField('price', 'Must be a valid number.');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
        if ($action == NULL) {
	        $action = 'list_products';
		    }
		    }

		    if ($action == 'list_products') {
		        
			    $category_id = filter_input(INPUT_GET,
			    'category_id', 
			                FILTER_VALIDATE_INT);
					    if ($category_id == NULL ||
					    $category_id == FALSE) {
					            $category_id = 1;
						        }

							    
							        $current_category
								=
								CategoryDB::getCategory($category_id);
								    $categories
								    =
								    CategoryDB::getCategories();
								        $products
									=
									ProductDB::getProductsByCategory($category_id);

									    
									        include('product_list.php');
										}
										else
										if
										($action
										==
										'delete_product')
										{
										   
										       $product_id
										       =
										       filter_input(INPUT_POST,
										       'product_id', 
										                   FILTER_VALIDATE_INT);
												       $category_id
												       =
												       filter_input(INPUT_POST,
												       'category_id', 
												                   FILTER_VALIDATE_INT);


														       ProductDB::deleteProduct($product_id);

														        
															    header("Location:
															    .?category_id=$category_id");
															    }
															    else
															    if
															    ($action
															    ==
															    'show_add_form')
															    {
															        $code
																=
																'';
																    $name
																    =
																    '';
																        $price
																	=
																	'';
																	    
																	        $categories
																		=
																		CategoryDB::getCategories();
																		    include('product_add.php');
																		    }
																		    else
																		    if
																		    ($action
																		    ==
																		    'add_product')
																		    {

																		        
																			    $category_id
																			    =
																			    filter_input(INPUT_POST,
																			    'category_id', 
																			                FILTER_VALIDATE_INT);
																					    $code
																					    =
																					    filter_input(INPUT_POST,
																					    'code');
																					        $name
																						=
																						filter_input(INPUT_POST,
																						'name');
																						    $price
																						    =
																						    filter_input(INPUT_POST,
																						    'price');

																						        $validate->text('code',
																							$code,
																							true,
																							1,
																							10);
																							    $validate->text('name',
																							    $name);
																							        $validate->number('price',
																								$price);

																								   
																								       if
																								       ($fields->hasErrors())
																								       {
																								               $categories
																									       =
																									       CategoryDB::getCategories();
																									               include
																										       'product_add.php';
																										           }
																											   else
																											   {
																											           $current_category
																												   =
																												   CategoryDB::getCategory($category_id);
																												           $product
																													   =
																													   new
																													   Product($current_category,
																													   $code,
																													   $name,
																													   $price);
																													           ProductDB::addProduct($product);

																														         
																															         header("Location:
																																 .?category_id=$category_id");
																																     }
																																     }
																																     ?>
