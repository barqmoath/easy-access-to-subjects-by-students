$(document).ready(function(){


  // When User Click On Love Button
  $('#love').on('click',function(){
    var item_id    = $(this).attr('item-id');
    $.ajax({
      type: 'POST',
      url : url,
      data: { item_id: item_id, _token: token },
      success:function(data){
        if(data.is_loved === true)
        {
          $('#love').addClass('love-active');
          var n = $('#love_counter').text();n++;
          $('#love_counter').text(n);
        }
        else
        {
          $('#love').removeClass('love-active');
          var n = $('#love_counter').text();n--;
          $('#love_counter').text(n);
        }
      }
    });
  });


  // When User Click On Bag Button
  $('#bag').on('click',function(){
    var item_id    = $(this).attr('item-id');
    $.ajax({
      type: 'POST',
      url : burl,
      data: { item_id: item_id, _token: btoken },
      success:function(data){
        if(data.is_in_bag === true)
        {
          $('#bag').addClass('bag-active');
          $('#bag_text').text('In My Bag');
        }
        else
        {
          $('#bag').removeClass('bag-active');
          $('#bag_text').text('Add To Bag');
        }
      }
    });
  });




});
