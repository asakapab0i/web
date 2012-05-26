		</div>
		<?php 
		wp_footer(); 
		if (function_exists('yoast_analytics')) yoast_analytics(); /*google analytics*/
		?>
		<script src="<?php echo get_template_directory_uri(); ?>/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<!-- <script src="<?php echo get_template_directory_uri(); ?>/js/global.js" type="text/javascript"></script> -->
	</body>
</html>
