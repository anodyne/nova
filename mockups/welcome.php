<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Nova 3 :: Main</title>
		
		<link rel="stylesheet" href="assets/bootstrap.min.css">
		<style>
			.news-feed-filters { font-size: .9em; }
			.nav-pills > li > a {
				padding: 4px 10px;
				border-radius: 2px 2px 2px 2px;
			}
			.nav-pills > li.active > a {
				outline: 0;
			}
			
			.news-feed-items li {
				margin-top: 2px;
				line-height: 2;
				clear: left;
			}
			
			.item-avatar {
				height: 50px;
				width: 50px;
			}
			.avatar {
				height: 50px;
				width: 50px;
				background: lightblue;
				border-radius: 2px 2px 2px 2px;
			}
			
			.item-type {
				width: 20px;
				text-align: center !important;
				vertical-align: middle !important;
			}
			
			.announcement {
				background-color: lightyellow;
			}
		</style>
		
		<script type="text/javascript" src="assets/jquery-1.7.1.min.js"></script>
		<script>
			$(document).ready(function(){
				$('.news-feed-filters a').click(function(){
					var type = $(this).data('feed');
					
					if (type == 'all')
					{
						$('.table tbody').children().show();
					}
					else
					{
						$('.table tbody').children().each(function(){
							if ($(this).hasClass(type))
								$(this).show();
							else
								$(this).hide();
						});
					}
					
					$('.nav-pills').children().removeClass('active');
					$(this).parent().addClass('active');
					
					return false;
				});
			});
		</script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="span3">
					<p>Sidebar</p>
				</div>
				
				<div class="span9">
					<div class="news-feed-filters">
						<ul class="nav nav-pills">
							<li class="active"><a href="#" data-feed="all">All</a></li>
							<li><a href="#" data-feed="announcement">Announcements</a></li>
							<li><a href="#" data-feed="log">Personal Logs</a></li>
							<li><a href="#" data-feed="mission">Mission Posts</a></li>
							<li><a href="#" data-feed="wiki">Wiki Updates</a></li>
							<li><a href="#" data-feed="forum">Forum Posts</a></li>
							<li><a href="#" data-feed="bio">Bio Updates</a></li>
						</ul>
					</div>
					
					<table class="table">
						<tbody>
							<tr class="announcement">
								<td class="item-avatar"><div class="avatar"></div></td>
								<td class="item-content">Announcement by <a href="#">John Doe</a>: <a href="#">Announcement Title</a>.</td>
								<td class="item-type"><img src="assets/img/icons/announce.png"></td>
							</tr>
							<tr class="announcement">
								<td class="item-avatar"><div class="avatar"></div></td>
								<td class="item-content">Announcement by <a href="#">John Doe</a>: <a href="#">Announcement Title</a>.</td>
								<td class="item-type"><img src="assets/img/icons/announce.png"></td>
							</tr>
							<tr class="mission">
								<td class="item-avatar"><div class="avatar"></div></td>
								<td class="item-content"><a href="#">John Doe</a>, <a href="#">Jane Doe</a>, and <a href="#">John Public</a> posted <a href="#">Post Title</a> in <a href="#">Mission X</a>.</td>
								<td class="item-type"><img src="assets/img/icons/mission.png"></td>
							</tr>
							<tr class="log">
								<td class="item-avatar"><div class="avatar"></div></td>
								<td class="item-content"><a href="#">John Doe</a>'s personal log: <a href="#">Log Title</a>.</td>
								<td class="item-type"><img src="assets/img/icons/log.png"></td>
							</tr>
							<tr class="wiki">
								<td class="item-avatar"><div class="avatar"></div></td>
								<td class="item-content"><a href="#">John Doe</a> updated <a href="#">Page X</a> in the wiki.</td>
								<td class="item-type"><img src="assets/img/icons/wiki.png"></td>
							</tr>
							<tr class="wiki">
								<td class="item-avatar"><div class="avatar"></div></td>
								<td class="item-content"><a href="#">John Doe</a> created <a href="#">Page Y</a> in the wiki.</td>
								<td class="item-type"><img src="assets/img/icons/wiki.png"></td>
							</tr>
							<tr class="announcement">
								<td class="item-avatar"><div class="avatar"></div></td>
								<td class="item-content">Announcement by <a href="#">John Doe</a>: <a href="#">Announcement Title</a>.</td>
								<td class="item-type"><img src="assets/img/icons/announce.png"></td>
							</tr>
							<tr class="bio">
								<td class="item-avatar"><div class="avatar"></div></td>
								<td class="item-content"><a href="#">John Doe</a> biography was updated.</td>
								<td class="item-type"><img src="assets/img/icons/bio.png"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>