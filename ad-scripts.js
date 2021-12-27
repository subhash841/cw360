//Interstitial ads
window.googletag=window.googletag||{cmd:[]};var interstitialSlot,staticSlot;googletag.cmd.push(function(){interstitialSlot=googletag.defineOutOfPageSlot('/22367406785/adi-interstitial',googletag.enums.OutOfPageFormat.INTERSTITIAL);if(interstitialSlot){interstitialSlot.setTargeting('site',['crowdwisdom360.com']).addService(googletag.pubads());googletag.pubads().addEventListener('slotOnload',function(event){});} googletag.enableServices();});googletag.cmd.push(function(){googletag.display(interstitialSlot);});

//Adds default css for ad slots
var css = '.ads {text-align: center; padding-top: 10px; padding-bottom: 5px;}',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');
if (style.styleSheet){
// This is required for IE8 and below.
  style.styleSheet.cssText = css;
} else {
  style.appendChild(document.createTextNode(css));
}
head.appendChild(style);

//Adds AdsStar.In link to a slot
window.addEventListener("load", function(){
  var adSlot = document.getElementsByClassName("ads-star");
  var adSlotLength = adSlot.length;

  for(var i = 0; i < adSlotLength; i++) {
    adSlot[i].style.cssText ="z-index: 9999;display: inline-block; width: 100%; text-align: center; padding-bottom: 10px;"
    var adsLink = document.createElement("a");
    adSlot[i].appendChild(adsLink);
    adsLink.style.cssText ="text-align: right; clear: both; text-decoration: none; color:black; font-size: 10px; font-family: Tahoma;"
    adsLink.href = 'https://adsstar.in';
    var text = document.createTextNode("Powered by AdsStar");
    adsLink.appendChild(text);
  }
});

//Adds styles for Sticky Footer (Banner)
var banner = '.ad-sticky-banner {display: inline-block; z-index: 10001 ;}',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');
if (style.styleSheet){
  // This is required for IE8 and below.
  style.styleSheet.cssText = banner;
} else {
  style.appendChild(document.createTextNode(banner));
}
head.appendChild(style);

//Adds styles for Sticky Footer (Slot container)
var stickySlot = '.ad-sticky-slot {position: fixed; height: auto; width: 100%; text-align: center; bottom: 0; left: 0; z-index: 9999; background-color: rgba(237,237,237,.7);}',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');
if (style.styleSheet){
  // This is required for IE8 and below.
  style.styleSheet.cssText = stickySlot;
} else {
  style.appendChild(document.createTextNode(stickySlot));
}
head.appendChild(style);

//Adds styles for Sticky Footer (Close button)
var stickyButton = '.ad-sticky-close-button {position:absolute; cursor: pointer; width:28px; height:28px; top:-28px; right:0; color: #000; font-weight: bolder; background: rgba(237,237,237, .7); box-shadow:0 -1px 1px 0 rgba(0,0,0,0.2); border:none; border-radius:12px 0 0 0; font-size:20px; font-family: monospace;}',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');
if (style.styleSheet){
  // This is required for IE8 and below.
  style.styleSheet.cssText = stickyButton;
} else {
  style.appendChild(document.createTextNode(stickyButton));
}
head.appendChild(style);

//GPT init calls
window.googletag = window.googletag || {cmd: []};

//Variables for ad units to display in the Quize plugin
var billboard1;
var billboard2;
var billboard3;
var skyscraper1;
var skyscraper2;
var MPU1;
var MPU2;
var MPU3;
var leaderboard1;
var leaderboard2;
var stickyFooter;

googletag.cmd.push(function () {

  //Setting up responsive ads size mapping
  var billboardSizes = googletag.sizeMapping()
  .addSize([992, 0], [[970, 90],[970, 250],[728, 90]]) //desktop
  .addSize([768, 0], [[728, 90],[468, 60]])            //tablet
  .addSize([320, 0], [[320, 50],[320, 100],[300, 50]]) //mobile
  .addSize([0, 0], [])
  .build();

  var skyscraperSizes = googletag.sizeMapping()
  .addSize([768, 0], [[300, 600],[160, 600],[120, 600]]) //desktop & tablet
  .build();

  var rectangleSizes = googletag.sizeMapping()
  .addSize([768, 0], [[300, 250],[336, 280],[250, 250],[200, 200]]) //desktop & tablet
  .addSize([320, 0], [[300, 250],[250, 250],[200, 200]])            //mobile
  .addSize([0, 0], [])
  .build();

  var leaderboardSizes = googletag.sizeMapping()
  .addSize([768, 0], [[728, 90],[468, 60]])  //desktop & tablet
  .addSize([320, 0], [[320, 50],[320, 100]]) //mobile
  .addSize([0, 0], [])
  .build();

  var SECONDS_TO_WAIT_AFTER_VIEWABILITY = 30; //sets the refresh interval in seconds
              
  //Responsive Billboard slots initialization
  billboard1 = googletag.defineSlot("/22367406785/billboard1", [728, 90], "billboard-1")
      .defineSizeMapping(billboardSizes)
      .setTargeting('pos', ['billboard1'])
      .addService(googletag.pubads());

  billboard2 = googletag.defineSlot("/22367406785/billboard2", [728, 90], "billboard-2")
      .defineSizeMapping(billboardSizes)
      .setTargeting('pos', ['billboard2'])
      .addService(googletag.pubads());

  billboard3 = googletag.defineSlot("/22367406785/billboard3", [728, 90], "billboard-3")
      .defineSizeMapping(billboardSizes)
      .setTargeting('pos', ['billboard3'])
      .addService(googletag.pubads());

  //Responsive Skyscraper slots initialization
  skyscraper1 = googletag.defineSlot("/22367406785/skyscraper1", [160, 600], "skyscraper-1")
      .defineSizeMapping(skyscraperSizes)
      .setTargeting('pos', ['skyscraper1'])
      .addService(googletag.pubads());

  skyscraper2 = googletag.defineSlot("/22367406785/skyscraper2", [160, 600], "skyscraper-2")
      .defineSizeMapping(skyscraperSizes)
      .setTargeting('pos', ['skyscraper2'])
      .addService(googletag.pubads());

  //Responsive MPU slots initialization
  MPU1 = googletag.defineSlot("/22367406785/MPU1", [300, 250], "MPU-1")
      .defineSizeMapping(rectangleSizes)
      .setTargeting('pos', ['MPU1'])
      .addService(googletag.pubads());

  MPU2 = googletag.defineSlot("/22367406785/MPU2", [300, 250], "MPU-2")
      .defineSizeMapping(rectangleSizes)
      .setTargeting('pos', ['MPU2'])
      .addService(googletag.pubads());

  MPU3 = googletag.defineSlot("/22367406785/MPU3", [300, 250], "MPU-3")
      .defineSizeMapping(rectangleSizes)
      .setTargeting('pos', ['MPU3'])
      .addService(googletag.pubads());

  //Responsive Leaderboard slots initialization
  leaderboard1 = googletag.defineSlot("/22367406785/leaderboard1", [320, 50], "leaderboard-1")
      .defineSizeMapping(leaderboardSizes)
      .setTargeting('pos', ['leaderboard1'])
      .addService(googletag.pubads());
      
  leaderboard2 = googletag.defineSlot("/22367406785/leaderboard2", [320, 50], "leaderboard-2")
      .defineSizeMapping(leaderboardSizes)
      .setTargeting('pos', ['leaderboard2'])
      .addService(googletag.pubads());

  //Responsive sticky footer slot initialization
  stickyFooter = googletag.defineSlot("/22367406785/sticky-footer", [320, 50], "sticky-footer")
      .defineSizeMapping(leaderboardSizes)
      .setTargeting('pos', ['sticky-footer'])
      .addService(googletag.pubads());

  //Display calls for the initialized slots
  window.addEventListener('load', function () {
    googletag.display('billboard-1');
    googletag.pubads().refresh([billboard1]);

    googletag.display('billboard-2');
    googletag.pubads().refresh([billboard2]);

    googletag.display('billboard-3');
    googletag.pubads().refresh([billboard3]);

    googletag.display('skyscraper-1');
    googletag.pubads().refresh([skyscraper1]);

    googletag.display('skyscraper-2');
    googletag.pubads().refresh([skyscraper2]);

    googletag.display('MPU-1');
    googletag.pubads().refresh([MPU1]);

    googletag.display('MPU-2');
    googletag.pubads().refresh([MPU2]);

    googletag.display('MPU-3');
    googletag.pubads().refresh([MPU3]);

    googletag.display('leaderboard-1');
    googletag.pubads().refresh([leaderboard1]);

    googletag.display('leaderboard-2');
    googletag.pubads().refresh([leaderboard2]);

    googletag.display('sticky-footer');
    googletag.pubads().refresh([stickyFooter]);
  });

  //Lazy Load
  googletag.pubads().enableLazyLoad({
    // Fetch slots within 2 viewports.
    fetchMarginPercent: 200,
    // Render slots within 1 viewport.
    renderMarginPercent: 100,
    // Increase 1,5 times the above values on mobile, where viewports are smaller
    // and users tend to scroll faster.
    mobileScaling: 1.5
  });

  //In-view slot auto-refresh function
  googletag.pubads().addEventListener('impressionViewable', function(event) {
    var slot = event.slot;
    setTimeout(function() {
        googletag.pubads().refresh([slot]);
    }, SECONDS_TO_WAIT_AFTER_VIEWABILITY * 1000);
  });

  googletag.pubads().setTargeting('site', 'crowdwisdom360.com');

  googletag.pubads().collapseEmptyDivs();
  googletag.pubads().disableInitialLoad();
  googletag.enableServices();
});

// Close button for sticky footer banner
function closeAdFooterStick() {
  var slots = googletag.pubads().getSlots();
  var slot = slots.find(slot => {
    return slot.slotID === 'sticky-footer';
  });

  if (slot) {
    googletag.destroySlots(slot);
  }
  document.querySelector("#ad-sticky-footer-container").remove();
}