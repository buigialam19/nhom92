			</div>
			<!-- /content -->
			
			<!-- footer -->
			<footer class="footer" role="contentinfo">
            <div class="footer1">
			<?php dynamic_sidebar('goc-khach-hang'); ?>
			</div>
			<div class="footer2">
			<?php dynamic_sidebar('tin-tuc'); ?>
			</div>
			<div class="footer3">
			<?php dynamic_sidebar('lien-he'); ?>
			</div>			
				<!-- copyright -->
				<p class="copyright">
					&copy; <?php echo date('Y'); ?> Copyright <?php bloginfo('name'); ?>. .
				</p>
				<!-- /copyright -->
			</footer>
			<!-- /footer -->

		</div>
		<!-- /wrapper -->

		<?php wp_footer(); ?>

		<!-- analytics -->
		<script>
		(function(f,i,r,e,s,h,l){i['GoogleAnalyticsObject']=s;f[s]=f[s]||function(){
		(f[s].q=f[s].q||[]).push(arguments)},f[s].l=1*new Date();h=i.createElement(r),
		l=i.getElementsByTagName(r)[0];h.async=1;h.src=e;l.parentNode.insertBefore(h,l)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-XXXXXXXX-XX', 'yourdomain.com');
		ga('send', 'pageview');
		</script>

	</body>
</html>
