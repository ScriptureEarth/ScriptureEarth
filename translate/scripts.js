//This array will hold the HTML that needs to be translated.
var translationTexts = [];

//This array will hold a list of the objects that are being translated.
var translationOutput = [];

//This object will hold the original English translation to allow for it to be reset.
var originalTexts = {};

//This variable holds the Bing API access token.
var tToken = '';

//Here is the main translation function.
function translate(targets, from, to, nextTranslation) {

//Reset the two arrays holding the elements to be translated and translations from previous batches.
    translationOutput.length = 0;
    translationTexts.length = 0;

//Iterate over each of the target elements for the current batch and push them into the arrays. 
    $.each(targets, function (index, element) {
        if ($(element).length) {
            var elementHTML = $(element).html();
            translationTexts.push(elementHTML);
            translationOutput.push($(element));
            originalTexts[element] = $(element).html();
        }
    });
    
//The array for translation is going to be sent as JSON so it is important to format it with JSON.stringify to avoid it causing mischief.
//This of course excludes IE7 from the party but there are scripts that bring it in from the cold if you can be bothered.
//I also encode any ampersands in the HTML as they can also cause JSON to choke.
    var textString = JSON.stringify(translationTexts).replace(/&amp;/g, "%26");

//Check that the length of the batch is not too long for Bing API and if it is discard it and move on to the next batch.
    if (textString.length > 10000) {
        nextTranslation();
        return;
    }
    
//This is the function to send the texts to Microsoft. 
    function processTranslation(token) {

//This object will hold the various parameters required by the API.
        var p = {},
 
//We are using the the TranslateArray method as this enables us to supply multiple individual elements to be translated.
//More info at http://msdn.microsoft.com/en-us/library/ff512407.aspx       
        requestStr = "http://api.microsofttranslator.com/V2/Ajax.svc/TranslateArray";

//Populate the object with required parmeters such as language codes, texts for translation and the token        
        p.contentType = 'text/html';
        p.texts = textString;
        p.from = from;
        p.to = to;
        p.appId = "Bearer " + token;

       
//Send it all to Bing and wait to see what happens. Because the token expires after 10 minutes, if there is an error we can reset the token variable which ensures it is refreshed before the next batch is processed.
//If the call is successful, the data is sent to 'ajaxTranslateCallback' for processing.
        $.ajax({
            url: requestStr,
            type: "GET",
            data: p,
            dataType: 'jsonp',
            jsonp: 'oncomplete',
            jsonpCallback: 'ajaxTranslateCallback',
            success: nextTranslation,
            error: function () {
                tToken = '';
                nextTranslation();
            }
        });
    }

//Check to see if a token already exists and if it doesn't, create it using translate.php.
//Once the token is ready we can execute the 'processTranslation' function we just created.
    if (tToken !== '') {
        processTranslation(tToken);
    } else {
        var requestStr = "translate.php";
        $.ajax({
            url: requestStr,
            type: "GET",
            cache: true,
            dataType: 'json',
            success: function (data) {
                tToken = data.access_token;
                processTranslation(tToken);
            }
        });
    }
}

//Once a batch has been successfully translated it is ready to be inserted back into the page. 
function ajaxTranslateCallback(response) {

//Create an array from the API response
    var translationsArray = response,
    translations = "",
    i = '';

//We now loop through the translation array and use the translationOutput array we created earlier to make sure they are each inserted back into the correct locations.
    for (i = 0; i < translationsArray.length; i++) {
        translations = translations + translationsArray[i].TranslatedText;
        translationOutput[i].html(translationsArray[i].TranslatedText);
    }
}

//This function resets the document to English. 
function resetEnglish() {
    $.each(originalTexts, function (element, html) {
        $(element).html(html);
    });
    originalTexts = {};
}

//The translator is ready so it's time to add some click events to the language menu
$(".translatePage li").click(function () {

//First get the language code from the links id attribute. I have prefixed them with 'lang-' to make them a little more unique so this needs to be removed first.
//A full list of codes can be found at http://msdn.microsoft.com/en-us/library/hh456380.aspx
    var langCode = $(this).attr('id').replace('lang-', '');
 
//Add a class to the active language link so that it can be styled    
    $(".translatePage li").removeClass('activeLang');
    $(this).addClass('activeLang');
    
//Check to see if the link was for English and if it was, reset the document to the original HTML and exit the function
    if ($(this).attr('id') == 'lang-en') {
        resetEnglish();
        return;
    }
    
//Before doing a translation the we need to check if this is the first translation by looking to see if the orinalTexts array is already populated.
//If original texts exist then we need to execute the 'restEnglish' function to return the document to it's original state before proceeding.
//This ensures that the translation is always being made from the original texts rather than from a translation and avoids the 'Chinese Whispers' effect. 
    if (!jQuery.isEmptyObject(originalTexts)) {
        resetEnglish();
    };

//Whilst the language translation is being done we can display a loading notice.
//I used the language links 'data-loading' attribute to provide a message in the relevant language.
    var loadingMessage = $(this).attr('data-loading');
    $('body').append('<div id="translationStarted"><p>' + loadingMessage + '<br><img src="loading.gif"/></p></div>');
    $('#translationStarted').height($('body').height());
    $('#translationStarted').fadeIn();
 
//Now we send the elements to be translated in batches. We do this with functions that pass the next batch for translation using anonymous callbacks which are executed on the success of the previous batch.
//This ensures that the API is only ever dealing with one batch at a time.
//Try and form your batches with the 10000 character limit in mind as to avoid any of them being skipped. The long text example here shows how texts over 10,000 characters are skipped. 
    translate(['#intro'], "en", langCode, function () {
        translate(['#moreText h2', '#longText'], "en", langCode, function () {
//The final callback should remove the loading screen and do any other clearing up that your page requires        
            $("#translationStarted").fadeOut('slow', function () {
                $(this).remove();
            });

        });
    });

});