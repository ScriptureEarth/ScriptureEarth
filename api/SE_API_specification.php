<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ScriptureEarth.org API specification</title>
</head>

<body link="#000080" vlink="#800000" dir="ltr" lang="en-US" xml:lang="en-US">
<h1 style="color: #039; text-align: center; font-family: Tahoma, Geneva, sans-serif; ">ScriptureEarth.org API</h1>

<h2 style="color: #900 ">Intro</h2>
<p>Welcome to the ScriptureEarth.org (SE) Application Programming Interface (API) specification. This API will pull an SE JSON which acts as an intermediary that allows SE to “talk” to another application. The SE API exposes the application's data to anyone who has a key.</p>
<p>You will need to have a version number and your SE key. The version number is now version 1. You will need to send an email to Scott Starker to get you key. Sending the email is done only once although you will need to enter the key for each time you make a SE API request. His email address is <a href="mailto:scott_starker@sil.org">scott_starker@sil.org</a>.</p>
<p>A request is called by &quot;https://www.ScriptureEarth.org/api/[the request]?v=[version]&amp;key=[your key]&quot;. You will need to chose the &quot;request&quot; which is in  the color green below. You will also have to type &quot;&amp;[iso=[ISO 639-3 code[&amp;rod=[ROD code][&amp;var=[variant code]]&quot;, <b>or</b> &quot;&amp;idx=[index]&quot;, <b>or</b> &quot;&amp;pln=[language name and alternate language name]&quot;, <b>or</b> &quot;&amp;cc=[country code]&quot;, <b>or</b> &quot;&amp;country=[country name]]”.</p>
<h2 style="color: #900 ">Summary</h2>
<p>SE API has these requests now:</p>
<ul>
  <li>
    <p><span style="color: #096; font-weight: bold; ">records.php</span> with the ISO 639-3 code, index, or the English language name the SE API and will pull out the counts of the products based on ISO 639-3 code, index, or the English language name</p>
  </li>
  <li>
    <p><span style="color: #096; font-weight: bold; ">all_iso.php</span> the SE API will pull out the counts of <strong>all</strong> of the ISO 639-3 products</p>
  </li>
  <li>
  	<p><span style="color: #096; font-weight: bold; ">partial_languageNames.php</span> with the partial (3 or more letters) for English language names and alternate language names starting at the beginning of the words and will pull out the English language names as well as the ISO 639-3 codes, indexes, alternate language numbers and names, country names, and coumtry codes</p>
  </li>
  <li>
    <p><span style="color: #096; font-weight: bold; ">country.php</span> with the country name or country code the SE API will pull out the English language names as well as the ISO 639-3 codes, indexes, alternate language numbers, and alternate language names</p>
  </li>
  <li>
    <p><span style="color: #096; font-weight: bold; ">partial_countries.php</span> with the partial (2 or more letters) country names starting at the beginning of the words and will pull out the English language names as well as the ISO 639-3 codes, indexes, alternate language numbers, and alternate language names</p>
  </li>
  <li>
    <p><span style="color: #096; font-weight: bold; ">all_countries.php</span> the SE API will pull out <strong>all</strong> of the countries and country codes</p>
  </li>
  <li>
  	<p><span style="color: #096; font-weight: bold; ">media_se.php</span> with the ISO 639-3 code or index the SE API will pull out  all of the SE URLs for texts, audio, videos, audio playlists, video playlists, theWord (Windows OS), and the online viewer</p>
  </li>
  <li>
    <p><span style="color: #096; font-weight: bold; ">general_links.php</span> with the ISO 639-3 code or index the SE API will pull out  the  general  URLs for texts, audio, and videos (Bible.is, YouVersion, and watch full Scripture videos) also the websites for GRN and eBible</p></li>
  <li>
    <p><span style="color: #096; font-weight: bold; ">apps.php</span> with the ISO 639-3 code or index the SE API will pull out the Android app (apk) and iOS Assent Package for that ISO 639-3 code or index</p>
  </li>
  <li>
    <p><span style="color: #096; font-weight: bold; ">sab.php</span> with the ISO 639-3 code or index the SE API will pull out path and all of the SAB HTML files</p>
  </li>
  <li>
    <p><span style="font-size: larger; color: red; font-weight: bold; background-color: yellow; ">Newest one:</span> <span style="color: #096; font-weight: bold; ">other_se.php</span> with the ISO 639-3 code or index the SE API will pull out  the other SE audio/PDF/ePub files</p>
  </li>
  <li>
    <p><span style="font-size: larger; color: red; font-weight: bold; background-color: yellow; ">Newest one:</span> <span style="color: #096; font-weight: bold; ">website_links.php</span> with the ISO 639-3 code or index the SE API will pull out  the other website links (e.g. OneStory, iTunes, Facebook, and other links)</p>
  </li>
  <li>
    <p><span style="font-size: larger; color: red; font-weight: bold; background-color: yellow; ">Newest one:</span> <span style="color: #096; font-weight: bold; ">download_media.php</span> with the ISO 639-3 code or index the SE API will pull out  the downloadable SE files (OT and NT audio files, playlist audio files, playlist video files, The Word for Windows, etc.)</p>
  </li>
</ul>
<p>Each of the applications will pull out the JSON appropriate for that php.</p>

<h2 style="color: #900 ">In Depth</h2>
<p>Each of the requests will now be examined.</p>
<p><span style="color: #096; font-weight: bold; ">records.php</span></p>
<div id='record'>
<p>To get the records.php of all (only 1 line per records.php)</p>
<ul>
  <li>
    index (type ‘?idx=[index]’)
  </li>
  <li>
    ISO 639-3 code (type ‘?iso=[ISO code]’)
  </li>
  <li>
    ISO 639-3 code and ROD code and variant code (type ‘?iso=[ISO code]&amp;rod=[ROD code]&amp;var=[variant code]’) </li>
  <li>
    language name and alternate language names (type ‘?pln=[language name and alternate language names]’)
  </li>
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
    index
  </li>
  <li>
    6 navigational language query strings
  </li>
  <li>
    6 major language names
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
        number of links to YouVersions
      </li>
      <li>
        number of links to eBible
      </li>
      <li>
        number of links to GRNs
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
</div>
<p><span style="color: #096; font-weight: bold; ">all_iso.php</span></p>
<div id='all_iso'>
<p>same as records.php but pulls the counts of <strong>all</strong> of the ISO 639-3 products</p>
</div>
<p><span style="color: #096; font-weight: bold; ">partial_languageNames.php</span></p>
<div id='partial_languageNames'>
<p>To get at least 3 letters for English language names and alternate language names starting at the beginning of the words</p>
<ul>
  <li>
  partial language names (type ‘?ln=[partial language names]’)
  </li>
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
  <li>indexes</li>
  <li>alternate language numbers</li>
  <li>alternate language names</li>
  <li>country names</li>
  <li>coumtry codes</li>
</ul>
</div>
<p><span style="color: #096; font-weight: bold; ">country.php</span></p>
<div id='country'>
<p>To get the country.php of the (only 1 line per country.php)</p>
<ul>
  <li>
    English country name (type ‘?country=[English country name]’)
  </li>
  <li>
    country code (type ‘?cc=[country code]’)
  </li>
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
    index
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
<p><span style="color: #096; font-weight: bold; ">partial_countries.php</span></p>
<div id='partial_countries'>
<p>To get  at least 2 letters starting at the beginning of the word</p>
<ul>
  <li>
  partial country name (type ‘?pc=[partial country name]’)
  </li>
  <li>
  <em>optional</em>: major language (type '?ml=English (default), Spanish, Portuguese, French, Dutch, or German’)
  </li>
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
    index
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
<p><span style="color: #096; font-weight: bold; ">all_countries.php</span></p>
<div id='all_countries'>
<p>To get all_countries.php</p>
<ul>
  <li><em>optional</em>: major language (type '?ml=English (default), Spanish, Portuguese, French, Dutch, or German’)</li>
</ul>
<p>will pull out</p>
<ul>
  <li>country names</li>
  <li>country codes</li>
</ul>
</div>
<p><span style="color: #096; font-weight: bold; ">media_se.php</span></p>
<div id='media_se'>
<p>To get the media_se.php of the (only 1 line per apps.php)</p>
<ul>
  <li>
    index (type ‘?idx=[index]’)</li>
  <li>
    ISO 639-3 code (type ‘?iso=[ISO code]’)</li>
  <li>
    ISO 639-3 code and ROD code and variant code (type ‘?iso=[ISO code]&amp;rod=[ROD code]&amp;var=[variant code]’)</li>
</ul>
<p>will pull out all of the SE URLs for</p>
<ul>
  <li>
    ISO 639-3 code</li>
  <li>
    ROD code</li>
  <li>
    variant code</li>
  <li>variant name</li>
  <li>
    index</li>
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
<p><span style="color: #096; font-weight: bold; ">general_links.php</span></p>
<div id='general_links'>
<p>To get the apps.php of the (only 1 line per apps.php)</p>
<ul>
  <li> index (type ‘?idx=[index]’) </li>
  <li> ISO 639-3 code (type ‘?iso=[ISO code]’) </li>
  <li> ISO 639-3 code and ROD code and variant code (type ‘?iso=[ISO code]&amp;rod=[ROD code]&amp;var=[variant code]’) </li>
</ul>
<p>will pull out the  general  URLs for</p>
<ul>
<li>Bible.is (Faith Comes by Hearing)
  <ul>
    <li>Read</li>
    <li>Read and Listen</li>
    <li>Read, Listen, and View</li>
  </ul>
</li>
<li>YouVersion (Bible.com)</li>
<li>Global Recordings Network (GRN) website</li>
<li>eBible website</li>
<li>Watch full videos from  websites other than ScriptureEarth.org
  <ul>
    <li>Jesus Film</li>
    <li>Scripture YouTube videos</li>
    <li>other Scripture videos</li>
  </ul>
</li>
</ul>
</div>
<p><span style="color: #096; font-weight: bold; ">apps.php</span></p>
<div id='apps'>
<p>To get the apps.php of the (only 1 line per apps.php)</p>
<ul>
  <li>
    index (type ‘?idx=[index]’)
  </li>
  <li>
    ISO 639-3 code (type ‘?iso=[ISO code][&amp;rel=[android OR ios]]’</li>
  <li><span style="font-size: larger; color: red; font-weight: bold; background-color: yellow; ">Newest one:</span> All the ISO 639-3 codes (type ‘?iso=ALL[&amp;rel=[android OR ios]]’) </li>
  <li>
    ISO 639-3 code and ROD code and variant code (type ‘?iso=[ISO code]&amp;rod=[ROD code]&amp;var=[variant code][&amp;rel=[android OR ios]]’) </li>
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
    index
  </li>
  <li>
    links to Android apps
  </li>
  <li>
    link to iOS Asset Package
  </li>
</ul>
</div>
<p><span style="color: #096; font-weight: bold; ">sab.php</span></p>
<div id='sab'>
<p>To get the sab.php of the (only 1 line per apps.php)</p>
<ul>
  <li>
    index (type ‘?idx=[index]’)</li>
  <li>
    ISO 639-3 code (type ‘?iso=[ISO code]’)</li>
  <li>
    ISO 639-3 code and ROD code and variant code (type ‘?iso=[ISO code]&amp;rod=[ROD code]&amp;var=[variant code]’)</li>
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
    index</li>
  <li>
    path to the HTML files</li>
  <li>
    all of the HTML files</li>
</ul>
</div>
<p><span style="color: #096; font-weight: bold; ">other_se.php</span></p>
<div id='other_se'>
<p>To get the other_se.php of the (only 1 line per apps.php)</p>
<ul>
  <li>index (type ‘?idx=[index]’)</li>
  <li>ISO 639-3 code (type ‘?iso=[ISO code]’)</li>
  <li>ISO 639-3 code and ROD code and variant code (type ‘?iso=[ISO code]&amp;rod=[ROD code]&amp;var=[variant code]’)</li>
</ul>
<p>will pull out</p>
<ul>
  <li>ISO 639-3 code</li>
  <li>ROD code</li>
  <li>variant code</li>
  <li>variant name</li>
  <li>index</li>
  <li>path to the other PDF/ePub or audio SE files</li>
  <li>all of the other PDF/ePub or audio SE files</li>
</ul>
</div>
<p><span style="color: #096; font-weight: bold; ">website_links.php</span></p>
<div id='website_links'>
<p>To get the website_links.php of the (only 1 line per apps.php)</p>
<ul>
  <li>index (type ‘?idx=[index]’)</li>
  <li>ISO 639-3 code (type ‘?iso=[ISO code]’)</li>
  <li>ISO 639-3 code and ROD code and variant code (type ‘?iso=[ISO code]&amp;rod=[ROD code]&amp;var=[variant code]’)</li>
</ul>
<p>will pull out</p>
<ul>
  <li>ISO 639-3 code</li>
  <li>ROD code</li>
  <li>variant code</li>
  <li>variant name</li>
  <li>index</li>
  <li>all of the website links (e.g. OneStory, iTunes, Facebook, and other links)</li>
</ul>
</div>
<p><span style="color: #096; font-weight: bold; ">download_media.php</span></p>
<div id='download_media'>
<p>To get the download_media.php of the (only 1 line per apps.php)</p>
<ul>
  <li>index (type ‘?idx=[index]’)</li>
  <li>ISO 639-3 code (type ‘?iso=[ISO code]’)</li>
  <li>ISO 639-3 code and ROD code and variant code (type ‘?iso=[ISO code]&amp;rod=[ROD code]&amp;var=[variant code]’)</li>
</ul>
<p>will pull out</p>
<ul>
  <li>ISO 639-3 code</li>
  <li>ROD code</li>
  <li>variant code</li>
  <li>variant name</li>
  <li>index</li>
  <li>path to the  files (audio, video, PDF, and study folders)</li>
  <li>all of the downloadable SE files (OT and NT audio files, playlist audio files, playlist video files, PDF files, The Word for Windows, etc.)</li>
</ul>
</div>
<p><br/>
  <br/>
</p>
</body>
</html>