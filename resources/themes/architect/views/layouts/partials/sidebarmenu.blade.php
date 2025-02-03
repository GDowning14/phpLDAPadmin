<div class="app-sidebar sidebar-shadow">
	<div class="app-header__logo">
		<div class="logo-src"></div>
		<div class="header__pane ms-auto">
			<div>
				<button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
					<span class="hamburger-box">
						<span class="hamburger-inner"></span>
					</span>
				</button>
			</div>
		</div>
	</div>
	<div class="app-header__mobile-menu">
		<div>
			<button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</button>
		</div>
	</div>
	<div class="app-header__menu">
		<span>
			<button type="button" class="btn-icon btn-icon-only btn btn-sm btn-primary mobile-toggle-header-nav">
				<span class="btn-icon-wrapper">
					<i class="fas fa-ellipsis-v fa-w-6"></i>
				</span>
			</button>
		</span>
	</div>
	<div class="scrollbar-sidebar">
		<div class="app-sidebar__inner">
			<ul class="vertical-nav-menu">
				<li class="app-sidebar__heading">{{ $server ?? __('Server Name') }}</li>
				<li>
					<div class="font-icon-wrapper float-start me-1 server-icon">
						<a class="p-0 m-0" href="{{ url('info') }}" onclick="return false;" style="display: contents;"><i class="fas fa-fw fa-info"></i></a>
					</div>
					<div class="font-icon-wrapper float-start ms-1 me-1 server-icon">
						<a class="p-0 m-0" href="{{ url('schema') }}" onclick="return false;" style="display: contents;"><i class="fas fa-fw fa-fingerprint"></i></a>
					</div>
					<div class="font-icon-wrapper float-start ms-1 me-1 server-icon">
						<a class="p-0 m-0" href="{{ url('import') }}" onclick="return false;" style="display: contents;"><i class="fas fa-fw fa-upload"></i></a>
					</div>
					@env(['local'])
						<div class="font-icon-wrapper float-end ms-1 server-icon">
							<a class="p-0 m-0" href="{{ url('debug') }}" onclick="return false;" style="display: contents;"><i class="fas fa-fw fa-toolbox"></i></a>
						</div>
					@endenv
					<div class="clearfix"></div>
				</li>
				<li>
					<i id="treeicon" class="metismenu-icon fa-fw fas fa-sitemap"></i>
					<span class="f16" id="tree"></span>
				</li>
			</ul>
		</div>
	</div>
</div>

@section('page-scripts')
	<script type="text/javascript">
		$(document).ready(function() {
			$('.server-icon > a').on('click',function(item) {
				var content;

				$.ajax({
					url: $(this).attr('href'),
					method: 'GET',
					dataType: 'html',
					statusCode: {
						404: function() {
							$('.main-content').empty().append(content);
						}
					},
					beforeSend: function() {
						content = $('.main-content').contents();
						$('.main-content').empty().append('<div class="fa-3x"><i class="fas fa-spinner fa-pulse"></i></div>');
					}

				}).done(function(html) {
					$('.main-content').empty().append(html);

				}).fail(function() {
					alert('Well that didnt work?');
				});

				item.stopPropagation();

				return false;
			});
		});
	</script>
@append
