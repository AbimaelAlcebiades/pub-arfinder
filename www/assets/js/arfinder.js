$(document).ready(function () {
  var elementAnalyText = $('#analyze-text');
  var containerSuggestionsTerms = $('#container-suggestions-terms');
  var containerAcademicReferences = $('#container-academic-references');
  var arTerm = $('#academic-reference-term');
  var searchBar = $('#search-bar-ar');
  var btnSearchAcademicReferences = $('#search-academic-references');
  var clearHistory = $('#clear-history');

  // Enable ARFinder agent.
  //startAgentARFinder();

  // Event when clicking element analyze text.
  elementAnalyText.on("click", function (vEvent) {
    // Stop event default behavior.
    vEvent.preventDefault();
    // Get content in tinyMCE editor.
    var articleText = tinyMCE.activeEditor.getContent({ format: 'text' });
    if (articleText.trim().length <= 0 ){
      return;
    }else{
      containerAcademicReferences.addClass('d-none').removeClass('d-block');
      // Send data to sobek.
      //generateSuggestionsTerms(articleText);
      
      var erroMsg = $('#container-mag-error-message');
      if(erroMsg.length > 0){
        $('#container-mag-error-message').remove();
      }

      suggestAcademicReference(articleText);
    }
  });

  // When click in try again.
  containerAcademicReferences.on('click', '#search-references-try-again', function (vEvent) {
    // Stop event default behavior.
    vEvent.preventDefault();
    var buttonTryAgain = $(this);
    //containerAcademicReferences.attr('data-filter-author', buttonTryAgain.attr('data-author-ta'));
    setAuthor(buttonTryAgain.attr('data-author-ta'));
    setTerm(buttonTryAgain.attr('data-results-for-ta'));
    //containerAcademicReferences.attr('data-results-for', buttonTryAgain.attr('data-results-for-ta')); 
    $('#container-mag-error-message').remove();
    getDataReferences(getTerm(), getAuthor());
  });

  // Event when clicking link paper's authors.
  clearHistory.on("click", function (vEvent) {
    // Performs request to get terms from text.
    $.ajax({
      url: 'arfinder.php?execute=arfinder_api',
      type: 'POST',
      data: {
        'controller': 'ReferenceFinder',
        'task': 'clearHistory'
      },
      success: function (requestResults) {
        alert(requestResults);
        location.reload();
      }
    });
  });

  // Event when clicking link paper's authors.
  containerAcademicReferences.on("click", "[data-author]", function (vEvent) {
    // Stop event default behavior.
    vEvent.preventDefault();

    // Link paper's author.
    var linklAuthor = $(this);

    // Check if are loading academic references.
    if (!$('#loading-academic-references').length > 0) {
      //var button = $('[data-term-active=true]');
      // Remove all academic references loaded.
      containerAcademicReferences.find('#container-mag-error-message').remove();
      $('.card-columns').remove();
      $('#search-label').remove();
      // Get references to term.
      //containerAcademicReferences.attr('data-filter-author', linklAuthor.attr('data-author'));
      setAuthor(linklAuthor.attr('data-author'));
      //containerAcademicReferences.attr('data-results-for', '');
      setTerm('');
      getDataReferences(getTerm(), getAuthor());
    }
  });

  // Event when click in suggestion term.
  containerSuggestionsTerms.on("click", '.suggestion-term', function (vEvent) {
    // Stop event default behavior.
    vEvent.preventDefault();
    // Check if are loading academic references.
    if(!$('#loading-academic-references').length > 0){
      var button = $(this);
      // Desactive all terms buttons previsious active except button this context.
      //$('[data-term-active=true]').not(button).removeAttr('data-term-active');  
      // Check if button is not active.
      //if (!button[0].hasAttribute("data-term-active")) {
      if (getTerm() !== button.attr('data-term-value')) {
        // Set button with active term.
        //button.attr('data-term-active', true);
        //containerAcademicReferences.attr('data-results-for', button.attr('data-term-value'));
        setTerm(button.attr('data-term-value'));
        // Remove all academic references loaded.
        containerAcademicReferences.find('#container-mag-error-message').remove();
        $('.card-columns').remove();
        $('#search-label').remove();
        // Get references to term.
        //getDataReferences(button.attr('data-term-value'));
        getDataReferences(getTerm());
      }
    }
  });

  
  btnSearchAcademicReferences.on('click', function (vEvent) {
    // Stop event default behavior.
    vEvent.preventDefault();  
    
    if (searchBar.val() <= 0){
      return;
    }
    
    // Check if are loading academic references.
    if (!$('#loading-academic-references').length > 0) {
      toogleSearchTools(false);

      if($('#search-filter-articles').is(':checked')){
        setTerm(searchBar.val());
        setAuthor('');
      }

      if ($('#search-filter-authors').is(':checked')) {
        setTerm('');
        setAuthor(searchBar.val());
      }
      // Remove all academic references loaded.
      containerAcademicReferences.find('#container-mag-error-message').remove();
      $('.card-columns').remove();
      $('#search-label').remove();
      // Get references to term.
      getDataReferences(getTerm(), getAuthor());
    }
  });

  searchBar.on('keydown', function (vEvent) {
    // If is enter key.
    if (vEvent.keyCode == 13) {   
      btnSearchAcademicReferences.click();
    }
  }); 

  // Event when click in load more academic references.
  $('#load-more-ar').on('click', function (vEvent) {
    // Get active term.
    //var term = $('[data-term-active=true]').attr('data-term-value');
    // Load term.
    //$('#search-label').remove();
    //getDataReferences(getTerm(), getAuthor(), true);
    // Stop event default behavior.
    vEvent.preventDefault();
    // Get content in tinyMCE editor.
    var articleText = tinyMCE.activeEditor.getContent({ format: 'text' });
    if (articleText.trim().length <= 0) {
      return;
    } else {
      // Send data to sobek.
      suggestAcademicReference(articleText);
    }
  });

});

function suggestAcademicReference (articleText) {
  getTermsFromText(articleText);
}

function getTermsFromText(articleText) {
  // Performs request to get terms from text.
  $.ajax({
    url: 'arfinder.php?execute=arfinder_api',
    type: 'POST',
    data: {
      'controller': 'TextAnalyzer',
      'task': 'analyzeText',
      'textToSobek': articleText
    },
    success: function (requestResults) {
      requestResults = $.parseJSON(requestResults);
      if(requestResults.status == 'success'){
        getAcademicReferences(requestResults.terms, articleText);
      }
    }
  });
}

function getAcademicReferences(terms, articleText) {
  var loader = $('<div id="loading-academic-references" class="loader"></div>');
  var options = getOptionsSearchAcademicReferences();
  var containerLoadMore = $('#container-load-more-ar');
  var listAcademicReferences = $('#list-academic-references');
  var containerAR = $('#container-academic-references');
  var listAcademicReferences = $('#list-academic-references');

  console.log("Passando termos:")
  console.log(terms);
  
  var data = {
    'controller': 'ReferenceFinder',
    'task': 'getAcademicReferences',
    'terms': terms,
    'articleText': articleText,
    'options': options
  };

  // Performs request for get academic references.
  $.ajax({
    url: 'arfinder.php?execute=arfinder_api',
    type: 'POST',
    data: data,
    beforeSend: function () {
      // Show container.      
      containerAR.addClass('d-block').removeClass('d-none').show("slow");
      // Insert loader.
      loader.insertAfter(listAcademicReferences.last());
      // Hide butto load more.
      containerLoadMore.addClass('d-none').removeClass('d-block');
      // Scrolling to loader.
      $('html, body').animate({
        scrollTop: loader.offset().top
      }, 2000);
    },
    success: function (dataReturn) {
      loader.remove();
      var requestResults = $.parseJSON(dataReturn);
      console.log("Resultado referências acadêmicas");
      console.log(requestResults);

      // Checks if should remove button more.
      if (requestResults.removeButtonMore === true) {
        containerLoadMore.addClass('d-none').removeClass('d-block');
      } else {
        containerLoadMore.removeClass('d-none').addClass('d-block');
      }

      // Append data returns.
      listAcademicReferences.append(requestResults.html);
      // Show content slowly.
      $('.card-academic-reference').show("slow");
      // Active resource data tooltip.
      $('[data-toggle="tooltip"]').tooltip();

      $('html, body').animate({
        scrollTop: $('.card-academic-reference:last').offset().top
      }, 500);
    }
  });
}

/**
 * Get academic references from database.
 *
 * @param string  term          Term for find in academic data base.
 * @param string  filterAuthor  (optional) Filter references by author.
 * @param boolean loadMore      (optional) Inform if is request load more academic references.
 *
 * @return void
 */
function getDataReferences(term, filterAuthor = false, loadMore = false) {
  var loader = $('<div id="loading-academic-references" class="loader"></div>');
  var listAcademicReferences = $('#list-academic-references');
  var containerAR = $('#container-academic-references');
  var containerLoadMore = $('#container-load-more-ar');
  var buttonMoreAr = $('#load-more-ar');
  //var referencesDisplayed = $(".card-academic-reference").length;
  var options = getOptionsSearchAcademicReferences();

  var data = {
    'controller': 'ReferenceFinder',
    'task': 'getAcademicReferences',
    'term': term,
    //'startIndex': referencesDisplayed,
    'options' : options
  };

  // Check if exists filter author.
  if(filterAuthor !== false){
    data.filterAuthor = filterAuthor;
  }

  // Check if is load more academic references.
  if (loadMore === true) {
    data.loadMore = true;
  }

  // Performs requisition for get data academic references.
  $.ajax({
    url: 'arfinder.php?execute=arfinder_api',
    type: 'POST',
    data: data,
    beforeSend: function () {
      // Show container.      
      containerAR.addClass('d-block').removeClass('d-none').show("slow");
      // Insert loader.
      loader.insertAfter(listAcademicReferences.last());
      // Hide butto load more.
      containerLoadMore.addClass('d-none').removeClass('d-block');
      // Scrolling to loader.
      $('html, body').animate({
        scrollTop: loader.offset().top
      }, 2000);
    },
    success: function (dataReturn) {
      toogleSearchTools(true);
      loader.remove();
      var requestResults = $.parseJSON(dataReturn);

      // TODO: TRATAR QUANDO NÃO DEVOLVER RESULTADO DE HTML.
      //console.log(dataReturn);

      // Checks if should remove button more.
      if (requestResults.removeButtonMore === true) {
        containerLoadMore.addClass('d-none').removeClass('d-block');
      } else {
        containerLoadMore.removeClass('d-none').addClass('d-block');
      }

      // Append data returns.
      listAcademicReferences.append(requestResults.html);
      // Show content slowly.
      $('.card-academic-reference').show("slow");
      // Active resource data tooltip.
      $('[data-toggle="tooltip"]').tooltip();

      $('html, body').animate({
        scrollTop: $('.card-academic-reference:last').offset().top
      }, 500);
    }
  });

}

// // TODO: TENHO QUE DESCREVER ESSA FUNÇÃO.
// function getDataReferences2() {
//   $.ajax({
//     url: 'arfinder.php?execute=arfinder_api',
//     type : 'POST',
//     data : {
//       'execute'      : 'api',
//       'controller'   : 'ReferenceFinder',
//       'task'         : 'getAcademicReferences',
//       'term'         : 'sobek',
//       'forceEngine'  : 'AcademicSearchApi'
//     },
//     success: function(dataReturn){
//       $('[data-reference="references-result"]').html(dataReturn);
//     }
//   });
// }

/**
 * Get current term configured.
 */
function getTerm() {
  return $('#academic-reference-term').val();
}

/**
 * Set term for apply in context.
 */
function setTerm(term) {
  $('#academic-reference-term').val(term) ;
}

/**
 * Get current filter author configured.
 */
function getAuthor() {
  return $('#academic-reference-author').val();
}

/**
 * Set author for apply in context.
 */
function setAuthor(author) {
  $('#academic-reference-author').val(author);
}


/**
 * Enable or disable search tools.
 * 
 * @param boolean $mode If true remove attribute disabled or false add attribute disabled, default value is true.
 * 
 * @return void
 */
function toogleSearchTools($mode = true) {
  var searchTools = $('#tools-search');
  if($mode){
    searchTools.find('input, button').removeAttr('disabled');
  }else{
    searchTools.find('input, button').attr('disabled', 'disabled');
  }
}

/**
 * Generate suggestions terms, this method receives text and send Sobek for analysis and returns suggestions terms.
 *
 * @param  string text Content to be analyzed by the Sobek.
 *
 * @return void
 */
function generateSuggestionsTerms(userArticleText) {

  var button = $('#analyze-text');
  var containerSuggestionsTerms = $('#container-suggestions-terms');
  var containerProgressiveBar = $('#container-progress-bar');
  var progressiveBar = containerProgressiveBar.find('.progress-bar');
  var tinyText = (userArticleText.length < 500) ? true : false;
  var progresBarPercentage = 0;
  var waitingTime = 0;

  // Performs requisition for to send data sobek.
  $.ajax({
    url: 'arfinder.php?execute=arfinder_api',
    type: 'POST',
    data: {
      'controller': 'TextAnalyzer',
      'task': 'analyzeText',
      'textToSobek': userArticleText
    },
    beforeSend: function () {
      button.attr('disabled', 'disabled');
      // Hidden previous suggestions.
      containerSuggestionsTerms.addClass('d-none').removeClass('d-block');
      // Insert loader.
      containerProgressiveBar.removeClass('d-none').addClass('d-block');    

      progresBarPercentage = (tinyText) ? 50 : 10;
      waitingTime = (tinyText) ? 0 : 500;
      
      // Wait milseconds.
      setTimeout(function () {
        // Set progressive bar init process.
        progressiveBar.css('width', progresBarPercentage+'%');
      }, waitingTime);

    },
    success: function (requestResults) {
      
      waitingTime = (tinyText) ? 0 : 500;
      setTimeout(function () {
        progresBarPercentage = (tinyText) ? 100 : 30;
        progressiveBar.css('width', progresBarPercentage+'%');
        
        waitingTime = (tinyText) ? 0 : 500;
        setTimeout(function () {
          progresBarPercentage = (tinyText) ? 100 : 100;
          progressiveBar.css('width', progresBarPercentage+'%');
         
          waitingTime = (tinyText) ? 0 : 500;
          setTimeout(function () {
            // Hidden progressive bar.
            containerProgressiveBar.removeClass('d-block').addClass('d-none');
            
            // Set bar progressive to init.
            progressiveBar.css('width', '0%');
            
            requestResults = $.parseJSON(requestResults);
            // Set and display suggestions terms.
            containerSuggestionsTerms.find('#list-suggestions-terms').html(requestResults.html);
            containerSuggestionsTerms.addClass('d-block').removeClass('d-none').hide();

            // Show content slowly.
            containerSuggestionsTerms.show("slow");
            $('html, body').animate({
              scrollTop: containerSuggestionsTerms.offset().top
            }, 500);

            button.removeAttr('disabled');

          }, waitingTime);
        }, waitingTime);
      }, waitingTime);


      // setTimeout(function(){
      //     loader.remove();
      //     $('#resultado').html(dataReturn);
      // }, 1000);
    }
  });
}

/**
 * Get options to search academic references.
 * 
 * @return array Returns list of options.
 */
function getOptionsSearchAcademicReferences() {
  
  var options = {};
  
  // Get language options.
  options.languages = new Array();
  $('input[name="language[]"]:checked').each(function () {
    options.languages.push($(this).attr('value'));
  });

  // Get order by.
  options.orderBy = $("input[name='orderby']:checked").val();

  console.log(options);

  // Get number of references displayed for start index.
  options.startIndex = $(".card-academic-reference").length;

  // Get display academic references automatically.
  options.autoAcademicReferences = $("#automatic-search-ar").is(":checked");

  // Get display suggesions search terms.
  options.displaySuggestionsTerms = $("#display-suggestions-list").is(":checked");

  // Analyze article in seconds.
  options.checkArticle = $("#check-one-each").val();

  return options;
}

/**
 * Actives ARFinder's agent for watching article and operate when necessary.
 */
function startAgentARFinder() {

  // Get options ARFinder.
  var options = getOptionsSearchAcademicReferences();

  // Check config automatic references.
  if (options.autoAcademicReferences === true){
    //var watchEachSeconds = options.checkArticle * 1000;
    var watchEachSeconds = 4000;
    window.setInterval(agentSuggestAcademicReferences, watchEachSeconds);
  }

}

/**
 * Generate academic references suggestions for user.
 */
function agentSuggestAcademicReferences() {
  // Get user text content.
  var usertext = tinyMCE.activeEditor.getContent({ format: 'text' });
  
  if (usertext.trim().length <= 0) {
    return;
  } 

  // Get options ARFinder.
  var options = getOptionsSearchAcademicReferences();

  // Check if should display suggested terms.
  if (options.displaySuggestionsTerms === true){
    $('#analyze-text').trigger('click');
  }else{
    // Get terms from text.
    var terms = getSuggestionsTerms(usertext);
  
    if(terms.status === 'error'){
      return;
    }
    console.log(terms);
  }  
}

function getSuggestionsTerms(userArticleText) {
  // Performs requisition for to send data sobek.
  var terms = $.ajax({
    url: 'arfinder.php?execute=arfinder_api',
    async: false,
    type: 'POST',
    data: {
      'controller': 'TextAnalyzer',
      'task': 'analyzeText',
      'textToSobek': userArticleText
    }
  }).responseText;
  return terms = $.parseJSON(terms);
}