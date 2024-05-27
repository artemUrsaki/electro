		<!-- FOOTER -->
		<footer id="footer">
			<!-- top footer -->
			<div class="section">
				<!-- container -->
				<div class="container">
					<!-- row -->
                    <?php
                    
                    $footer_list = array(
                        'About Us'=>array(
                            'map-marker'=>'1734 Stonecoal Road',
                            'phone'=>'+021-95-51-84',
                            'envelope-o'=>'email@email.com',
                        ),
                        'Categories'=>array(
                            'Hot Deals'=>'hot-deals.php',
                            'Laptops'=>'store.php',
                            'Smartphones'=>'store.php',
                            'Cameras'=>'store.php',
                            'Accessories'=>'store.php',
                        ),
                        'Information'=>array(
                            'About Us'=>'about.php',
                            'Contact Us'=>'contact.php',
                            'Privacy Policy'=>'privacy.php',
                            'Terms & Conditions'=>'terms.php',
                        ),
                        'Service'=>array(
                            'My Account'=>'account.php',
                            'View Cart'=>'cart.php',
                            'Wishlist'=>'wishlist.php',
                            'My Order'=>'checkout.php',
                            'Help'=>'contact.php',
                        ),
                    );

                    $menu_obj->generate_footer(4, $footer_list);

                    ?>

					<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /top footer -->

			<!-- bottom footer -->
			<div id="bottom-footer" class="section">
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-12 text-center">
                            <?php
                            
                            $cards = array(
                                'cc-visa'=>'#',
                                'credit-card'=>'#',
                                'cc-paypal'=>'#',
                                'cc-mastercard'=>'#',
                                'cc-discover'=>'#',
                                'cc-amex'=>'#',
                            );

                            $menu_obj->add_cards($cards);

                            ?>

							<span class="copyright">
								<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
								Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							</span>
						</div>
					</div>
						<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /bottom footer -->
		</footer>
		<!-- /FOOTER -->

		<!-- jQuery Plugins -->
		<?php
		echo ($page_obj->add_scripts());
		?>  

	</body>
</html>