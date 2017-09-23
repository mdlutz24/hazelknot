(function($, window, document){
  $.fn.modifyLineupForm = function() {
    var $table = this.find('table.report');
    var $trs = $table.find('tr.oddtablerow, tr.eventablerow').filter(":not(:last)");
    var $players = $("<div></div>");
    $trs.each(function(){
      $players.append($(this).trAsDiv());
    });

    this.children('.mobile-wrap').append($players);
  };

  $.fn.trAsDiv = function() {
    var $div = $('<div></div>');
    var $tds = this.children('td');
    var $player = $('<div class="player"></div>');
    $player.append($tds.eq(0).children('a'));
    var $opp = $('<div class="opponent"></div>');
    $opp.append($tds.eq(1).html());
    var $top = $('<div class="top"></div>');
    $top.append($player).append($opp);

    var $bottom = $('<div class="bottom"></div>');

    var $rush = $('<div class="rush"><label>Rush</label><br></div>')
    $rush.append($tds.eq(2).html());

    $bottom.append($rush);
    $div.append($top).append($bottom);
    return $div;

  };

  $(document).ready(function(){

    if (thisProgram === "options_02") {
      if (franchise_id == "0001") {
        $('#contentframe form').modifyLineupForm();
      }
    }


  })
})(jQuery, this, this.document)