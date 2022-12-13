{"version":3,"sources":["inline-video.js"],"names":["BX","addCustomEvent","window","event","initBlock","slice","call","block","querySelectorAll","node","hasAttribute","videos","length","forEach","video","resetPlayerPreview","source","dataset","src","Landing","Utils","Matchers","youtube","test","indexOf","getMode","loadPlayerYT","autoplay","mute","tagName","bind","onYTPreviewClick","vimeo","vine","facebookVideos","rutube","vk","loadPlayerFrame","showError","classList","remove","add","innerHTML","message","playerPreview","clearPlayerPreview","create","props","className","style","backgroundImage","preview","insertBefore","unbind","scheduledPlayers","target","additionalParams","YT","Player","includes","push","onYouTubeIframeAPIReady","item","playerFrame","player","MediaPlayer","Factory","Object","keys","parameters","assign","selector","attrs","util","htmlspecialcharsback","frameborder","allowfullscreen","allow","events","load","loader","hide","Loader","show"],"mappings":"CAAC,WAEA,aAEAA,GAAGC,eAAeC,OAAQ,yBAAyB,SAAUC,GAE5DC,EAAU,GAAGC,MAAMC,KAAKH,EAAMI,MAAMC,iBAAiB,sBAGtDR,GAAGC,eAAe,gCAAgC,SAAUE,GAE3D,GAAIA,EAAMM,MAAQN,EAAMM,KAAKC,aAAa,eAC1C,CACCN,EAAU,GAAGC,MAAMC,KAAKH,EAAMI,MAAMC,iBAAiB,uBAIvD,SAASJ,EAAUO,GAElB,GAAIA,EAAOC,OACX,CACCD,EAAOE,SAAQ,SAAUC,GAExBA,EAAQC,EAAmBD,GAC3B,MAAME,EAASF,EAAMG,QAAQD,OAC7B,MAAME,EAAMJ,EAAMI,KAAQJ,EAAMG,QAAQC,IAExC,GACClB,GAAGmB,QAAQC,MAAMC,SAASC,QAAQC,KAAKP,IACpChB,GAAGmB,QAAQC,MAAMC,SAASC,QAAQC,KAAKL,GAE3C,CACC,GAAIA,EAAIM,QAAQ,iBAAmB,GAAKxB,GAAGmB,QAAQM,YAAc,OACjE,CACCC,EAAaZ,EAAO,CAACa,SAAU,EAAGC,KAAM,SAGpC,GAAId,EAAMe,UAAY,SAC3B,CACC7B,GAAG8B,KAAKhB,EAAO,QAASiB,OAIzB,CACCL,EAAaZ,SAGV,GACJd,GAAGmB,QAAQC,MAAMC,SAASW,MAAMT,KAAKP,IAClChB,GAAGmB,QAAQC,MAAMC,SAASY,KAAKV,KAAKP,IACpChB,GAAGmB,QAAQC,MAAMC,SAASa,eAAeX,KAAKP,IAC9ChB,GAAGmB,QAAQC,MAAMC,SAASc,OAAOZ,KAAKP,IACtChB,GAAGmB,QAAQC,MAAMC,SAASe,GAAGb,KAAKP,GAEtC,CACCqB,EAAgBvB,OAGjB,CACCwB,EAAUxB,QAMd,SAASwB,EAAU7B,GAElBA,EAAK8B,UAAUC,OAAO,mBAEtB/B,EAAK8B,UAAUE,IAAI,yBACnBhC,EAAKiC,UAAY,mCAChB,sCACA1C,GAAG2C,QAAQ,oCACX,SACA,qCACA3C,GAAG2C,QAAQ,2CACX,SACA,SAGF,SAAS5B,EAAmB6B,GAG3B,GAAIA,EAAcf,UAAY,SAC9B,CACC,IAAIgB,EAAqB7C,GAAG8C,OAAO,MAAO,CACzCC,MAAO,CACNC,UAAWJ,EAAcI,WAE1BC,MAAO,CACNC,gBAAiB,OAAQN,EAAc3B,QAAQkC,QAAS,KAEzDlC,QAAS,CACRC,IAAK0B,EAAc1B,KAAO0B,EAAc3B,QAAQC,IAChDF,OAAQ4B,EAAc3B,QAAQD,UAIhChB,GAAGoD,aAAaP,EAAoBD,GACpC5C,GAAGwC,OAAOI,GACV,OAAOC,EAIR7C,GAAGqD,OAAOT,EAAe,QAASb,GAGlCa,EAAcL,UAAUE,IAAI,mBAC5BG,EAAcL,UAAUC,OAAO,yBAC/BI,EAAcF,UAAY,GAE1B,OAAOE,EAGR,IAAIU,EAAmB,GAEvB,SAASvB,EAAiB5B,GAEzB,IAAIyC,EAAgBzC,EAAMoD,OAC1B7B,EAAakB,EAAe,CAACjB,SAAU,IAQxC,SAASD,EAAakB,EAAeY,GAEpC,UAAWC,KAAO,oBAAsBA,GAAGC,SAAW,YACtD,CACC,IAAKJ,EAAiBK,SAASf,GAC/B,CACCU,EAAiBM,KAAKhB,GAGvB1C,OAAO2D,wBAA0B,WAEhCP,EAAiBzC,SAAQ,SAAUiD,GAElCpC,EAAaoC,EAAMN,WAKtB,CACC,IAAIO,EAAc1B,EAAgBO,GAClC,IAAIoB,EAAShE,GAAGmB,QAAQ8C,YAAYC,QAAQpB,OAAOiB,GACnD,UACQP,IAAqB,aACzBW,OAAOC,KAAKZ,GAAkB5C,OAElC,CACCoD,EAAOK,WAAaF,OAAOG,OAAON,EAAOK,WAAYb,KAUxD,SAASnB,EAAgBO,GAGxB,GAAIA,EAAcf,UAAY,SAC9B,CACC,OAAOe,EAGR,MAAM2B,EAAW3B,EAAcI,UAC/BJ,EAAcI,UAAY,8BAE1B,MAAMe,EAAc/D,GAAG8C,OAAO,SAAU,CACvCC,MAAO,CACNC,UAAWuB,GAEZC,MAAO,CACNtD,IAAKlB,GAAGyE,KAAKC,qBAAqB9B,EAAc3B,QAAQC,KACxDyD,YAAa,IACbC,gBAAiB,kBACjBC,MAAO,2EAER5D,QAAS,CACRC,IAAKlB,GAAGyE,KAAKC,qBAAqB9B,EAAc3B,QAAQC,KACxDF,OAAQhB,GAAGyE,KAAKC,qBAAqB9B,EAAc3B,QAAQD,SAE5D8D,OAAQ,CACPC,KAAM,WAEL/E,GAAGwC,OAAOI,GACVoC,EAAOC,WAIV,MAAMD,EAAS,IAAIhF,GAAGkF,OAAO,CAC5B3B,OAAQX,IAEToC,EAAOG,OAEPnF,GAAGoD,aAAaW,EAAanB,GAC7B,OAAOmB,IA1MR","file":"inline-video.map.js"}