<?php
$con=mysqli_connect("localhost","root","","lessmovies");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM movietitles");



?>

<html>
<head>
	<meta charset="UTF-8">
	<title>CPS842 Project</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://scs.ryerson.ca/~brturner/filmly/filmly.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="col-xs-12 col-xs-offset-0 col-md-8 col-md-offset-2" id="content_holder_all">
	<div class="container content_holder">
		<div class="row">
			<div class="col-xs-12 col-xs-offset-0 col-md-10 col-md-offset-1">
				<section class="header">
					<div> 
						<div class="hamburger_menu" onclick="myFunction(this)">
							<div class="bar1"></div>
							<div class="bar2"></div>
							<div class="bar3"></div>
						</div>
						<h1 class="text-center" id="main_title">Filmly</h1>
					</div>
				</section>
				
				<?php
				
				while($row = mysqli_fetch_array($result)){
				
				echo "<section id=\"listing\">";
				echo	"<div class=\"container-fluid\">";
				echo		"<ul class=\"list-unstyled list_items\">";
				echo			"<hr>";
				echo			"<li>" . $row['Title'] . "</li>";
				echo			"<li><div class=\"row lead\">";
				echo				"<div id=\"stars\" class=\"starrr\"></div>";
				echo				"You gave a rating of <span id=\"count\">" . $row['Rating'] . "</span> star(s)";
				echo			"</div></li>";
				echo			"<hr>";
				echo		"</ul>";
				echo	"</div>";
				echo "</section>";	
				
				}
				
				?>
				
			</div>
		</div>
	</div>	
</div>

</body>
<!--Animation for hamburger menu-->
<script>
	function myFunction(x) {
		x.classList.toggle("change");
	}
</script>
<script>
	// Starrr plugin (https://github.com/dobtco/starrr)
	var __slice = [].slice;

	(function($, window) {
		var Starrr;

		Starrr = (function() {
			Starrr.prototype.defaults = {
				rating: void 0,
				numStars: 5,
				change: function(e, value) {}
			};

			function Starrr($el, options) {
				var i, _, _ref,
				_this = this;

				this.options = $.extend({}, this.defaults, options);
				this.$el = $el;
				_ref = this.defaults;
				for (i in _ref) {
					_ = _ref[i];
					if (this.$el.data(i) != null) {
						this.options[i] = this.$el.data(i);
					}
				}
				this.createStars();
				this.syncRating();
				this.$el.on('mouseover.starrr', 'span', function(e) {
					return _this.syncRating(_this.$el.find('span').index(e.currentTarget) + 1);
				});
				this.$el.on('mouseout.starrr', function() {
					return _this.syncRating();
				});
				this.$el.on('click.starrr', 'span', function(e) {
					return _this.setRating(_this.$el.find('span').index(e.currentTarget) + 1);
				});
				this.$el.on('starrr:change', this.options.change);
			}

			Starrr.prototype.createStars = function() {
				var _i, _ref, _results;

				_results = [];
				for (_i = 1, _ref = this.options.numStars; 1 <= _ref ? _i <= _ref : _i >= _ref; 1 <= _ref ? _i++ : _i--) {
					_results.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"));
				}
				return _results;
			};

			Starrr.prototype.setRating = function(rating) {
				if (this.options.rating === rating) {
					rating = void 0;
				}
				this.options.rating = rating;
				this.syncRating();
				return this.$el.trigger('starrr:change', rating);
			};

			Starrr.prototype.syncRating = function(rating) {
				var i, _i, _j, _ref;

				rating || (rating = this.options.rating);
				if (rating) {
					for (i = _i = 0, _ref = rating - 1; 0 <= _ref ? _i <= _ref : _i >= _ref; i = 0 <= _ref ? ++_i : --_i) {
						this.$el.find('span').eq(i).removeClass('glyphicon-star-empty').addClass('glyphicon-star');
					}
				}
				if (rating && rating < 5) {
					for (i = _j = rating; rating <= 4 ? _j <= 4 : _j >= 4; i = rating <= 4 ? ++_j : --_j) {
						this.$el.find('span').eq(i).removeClass('glyphicon-star').addClass('glyphicon-star-empty');
					}
				}
				if (!rating) {
					return this.$el.find('span').removeClass('glyphicon-star').addClass('glyphicon-star-empty');
				}
			};

			return Starrr;

		})();
		return $.fn.extend({
			starrr: function() {
				var args, option;

				option = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
				return this.each(function() {
					var data;

					data = $(this).data('star-rating');
					if (!data) {
						$(this).data('star-rating', (data = new Starrr($(this), option)));
					}
					if (typeof option === 'string') {
						return data[option].apply(data, args);
					}
				});
			}
		});
	})(window.jQuery, window);

	$(function() {
		return $(".starrr").starrr();
	});

	$( document ).ready(function() {

		$('#stars').on('starrr:change', function(e, value){
			$('#count').html(value);
		});

		$('#stars-existing').on('starrr:change', function(e, value){
			$('#count-existing').html(value);
		});
	});
</script>
</html>