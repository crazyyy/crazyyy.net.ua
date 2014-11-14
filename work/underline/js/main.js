(function () {
  var WPMISC = {
    version: '1.0.4'
  };

  var forEach = Array.prototype.forEach;
	var $ = {
    // http://youmightnotneedjquery.com/
		addClass: function(el, className) {
			if (el.classList)
  			el.classList.add(className);
			else
  			el.className += ' ' + className;
		},
		removeClass: function(el, className) {
			if (el.classList)
			  el.classList.remove(className);
			else
			  el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
		},
		toggleClass: function(el, className) {
			if (el.classList) {
			  el.classList.toggle(className);
			} else {
			  var classes = el.className.split(' ');
			  var existingIndex = classes.indexOf(className);

			  if (existingIndex >= 0)
			    classes.splice(existingIndex, 1);
			  else
			    classes.push(className);

			  el.className = classes.join(' ');
			}
		}
	}

  function hideAllSubMenu(item, i) {
    forEach.call(document.querySelectorAll('.menu-item'), function (item, i) {
      $.removeClass(item, 'active');
    });
    return false;
  }

  function toggleSubMenu (item, i) {
		item.addEventListener('click', function(e) { console.log('Clicked');
			e.stopPropagation();
			$.toggleClass(this.parentNode, 'active');
		});
		return false;
	}	

	document.addEventListener('DOMContentLoaded', function(){
    
    // Toggle sub-menu
    forEach.call(document.querySelectorAll('.extend'), toggleSubMenu);
  
    // Toggle mobile menu
    document.querySelectorAll('.a-show-menu')[0].addEventListener('click', function (e) {
	  	$.toggleClass(this, 'active');
	  	$.toggleClass(document.querySelectorAll('#mobile-navigation')[0], 'active');
	  	return false;
	  });

    // Hide sub-menu if clicking somewhere else
    document.body.addEventListener('click', hideAllSubMenu);

    // Display scroll-to-top button
	  window.addEventListener('scroll', function (e) {
	  	var jump_el = document.querySelectorAll('.a-jump-to-top')[0];
	  	
	  	if (! jump_el) 
	  		return;
   
	  	if (window.pageYOffset) {
	  		$.addClass(jump_el, 'is-showed');
	  	} else {
	  		$.removeClass(jump_el, 'is-showed');
	  	}
	  });
  });

  window.WPMISC = WPMISC;
}())
	
