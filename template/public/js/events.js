$(function(){
  $('.header-phone .open-callback').click(function(){    
    ga('send', 'event', 'zvonok', 'up');
    yaCounter34928630.reachGoal('zvonok_up');
  });
  $('footer .open-callback').click(function(){    
    ga('send', 'event', 'zvonok', 'down');
    yaCounter34928630.reachGoal('zvonok_down');
  });
  $('.favorites-page .yellow-btn').click(function(){    
    ga('send', 'event', 'order', 'done');
    yaCounter34928630.reachGoal('order_done');
  });
});