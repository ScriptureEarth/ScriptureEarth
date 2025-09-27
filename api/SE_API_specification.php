<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ScriptureEarth.org API specification</title>
<style>
li a {
  color: #096;
  font-weight: bold;
}
/* mouse over link */
a:hover {
  color: white;
  background-color: #096;
  text-decoration: none;
}

div + p {                       /* div followed immediately by p  */
  color: white;
  font-weight: bold;
  background-color: #096;
  padding: 8px;
}
</style>
</head>

<body link="#000080" vlink="#800000" dir="ltr" lang="en-US" xml:lang="en-US">
<h1 style="color: #039; text-align: center; font-family: Tahoma, Geneva, sans-serif; ">ScriptureEarth.org API</h1>

<h2 style="color: #900 ">Intro</h2>
<p>Welcome to the ScriptureEarth.org (SE) Application Programming Interface (API) specification. This API will retrieve an SE JSON that serves as a bridge, enabling SE to communicate with another application. The SE API exposes the application's data to anyone who has a key.</p>
<p>You will need a version number and your SE key. The available version numbers are now 1 or 2. You will need to email Scott Starker to obtain your key. This email only   needs to be sent once, but you will need to enter the key each time you   make an SE API request. His email address is <a href="mailto:scott_starker@sil.org">scott_starker@sil.org</a>.</p>
<p>A request is called by &quot;https://www.ScriptureEarth.org/api/[the request]?v=[version]&amp;key=[your key]&quot;. You will need to type the request. The requests are display in green below. Depending on the request you will need to type &quot;&amp;[iso=[ISO 639-3 code[&amp;rod=[ROD code][&amp;var=[variant code]]&quot;, <b>or</b> &quot;&amp;idx=[index number]&quot;, <b>or</b> &quot;&amp;pln=[language name and alternate language name]&quot;, <b>or</b> &quot;&amp;cc=[country code]&quot;, <b>or</b> &quot;&amp;country=[country name]]”.</p>
<p style='background-color: #FF0; '>New SE API requests are displayed with this background color. (5/13/2025)</p>
<h2 style="color: #900 ">Summary</h2>
<p>SE API has these requests now:</p>
<ul>
  <li>
    <p><a href='#records'>records.php</a> with the ISO 639-3 code, index number, or the English language name, the SE API  will pull out the counts of the products based on ISO 639-3 code, index number, or the English language name</p>
  </li>
  <li>
    <p><a href='#all_iso'>all_iso.php</a> the SE API will pull out the counts of <strong>all</strong> of the ISO 639-3 products</p>
  </li>
  <li>
  	<p><a href="#partial_languageNames">partial_languageNames.php</a> with the partial (3 or more letters) for English language names and alternate language names starting at the beginning of the words, the SE API  will pull out the English language names as well as the ISO 639-3 codes, index numbers, alternate language numbers and names, country names, and coumtry codes</p>
  </li>
  <li>
    <p><a href="#country">country.php</a> with the country name or country code, the SE API will pull out the English language names as well as the ISO 639-3 codes, index numbers, alternate language numbers, and alternate language names</p>
  </li>
  <li>
    <p><a href="#partial_countries">partial_countries.php</a> with the partial (2 or more letters) country names starting at the beginning of the words, the SE API will pull out the English language names as well as the ISO 639-3 codes, indexes, alternate language numbers, and alternate language names</p>
  </li>
  <li>
    <p><a href="#all_countries">all_countries.php</a> the SE API will pull out <strong>all</strong> of the countries and country codes</p>
  </li>
  <li>
  	<p style='background-color: #FF0; '><a href="#dialects">dialects.php</a> the SE API will pull out the dialect(s).</p>
  </li>
  <li>
    <p><a href="#media_se">media_se.php</a> with the ISO 639-3 code or index number, the SE API will pull out  all of the SE URLs for texts, audio, videos, audio playlists, video playlists, theWord (Windows OS), and the online viewer</p>
  </li>
  <li>
    <p><a href="#general_links">general_links.php</a> with the ISO 639-3 code or index number, the SE API will pull out  the  general  URLs for texts, audio, and videos (Bible.is, YouVersion, and watch full Scripture videos) also the websites for GRN and eBible</p>
  </li>
  <li>
    <p><a href="#apps">apps.php</a> with the ISO 639-3 code or index number, the SE API will pull out the Android app (apk) and iOS Assent Package for that ISO 639-3 code or index</p>
  </li>
  <li>
    <p style='background-color: #FF0; '><a href="#languageNames">languageNames.php</a> with the ISO 639-3 code, index number, or the country code with either the Android app (apk) and iOS Assent Package, or both, the SE API will pull out the language name(s)</p>
  </li>
  <li>
    <p><a href="#sab">sab.php</a> with the ISO 639-3 code or index number, the SE API will pull out path all of the SAB HTML files</p>
  </li>
  <li>
    <p><a href="#other_se">other_se.php</a> with the ISO 639-3 code or index number, the SE API will pull out the other SE audio/PDF/ePub files</p>
  </li>
  <li>
    <p><a href="#website_links">website_links.php</a> with the ISO 639-3 code or index number, the SE API will pull out the other website links (e.g., Kalaam Media, OneStory, iTunes, Facebook, Deaf Bibles, SIL Papua New Guinea, and other links)</p>
  </li>
  <li>
    <p><a href="#download_media">download_media.php</a> with the ISO 639-3 code or index number, the SE API will pull out  the downloadable SE files (OT and NT audio files, playlist audio files, playlist video files, The Word for Windows, etc.)</p>
  </li>
</ul>
<p>Each of the applications will pull out the JSON appropriate for that php.</p>

<h2 style="color: #900 ">In Depth</h2>
<p>Each of the requests will now be detailed.</p>
<div></div>
<p id='records'>records.php</p>
<div>
<p>To get every item for one language:</p>
<ul>
  <li>  
    With the ?v=1&amp;key=[your key], you will also need
  </li>
  <ul>
    <li>
      index number (type ‘&amp;idx=[index number]’)
    </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>
      ISO 639-3 code (type ‘&amp;iso=[ISO code]’) </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
   <li>
      ISO 639-3 code and ROD code [and variant code] (type ‘&amp;iso=[ISO code]&amp;rod=[ROD code][&amp;var=[variant code]]’)
    </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>
      language name and alternate language names (type ‘&amp;pln=[language name and alternate language names]’)
    </li>
  </ul>
</ul>
<p>will pull out</p>
<ul>
  <li>
    ISO 639-3 code
  </li>
  <li>
    ROD code
  </li>
  <li>
    variant code
  </li>
  <li>variant name</li>
  <li>
    index number
  </li>
  <li>
    10 navigational language query strings
  </li>
  <li>
    10 major language names
  </li>
  <li>
    alternate language numbers
  </li>
  <li>
    alternate language names
    <ul>
      <li>alternate language</li>
      <li>second alternate language</li>
      <li>... </li>
    </ul>
  </li>
  <li>
    English countries names
    <ul>
      <li>English country name</li>
      <li>second English country name</li>
      <li>...</li>
    </ul>
  </li>
  <li>
    countries codes
    <ul>
      <li>country code</li>
      <li>second country code</li>
      <li>...</li>
    </ul>
  </li>
  <li>
    number of SE apps
    <ul>
      <li>
        Android app (apk)
      </li>
      <li>
        iOS Asset Package
      </li>
    </ul>
  </li>
  <li>
    number of SE Scripture App Build HTMLs
    <ul>
      <li>
        text
      </li>
      <li>
        audio
      </li>
      <li>
        video
      </li>
    </ul>
  </li>
  <li>
    number of SE online viewers
  </li>
  <li>
    number of the SE media
    <ul>
      <li>
        text (OT and NT PDFs)
      </li>
      <li>
        audio (OT and NT audio recordings)
      </li>
      <li>
        video (OT and NT video recordings)
      </li>
      <li>
        audio playlists
      </li>
      <li>
        video playlists
      </li>
    </ul>
  </li>
  <li>
    number of the SE media downloads
    <ul>
      <li>
        text (OT and NT PDFs)
      </li>
      <li>
        audio (OT and NT audio recordings)
      </li>
      <li>
        video (OT and NT video recordings)
      </li>
      <li>
        video playlists
      </li>
    </ul>
  </li>
  <li>
    number of links to SE Google Play (apk)
  </li>
  <li>
    other SE software modules
    <ul>
      <li>
        number of GoBible
      </li>
      <li>
        number of MySword
      </li>
      <li>
        number of theWord Windows Bible software
      </li>
    </ul>
  </li>
  <li>
    links to media
    <ul>
    <li>
        number of links to Bible.is (Faith Comes by Hearing)
      </li>
      <li>
        number of links to LUMO Bible.is Gospel Film (Faith Comes by Hearing)
      </li>
      <li>
        number of links to YouVersions (Bible.com)
      </li>
      <li>
        number of links to eBible
      </li>
      <li>
        number of links to Global Recordings Network (GRN)
      </li>
    </ul>
  </li>
  <li>
    number of Bibles to buy
  </li>
  <li>
    number of links to maps
  </li>
  <li>
    number of links to watches
  </li>
  <li>
    number of links to other websites
  </li>
  <li>
    number of other titles
  </li>
  <li>
    number of links to SIL
  </li>
</ul>
<p>records.php will look like (https://scriptureearth.org/api/records.php?v=1&amp;key=[your key]&amp;iso=ngu) in raw data:</p>
<pre>
{<br>    &quot;0&quot;: {<br>        &quot;type&quot;: &quot;iso&quot;,<br>        &quot;id&quot;: &quot;1&quot;,<br>        &quot;attributes&quot;: {<br>            &quot;iso&quot;: &quot;ngu&quot;,<br>            &quot;num_nav&quot;: 9,<br>            &quot;navigation&quot;: {<br>                &quot;English&quot;: &quot;00eng.php&quot;,<br>                &quot;Spanish&quot;: &quot;00spa.php&quot;,<br>                &quot;Portugues&quot;: &quot;00por.php&quot;,<br>                &quot;French&quot;: &quot;00fra.php&quot;,<br>                &quot;Dutch&quot;: &quot;00nld.php&quot;,<br>                &quot;German&quot;: &quot;00deu.php&quot;,<br>                &quot;Chinese&quot;: &quot;00cmn.php&quot;,<br>                &quot;Korean&quot;: &quot;00kor.php&quot;,<br>                &quot;Russian&quot;: &quot;00rus.php,&quot;<br>                &quot;Arabic&quot;: &quot;00arb.php&quot;<br>            }<br>        },<br>        &quot;relationships&quot;: {<br>            &quot;rod&quot;: &quot;00000&quot;,<br>            &quot;var_code&quot;: &quot;&quot;,<br>            &quot;var_name&quot;: &quot;&quot;,<br>            &quot;iso_query_string&quot;: &quot;iso=ngu&quot;,<br>            &quot;idx&quot;: 113,<br>            &quot;idx_query_string&quot;: &quot;idx=113&quot;,<br>            &quot;language_name&quot;: {<br>                &quot;English&quot;: &quot;Náhuatl, Guerrero&quot;,<br>                &quot;Spanish&quot;: &quot;Náhuatl de Guerrero&quot;,<br>                &quot;Portuguese&quot;: &quot;&quot;,<br>                &quot;French&quot;: &quot;&quot;,<br>                &quot;Dutch&quot;: &quot;&quot;,<br>                &quot;German&quot;: &quot;&quot;,<br>                &quot;Chinese&quot;: &quot;&quot;,<br>                &quot;Korean&quot;: &quot;나후아틀, 게레로&quot;,<br>                &quot;Russian&quot;: &quot;Науатль, Герреро&quot;,<br>                &quot;Arabic&quot;: &quot;&quot;,<br>                &quot;minority&quot;: &quot;&quot;<br>            },<br>            &quot;alternate_language_count&quot;: 6,<br>            &quot;alternate_language_names&quot;: {<br>                &quot;0&quot;: &quot;Náhuatl (Nauatl; Azteca) de Guerrero Central&quot;,<br>                &quot;1&quot;: &quot;Mexicano (Mejicano) de Guerrero Central&quot;,<br>                &quot;2&quot;: &quot;Nahuatl, Guerrero&quot;,<br>                &quot;3&quot;: &quot;Guerrero Aztec&quot;,<br>                &quot;4&quot;: &quot;Mexicano de Guerrero&quot;,<br>                &quot;5&quot;: &quot;Xalitla Nahuatl&quot;<br>            },<br>            &quot;country_count&quot;: 1,<br>            &quot;countries_names&quot;: {<br>                &quot;0&quot;: &quot;Mexico&quot;<br>            },<br>            &quot;countries_codes&quot;: {<br>                &quot;0&quot;: &quot;MX&quot;<br>            },<br>            &quot;se_apps&quot;: {<br>                &quot;android&quot;: 6,<br>                &quot;ios&quot;: 1<br>            },<br>            &quot;se_sab&quot;: {<br>                &quot;text&quot;: 1095,<br>                &quot;audio&quot;: 0,<br>                &quot;video&quot;: 0<br>            },<br>            &quot;se_online_viewer&quot;: 1,<br>            &quot;se_media&quot;: {<br>                &quot;text&quot;: 33,<br>                &quot;ePub&quot;: 0,<br>                &quot;audio&quot;: 187,<br>                &quot;video&quot;: 0,<br>                &quot;playlist_audio&quot;: 1,<br>                &quot;playlist_video&quot;: 4<br>            },<br>            &quot;se_download_media&quot;: {<br>                &quot;text&quot;: 33,<br>                &quot;audio&quot;: 187,<br>                &quot;video&quot;: 0,<br>                &quot;playlist_video&quot;: 3<br>            },<br>            &quot;se_google_play&quot;: 1,<br>            &quot;se_other_software&quot;: {<br>                &quot;GoBible&quot;: 1,<br>                &quot;MySword&quot;: 0,<br>                &quot;theWord&quot;: 1<br>            },<br>            &quot;links_media&quot;: {<br>                &quot;Bible.is&quot;: 2,<br>                &quot;Bible.is_Gospel_Film&quot;: 1,<br>                &quot;YouVersion&quot;: 2,<br>                &quot;eBible&quot;: 1,<br>                &quot;GRN&quot;: 1<br>            },<br>            &quot;buy&quot;: 1,<br>            &quot;maps&quot;: 1,<br>            &quot;watch&quot;: 1,<br>            &quot;websites&quot;: 0,<br>            &quot;other_titles&quot;: 1,<br>            &quot;SIL_link&quot;: 1<br>        }<br>    }<br>}
</pre>
</div>
<p id='all_iso'>all_iso.php</p>
<div>
<p>same as records.php but pulls the counts of <strong>all</strong> of the ISO 639-3 products</p>
</div>
<p id='partial_languageNames'>partial_languageNames.php</p>
<div>
<p>To get at least 3 letters for English language names and alternate language names starting at the beginning of the words</p>
<ul>
  <li>  
    With the ?v=1&amp;key=[your key], you will also need
  </li>
  <ul>
    <li>
    partial language names (type ‘&amp;ln=[partial language names]’)
    </li>
  </ul>
</ul>
<p>will pull out</p>
<ul>
  <li>English language names</li>
  <li>ISO 639-3 codes</li>
  <li>
    ROD codes
  </li>
  <li>
    variant codes
  </li>
  <li>variant names</li>
  <li>index numbers</li>
  <li>alternate language numbers</li>
  <li>alternate language names</li>
  <li>country names</li>
  <li>coumtry codes</li>
</ul>
</div>
<p id='country'>country.php</p>
<div>
<p>To get the country:</p>
<ul>
  <li>  
    With the ?v=1&amp;key=[your key], you will also need </li>
  <ul>
    <li>
      English country name (type ‘&amp;country=[English country name]’)
    </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>
      country code (type ‘&amp;cc=[country code]’)
    </li>
  </ul>
</ul>
<p>will pull out</p>
<ul>
  <li>
    English country name
  </li>
  <li>
    country code
  </li>
  <li>
    ISO 639-3 code
  </li>
  <li>
    ROD code
  </li>
  <li>
    variant code
  </li>
  <li>variant name</li>
  <li>
    index number
  </li>
  <li>English language name</li>
  <li>
    alternate language numbers
  </li>
  <li>
    alternate language names
  </li>
</ul>
</div>
<p id='partial_countries'>partial_countries.php</p>
<div>
<p>To get  at least 2 letters starting at the beginning of the word</p>
<ul>
  <li>  
    With the ?v=1&amp;key=[your key], you will also need
  </li>
  <ul>
    <li>
      partial country name in English (type ‘&amp;pc=[partial country name]’)
    </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>
      partial country name and major language (type '&amp;pc=[partial country name]&amp;ml=[English, Spanish, Portuguese, French, Dutch, German, Chinese, Russian, Korean, or Arabic]’)
  </li>
  </ul>
</ul>
<p>will pull out</p>
<ul>
  <li>
    country name
  </li>
  <li>
    country code
  </li>
  <li>
    ISO 639-3 code
  </li>
  <li>
    ROD code
  </li>
  <li>
    variant code
  </li>
  <li>variant name</li>
  <li>
    index number
  </li>
  <li>
    English language name
  </li>
  <li>
    alternate language numbers
  </li>
  <li>
    alternate language names
  </li>
</ul>
</div>
<p id='all_countries'>all_countries.php</p>
<div>
<p>To get all the countries</p>
<ul>
  <li>v=1&key=[your key]</li>
  <ul>
  <li><em>optional</em>: major language (type '&amp;ml=[English, Spanish, Portuguese, French, Dutch, German, Chinese, Russian, Korean, or Arabic]’)</li>
  </ul>
</ul>
<p>will pull out</p>
<ul>
  <li>country names</li>
  <li>country codes</li>
</ul>
</div>
<p id='dialects'>dialects.php</p>
<div style='background-color: #FF0; '>
<p>To get the dialect(s)</p>
<ul>
  <li>With the ?v=1&amp;key=[your key], you will also need </li>
  <ul>
  <li>just the dialect names only (type ‘&amp;all=justdialects’)</li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
  	<li>all of the dialects (type ‘&amp;all=dialects’)</li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
  	<li>a dialect (type ‘&amp;dialect=[the particular name of the dialect]’)</li>
  </ul>
</ul>
<p>will pull out</p>
<ul>
  <li>total countries for the dialect</li>
  <li>
    ISO 639-3 codes</li>
  <li>
    ROD codes</li>
  <li>
    variant codes</li>
  <li>variant names</li>
  <li>
    index numbers</li>
  <li>language names</li>
  <li>individual countries based on the language name</li>
</ul>
</div>
<p id='media_se'>media_se.php</p>
<div>
<p>To get the ScriptureEarth media:</p>
<ul>
<li>  
    With the ?v=1&amp;key=[your key], you will also need
  </li>
  <ul>
    <li>
      index number (type ‘&amp;idx=[index number]’)
    </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>
      ISO 639-3 code (type ‘&amp;iso=[ISO code]’)
    </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>
      ISO 639-3 code and ROD code [and variant code] (type ‘&amp;iso=[ISO code]&amp;rod=[ROD code][&amp;var=[variant code]]’)
    </li>
  </ul>
</ul>
<p>will pull out all of the ScriptureEarth URLs for</p>
<ul>
  <li>
    ISO 639-3 code</li>
  <li>
    ROD code</li>
  <li>
    variant code</li>
  <li>variant name</li>
  <li>
    index number</li>
      <li>
        texts (OT and NT PDFs)
      </li>
      <li>
        audio (OT and NT audio recordings)
      </li>
      <li>
        videos (OT and NT video recordings)
      </li>
      <li>
        audio playlists
      </li>
      <li>
        video playlists
      </li>
    <li>theWord (Windows OS)</li>
  <li>online viewer</li>
</ul>
</div>
<p id='general_links'>general_links.php</p>
<div>
<p>To get the links:</p>
<ul>
  <li>  
    With the ?v=1&amp;key=[your key], you will also need
  </li>
  <ul>
    <li>
      index number (type ‘&amp;idx=[index number]’)
    </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>
      ISO 639-3 code (type ‘&amp;iso=[ISO code]’)
    </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>
      ISO 639-3 code and ROD code [and variant code] (type ‘&amp;iso=[ISO code]&amp;rod=[ROD code][&amp;var=[variant code]]’)
    </li>
  </ul>
</ul>
<p>will pull out the  general  URLs for</p>
<ul>
<li>Bible.is (Faith Comes by Hearing)</li>
  <ul>
    <li>Read</li>
    <li>Read and Listen</li>
    <li>Read, Listen, and View</li>
  </ul>
<li>LUMO Bible.is Gospel Film (Faith Comes by Hearing)</li>
<li>YouVersion (Bible.com)</li>
<li>Global Recordings Network (GRN)</li>
<li>eBible</li>
<li>Watch full videos from  websites other than ScriptureEarth.org
  <ul>
    <li>Jesus Film</li>
    <li>Scripture YouTube videos</li>
    <li>other Scripture videos</li>
  </ul>
</li>
</ul>
</div>
<p id='apps'>apps.php</p>
<div>
<p>To get the Android, iOS, or both apps:</p>
<ul>
  <li>  
    With the ?v=[1 or 2]&amp;key=[your key], you will also need
  </li>
  <ul>
    <li>
      index number (type ‘&amp;idx=[index number]’)
    </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>
      ISO 639-3 code (type ‘&amp;iso=[ISO code][&amp;rel=[android OR ios]]’
    </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>
      All the ISO 639-3 codes (type ‘&amp;iso=ALL[&amp;rel=[android OR ios]]’)
    </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>
      ISO 639-3 code and ROD code [and variant code] (type ‘&amp;iso=[ISO code]&amp;rod=[ROD code][&amp;var=[variant code]][&amp;rel=[android OR ios]]’)
    </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>country code or country with either Android, iOS, or both (type '&amp;cc=[country code]' OR '&amp;country=[English country name]'[&amp;rel=[android OR ios]])</li>
  </ul>
</ul>
<p>will pull out</p>
<ul>
  <li>
    ISO 639-3 code(s)
  </li>
  <li>
    ROD code(s)
  </li>
  <li>
    variant code(s)
  </li>
  <li>variant name(s)</li>
  <li>
    index number(s)
  </li>
  <li>
    links to Android apps
  </li>
  <li>
    link to iOS Asset Package
  </li>
</ul>
<p>version 2 will add</p>
<ul>
  <li>
    the descriptions of each link
  </li>
</ul>
<p>apps.php will look like (https://scriptureearth.org/api/apps.php?v=2&amp;key=[your key]&amp;cc=MX):</p>
<p><img src="../images/apps.php.jpeg"></p>
</div>

<p id='languageNames'>languageNames.php</p>
<div style='background-color: #FF0; '>
<p>To get the language name(s) and mobile devices:</p>
<ul>
  <li>  
    With the ?v=1&amp;key=[your key], you will also need
  </li>
  <ul>
    <li>
      index number (type ‘&idx=[index number]’)
    </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>
      ISO 639-3 code (type ‘&amp;iso=[ISO code]’)
    </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>
      ISO 639-3 code and ROD code [and variant code] (type ‘&amp;iso=[ISO code]&amp;rod=[ROD code][&amp;var=[variant code]]’)
    </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>
      country code  with either the Android app (apk) and iOS Assent Package, or both (type '&amp;cc=[country code][[&amp;rel=ios or android]]')
    </li>
  </ul>
</ul>
<p>will pull out</p>
<ul>
  <li>
    ISO 639-3 code(s)</li>
  <li>
    ROD code(s)</li>
  <li>
    variant code(s)
  </li>
  <li>variant name(s)</li>
  <li>
    index number(s)</li>
  <li>
    English language name(s)
  </li>
  <li>[iOS and/or Android for the country code]
    <ul>
      <li>[title]</li>
      <li>[file name]</li>
      <li>[optional]</li>
    </ul>
  </li>
</ul>
<p>languageNames.php will look like (https://scriptureearth.org/api/languageNames.php?v=2&amp;key=[your key]&amp;cc=MX&amp;rel=ios):</p>
<img src="../images/languageNames.php.jpg" width="833" height="557" />
</div>

<p id='sab'>sab.php</p>
<div>
<p>To get the SAB HTML:</p>
<ul>
  <li>  
    With the ?v=1&amp;key=[your key], you will also need
  </li>
  <ul>
    <li>
      index number (type ‘&amp;idx=[index number]’)
    </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>
      ISO 639-3 code (type ‘&amp;iso=[ISO code]’)
    </li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>
      ISO 639-3 code and ROD code [and variant code] (type ‘&amp;iso=[ISO code]&amp;rod=[ROD code][&amp;var=[variant code]]’)
    </li>
  </ul>
</ul>
<p>will pull out</p>
<ul>
  <li>
    ISO 639-3 code</li>
  <li>
    ROD code</li>
  <li>
    variant code</li>
  <li>variant name</li>
  <li>
    index number</li>
  <li>
    path to the HTML files</li>
  <li>
    all of the HTML files</li>
</ul>
</div>
<p id='other_se'>other_se.php</p>
<div>
<p>To get the other ScritureEarth items:</p>
<ul>
  <li>  
    With the ?v=1&amp;key=[your key], you will also need
  </li>
  <ul>
    <li>index number (type ‘&amp;idx=[index number]’)</li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>ISO 639-3 code (type ‘&amp;iso=[ISO code]’)</li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>ISO 639-3 code and ROD code [and variant code] (type ‘&amp;iso=[ISO code]&amp;rod=[ROD code][&amp;var=[variant code]]’)</li>
  </ul>
</ul>
<p>will pull out</p>
<ul>
  <li>ISO 639-3 code</li>
  <li>ROD code</li>
  <li>variant code</li>
  <li>variant name</li>
  <li>index number</li>
  <li>path to the other PDF/ePub or audio SE files</li>
  <li>all of the other PDF/ePub or audio SE files</li>
</ul>
</div>
<p id='website_links'>website_links.php</p>
<div>
<p>To get the website links:</p>
<ul>
  <li>  
    With the ?v=1&amp;key=[your key], you will also need
  </li>
  <ul>
    <li>index number (type ‘&amp;idx=[index number]’)</li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>ISO 639-3 code (type ‘&amp;iso=[ISO code]’)</li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>ISO 639-3 code and ROD code [and variant code] (type ‘&amp;iso=[ISO code]&amp;rod=[ROD code][&amp;var=[variant code]]’)</li>
  </ul>
</ul>
<p>will pull out</p>
<ul>
  <li>ISO 639-3 code</li>
  <li>ROD code</li>
  <li>variant code</li>
  <li>variant name</li>
  <li>index number</li>
  <li>all of the website links (e.g., Kalaam Media, OneStory, iTunes, Facebook, Deaf Bibles, SIL Papua New Guinea, and other links)</li>
</ul>
</div>
<p id='download_media'>download_media.php</p>
<div>
<p>To get the downloadable media:</p>
<ul>
  <li>  
    With the ?v=1&amp;key=[your key], you will also need
  </li>
  <ul>
    <li>index number (type ‘&amp;idx=[index namer]’)</li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>ISO 639-3 code (type ‘&amp;iso=[ISO code]’)</li>
    <li>&nbsp;&nbsp;&nbsp;&nbsp;OR</li>
    <li>ISO 639-3 code and ROD code [and variant code] (type ‘&amp;iso=[ISO code]&amp;rod=[ROD code][&amp;var=[variant code]]’)</li>
  </ul>
</ul>
<p>will pull out</p>
<ul>
  <li>ISO 639-3 code</li>
  <li>ROD code</li>
  <li>variant code</li>
  <li>variant name</li>
  <li>index number</li>
  <li>path to the  files (audio, video, PDF, and study folders)</li>
  <li>all of the downloadable SE files (OT and NT audio files, playlist audio files, playlist video files, PDF files, The Word for Windows, etc.)</li>
</ul>
</div>
<br/>
<br/>
</body>
</html>