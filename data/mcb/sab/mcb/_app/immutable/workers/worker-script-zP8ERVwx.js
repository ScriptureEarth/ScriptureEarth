var Uf=Object.defineProperty;var Vf=(t,e,n)=>e in t?Uf(t,e,{enumerable:!0,configurable:!0,writable:!0,value:n}):t[e]=n;var Pe=(t,e,n)=>Vf(t,typeof e!="symbol"?e+"":e,n);var jt=Uint8Array,Lr=Uint16Array,Jf=Int32Array,h1=new jt([0,0,0,0,0,0,0,0,1,1,1,1,2,2,2,2,3,3,3,3,4,4,4,4,5,5,5,5,0,0,0,0]),m1=new jt([0,0,0,0,1,1,2,2,3,3,4,4,5,5,6,6,7,7,8,8,9,9,10,10,11,11,12,12,13,13,0,0]),Hf=new jt([16,17,18,0,8,7,9,6,10,5,11,4,12,3,13,2,14,1,15]),D1=function(t,e){for(var n=new Lr(31),r=0;r<31;++r)n[r]=e+=1<<t[r-1];for(var s=new Jf(n[30]),r=1;r<30;++r)for(var o=n[r];o<n[r+1];++o)s[o]=o-n[r]<<5|r;return{b:n,r:s}},S1=D1(h1,2),E1=S1.b,Wf=S1.r;E1[28]=258,Wf[258]=28;var Kf=D1(m1,0),Xf=Kf.b,zi=new Lr(32768);for(var tt=0;tt<32768;++tt){var Rn=(tt&43690)>>1|(tt&21845)<<1;Rn=(Rn&52428)>>2|(Rn&13107)<<2,Rn=(Rn&61680)>>4|(Rn&3855)<<4,zi[tt]=((Rn&65280)>>8|(Rn&255)<<8)>>1}var ms=function(t,e,n){for(var r=t.length,s=0,o=new Lr(e);s<r;++s)t[s]&&++o[t[s]-1];var i=new Lr(e);for(s=1;s<e;++s)i[s]=i[s-1]+o[s-1]<<1;var a;if(n){a=new Lr(1<<e);var u=15-e;for(s=0;s<r;++s)if(t[s])for(var c=s<<4|t[s],l=e-t[s],p=i[t[s]-1]++<<l,d=p|(1<<l)-1;p<=d;++p)a[zi[p]>>u]=c}else for(a=new Lr(r),s=0;s<r;++s)t[s]&&(a[s]=zi[i[t[s]-1]++]>>15-t[s]);return a},$s=new jt(288);for(var tt=0;tt<144;++tt)$s[tt]=8;for(var tt=144;tt<256;++tt)$s[tt]=9;for(var tt=256;tt<280;++tt)$s[tt]=7;for(var tt=280;tt<288;++tt)$s[tt]=8;var y1=new jt(32);for(var tt=0;tt<32;++tt)y1[tt]=5;var zf=ms($s,9,1),Yf=ms(y1,5,1),yi=function(t){for(var e=t[0],n=1;n<t.length;++n)t[n]>e&&(e=t[n]);return e},Zt=function(t,e,n){var r=e/8|0;return(t[r]|t[r+1]<<8)>>(e&7)&n},gi=function(t,e){var n=e/8|0;return(t[n]|t[n+1]<<8|t[n+2]<<16)>>(e&7)},Zf=function(t){return(t+7)/8|0},g1=function(t,e,n){return(e==null||e<0)&&(e=0),(n==null||n>t.length)&&(n=t.length),new jt(t.subarray(e,n))},Qf=["unexpected EOF","invalid block type","invalid length/literal","invalid distance","stream finished","no stream handler",,"no callback","invalid UTF-8 data","extra field too long","date not in range 1980-2099","filename too long","stream finishing","invalid zip data"],Rt=function(t,e,n){var r=new Error(e||Qf[t]);if(r.code=t,Error.captureStackTrace&&Error.captureStackTrace(r,Rt),!n)throw r;return r},Ba=function(t,e,n,r){var s=t.length,o=0;if(!s||e.f&&!e.l)return n||new jt(0);var i=!n,a=i||e.i!=2,u=e.i;i&&(n=new jt(s*3));var c=function(U){var V=n.length;if(U>V){var Y=new jt(Math.max(V*2,U));Y.set(n),n=Y}},l=e.f||0,p=e.p||0,d=e.b||0,f=e.l,S=e.d,b=e.m,F=e.n,y=s*8;do{if(!f){l=Zt(t,p,1);var T=Zt(t,p+1,3);if(p+=3,T)if(T==1)f=zf,S=Yf,b=9,F=5;else if(T==2){var ee=Zt(t,p,31)+257,ne=Zt(t,p+10,15)+4,Ne=ee+Zt(t,p+5,31)+1;p+=14;for(var L=new jt(Ne),pe=new jt(19),de=0;de<ne;++de)pe[Hf[de]]=Zt(t,p+de*3,7);p+=ne*3;for(var re=yi(pe),he=(1<<re)-1,Te=ms(pe,re,1),de=0;de<Ne;){var Ge=Te[Zt(t,p,he)];p+=Ge&15;var O=Ge>>4;if(O<16)L[de++]=O;else{var qe=0,ce=0;for(O==16?(ce=3+Zt(t,p,3),p+=2,qe=L[de-1]):O==17?(ce=3+Zt(t,p,7),p+=3):O==18&&(ce=11+Zt(t,p,127),p+=7);ce--;)L[de++]=qe}}var Ze=L.subarray(0,ee),ke=L.subarray(ee);b=yi(Ze),F=yi(ke),f=ms(Ze,b,1),S=ms(ke,F,1)}else Rt(1);else{var O=Zf(p)+4,j=t[O-4]|t[O-3]<<8,M=O+j;if(M>s){u&&Rt(0);break}a&&c(d+j),n.set(t.subarray(O,M),d),e.b=d+=j,e.p=p=M*8,e.f=l;continue}if(p>y){u&&Rt(0);break}}a&&c(d+131072);for(var Z=(1<<b)-1,x=(1<<F)-1,v=p;;v=p){var qe=f[gi(t,p)&Z],C=qe>>4;if(p+=qe&15,p>y){u&&Rt(0);break}if(qe||Rt(2),C<256)n[d++]=C;else if(C==256){v=p,f=null;break}else{var m=C-254;if(C>264){var de=C-257,A=h1[de];m=Zt(t,p,(1<<A)-1)+E1[de],p+=A}var $=S[gi(t,p)&x],g=$>>4;$||Rt(3),p+=$&15;var ke=Xf[g];if(g>3){var A=m1[g];ke+=gi(t,p)&(1<<A)-1,p+=A}if(p>y){u&&Rt(0);break}a&&c(d+131072);var E=d+m;if(d<ke){var N=o-ke,k=Math.min(ke,E);for(N+d<0&&Rt(3);d<k;++d)n[d]=r[N+d]}for(;d<E;++d)n[d]=n[d-ke]}}e.l=f,e.p=v,e.b=d,e.f=l,f&&(l=1,e.m=b,e.d=S,e.n=F)}while(!l);return d!=n.length&&i?g1(n,0,d):n.subarray(0,d)},eh=new jt(0),th=function(t){(t[0]!=31||t[1]!=139||t[2]!=8)&&Rt(6,"invalid gzip data");var e=t[3],n=10;e&4&&(n+=(t[10]|t[11]<<8)+2);for(var r=(e>>3&1)+(e>>4&1);r>0;r-=!t[n++]);return n+(e&2)},nh=function(t){var e=t.length;return(t[e-4]|t[e-3]<<8|t[e-2]<<16|t[e-1]<<24)>>>0},rh=function(t,e){return((t[0]&15)!=8||t[0]>>4>7||(t[0]<<8|t[1])%31)&&Rt(6,"invalid zlib data"),(t[1]>>5&1)==+!e&&Rt(6,"invalid zlib data: "+(t[1]&32?"need":"unexpected")+" dictionary"),(t[1]>>3&4)+2};function sh(t,e){return Ba(t,{i:2},e,e)}function oh(t,e){var n=th(t);return n+8>t.length&&Rt(6,"invalid gzip data"),Ba(t.subarray(n,-8),{i:2},new jt(nh(t)),e)}function ih(t,e){return Ba(t.subarray(rh(t,e),-4),{i:2},e,e)}function ah(t,e){return t[0]==31&&t[1]==139&&t[2]==8?oh(t,e):(t[0]&15)!=8||t[0]>>4>7||(t[0]<<8|t[1])%31?sh(t,e):ih(t,e)}var Yi=typeof TextDecoder<"u"&&new TextDecoder,uh=0;try{Yi.decode(eh,{stream:!0}),uh=1}catch{}var ch=function(t){for(var e="",n=0;;){var r=t[n++],s=(r>127)+(r>223)+(r>239);if(n+s>t.length)return{s:e,r:g1(t,n-1)};s?s==3?(r=((r&15)<<18|(t[n++]&63)<<12|(t[n++]&63)<<6|t[n++]&63)-65536,e+=String.fromCharCode(55296|r>>10,56320|r&1023)):s&1?e+=String.fromCharCode((r&31)<<6|t[n++]&63):e+=String.fromCharCode((r&15)<<12|(t[n++]&63)<<6|t[n++]&63):e+=String.fromCharCode(r)}};function lh(t,e){var n;if(Yi)return Yi.decode(t);var r=ch(t),s=r.s,n=r.r;return n.length&&Rt(8),s}const ph=(t,e,n=null,r=null)=>{n=n||function(a){return a},r=r||function(a){return a};const s=ah(e),o=lh(s),i=JSON.parse(o);return i.metadata.selectors=n(i.metadata.selectors),i.id=r(i.id),t.loadSuccinctDocSet(i)};function dh(t){return t.type==="error"}class fh{constructor(e,{timeout:n=5e3,inboundHandler:r}={}){Pe(this,"io");Pe(this,"requestHandler");Pe(this,"timeout");Pe(this,"pendingRequests",new Map);Pe(this,"lastRequest",-1);this.requestHandler=r,this.io=e,this.timeout=n,e.setOnMessage(s=>this.onMessage(s))}setInboundHandler(e){this.requestHandler=e}outboundHandler(){return e=>this.postRequest(e)}postRequest(e){const n=++this.lastRequest,r={transactionId:n,type:"request",payload:e},s=new Promise((o,i)=>{this.pendingRequests.set(n,{resolve:o,reject:i}),this.io.postMessage(r)});return this.addTimeout(s,e,n)}addTimeout(e,n,r){if(!this.timeout)return e;const s=this.setRequestTimeout(n,r);return Promise.race([e,s])}async setRequestTimeout(e,n){return await new Promise(r=>setTimeout(r,this.timeout)),this.pendingRequests.delete(n),await Promise.reject(new Error(`Message request timed out after ${this.timeout} ms. Request type: ${e.type}`))}onMessage(e){const n=e.data;if((n==null?void 0:n.type)==="request")this.onRequest(n);else if((n==null?void 0:n.type)==="response")this.onResponse(n);else throw new Error(`Invalid message from worker: ${n}`)}async onRequest(e){if(!this.requestHandler)throw new Error("Messenger incoming request handler was undefined. Did you foget to call setInboundHandler?");const n=await this.requestHandler(e.payload),r={transactionId:e.transactionId,type:"response",payload:n};this.io.postMessage(r)}onResponse(e){const n=e.transactionId;if(!this.pendingRequests.has(n))throw new Error(`No callback to handle response for message transaction ${n}`);const r=e.payload,{resolve:s,reject:o}=this.pendingRequests.get(n);dh(r)?o(new Error(r.message)):s(r),this.pendingRequests.delete(n)}}function hc(t,e,n){t[e]?t[e]+=n:t[e]=n}class Xr{constructor(e,n){Pe(this,"token");Pe(this,"locale");"\\$*.?+[]^&{}!<>|-".includes(e)&&(e="\\"+e),this.token=e,this.locale=n}toString(){return this.token}toUpperCase(){return new Xr(this.token.toLocaleUpperCase(this.locale))}toLowerCase(){return new Xr(this.token.toLocaleLowerCase(this.locale))}hasCase(){return this.token.toLocaleUpperCase(this.locale)!==this.token.toLocaleLowerCase(this.locale)}}class Zi{constructor(e,n={}){Pe(this,"tokens");Pe(this,"starred");this.tokens=this.mapTokens(e,n.matchCase),this.starred=n.starred??!1}mapTokens(e,n=!1){return n?e:e.flatMap(r=>r.hasCase()?[r.toUpperCase(),r.toLowerCase()]:r)}toString(){const e=this.starred?"*":"";return"(?:"+this.tokens.join("|")+")"+e}}function Qi(t,e){return[...t].map(n=>new Xr(n,e))}function v1(t,e){const n={};for(const r of Object.keys(t)){const s=hh(t[r],e);hc(n,r.toLocaleUpperCase(e),s),hc(n,r.toLocaleLowerCase(e),s)}for(const r of Object.keys(n))n[r]=[...new Set(n[r]).values()].join("");return n}function hh(t,e){const n=t.toLocaleUpperCase(e),r=t.toLocaleLowerCase(e);return n===r?t:n+r}class Ra{regex(e,n={}){const r=this.pattern(e,n);return new RegExp(r)}pattern(e,n={}){const r=n.matchCase?n.substitute:v1(n.substitute??{},n.locale);let o=this.getGroupsWithIgnore(e,n.ignore,r,n.matchCase,n.locale).map(i=>i.toString()).join("");return n.capture&&(o="("+o+")"),n.wholeLine&&(o="^"+o+"$"),o}getGroupsWithIgnore(e,n,r,s,o){const i=this.getIgnoreGroup(n,s,o);i&&(e=e.replaceAll(new RegExp(i.toString(),"g"),""));let a=this.getGroups(e,r,s,o);return i&&(a=this.addIgnoreGroups(a,i)),a}getIgnoreGroup(e,n,r){if(!e)return null;const s=Qi(e,r);return new Zi(s,{starred:!0,matchCase:n})}addIgnoreGroups(e,n){const r=[];r.push(n);for(const s of e)r.push(s),r.push(n);return r}getGroups(e,n={},r,s){const o=[];for(const i of[...e]){const a=[new Xr(i,s)];n[i]&&a.push(...Qi(n[i],s)),o.push(new Zi(a,{matchCase:r}))}return o}}let Yo=new Ra;function mh(){Yo=new Ra}function Dh(t){Yo=t}function mc(t,e){return Yo.regex(t,e)}function Sh(t,e){return Yo.pattern(t,e)}function Eh(t){const e=/[\p{L}\p{N}]+/gu;return t.match(e)||[]}function yh(t){const e=/([\p{L}\p{N}]+)/u;return t.split(e).filter(n=>n)}const xa={RegexToken:Xr,RegexGroup:Zi,RegexBuilder:Ra,allowCaseSubstitution:v1,resetBuilderInstance:mh,setBuilderInstance:Dh,splitByWords:yh,tokenize:Qi,wordsOf:Eh};function gh(t,e=!1,n="",r={},s){let o=t;return o=Sh(o,{ignore:n,substitute:r,locale:s}),o=o.replaceAll("\\","\\\\"),o=o.replaceAll('"','\\"'),e&&(o="^"+o+"$"),o}function vh(t,e){return`withMatchingChars: ["${xa.wordsOf(t).map(s=>gh(s,e.wholeWords,e.ignore,e.substitute,e.locale)).join('", "')}"]`}class Ah{constructor(e,n){Pe(this,"pk");Pe(this,"thaw");this.pk=e,this.thaw=n}async loadDocSet(e){this.thaw(this.pk,new Uint8Array(e))}async queryBooks(e,n){if(this.phraseIsEmtpy(e))return[];const r=`{
            docSet(id: "${n.docSet}") {
                documents(sortedBy: "paratext") {
                    id
                    idParts { type }
                    bookCode: header(id: "bookCode")
                }
            }
        } `;return(await this.makeQuery(r)).data.docSet.documents}async queryTokens(e,n,r){if(this.phraseIsEmtpy(e))return[];const s=vh(e,r),o=`{
            document(id: "${n}") {
                mainSequence {
                    blocks(${s} allChars: true) {
                        tokens(includeContext: true) {
                            scopes(startsWith: ["chapter/" "verses/"])
                            payload
                        }
                    }
                }
            }
        }`;return(await this.makeQuery(o)).data.document.mainSequence.blocks.flatMap(u=>u.tokens)}async makeQuery(e){const n=await this.pk.gqlQuery(e);if(!n.data)throw new Error(`Unexpected GQL Response: ${n}`);return n}phraseIsEmtpy(e){return xa.wordsOf(e).length===0}}/*!
 * XRegExp 5.1.1
 * <xregexp.com>
 * Steven Levithan (c) 2007-present MIT License
 */const nt="xregexp",fr={astral:!1,namespacing:!0},gn={};let us={},xr={};const ea=[],Ur="default",Dc="class",bh={default:/\\(?:0(?:[0-3][0-7]{0,2}|[4-7][0-7]?)?|[1-9]\d*|x[\dA-Fa-f]{2}|u(?:[\dA-Fa-f]{4}|{[\dA-Fa-f]+})|c[A-Za-z]|[\s\S])|\(\?(?:[:=!]|<[=!])|[?*+]\?|{\d+(?:,\d*)?}\??|[\s\S]/,class:/\\(?:[0-3][0-7]{0,2}|[4-7][0-7]?|x[\dA-Fa-f]{2}|u(?:[\dA-Fa-f]{4}|{[\dA-Fa-f]+})|c[A-Za-z]|[\s\S])|[\s\S]/},Ch=/\$(?:\{([^\}]+)\}|<([^>]+)>|(\d\d?|[\s\S]?))/g,Th=/()??/.exec("")[1]===void 0,wh=/x/.flags!==void 0;function Bs(t){let e=!0;try{if(new RegExp("",t),t==="y"){const n="gy";".a".replace(new RegExp("a",n),".")===".."&&(e=!1)}}catch{e=!1}return e}const Fh=Bs("d"),qa=Bs("s"),A1=Bs("u"),Ma=Bs("y"),b1={d:Fh,g:!0,i:!0,m:!0,s:qa,u:A1,y:Ma},Ih=qa?/[^dgimsuy]+/g:/[^dgimuy]+/g;function C1(t,e,n,r,s){if(t[nt]={captureNames:e},s)return t;if(t.__proto__)t.__proto__=B.prototype;else for(const o in B.prototype)t[o]=B.prototype[o];return t[nt].source=n,t[nt].flags=r&&r.split("").sort().join(""),t}function Cs(t){return t.replace(/([\s\S])(?=[\s\S]*\1)/g,"")}function gr(t,e){if(!B.isRegExp(t))throw new TypeError("Type RegExp expected");const n=t[nt]||{};let r=kh(t),s="",o="",i=null,a=null;return e=e||{},e.removeG&&(o+="g"),e.removeY&&(o+="y"),o&&(r=r.replace(new RegExp(`[${o}]+`,"g"),"")),e.addG&&(s+="g"),e.addY&&(s+="y"),s&&(r=Cs(r+s)),e.isInternalOnly||(n.source!==void 0&&(i=n.source),n.flags!=null&&(a=s?Cs(n.flags+s):n.flags)),t=C1(new RegExp(e.source||t.source,r),Ph(t)?n.captureNames.slice(0):null,i,a,e.isInternalOnly),t}function T1(t){return parseInt(t,16)}function w1(t,e,n){const r=t.index+t[0].length,s=t.input[t.index-1],o=t.input[r];return/^[()|]$/.test(s)||/^[()|]$/.test(o)||t.index===0||r===t.input.length||/\(\?(?:[:=!]|<[=!])$/.test(t.input.substring(t.index-4,t.index))||Nh(t.input,r,n)?"":"(?:)"}function kh(t){return wh?t.flags:/\/([a-z]*)$/i.exec(RegExp.prototype.toString.call(t))[1]}function Ph(t){return!!(t[nt]&&t[nt].captureNames)}function La(t){return parseInt(t,10).toString(16)}function Nh(t,e,n){const r="\\(\\?#[^)]*\\)",s="#[^#\\n]*",o="[?*+]|{\\d+(?:,\\d*)?}";return(n.includes("x")?new RegExp(`^(?:\\s|${s}|${r})*(?:${o})`):new RegExp(`^(?:${r})*(?:${o})`)).test(t.slice(e))}function bo(t,e){return Object.prototype.toString.call(t)===`[object ${e}]`}function Qr(t){if(t==null)throw new TypeError("Cannot convert null or undefined to object");return t}function ja(t){for(;t.length<4;)t=`0${t}`;return t}function _h(t,e){if(Cs(e)!==e)throw new SyntaxError(`Invalid duplicate regex flag ${e}`);t=t.replace(/^\(\?([\w$]+)\)/,(n,r)=>{if(/[dgy]/.test(r))throw new SyntaxError(`Cannot use flags dgy in mode modifier ${n}`);return e=Cs(e+r),""});for(const n of e)if(!b1[n])throw new SyntaxError(`Unknown regex flag ${n}`);return{pattern:t,flags:e}}function F1(t){const e={};return bo(t,"String")?(B.forEach(t,/[^\s,]+/,n=>{e[n]=!0}),e):t}function Sc(t){if(!/^[\w$]$/.test(t))throw new Error("Flag must be a single character A-Za-z0-9_$");b1[t]=!0}function Oh(t,e,n,r,s){let o=ea.length;const i=t[n];let a=null,u,c;for(;o--;)if(c=ea[o],!(c.leadChar&&c.leadChar!==i||c.scope!==r&&c.scope!=="all"||c.flag&&!e.includes(c.flag))&&(u=B.exec(t,c.regex,n,"sticky"),u)){a={matchLength:u[0].length,output:c.handler.call(s,u,r,e),reparse:c.reparse};break}return a}function I1(t){fr.astral=t}function k1(t){fr.namespacing=t}function B(t,e){if(B.isRegExp(t)){if(e!==void 0)throw new TypeError("Cannot supply flags when copying a RegExp");return gr(t)}if(t=t===void 0?"":String(t),e=e===void 0?"":String(e),B.isInstalled("astral")&&!e.includes("A")&&(e+="A"),xr[t]||(xr[t]={}),!xr[t][e]){const r={hasNamedCapture:!1,captureNames:[]};let s=Ur,o="",i=0,a;const u=_h(t,e);let c=u.pattern;const l=u.flags;for(;i<c.length;){do a=Oh(c,l,i,s,r),a&&a.reparse&&(c=c.slice(0,i)+a.output+c.slice(i+a.matchLength));while(a&&a.reparse);if(a)o+=a.output,i+=a.matchLength||1;else{const[p]=B.exec(c,bh[s],i,"sticky");o+=p,i+=p.length,p==="["&&s===Ur?s=Dc:p==="]"&&s===Dc&&(s=Ur)}}xr[t][e]={pattern:o.replace(/(?:\(\?:\))+/g,"(?:)"),flags:l.replace(Ih,""),captures:r.hasNamedCapture?r.captureNames:null}}const n=xr[t][e];return C1(new RegExp(n.pattern,n.flags),n.captures,t,e)}B.prototype=new RegExp;B.version="5.1.1";B._clipDuplicates=Cs;B._hasNativeFlag=Bs;B._dec=T1;B._hex=La;B._pad4=ja;B.addToken=(t,e,n)=>{n=n||{};let{optionalFlags:r}=n;if(n.flag&&Sc(n.flag),r){r=r.split("");for(const s of r)Sc(s)}ea.push({regex:gr(t,{addG:!0,addY:Ma,isInternalOnly:!0}),handler:e,scope:n.scope||Ur,flag:n.flag,reparse:n.reparse,leadChar:n.leadChar}),B.cache.flush("patterns")};B.cache=(t,e)=>(us[t]||(us[t]={}),us[t][e]||(us[t][e]=B(t,e)));B.cache.flush=t=>{t==="patterns"?xr={}:us={}};B.escape=t=>String(Qr(t)).replace(/[\\\[\]{}()*+?.^$|]/g,"\\$&").replace(/[\s#\-,]/g,e=>`\\u${ja(La(e.charCodeAt(0)))}`);B.exec=(t,e,n,r)=>{let s="g",o=!1,i=!1,a;o=Ma&&!!(r||e.sticky&&r!==!1),o?s+="y":r&&(i=!0,s+="FakeY"),e[nt]=e[nt]||{};const u=e[nt][s]||(e[nt][s]=gr(e,{addG:!0,addY:o,source:i?`${e.source}|()`:void 0,removeY:r===!1,isInternalOnly:!0}));return n=n||0,u.lastIndex=n,a=gn.exec.call(u,t),i&&a&&a.pop()===""&&(a=null),e.global&&(e.lastIndex=a?u.lastIndex:0),a};B.forEach=(t,e,n)=>{let r=0,s=-1,o;for(;o=B.exec(t,e,r);)n(o,++s,t,e),r=o.index+(o[0].length||1)};B.globalize=t=>gr(t,{addG:!0});B.install=t=>{t=F1(t),!fr.astral&&t.astral&&I1(!0),!fr.namespacing&&t.namespacing&&k1(!0)};B.isInstalled=t=>!!fr[t];B.isRegExp=t=>Object.prototype.toString.call(t)==="[object RegExp]";B.match=(t,e,n)=>{const r=e.global&&n!=="one"||n==="all",s=(r?"g":"")+(e.sticky?"y":"")||"noGY";e[nt]=e[nt]||{};const o=e[nt][s]||(e[nt][s]=gr(e,{addG:!!r,removeG:n==="one",isInternalOnly:!0})),i=String(Qr(t)).match(o);return e.global&&(e.lastIndex=n==="one"&&i?i.index+i[0].length:0),r?i||[]:i&&i[0]};B.matchChain=(t,e)=>function n(r,s){const o=e[s].regex?e[s]:{regex:e[s]},i=[];function a(u){if(o.backref){const c=`Backreference to undefined group: ${o.backref}`,l=isNaN(o.backref);if(l&&B.isInstalled("namespacing")){if(!(u.groups&&o.backref in u.groups))throw new ReferenceError(c)}else if(!u.hasOwnProperty(o.backref))throw new ReferenceError(c);const p=l&&B.isInstalled("namespacing")?u.groups[o.backref]:u[o.backref];i.push(p||"")}else i.push(u[0])}for(const u of r)B.forEach(u,o.regex,a);return s===e.length-1||!i.length?i:n(i,s+1)}([t],0);B.replace=(t,e,n,r)=>{const s=B.isRegExp(e),o=e.global&&r!=="one"||r==="all",i=(o?"g":"")+(e.sticky?"y":"")||"noGY";let a=e;s?(e[nt]=e[nt]||{},a=e[nt][i]||(e[nt][i]=gr(e,{addG:!!o,removeG:r==="one",isInternalOnly:!0}))):o&&(a=new RegExp(B.escape(String(e)),"g"));const u=gn.replace.call(Qr(t),a,n);return s&&e.global&&(e.lastIndex=0),u};B.replaceEach=(t,e)=>{for(const n of e)t=B.replace(t,n[0],n[1],n[2]);return t};B.split=(t,e,n)=>gn.split.call(Qr(t),e,n);B.test=(t,e,n,r)=>!!B.exec(t,e,n,r);B.uninstall=t=>{t=F1(t),fr.astral&&t.astral&&I1(!1),fr.namespacing&&t.namespacing&&k1(!1)};B.union=(t,e,n)=>{n=n||{};const r=n.conjunction||"or";let s=0,o,i;function a(p,d,f){const S=i[s-o];if(d){if(++s,S)return`(?<${S}>`}else if(f)return`\\${+f+o}`;return p}if(!(bo(t,"Array")&&t.length))throw new TypeError("Must provide a nonempty array of patterns to merge");const u=/(\()(?!\?)|\\([1-9]\d*)|\\[\s\S]|\[(?:[^\\\]]|\\[\s\S])*\]/g,c=[];for(const p of t)B.isRegExp(p)?(o=s,i=p[nt]&&p[nt].captureNames||[],c.push(B(p.source).source.replace(u,a))):c.push(B.escape(p));const l=r==="none"?"":"|";return B(c.join(l),e)};gn.exec=function(t){const e=this.lastIndex,n=RegExp.prototype.exec.apply(this,arguments);if(n){if(!Th&&n.length>1&&n.includes("")){const r=gr(this,{removeG:!0,isInternalOnly:!0});String(t).slice(n.index).replace(r,(...s)=>{const o=s.length;for(let i=1;i<o-2;++i)s[i]===void 0&&(n[i]=void 0)})}if(this[nt]&&this[nt].captureNames){let r=n;B.isInstalled("namespacing")&&(n.groups=Object.create(null),r=n.groups);for(let s=1;s<n.length;++s){const o=this[nt].captureNames[s-1];o&&(r[o]=n[s])}}else!n.groups&&B.isInstalled("namespacing")&&(n.groups=void 0);this.global&&!n[0].length&&this.lastIndex>n.index&&(this.lastIndex=n.index)}return this.global||(this.lastIndex=e),n};gn.test=function(t){return!!gn.exec.call(this,t)};gn.match=function(t){if(!B.isRegExp(t))t=new RegExp(t);else if(t.global){const e=String.prototype.match.apply(this,arguments);return t.lastIndex=0,e}return gn.exec.call(t,Qr(this))};gn.replace=function(t,e){const n=B.isRegExp(t);let r,s,o;return n?(t[nt]&&({captureNames:s}=t[nt]),r=t.lastIndex):t+="",bo(e,"Function")?o=String(this).replace(t,(...i)=>{if(s){let a;B.isInstalled("namespacing")?(a=Object.create(null),i.push(a)):(i[0]=new String(i[0]),[a]=i);for(let u=0;u<s.length;++u)s[u]&&(a[s[u]]=i[u+1])}return e(...i)}):o=String(Qr(this)).replace(t,(...i)=>{return String(e).replace(Ch,a);function a(u,c,l,p){c=c||l;const d=bo(i[i.length-1],"Object")?4:3,f=i.length-d;if(c){if(/^\d+$/.test(c)){const b=+c;if(b<=f)return i[b]||""}const S=s?s.indexOf(c):-1;if(S<0)throw new SyntaxError(`Backreference to undefined group ${u}`);return i[S+1]||""}if(p===""||p===" ")throw new SyntaxError(`Invalid token ${u}`);if(p==="&"||+p==0)return i[0];if(p==="$")return"$";if(p==="`")return i[i.length-1].slice(0,i[i.length-2]);if(p==="'")return i[i.length-1].slice(i[i.length-2]+i[0].length);if(p=+p,!isNaN(p)){if(p>f)throw new SyntaxError(`Backreference to undefined group ${u}`);return i[p]||""}throw new SyntaxError(`Invalid token ${u}`)}}),n&&(t.global?t.lastIndex=0:t.lastIndex=r),o};gn.split=function(t,e){if(!B.isRegExp(t))return String.prototype.split.apply(this,arguments);const n=String(this),r=[],s=t.lastIndex;let o=0,i;return e=(e===void 0?-1:e)>>>0,B.forEach(n,t,a=>{a.index+a[0].length>o&&(r.push(n.slice(o,a.index)),a.length>1&&a.index<n.length&&Array.prototype.push.apply(r,a.slice(1)),i=a[0].length,o=a.index+i)}),o===n.length?(!t.test("")||i)&&r.push(""):r.push(n.slice(o)),t.lastIndex=s,r.length>e?r.slice(0,e):r};B.addToken(/\\([ABCE-RTUVXYZaeg-mopqyz]|c(?![A-Za-z])|u(?![\dA-Fa-f]{4}|{[\dA-Fa-f]+})|x(?![\dA-Fa-f]{2}))/,(t,e)=>{if(t[1]==="B"&&e===Ur)return t[0];throw new SyntaxError(`Invalid escape ${t[0]}`)},{scope:"all",leadChar:"\\"});B.addToken(/\\u{([\dA-Fa-f]+)}/,(t,e,n)=>{const r=T1(t[1]);if(r>1114111)throw new SyntaxError(`Invalid Unicode code point ${t[0]}`);if(r<=65535)return`\\u${ja(La(r))}`;if(A1&&n.includes("u"))return t[0];throw new SyntaxError("Cannot use Unicode code point above \\u{FFFF} without flag u")},{scope:"all",leadChar:"\\"});B.addToken(/\(\?#[^)]*\)/,w1,{leadChar:"("});B.addToken(/\s+|#[^\n]*\n?/,w1,{flag:"x"});qa||B.addToken(/\./,()=>"[\\s\\S]",{flag:"s",leadChar:"."});B.addToken(/\\k<([^>]+)>/,function(t){const e=isNaN(t[1])?this.captureNames.indexOf(t[1])+1:+t[1],n=t.index+t[0].length;if(!e||e>this.captureNames.length)throw new SyntaxError(`Backreference to undefined group ${t[0]}`);return`\\${e}${n===t.input.length||isNaN(t.input[n])?"":"(?:)"}`},{leadChar:"\\"});B.addToken(/\\(\d+)/,function(t,e){if(!(e===Ur&&/^[1-9]/.test(t[1])&&+t[1]<=this.captureNames.length)&&t[1]!=="0")throw new SyntaxError(`Cannot use octal escape or backreference to undefined group ${t[0]}`);return t[0]},{scope:"all",leadChar:"\\"});B.addToken(/\(\?P?<([\p{ID_Start}$_][\p{ID_Continue}$_\u200C\u200D]*)>/u,function(t){if(!B.isInstalled("namespacing")&&(t[1]==="length"||t[1]==="__proto__"))throw new SyntaxError(`Cannot use reserved word as capture name ${t[0]}`);if(this.captureNames.includes(t[1]))throw new SyntaxError(`Cannot use same name for multiple groups ${t[0]}`);return this.captureNames.push(t[1]),this.hasNamedCapture=!0,"("},{leadChar:"("});B.addToken(/\((?!\?)/,function(t,e,n){return n.includes("n")?"(?:":(this.captureNames.push(null),"(")},{optionalFlags:"n",leadChar:"("});/*!
 * XRegExp.build 5.1.1
 * <xregexp.com>
 * Steven Levithan (c) 2012-present MIT License
 */const $h=t=>{const e="xregexp",n=/(\()(?!\?)|\\([1-9]\d*)|\\[\s\S]|\[(?:[^\\\]]|\\[\s\S])*\]/g,r=t.union([/\({{([\w$]+)}}\)|{{([\w$]+)}}/,n],"g",{conjunction:"or"});function s(c){const l=/^(?:\(\?:\))*\^/,p=/\$(?:\(\?:\))*$/;return l.test(c)&&p.test(c)&&p.test(c.replace(/\\[\s\S]/g,""))?c.replace(l,"").replace(p,""):c}function o(c,l){const p=l?"x":"";return t.isRegExp(c)?c[e]&&c[e].captureNames?c:t(c.source,p):t(c,p)}function i(c){return c instanceof RegExp?c:t.escape(c)}function a(c,l,p){return c[`subpattern${p}`]=l,c}function u(c,l,p){const d=l<p.length-1;return c+(d?`{{subpattern${l}}}`:"")}t.tag=c=>(l,...p)=>{const d=p.map(i).reduce(a,{}),f=l.raw.map(u).join("");return t.build(f,d,c)},t.build=(c,l,p)=>{p=p||"";const d=p.includes("x"),f=/^\(\?([\w$]+)\)/.exec(c);f&&(p=t._clipDuplicates(p+f[1]));const S={};for(const ee in l)if(l.hasOwnProperty(ee)){const ne=o(l[ee],d);S[ee]={pattern:s(ne.source),names:ne[e].captureNames||[]}}const b=o(c,d);let F=0,y,T=0;const O=[0],j=b[e].captureNames||[],M=b.source.replace(r,(ee,ne,Ne,L,pe)=>{const de=ne||Ne;let re,he,Te;if(de){if(!S.hasOwnProperty(de))throw new ReferenceError(`Undefined property ${ee}`);ne?(re=j[T],O[++T]=++F,he=`(?<${re||de}>`):he="(?:",y=F;const Ge=S[de].pattern.replace(n,(qe,ce,Ze)=>{if(ce){if(re=S[de].names[F-y],++F,re)return`(?<${re}>`}else if(Ze)return Te=+Ze-1,S[de].names[Te]?`\\k<${S[de].names[Te]}>`:`\\${+Ze+y}`;return qe});return`${he}${Ge})`}if(L){if(re=j[T],O[++T]=++F,re)return`(?<${re}>`}else if(pe)return Te=+pe-1,j[Te]?`\\k<${j[Te]}>`:`\\${O[+pe]}`;return ee});return t(M,p)}};/*!
 * XRegExp.matchRecursive 5.1.1
 * <xregexp.com>
 * Steven Levithan (c) 2009-present MIT License
 */const Bh=t=>{function e(n,r,s,o){return{name:n,value:r,start:s,end:o}}t.matchRecursive=(n,r,s,o,i)=>{o=o||"",i=i||{};const a=o.includes("g"),u=o.includes("y"),c=o.replace(/y/g,"");r=t(r,c),s=t(s,c);let l,{escapeChar:p}=i;if(p){if(p.length>1)throw new Error("Cannot use more than one escape character");p=t.escape(p),l=new RegExp(`(?:${p}[\\S\\s]|(?:(?!${t.union([r,s],"",{conjunction:"or"}).source})[^${p}])+)+`,o.replace(t._hasNativeFlag("s")?/[^imsu]/g:/[^imu]/g,""))}let d=0,f=0,S=0,b=0,F,y,T,O;const j=i.valueNames,M=[];for(;;){if(p&&(S+=(t.exec(n,l,S,"sticky")||[""])[0].length),T=t.exec(n,r,S),O=t.exec(n,s,S),T&&O&&(T.index<=O.index?O=null:T=null),T||O)f=(T||O).index,S=f+(T||O)[0].length;else if(!d)break;if(u&&!d&&f>b)break;if(T)d||(F=f,y=S),d+=1;else if(O&&d){if(d-=1,!d&&(j?(j[0]&&F>b&&M.push(e(j[0],n.slice(b,F),b,F)),j[1]&&M.push(e(j[1],n.slice(F,y),F,y)),j[2]&&M.push(e(j[2],n.slice(y,f),y,f)),j[3]&&M.push(e(j[3],n.slice(f,S),f,S))):M.push(n.slice(y,f)),b=S,!a))break}else{const ee=i.unbalanced||"error";if(ee==="skip"||ee==="skip-lazy")if(O)O=null;else{if(ee==="skip"){const ne=t.exec(n,r,F,"sticky")[0].length;S=F+(ne||1)}else S=F+1;d=0}else if(ee==="error"){const ne=O?"right":"left",Ne=O?f:F;throw new Error(`Unbalanced ${ne} delimiter found in string at position ${Ne}`)}else throw new Error(`Unsupported value for unbalanced: ${ee}`)}f===S&&(S+=1)}return a&&M.length>0&&!u&&j&&j[0]&&n.length>b&&M.push(e(j[0],n.slice(b),b,n.length)),M}};/*!
 * XRegExp Unicode Base 5.1.1
 * <xregexp.com>
 * Steven Levithan (c) 2008-present MIT License
 */const Rh=t=>{const e={},n={},r=t._dec,s=t._hex,o=t._pad4;function i(d){return d.replace(/[- _]+/g,"").toLowerCase()}function a(d){const f=/^\\[xu](.+)/.exec(d);return f?r(f[1]):d.charCodeAt(d[0]==="\\"?1:0)}function u(d){let f="",S=-1;return t.forEach(d,/(\\x..|\\u....|\\?[\s\S])(?:-(\\x..|\\u....|\\?[\s\S]))?/,b=>{const F=a(b[1]);F>S+1&&(f+=`\\u${o(s(S+1))}`,F>S+2&&(f+=`-\\u${o(s(F-1))}`)),S=a(b[2]||b[1])}),S<65535&&(f+=`\\u${o(s(S+1))}`,S<65534&&(f+="-\\uFFFF")),f}function c(d){const f="b!";return e[d][f]||(e[d][f]=u(e[d].bmp))}function l(d,f){const S=e[d];let b="";return S.bmp&&!S.isBmpLast&&(b=`[${S.bmp}]${S.astral?"|":""}`),S.astral&&(b+=S.astral),S.isBmpLast&&S.bmp&&(b+=`${S.astral?"|":""}[${S.bmp}]`),f?`(?:(?!${b})(?:[\uD800-\uDBFF][\uDC00-\uDFFF]|[\0-￿]))`:`(?:${b})`}function p(d,f){const S=f?"a!":"a=";return e[d][S]||(e[d][S]=l(d,f))}t.addToken(/\\([pP])(?:{(\^?)(?:(\w+)=)?([^}]*)}|([A-Za-z]))/,(d,f,S)=>{const b="Invalid double negation ",F="Unknown Unicode token ",y="Unicode token missing data ",T="Astral mode required for Unicode token ",O="Astral mode does not support Unicode tokens within character classes",[j,M,ee,ne,Ne,L]=d;let pe=M==="P"||!!ee;const de=S.includes("A");let re=i(L||Ne),he=e[re];if(M==="P"&&ee)throw new SyntaxError(b+j);if(!e.hasOwnProperty(re))throw new SyntaxError(F+j);if(ne&&!(n[ne]&&n[ne][re]))throw new SyntaxError(F+j);if(he.inverseOf){if(re=i(he.inverseOf),!e.hasOwnProperty(re))throw new ReferenceError(`${y+j} -> ${he.inverseOf}`);he=e[re],pe=!pe}if(!(he.bmp||de))throw new SyntaxError(T+j);if(de){if(f==="class")throw new SyntaxError(O);return p(re,pe)}return f==="class"?pe?c(re):he.bmp:`${(pe?"[^":"[")+he.bmp}]`},{scope:"all",optionalFlags:"A",leadChar:"\\"}),t.addUnicodeData=(d,f)=>{const S="Unicode token requires name",b="Unicode token has no character data ";f&&(n[f]={});for(const F of d){if(!F.name)throw new Error(S);if(!(F.inverseOf||F.bmp||F.astral))throw new Error(b+F.name);const y=i(F.name);if(e[y]=F,f&&(n[f][y]=!0),F.alias){const T=i(F.alias);e[T]=F,f&&(n[f][T]=!0)}}t.cache.flush("patterns")},t._getUnicodeProperty=d=>{const f=i(d);return e[f]}};var pr=typeof globalThis<"u"?globalThis:typeof window<"u"?window:typeof global<"u"?global:typeof self<"u"?self:{};function On(t){return t&&t.__esModule&&Object.prototype.hasOwnProperty.call(t,"default")?t.default:t}function xh(t){if(t.__esModule)return t;var e=t.default;if(typeof e=="function"){var n=function r(){return this instanceof r?Reflect.construct(e,arguments,this.constructor):e.apply(this,arguments)};n.prototype=e.prototype}else n={};return Object.defineProperty(n,"__esModule",{value:!0}),Object.keys(t).forEach(function(r){var s=Object.getOwnPropertyDescriptor(t,r);Object.defineProperty(n,r,s.get?s:{enumerable:!0,get:function(){return t[r]}})}),n}var qh=[{name:"C",alias:"Other",isBmpLast:!0,bmp:"\0--­͸͹΀-΃΋΍΢԰՗՘֋֌֐׈-׏׫-׮׵-؅؜۝܎܏݋݌޲-޿߻߼࠮࠯࠿࡜࡝࡟࡫-࡯࢏-ࢗ࣢঄঍঎঑঒঩঱঳-঵঺঻৅৆৉৊৏-৖৘-৛৞৤৥৿਀਄਋-਎਑਒਩਱਴਷਺਻਽੃-੆੉੊੎-੐੒-੘੝੟-੥੷-઀઄઎઒઩઱઴઺઻૆૊૎૏૑-૟૤૥૲-૸଀଄଍଎଑଒଩଱଴଺଻୅୆୉୊୎-୔୘-୛୞୤୥୸-஁஄஋-஍஑஖-஘஛஝஠-஢஥-஧஫-஭஺-஽௃-௅௉௎௏௑-௖௘-௥௻-௿఍఑఩఺఻౅౉౎-౔౗౛౜౞౟౤౥౰-౶಍಑಩಴಺಻೅೉೎-೔೗-೜೟೤೥೰ೳ-೿഍഑൅൉൐-൓൤൥඀඄඗-඙඲඼඾඿෇-෉෋-෎෕෗෠-෥෰෱෵-฀฻-฾๜-຀຃຅຋຤຦຾຿໅໇໎໏໚໛໠-໿཈཭-཰྘྽࿍࿛-࿿჆჈-჌჎჏቉቎቏቗቙቞቟኉኎኏኱኶኷኿዁዆዇዗጑጖጗፛፜፽-፿᎚-᎟᏶᏷᏾᏿᚝-᚟᛹-᛿᜖-᜞᜷-᜿᝔-᝟᝭᝱᝴-᝿៞៟៪-៯៺-៿᠎᠚-᠟᡹-᡿᢫-᢯᣶-᣿᤟᤬-᤯᤼-᤿᥁-᥃᥮᥯᥵-᥿᦬-᦯᧊-᧏᧛-᧝᨜᨝᩟᩽᩾᪊-᪏᪚-᪟᪮᪯᫏-᫿᭍-᭏᭿᯴-᯻᰸-᰺᱊-᱌Ᲊ-᲏᲻᲼᳈-᳏᳻-᳿἖἗἞἟὆὇὎὏὘὚὜὞὾὿᾵῅῔῕῜῰῱῵῿​-‏‪-‮⁠-⁯⁲⁳₏₝-₟⃁-⃏⃱-⃿↌-↏␧-␿⑋-⑟⭴⭵⮖⳴-⳸⴦⴨-⴬⴮⴯⵨-⵮⵱-⵾⶗-⶟⶧⶯⶷⶿⷇⷏⷗⷟⹞-⹿⺚⻴-⻿⿖-⿯⿼-⿿぀゗゘㄀-㄄㄰㆏㇤-㇯㈟꒍-꒏꓇-꓏꘬-꘿꛸-꛿Ɤ-꟏꟒꟔Ꟛ-꟱꠭-꠯꠺-꠿꡸-꡿꣆-꣍꣚-꣟꥔-꥞꥽-꥿꧎꧚-꧝꧿꨷-꨿꩎꩏꩚꩛꫃-꫚꫷-꬀꬇꬈꬏꬐꬗-꬟꬧꬯꭬-꭯꯮꯯꯺-꯿힤-힯퟇-퟊퟼-﩮﩯﫚-﫿﬇-﬒﬘-﬜﬷﬽﬿﭂﭅﯃-﯒﶐﶑﷈-﷎﷐-﷯︚-︟﹓﹧﹬-﹯﹵﻽-＀﾿-￁￈￉￐￑￘￙￝-￟￧￯-￻￾￿",astral:"\uD800[\uDC0C\uDC27\uDC3B\uDC3E\uDC4E\uDC4F\uDC5E-\uDC7F\uDCFB-\uDCFF\uDD03-\uDD06\uDD34-\uDD36\uDD8F\uDD9D-\uDD9F\uDDA1-\uDDCF\uDDFE-\uDE7F\uDE9D-\uDE9F\uDED1-\uDEDF\uDEFC-\uDEFF\uDF24-\uDF2C\uDF4B-\uDF4F\uDF7B-\uDF7F\uDF9E\uDFC4-\uDFC7\uDFD6-\uDFFF]|\uD801[\uDC9E\uDC9F\uDCAA-\uDCAF\uDCD4-\uDCD7\uDCFC-\uDCFF\uDD28-\uDD2F\uDD64-\uDD6E\uDD7B\uDD8B\uDD93\uDD96\uDDA2\uDDB2\uDDBA\uDDBD-\uDDFF\uDF37-\uDF3F\uDF56-\uDF5F\uDF68-\uDF7F\uDF86\uDFB1\uDFBB-\uDFFF]|\uD802[\uDC06\uDC07\uDC09\uDC36\uDC39-\uDC3B\uDC3D\uDC3E\uDC56\uDC9F-\uDCA6\uDCB0-\uDCDF\uDCF3\uDCF6-\uDCFA\uDD1C-\uDD1E\uDD3A-\uDD3E\uDD40-\uDD7F\uDDB8-\uDDBB\uDDD0\uDDD1\uDE04\uDE07-\uDE0B\uDE14\uDE18\uDE36\uDE37\uDE3B-\uDE3E\uDE49-\uDE4F\uDE59-\uDE5F\uDEA0-\uDEBF\uDEE7-\uDEEA\uDEF7-\uDEFF\uDF36-\uDF38\uDF56\uDF57\uDF73-\uDF77\uDF92-\uDF98\uDF9D-\uDFA8\uDFB0-\uDFFF]|\uD803[\uDC49-\uDC7F\uDCB3-\uDCBF\uDCF3-\uDCF9\uDD28-\uDD2F\uDD3A-\uDE5F\uDE7F\uDEAA\uDEAE\uDEAF\uDEB2-\uDEFF\uDF28-\uDF2F\uDF5A-\uDF6F\uDF8A-\uDFAF\uDFCC-\uDFDF\uDFF7-\uDFFF]|\uD804[\uDC4E-\uDC51\uDC76-\uDC7E\uDCBD\uDCC3-\uDCCF\uDCE9-\uDCEF\uDCFA-\uDCFF\uDD35\uDD48-\uDD4F\uDD77-\uDD7F\uDDE0\uDDF5-\uDDFF\uDE12\uDE3F-\uDE7F\uDE87\uDE89\uDE8E\uDE9E\uDEAA-\uDEAF\uDEEB-\uDEEF\uDEFA-\uDEFF\uDF04\uDF0D\uDF0E\uDF11\uDF12\uDF29\uDF31\uDF34\uDF3A\uDF45\uDF46\uDF49\uDF4A\uDF4E\uDF4F\uDF51-\uDF56\uDF58-\uDF5C\uDF64\uDF65\uDF6D-\uDF6F\uDF75-\uDFFF]|\uD805[\uDC5C\uDC62-\uDC7F\uDCC8-\uDCCF\uDCDA-\uDD7F\uDDB6\uDDB7\uDDDE-\uDDFF\uDE45-\uDE4F\uDE5A-\uDE5F\uDE6D-\uDE7F\uDEBA-\uDEBF\uDECA-\uDEFF\uDF1B\uDF1C\uDF2C-\uDF2F\uDF47-\uDFFF]|\uD806[\uDC3C-\uDC9F\uDCF3-\uDCFE\uDD07\uDD08\uDD0A\uDD0B\uDD14\uDD17\uDD36\uDD39\uDD3A\uDD47-\uDD4F\uDD5A-\uDD9F\uDDA8\uDDA9\uDDD8\uDDD9\uDDE5-\uDDFF\uDE48-\uDE4F\uDEA3-\uDEAF\uDEF9-\uDFFF]|\uD807[\uDC09\uDC37\uDC46-\uDC4F\uDC6D-\uDC6F\uDC90\uDC91\uDCA8\uDCB7-\uDCFF\uDD07\uDD0A\uDD37-\uDD39\uDD3B\uDD3E\uDD48-\uDD4F\uDD5A-\uDD5F\uDD66\uDD69\uDD8F\uDD92\uDD99-\uDD9F\uDDAA-\uDEDF\uDEF9-\uDFAF\uDFB1-\uDFBF\uDFF2-\uDFFE]|\uD808[\uDF9A-\uDFFF]|\uD809[\uDC6F\uDC75-\uDC7F\uDD44-\uDFFF]|[\uD80A\uD80E-\uD810\uD812-\uD819\uD824-\uD82A\uD82D\uD82E\uD830-\uD832\uD83F\uD87B-\uD87D\uD87F\uD885-\uDB3F\uDB41-\uDBFF][\uDC00-\uDFFF]|\uD80B[\uDC00-\uDF8F\uDFF3-\uDFFF]|\uD80D[\uDC2F-\uDFFF]|\uD811[\uDE47-\uDFFF]|\uD81A[\uDE39-\uDE3F\uDE5F\uDE6A-\uDE6D\uDEBF\uDECA-\uDECF\uDEEE\uDEEF\uDEF6-\uDEFF\uDF46-\uDF4F\uDF5A\uDF62\uDF78-\uDF7C\uDF90-\uDFFF]|\uD81B[\uDC00-\uDE3F\uDE9B-\uDEFF\uDF4B-\uDF4E\uDF88-\uDF8E\uDFA0-\uDFDF\uDFE5-\uDFEF\uDFF2-\uDFFF]|\uD821[\uDFF8-\uDFFF]|\uD823[\uDCD6-\uDCFF\uDD09-\uDFFF]|\uD82B[\uDC00-\uDFEF\uDFF4\uDFFC\uDFFF]|\uD82C[\uDD23-\uDD4F\uDD53-\uDD63\uDD68-\uDD6F\uDEFC-\uDFFF]|\uD82F[\uDC6B-\uDC6F\uDC7D-\uDC7F\uDC89-\uDC8F\uDC9A\uDC9B\uDCA0-\uDFFF]|\uD833[\uDC00-\uDEFF\uDF2E\uDF2F\uDF47-\uDF4F\uDFC4-\uDFFF]|\uD834[\uDCF6-\uDCFF\uDD27\uDD28\uDD73-\uDD7A\uDDEB-\uDDFF\uDE46-\uDEDF\uDEF4-\uDEFF\uDF57-\uDF5F\uDF79-\uDFFF]|\uD835[\uDC55\uDC9D\uDCA0\uDCA1\uDCA3\uDCA4\uDCA7\uDCA8\uDCAD\uDCBA\uDCBC\uDCC4\uDD06\uDD0B\uDD0C\uDD15\uDD1D\uDD3A\uDD3F\uDD45\uDD47-\uDD49\uDD51\uDEA6\uDEA7\uDFCC\uDFCD]|\uD836[\uDE8C-\uDE9A\uDEA0\uDEB0-\uDFFF]|\uD837[\uDC00-\uDEFF\uDF1F-\uDFFF]|\uD838[\uDC07\uDC19\uDC1A\uDC22\uDC25\uDC2B-\uDCFF\uDD2D-\uDD2F\uDD3E\uDD3F\uDD4A-\uDD4D\uDD50-\uDE8F\uDEAF-\uDEBF\uDEFA-\uDEFE\uDF00-\uDFFF]|\uD839[\uDC00-\uDFDF\uDFE7\uDFEC\uDFEF\uDFFF]|\uD83A[\uDCC5\uDCC6\uDCD7-\uDCFF\uDD4C-\uDD4F\uDD5A-\uDD5D\uDD60-\uDFFF]|\uD83B[\uDC00-\uDC70\uDCB5-\uDD00\uDD3E-\uDDFF\uDE04\uDE20\uDE23\uDE25\uDE26\uDE28\uDE33\uDE38\uDE3A\uDE3C-\uDE41\uDE43-\uDE46\uDE48\uDE4A\uDE4C\uDE50\uDE53\uDE55\uDE56\uDE58\uDE5A\uDE5C\uDE5E\uDE60\uDE63\uDE65\uDE66\uDE6B\uDE73\uDE78\uDE7D\uDE7F\uDE8A\uDE9C-\uDEA0\uDEA4\uDEAA\uDEBC-\uDEEF\uDEF2-\uDFFF]|\uD83C[\uDC2C-\uDC2F\uDC94-\uDC9F\uDCAF\uDCB0\uDCC0\uDCD0\uDCF6-\uDCFF\uDDAE-\uDDE5\uDE03-\uDE0F\uDE3C-\uDE3F\uDE49-\uDE4F\uDE52-\uDE5F\uDE66-\uDEFF]|\uD83D[\uDED8-\uDEDC\uDEED-\uDEEF\uDEFD-\uDEFF\uDF74-\uDF7F\uDFD9-\uDFDF\uDFEC-\uDFEF\uDFF1-\uDFFF]|\uD83E[\uDC0C-\uDC0F\uDC48-\uDC4F\uDC5A-\uDC5F\uDC88-\uDC8F\uDCAE\uDCAF\uDCB2-\uDCFF\uDE54-\uDE5F\uDE6E\uDE6F\uDE75-\uDE77\uDE7D-\uDE7F\uDE87-\uDE8F\uDEAD-\uDEAF\uDEBB-\uDEBF\uDEC6-\uDECF\uDEDA-\uDEDF\uDEE8-\uDEEF\uDEF7-\uDEFF\uDF93\uDFCB-\uDFEF\uDFFA-\uDFFF]|\uD869[\uDEE0-\uDEFF]|\uD86D[\uDF39-\uDF3F]|\uD86E[\uDC1E\uDC1F]|\uD873[\uDEA2-\uDEAF]|\uD87A[\uDFE1-\uDFFF]|\uD87E[\uDE1E-\uDFFF]|\uD884[\uDF4B-\uDFFF]|\uDB40[\uDC00-\uDCFF\uDDF0-\uDFFF]"},{name:"Cc",alias:"Control",bmp:"\0--"},{name:"Cf",alias:"Format",bmp:"­؀-؅؜۝܏࢐࢑࣢᠎​-‏‪-‮⁠-⁤⁦-⁯\uFEFF￹-￻",astral:"\uD804[\uDCBD\uDCCD]|\uD80D[\uDC30-\uDC38]|\uD82F[\uDCA0-\uDCA3]|\uD834[\uDD73-\uDD7A]|\uDB40[\uDC01\uDC20-\uDC7F]"},{name:"Cn",alias:"Unassigned",bmp:"͸͹΀-΃΋΍΢԰՗՘֋֌֐׈-׏׫-׮׵-׿܎݋݌޲-޿߻߼࠮࠯࠿࡜࡝࡟࡫-࡯࢏࢒-ࢗ঄঍঎঑঒঩঱঳-঵঺঻৅৆৉৊৏-৖৘-৛৞৤৥৿਀਄਋-਎਑਒਩਱਴਷਺਻਽੃-੆੉੊੎-੐੒-੘੝੟-੥੷-઀઄઎઒઩઱઴઺઻૆૊૎૏૑-૟૤૥૲-૸଀଄଍଎଑଒଩଱଴଺଻୅୆୉୊୎-୔୘-୛୞୤୥୸-஁஄஋-஍஑஖-஘஛஝஠-஢஥-஧஫-஭஺-஽௃-௅௉௎௏௑-௖௘-௥௻-௿఍఑఩఺఻౅౉౎-౔౗౛౜౞౟౤౥౰-౶಍಑಩಴಺಻೅೉೎-೔೗-೜೟೤೥೰ೳ-೿഍഑൅൉൐-൓൤൥඀඄඗-඙඲඼඾඿෇-෉෋-෎෕෗෠-෥෰෱෵-฀฻-฾๜-຀຃຅຋຤຦຾຿໅໇໎໏໚໛໠-໿཈཭-཰྘྽࿍࿛-࿿჆჈-჌჎჏቉቎቏቗቙቞቟኉኎኏኱኶኷኿዁዆዇዗጑጖጗፛፜፽-፿᎚-᎟᏶᏷᏾᏿᚝-᚟᛹-᛿᜖-᜞᜷-᜿᝔-᝟᝭᝱᝴-᝿៞៟៪-៯៺-៿᠚-᠟᡹-᡿᢫-᢯᣶-᣿᤟᤬-᤯᤼-᤿᥁-᥃᥮᥯᥵-᥿᦬-᦯᧊-᧏᧛-᧝᨜᨝᩟᩽᩾᪊-᪏᪚-᪟᪮᪯᫏-᫿᭍-᭏᭿᯴-᯻᰸-᰺᱊-᱌Ᲊ-᲏᲻᲼᳈-᳏᳻-᳿἖἗἞἟὆὇὎὏὘὚὜὞὾὿᾵῅῔῕῜῰῱῵῿⁥⁲⁳₏₝-₟⃁-⃏⃱-⃿↌-↏␧-␿⑋-⑟⭴⭵⮖⳴-⳸⴦⴨-⴬⴮⴯⵨-⵮⵱-⵾⶗-⶟⶧⶯⶷⶿⷇⷏⷗⷟⹞-⹿⺚⻴-⻿⿖-⿯⿼-⿿぀゗゘㄀-㄄㄰㆏㇤-㇯㈟꒍-꒏꓇-꓏꘬-꘿꛸-꛿Ɤ-꟏꟒꟔Ꟛ-꟱꠭-꠯꠺-꠿꡸-꡿꣆-꣍꣚-꣟꥔-꥞꥽-꥿꧎꧚-꧝꧿꨷-꨿꩎꩏꩚꩛꫃-꫚꫷-꬀꬇꬈꬏꬐꬗-꬟꬧꬯꭬-꭯꯮꯯꯺-꯿힤-힯퟇-퟊퟼-퟿﩮﩯﫚-﫿﬇-﬒﬘-﬜﬷﬽﬿﭂﭅﯃-﯒﶐﶑﷈-﷎﷐-﷯︚-︟﹓﹧﹬-﹯﹵﻽﻾＀﾿-￁￈￉￐￑￘￙￝-￟￧￯-￸￾￿",astral:"\uD800[\uDC0C\uDC27\uDC3B\uDC3E\uDC4E\uDC4F\uDC5E-\uDC7F\uDCFB-\uDCFF\uDD03-\uDD06\uDD34-\uDD36\uDD8F\uDD9D-\uDD9F\uDDA1-\uDDCF\uDDFE-\uDE7F\uDE9D-\uDE9F\uDED1-\uDEDF\uDEFC-\uDEFF\uDF24-\uDF2C\uDF4B-\uDF4F\uDF7B-\uDF7F\uDF9E\uDFC4-\uDFC7\uDFD6-\uDFFF]|\uD801[\uDC9E\uDC9F\uDCAA-\uDCAF\uDCD4-\uDCD7\uDCFC-\uDCFF\uDD28-\uDD2F\uDD64-\uDD6E\uDD7B\uDD8B\uDD93\uDD96\uDDA2\uDDB2\uDDBA\uDDBD-\uDDFF\uDF37-\uDF3F\uDF56-\uDF5F\uDF68-\uDF7F\uDF86\uDFB1\uDFBB-\uDFFF]|\uD802[\uDC06\uDC07\uDC09\uDC36\uDC39-\uDC3B\uDC3D\uDC3E\uDC56\uDC9F-\uDCA6\uDCB0-\uDCDF\uDCF3\uDCF6-\uDCFA\uDD1C-\uDD1E\uDD3A-\uDD3E\uDD40-\uDD7F\uDDB8-\uDDBB\uDDD0\uDDD1\uDE04\uDE07-\uDE0B\uDE14\uDE18\uDE36\uDE37\uDE3B-\uDE3E\uDE49-\uDE4F\uDE59-\uDE5F\uDEA0-\uDEBF\uDEE7-\uDEEA\uDEF7-\uDEFF\uDF36-\uDF38\uDF56\uDF57\uDF73-\uDF77\uDF92-\uDF98\uDF9D-\uDFA8\uDFB0-\uDFFF]|\uD803[\uDC49-\uDC7F\uDCB3-\uDCBF\uDCF3-\uDCF9\uDD28-\uDD2F\uDD3A-\uDE5F\uDE7F\uDEAA\uDEAE\uDEAF\uDEB2-\uDEFF\uDF28-\uDF2F\uDF5A-\uDF6F\uDF8A-\uDFAF\uDFCC-\uDFDF\uDFF7-\uDFFF]|\uD804[\uDC4E-\uDC51\uDC76-\uDC7E\uDCC3-\uDCCC\uDCCE\uDCCF\uDCE9-\uDCEF\uDCFA-\uDCFF\uDD35\uDD48-\uDD4F\uDD77-\uDD7F\uDDE0\uDDF5-\uDDFF\uDE12\uDE3F-\uDE7F\uDE87\uDE89\uDE8E\uDE9E\uDEAA-\uDEAF\uDEEB-\uDEEF\uDEFA-\uDEFF\uDF04\uDF0D\uDF0E\uDF11\uDF12\uDF29\uDF31\uDF34\uDF3A\uDF45\uDF46\uDF49\uDF4A\uDF4E\uDF4F\uDF51-\uDF56\uDF58-\uDF5C\uDF64\uDF65\uDF6D-\uDF6F\uDF75-\uDFFF]|\uD805[\uDC5C\uDC62-\uDC7F\uDCC8-\uDCCF\uDCDA-\uDD7F\uDDB6\uDDB7\uDDDE-\uDDFF\uDE45-\uDE4F\uDE5A-\uDE5F\uDE6D-\uDE7F\uDEBA-\uDEBF\uDECA-\uDEFF\uDF1B\uDF1C\uDF2C-\uDF2F\uDF47-\uDFFF]|\uD806[\uDC3C-\uDC9F\uDCF3-\uDCFE\uDD07\uDD08\uDD0A\uDD0B\uDD14\uDD17\uDD36\uDD39\uDD3A\uDD47-\uDD4F\uDD5A-\uDD9F\uDDA8\uDDA9\uDDD8\uDDD9\uDDE5-\uDDFF\uDE48-\uDE4F\uDEA3-\uDEAF\uDEF9-\uDFFF]|\uD807[\uDC09\uDC37\uDC46-\uDC4F\uDC6D-\uDC6F\uDC90\uDC91\uDCA8\uDCB7-\uDCFF\uDD07\uDD0A\uDD37-\uDD39\uDD3B\uDD3E\uDD48-\uDD4F\uDD5A-\uDD5F\uDD66\uDD69\uDD8F\uDD92\uDD99-\uDD9F\uDDAA-\uDEDF\uDEF9-\uDFAF\uDFB1-\uDFBF\uDFF2-\uDFFE]|\uD808[\uDF9A-\uDFFF]|\uD809[\uDC6F\uDC75-\uDC7F\uDD44-\uDFFF]|[\uD80A\uD80E-\uD810\uD812-\uD819\uD824-\uD82A\uD82D\uD82E\uD830-\uD832\uD83F\uD87B-\uD87D\uD87F\uD885-\uDB3F\uDB41-\uDB7F][\uDC00-\uDFFF]|\uD80B[\uDC00-\uDF8F\uDFF3-\uDFFF]|\uD80D[\uDC2F\uDC39-\uDFFF]|\uD811[\uDE47-\uDFFF]|\uD81A[\uDE39-\uDE3F\uDE5F\uDE6A-\uDE6D\uDEBF\uDECA-\uDECF\uDEEE\uDEEF\uDEF6-\uDEFF\uDF46-\uDF4F\uDF5A\uDF62\uDF78-\uDF7C\uDF90-\uDFFF]|\uD81B[\uDC00-\uDE3F\uDE9B-\uDEFF\uDF4B-\uDF4E\uDF88-\uDF8E\uDFA0-\uDFDF\uDFE5-\uDFEF\uDFF2-\uDFFF]|\uD821[\uDFF8-\uDFFF]|\uD823[\uDCD6-\uDCFF\uDD09-\uDFFF]|\uD82B[\uDC00-\uDFEF\uDFF4\uDFFC\uDFFF]|\uD82C[\uDD23-\uDD4F\uDD53-\uDD63\uDD68-\uDD6F\uDEFC-\uDFFF]|\uD82F[\uDC6B-\uDC6F\uDC7D-\uDC7F\uDC89-\uDC8F\uDC9A\uDC9B\uDCA4-\uDFFF]|\uD833[\uDC00-\uDEFF\uDF2E\uDF2F\uDF47-\uDF4F\uDFC4-\uDFFF]|\uD834[\uDCF6-\uDCFF\uDD27\uDD28\uDDEB-\uDDFF\uDE46-\uDEDF\uDEF4-\uDEFF\uDF57-\uDF5F\uDF79-\uDFFF]|\uD835[\uDC55\uDC9D\uDCA0\uDCA1\uDCA3\uDCA4\uDCA7\uDCA8\uDCAD\uDCBA\uDCBC\uDCC4\uDD06\uDD0B\uDD0C\uDD15\uDD1D\uDD3A\uDD3F\uDD45\uDD47-\uDD49\uDD51\uDEA6\uDEA7\uDFCC\uDFCD]|\uD836[\uDE8C-\uDE9A\uDEA0\uDEB0-\uDFFF]|\uD837[\uDC00-\uDEFF\uDF1F-\uDFFF]|\uD838[\uDC07\uDC19\uDC1A\uDC22\uDC25\uDC2B-\uDCFF\uDD2D-\uDD2F\uDD3E\uDD3F\uDD4A-\uDD4D\uDD50-\uDE8F\uDEAF-\uDEBF\uDEFA-\uDEFE\uDF00-\uDFFF]|\uD839[\uDC00-\uDFDF\uDFE7\uDFEC\uDFEF\uDFFF]|\uD83A[\uDCC5\uDCC6\uDCD7-\uDCFF\uDD4C-\uDD4F\uDD5A-\uDD5D\uDD60-\uDFFF]|\uD83B[\uDC00-\uDC70\uDCB5-\uDD00\uDD3E-\uDDFF\uDE04\uDE20\uDE23\uDE25\uDE26\uDE28\uDE33\uDE38\uDE3A\uDE3C-\uDE41\uDE43-\uDE46\uDE48\uDE4A\uDE4C\uDE50\uDE53\uDE55\uDE56\uDE58\uDE5A\uDE5C\uDE5E\uDE60\uDE63\uDE65\uDE66\uDE6B\uDE73\uDE78\uDE7D\uDE7F\uDE8A\uDE9C-\uDEA0\uDEA4\uDEAA\uDEBC-\uDEEF\uDEF2-\uDFFF]|\uD83C[\uDC2C-\uDC2F\uDC94-\uDC9F\uDCAF\uDCB0\uDCC0\uDCD0\uDCF6-\uDCFF\uDDAE-\uDDE5\uDE03-\uDE0F\uDE3C-\uDE3F\uDE49-\uDE4F\uDE52-\uDE5F\uDE66-\uDEFF]|\uD83D[\uDED8-\uDEDC\uDEED-\uDEEF\uDEFD-\uDEFF\uDF74-\uDF7F\uDFD9-\uDFDF\uDFEC-\uDFEF\uDFF1-\uDFFF]|\uD83E[\uDC0C-\uDC0F\uDC48-\uDC4F\uDC5A-\uDC5F\uDC88-\uDC8F\uDCAE\uDCAF\uDCB2-\uDCFF\uDE54-\uDE5F\uDE6E\uDE6F\uDE75-\uDE77\uDE7D-\uDE7F\uDE87-\uDE8F\uDEAD-\uDEAF\uDEBB-\uDEBF\uDEC6-\uDECF\uDEDA-\uDEDF\uDEE8-\uDEEF\uDEF7-\uDEFF\uDF93\uDFCB-\uDFEF\uDFFA-\uDFFF]|\uD869[\uDEE0-\uDEFF]|\uD86D[\uDF39-\uDF3F]|\uD86E[\uDC1E\uDC1F]|\uD873[\uDEA2-\uDEAF]|\uD87A[\uDFE1-\uDFFF]|\uD87E[\uDE1E-\uDFFF]|\uD884[\uDF4B-\uDFFF]|\uDB40[\uDC00\uDC02-\uDC1F\uDC80-\uDCFF\uDDF0-\uDFFF]|[\uDBBF\uDBFF][\uDFFE\uDFFF]"},{name:"Co",alias:"Private_Use",bmp:"-",astral:"[\uDB80-\uDBBE\uDBC0-\uDBFE][\uDC00-\uDFFF]|[\uDBBF\uDBFF][\uDC00-\uDFFD]"},{name:"Cs",alias:"Surrogate",bmp:"\uD800-\uDFFF"},{name:"L",alias:"Letter",bmp:"A-Za-zªµºÀ-ÖØ-öø-ˁˆ-ˑˠ-ˤˬˮͰ-ʹͶͷͺ-ͽͿΆΈ-ΊΌΎ-ΡΣ-ϵϷ-ҁҊ-ԯԱ-Ֆՙՠ-ֈא-תׯ-ײؠ-يٮٯٱ-ۓەۥۦۮۯۺ-ۼۿܐܒ-ܯݍ-ޥޱߊ-ߪߴߵߺࠀ-ࠕࠚࠤࠨࡀ-ࡘࡠ-ࡪࡰ-ࢇࢉ-ࢎࢠ-ࣉऄ-हऽॐक़-ॡॱ-ঀঅ-ঌএঐও-নপ-রলশ-হঽৎড়ঢ়য়-ৡৰৱৼਅ-ਊਏਐਓ-ਨਪ-ਰਲਲ਼ਵਸ਼ਸਹਖ਼-ੜਫ਼ੲ-ੴઅ-ઍએ-ઑઓ-નપ-રલળવ-હઽૐૠૡૹଅ-ଌଏଐଓ-ନପ-ରଲଳଵ-ହଽଡ଼ଢ଼ୟ-ୡୱஃஅ-ஊஎ-ஐஒ-கஙசஜஞடணதந-பம-ஹௐఅ-ఌఎ-ఐఒ-నప-హఽౘ-ౚౝౠౡಀಅ-ಌಎ-ಐಒ-ನಪ-ಳವ-ಹಽೝೞೠೡೱೲഄ-ഌഎ-ഐഒ-ഺഽൎൔ-ൖൟ-ൡൺ-ൿඅ-ඖක-නඳ-රලව-ෆก-ะาำเ-ๆກຂຄຆ-ຊຌ-ຣລວ-ະາຳຽເ-ໄໆໜ-ໟༀཀ-ཇཉ-ཬྈ-ྌက-ဪဿၐ-ၕၚ-ၝၡၥၦၮ-ၰၵ-ႁႎႠ-ჅჇჍა-ჺჼ-ቈቊ-ቍቐ-ቖቘቚ-ቝበ-ኈኊ-ኍነ-ኰኲ-ኵኸ-ኾዀዂ-ዅወ-ዖዘ-ጐጒ-ጕጘ-ፚᎀ-ᎏᎠ-Ᏽᏸ-ᏽᐁ-ᙬᙯ-ᙿᚁ-ᚚᚠ-ᛪᛱ-ᛸᜀ-ᜑᜟ-ᜱᝀ-ᝑᝠ-ᝬᝮ-ᝰក-ឳៗៜᠠ-ᡸᢀ-ᢄᢇ-ᢨᢪᢰ-ᣵᤀ-ᤞᥐ-ᥭᥰ-ᥴᦀ-ᦫᦰ-ᧉᨀ-ᨖᨠ-ᩔᪧᬅ-ᬳᭅ-ᭌᮃ-ᮠᮮᮯᮺ-ᯥᰀ-ᰣᱍ-ᱏᱚ-ᱽᲀ-ᲈᲐ-ᲺᲽ-Ჿᳩ-ᳬᳮ-ᳳᳵᳶᳺᴀ-ᶿḀ-ἕἘ-Ἕἠ-ὅὈ-Ὅὐ-ὗὙὛὝὟ-ώᾀ-ᾴᾶ-ᾼιῂ-ῄῆ-ῌῐ-ΐῖ-Ίῠ-Ῥῲ-ῴῶ-ῼⁱⁿₐ-ₜℂℇℊ-ℓℕℙ-ℝℤΩℨK-ℭℯ-ℹℼ-ℿⅅ-ⅉⅎↃↄⰀ-ⳤⳫ-ⳮⳲⳳⴀ-ⴥⴧⴭⴰ-ⵧⵯⶀ-ⶖⶠ-ⶦⶨ-ⶮⶰ-ⶶⶸ-ⶾⷀ-ⷆⷈ-ⷎⷐ-ⷖⷘ-ⷞⸯ々〆〱-〵〻〼ぁ-ゖゝ-ゟァ-ヺー-ヿㄅ-ㄯㄱ-ㆎㆠ-ㆿㇰ-ㇿ㐀-䶿一-ꒌꓐ-ꓽꔀ-ꘌꘐ-ꘟꘪꘫꙀ-ꙮꙿ-ꚝꚠ-ꛥꜗ-ꜟꜢ-ꞈꞋ-ꟊꟐꟑꟓꟕ-ꟙꟲ-ꠁꠃ-ꠅꠇ-ꠊꠌ-ꠢꡀ-ꡳꢂ-ꢳꣲ-ꣷꣻꣽꣾꤊ-ꤥꤰ-ꥆꥠ-ꥼꦄ-ꦲꧏꧠ-ꧤꧦ-ꧯꧺ-ꧾꨀ-ꨨꩀ-ꩂꩄ-ꩋꩠ-ꩶꩺꩾ-ꪯꪱꪵꪶꪹ-ꪽꫀꫂꫛ-ꫝꫠ-ꫪꫲ-ꫴꬁ-ꬆꬉ-ꬎꬑ-ꬖꬠ-ꬦꬨ-ꬮꬰ-ꭚꭜ-ꭩꭰ-ꯢ가-힣ힰ-ퟆퟋ-ퟻ豈-舘並-龎ﬀ-ﬆﬓ-ﬗיִײַ-ﬨשׁ-זּטּ-לּמּנּסּףּפּצּ-ﮱﯓ-ﴽﵐ-ﶏﶒ-ﷇﷰ-ﷻﹰ-ﹴﹶ-ﻼＡ-Ｚａ-ｚｦ-ﾾￂ-ￇￊ-ￏￒ-ￗￚ-ￜ",astral:"\uD800[\uDC00-\uDC0B\uDC0D-\uDC26\uDC28-\uDC3A\uDC3C\uDC3D\uDC3F-\uDC4D\uDC50-\uDC5D\uDC80-\uDCFA\uDE80-\uDE9C\uDEA0-\uDED0\uDF00-\uDF1F\uDF2D-\uDF40\uDF42-\uDF49\uDF50-\uDF75\uDF80-\uDF9D\uDFA0-\uDFC3\uDFC8-\uDFCF]|\uD801[\uDC00-\uDC9D\uDCB0-\uDCD3\uDCD8-\uDCFB\uDD00-\uDD27\uDD30-\uDD63\uDD70-\uDD7A\uDD7C-\uDD8A\uDD8C-\uDD92\uDD94\uDD95\uDD97-\uDDA1\uDDA3-\uDDB1\uDDB3-\uDDB9\uDDBB\uDDBC\uDE00-\uDF36\uDF40-\uDF55\uDF60-\uDF67\uDF80-\uDF85\uDF87-\uDFB0\uDFB2-\uDFBA]|\uD802[\uDC00-\uDC05\uDC08\uDC0A-\uDC35\uDC37\uDC38\uDC3C\uDC3F-\uDC55\uDC60-\uDC76\uDC80-\uDC9E\uDCE0-\uDCF2\uDCF4\uDCF5\uDD00-\uDD15\uDD20-\uDD39\uDD80-\uDDB7\uDDBE\uDDBF\uDE00\uDE10-\uDE13\uDE15-\uDE17\uDE19-\uDE35\uDE60-\uDE7C\uDE80-\uDE9C\uDEC0-\uDEC7\uDEC9-\uDEE4\uDF00-\uDF35\uDF40-\uDF55\uDF60-\uDF72\uDF80-\uDF91]|\uD803[\uDC00-\uDC48\uDC80-\uDCB2\uDCC0-\uDCF2\uDD00-\uDD23\uDE80-\uDEA9\uDEB0\uDEB1\uDF00-\uDF1C\uDF27\uDF30-\uDF45\uDF70-\uDF81\uDFB0-\uDFC4\uDFE0-\uDFF6]|\uD804[\uDC03-\uDC37\uDC71\uDC72\uDC75\uDC83-\uDCAF\uDCD0-\uDCE8\uDD03-\uDD26\uDD44\uDD47\uDD50-\uDD72\uDD76\uDD83-\uDDB2\uDDC1-\uDDC4\uDDDA\uDDDC\uDE00-\uDE11\uDE13-\uDE2B\uDE80-\uDE86\uDE88\uDE8A-\uDE8D\uDE8F-\uDE9D\uDE9F-\uDEA8\uDEB0-\uDEDE\uDF05-\uDF0C\uDF0F\uDF10\uDF13-\uDF28\uDF2A-\uDF30\uDF32\uDF33\uDF35-\uDF39\uDF3D\uDF50\uDF5D-\uDF61]|\uD805[\uDC00-\uDC34\uDC47-\uDC4A\uDC5F-\uDC61\uDC80-\uDCAF\uDCC4\uDCC5\uDCC7\uDD80-\uDDAE\uDDD8-\uDDDB\uDE00-\uDE2F\uDE44\uDE80-\uDEAA\uDEB8\uDF00-\uDF1A\uDF40-\uDF46]|\uD806[\uDC00-\uDC2B\uDCA0-\uDCDF\uDCFF-\uDD06\uDD09\uDD0C-\uDD13\uDD15\uDD16\uDD18-\uDD2F\uDD3F\uDD41\uDDA0-\uDDA7\uDDAA-\uDDD0\uDDE1\uDDE3\uDE00\uDE0B-\uDE32\uDE3A\uDE50\uDE5C-\uDE89\uDE9D\uDEB0-\uDEF8]|\uD807[\uDC00-\uDC08\uDC0A-\uDC2E\uDC40\uDC72-\uDC8F\uDD00-\uDD06\uDD08\uDD09\uDD0B-\uDD30\uDD46\uDD60-\uDD65\uDD67\uDD68\uDD6A-\uDD89\uDD98\uDEE0-\uDEF2\uDFB0]|\uD808[\uDC00-\uDF99]|\uD809[\uDC80-\uDD43]|\uD80B[\uDF90-\uDFF0]|[\uD80C\uD81C-\uD820\uD822\uD840-\uD868\uD86A-\uD86C\uD86F-\uD872\uD874-\uD879\uD880-\uD883][\uDC00-\uDFFF]|\uD80D[\uDC00-\uDC2E]|\uD811[\uDC00-\uDE46]|\uD81A[\uDC00-\uDE38\uDE40-\uDE5E\uDE70-\uDEBE\uDED0-\uDEED\uDF00-\uDF2F\uDF40-\uDF43\uDF63-\uDF77\uDF7D-\uDF8F]|\uD81B[\uDE40-\uDE7F\uDF00-\uDF4A\uDF50\uDF93-\uDF9F\uDFE0\uDFE1\uDFE3]|\uD821[\uDC00-\uDFF7]|\uD823[\uDC00-\uDCD5\uDD00-\uDD08]|\uD82B[\uDFF0-\uDFF3\uDFF5-\uDFFB\uDFFD\uDFFE]|\uD82C[\uDC00-\uDD22\uDD50-\uDD52\uDD64-\uDD67\uDD70-\uDEFB]|\uD82F[\uDC00-\uDC6A\uDC70-\uDC7C\uDC80-\uDC88\uDC90-\uDC99]|\uD835[\uDC00-\uDC54\uDC56-\uDC9C\uDC9E\uDC9F\uDCA2\uDCA5\uDCA6\uDCA9-\uDCAC\uDCAE-\uDCB9\uDCBB\uDCBD-\uDCC3\uDCC5-\uDD05\uDD07-\uDD0A\uDD0D-\uDD14\uDD16-\uDD1C\uDD1E-\uDD39\uDD3B-\uDD3E\uDD40-\uDD44\uDD46\uDD4A-\uDD50\uDD52-\uDEA5\uDEA8-\uDEC0\uDEC2-\uDEDA\uDEDC-\uDEFA\uDEFC-\uDF14\uDF16-\uDF34\uDF36-\uDF4E\uDF50-\uDF6E\uDF70-\uDF88\uDF8A-\uDFA8\uDFAA-\uDFC2\uDFC4-\uDFCB]|\uD837[\uDF00-\uDF1E]|\uD838[\uDD00-\uDD2C\uDD37-\uDD3D\uDD4E\uDE90-\uDEAD\uDEC0-\uDEEB]|\uD839[\uDFE0-\uDFE6\uDFE8-\uDFEB\uDFED\uDFEE\uDFF0-\uDFFE]|\uD83A[\uDC00-\uDCC4\uDD00-\uDD43\uDD4B]|\uD83B[\uDE00-\uDE03\uDE05-\uDE1F\uDE21\uDE22\uDE24\uDE27\uDE29-\uDE32\uDE34-\uDE37\uDE39\uDE3B\uDE42\uDE47\uDE49\uDE4B\uDE4D-\uDE4F\uDE51\uDE52\uDE54\uDE57\uDE59\uDE5B\uDE5D\uDE5F\uDE61\uDE62\uDE64\uDE67-\uDE6A\uDE6C-\uDE72\uDE74-\uDE77\uDE79-\uDE7C\uDE7E\uDE80-\uDE89\uDE8B-\uDE9B\uDEA1-\uDEA3\uDEA5-\uDEA9\uDEAB-\uDEBB]|\uD869[\uDC00-\uDEDF\uDF00-\uDFFF]|\uD86D[\uDC00-\uDF38\uDF40-\uDFFF]|\uD86E[\uDC00-\uDC1D\uDC20-\uDFFF]|\uD873[\uDC00-\uDEA1\uDEB0-\uDFFF]|\uD87A[\uDC00-\uDFE0]|\uD87E[\uDC00-\uDE1D]|\uD884[\uDC00-\uDF4A]"},{name:"LC",alias:"Cased_Letter",bmp:"A-Za-zµÀ-ÖØ-öø-ƺƼ-ƿǄ-ʓʕ-ʯͰ-ͳͶͷͻ-ͽͿΆΈ-ΊΌΎ-ΡΣ-ϵϷ-ҁҊ-ԯԱ-Ֆՠ-ֈႠ-ჅჇჍა-ჺჽ-ჿᎠ-Ᏽᏸ-ᏽᲀ-ᲈᲐ-ᲺᲽ-Ჿᴀ-ᴫᵫ-ᵷᵹ-ᶚḀ-ἕἘ-Ἕἠ-ὅὈ-Ὅὐ-ὗὙὛὝὟ-ώᾀ-ᾴᾶ-ᾼιῂ-ῄῆ-ῌῐ-ΐῖ-Ίῠ-Ῥῲ-ῴῶ-ῼℂℇℊ-ℓℕℙ-ℝℤΩℨK-ℭℯ-ℴℹℼ-ℿⅅ-ⅉⅎↃↄⰀ-ⱻⱾ-ⳤⳫ-ⳮⳲⳳⴀ-ⴥⴧⴭꙀ-ꙭꚀ-ꚛꜢ-ꝯꝱ-ꞇꞋ-ꞎꞐ-ꟊꟐꟑꟓꟕ-ꟙꟵꟶꟺꬰ-ꭚꭠ-ꭨꭰ-ꮿﬀ-ﬆﬓ-ﬗＡ-Ｚａ-ｚ",astral:"\uD801[\uDC00-\uDC4F\uDCB0-\uDCD3\uDCD8-\uDCFB\uDD70-\uDD7A\uDD7C-\uDD8A\uDD8C-\uDD92\uDD94\uDD95\uDD97-\uDDA1\uDDA3-\uDDB1\uDDB3-\uDDB9\uDDBB\uDDBC]|\uD803[\uDC80-\uDCB2\uDCC0-\uDCF2]|\uD806[\uDCA0-\uDCDF]|\uD81B[\uDE40-\uDE7F]|\uD835[\uDC00-\uDC54\uDC56-\uDC9C\uDC9E\uDC9F\uDCA2\uDCA5\uDCA6\uDCA9-\uDCAC\uDCAE-\uDCB9\uDCBB\uDCBD-\uDCC3\uDCC5-\uDD05\uDD07-\uDD0A\uDD0D-\uDD14\uDD16-\uDD1C\uDD1E-\uDD39\uDD3B-\uDD3E\uDD40-\uDD44\uDD46\uDD4A-\uDD50\uDD52-\uDEA5\uDEA8-\uDEC0\uDEC2-\uDEDA\uDEDC-\uDEFA\uDEFC-\uDF14\uDF16-\uDF34\uDF36-\uDF4E\uDF50-\uDF6E\uDF70-\uDF88\uDF8A-\uDFA8\uDFAA-\uDFC2\uDFC4-\uDFCB]|\uD837[\uDF00-\uDF09\uDF0B-\uDF1E]|\uD83A[\uDD00-\uDD43]"},{name:"Ll",alias:"Lowercase_Letter",bmp:"a-zµß-öø-ÿāăąćĉċčďđēĕėęěĝğġģĥħĩīĭįıĳĵķĸĺļľŀłńņňŉŋōŏőœŕŗřśŝşšţťŧũūŭůűųŵŷźżž-ƀƃƅƈƌƍƒƕƙ-ƛƞơƣƥƨƪƫƭưƴƶƹƺƽ-ƿǆǉǌǎǐǒǔǖǘǚǜǝǟǡǣǥǧǩǫǭǯǰǳǵǹǻǽǿȁȃȅȇȉȋȍȏȑȓȕȗșțȝȟȡȣȥȧȩȫȭȯȱȳ-ȹȼȿɀɂɇɉɋɍɏ-ʓʕ-ʯͱͳͷͻ-ͽΐά-ώϐϑϕ-ϗϙϛϝϟϡϣϥϧϩϫϭϯ-ϳϵϸϻϼа-џѡѣѥѧѩѫѭѯѱѳѵѷѹѻѽѿҁҋҍҏґғҕҗҙқҝҟҡңҥҧҩҫҭүұҳҵҷҹһҽҿӂӄӆӈӊӌӎӏӑӓӕӗәӛӝӟӡӣӥӧөӫӭӯӱӳӵӷӹӻӽӿԁԃԅԇԉԋԍԏԑԓԕԗԙԛԝԟԡԣԥԧԩԫԭԯՠ-ֈა-ჺჽ-ჿᏸ-ᏽᲀ-ᲈᴀ-ᴫᵫ-ᵷᵹ-ᶚḁḃḅḇḉḋḍḏḑḓḕḗḙḛḝḟḡḣḥḧḩḫḭḯḱḳḵḷḹḻḽḿṁṃṅṇṉṋṍṏṑṓṕṗṙṛṝṟṡṣṥṧṩṫṭṯṱṳṵṷṹṻṽṿẁẃẅẇẉẋẍẏẑẓẕ-ẝẟạảấầẩẫậắằẳẵặẹẻẽếềểễệỉịọỏốồổỗộớờởỡợụủứừửữựỳỵỷỹỻỽỿ-ἇἐ-ἕἠ-ἧἰ-ἷὀ-ὅὐ-ὗὠ-ὧὰ-ώᾀ-ᾇᾐ-ᾗᾠ-ᾧᾰ-ᾴᾶᾷιῂ-ῄῆῇῐ-ΐῖῗῠ-ῧῲ-ῴῶῷℊℎℏℓℯℴℹℼℽⅆ-ⅉⅎↄⰰ-ⱟⱡⱥⱦⱨⱪⱬⱱⱳⱴⱶ-ⱻⲁⲃⲅⲇⲉⲋⲍⲏⲑⲓⲕⲗⲙⲛⲝⲟⲡⲣⲥⲧⲩⲫⲭⲯⲱⲳⲵⲷⲹⲻⲽⲿⳁⳃⳅⳇⳉⳋⳍⳏⳑⳓⳕⳗⳙⳛⳝⳟⳡⳣⳤⳬⳮⳳⴀ-ⴥⴧⴭꙁꙃꙅꙇꙉꙋꙍꙏꙑꙓꙕꙗꙙꙛꙝꙟꙡꙣꙥꙧꙩꙫꙭꚁꚃꚅꚇꚉꚋꚍꚏꚑꚓꚕꚗꚙꚛꜣꜥꜧꜩꜫꜭꜯ-ꜱꜳꜵꜷꜹꜻꜽꜿꝁꝃꝅꝇꝉꝋꝍꝏꝑꝓꝕꝗꝙꝛꝝꝟꝡꝣꝥꝧꝩꝫꝭꝯꝱ-ꝸꝺꝼꝿꞁꞃꞅꞇꞌꞎꞑꞓ-ꞕꞗꞙꞛꞝꞟꞡꞣꞥꞧꞩꞯꞵꞷꞹꞻꞽꞿꟁꟃꟈꟊꟑꟓꟕꟗꟙꟶꟺꬰ-ꭚꭠ-ꭨꭰ-ꮿﬀ-ﬆﬓ-ﬗａ-ｚ",astral:"\uD801[\uDC28-\uDC4F\uDCD8-\uDCFB\uDD97-\uDDA1\uDDA3-\uDDB1\uDDB3-\uDDB9\uDDBB\uDDBC]|\uD803[\uDCC0-\uDCF2]|\uD806[\uDCC0-\uDCDF]|\uD81B[\uDE60-\uDE7F]|\uD835[\uDC1A-\uDC33\uDC4E-\uDC54\uDC56-\uDC67\uDC82-\uDC9B\uDCB6-\uDCB9\uDCBB\uDCBD-\uDCC3\uDCC5-\uDCCF\uDCEA-\uDD03\uDD1E-\uDD37\uDD52-\uDD6B\uDD86-\uDD9F\uDDBA-\uDDD3\uDDEE-\uDE07\uDE22-\uDE3B\uDE56-\uDE6F\uDE8A-\uDEA5\uDEC2-\uDEDA\uDEDC-\uDEE1\uDEFC-\uDF14\uDF16-\uDF1B\uDF36-\uDF4E\uDF50-\uDF55\uDF70-\uDF88\uDF8A-\uDF8F\uDFAA-\uDFC2\uDFC4-\uDFC9\uDFCB]|\uD837[\uDF00-\uDF09\uDF0B-\uDF1E]|\uD83A[\uDD22-\uDD43]"},{name:"Lm",alias:"Modifier_Letter",bmp:"ʰ-ˁˆ-ˑˠ-ˤˬˮʹͺՙـۥۦߴߵߺࠚࠤࠨࣉॱๆໆჼៗᡃᪧᱸ-ᱽᴬ-ᵪᵸᶛ-ᶿⁱⁿₐ-ₜⱼⱽⵯⸯ々〱-〵〻ゝゞー-ヾꀕꓸ-ꓽꘌꙿꚜꚝꜗ-ꜟꝰꞈꟲ-ꟴꟸꟹꧏꧦꩰꫝꫳꫴꭜ-ꭟꭩｰﾞﾟ",astral:"\uD801[\uDF80-\uDF85\uDF87-\uDFB0\uDFB2-\uDFBA]|\uD81A[\uDF40-\uDF43]|\uD81B[\uDF93-\uDF9F\uDFE0\uDFE1\uDFE3]|\uD82B[\uDFF0-\uDFF3\uDFF5-\uDFFB\uDFFD\uDFFE]|\uD838[\uDD37-\uDD3D]|𞥋"},{name:"Lo",alias:"Other_Letter",bmp:"ªºƻǀ-ǃʔא-תׯ-ײؠ-ؿف-يٮٯٱ-ۓەۮۯۺ-ۼۿܐܒ-ܯݍ-ޥޱߊ-ߪࠀ-ࠕࡀ-ࡘࡠ-ࡪࡰ-ࢇࢉ-ࢎࢠ-ࣈऄ-हऽॐक़-ॡॲ-ঀঅ-ঌএঐও-নপ-রলশ-হঽৎড়ঢ়য়-ৡৰৱৼਅ-ਊਏਐਓ-ਨਪ-ਰਲਲ਼ਵਸ਼ਸਹਖ਼-ੜਫ਼ੲ-ੴઅ-ઍએ-ઑઓ-નપ-રલળવ-હઽૐૠૡૹଅ-ଌଏଐଓ-ନପ-ରଲଳଵ-ହଽଡ଼ଢ଼ୟ-ୡୱஃஅ-ஊஎ-ஐஒ-கஙசஜஞடணதந-பம-ஹௐఅ-ఌఎ-ఐఒ-నప-హఽౘ-ౚౝౠౡಀಅ-ಌಎ-ಐಒ-ನಪ-ಳವ-ಹಽೝೞೠೡೱೲഄ-ഌഎ-ഐഒ-ഺഽൎൔ-ൖൟ-ൡൺ-ൿඅ-ඖක-නඳ-රලව-ෆก-ะาำเ-ๅກຂຄຆ-ຊຌ-ຣລວ-ະາຳຽເ-ໄໜ-ໟༀཀ-ཇཉ-ཬྈ-ྌက-ဪဿၐ-ၕၚ-ၝၡၥၦၮ-ၰၵ-ႁႎᄀ-ቈቊ-ቍቐ-ቖቘቚ-ቝበ-ኈኊ-ኍነ-ኰኲ-ኵኸ-ኾዀዂ-ዅወ-ዖዘ-ጐጒ-ጕጘ-ፚᎀ-ᎏᐁ-ᙬᙯ-ᙿᚁ-ᚚᚠ-ᛪᛱ-ᛸᜀ-ᜑᜟ-ᜱᝀ-ᝑᝠ-ᝬᝮ-ᝰក-ឳៜᠠ-ᡂᡄ-ᡸᢀ-ᢄᢇ-ᢨᢪᢰ-ᣵᤀ-ᤞᥐ-ᥭᥰ-ᥴᦀ-ᦫᦰ-ᧉᨀ-ᨖᨠ-ᩔᬅ-ᬳᭅ-ᭌᮃ-ᮠᮮᮯᮺ-ᯥᰀ-ᰣᱍ-ᱏᱚ-ᱷᳩ-ᳬᳮ-ᳳᳵᳶᳺℵ-ℸⴰ-ⵧⶀ-ⶖⶠ-ⶦⶨ-ⶮⶰ-ⶶⶸ-ⶾⷀ-ⷆⷈ-ⷎⷐ-ⷖⷘ-ⷞ〆〼ぁ-ゖゟァ-ヺヿㄅ-ㄯㄱ-ㆎㆠ-ㆿㇰ-ㇿ㐀-䶿一-ꀔꀖ-ꒌꓐ-ꓷꔀ-ꘋꘐ-ꘟꘪꘫꙮꚠ-ꛥꞏꟷꟻ-ꠁꠃ-ꠅꠇ-ꠊꠌ-ꠢꡀ-ꡳꢂ-ꢳꣲ-ꣷꣻꣽꣾꤊ-ꤥꤰ-ꥆꥠ-ꥼꦄ-ꦲꧠ-ꧤꧧ-ꧯꧺ-ꧾꨀ-ꨨꩀ-ꩂꩄ-ꩋꩠ-ꩯꩱ-ꩶꩺꩾ-ꪯꪱꪵꪶꪹ-ꪽꫀꫂꫛꫜꫠ-ꫪꫲꬁ-ꬆꬉ-ꬎꬑ-ꬖꬠ-ꬦꬨ-ꬮꯀ-ꯢ가-힣ힰ-ퟆퟋ-ퟻ豈-舘並-龎יִײַ-ﬨשׁ-זּטּ-לּמּנּסּףּפּצּ-ﮱﯓ-ﴽﵐ-ﶏﶒ-ﷇﷰ-ﷻﹰ-ﹴﹶ-ﻼｦ-ｯｱ-ﾝﾠ-ﾾￂ-ￇￊ-ￏￒ-ￗￚ-ￜ",astral:"\uD800[\uDC00-\uDC0B\uDC0D-\uDC26\uDC28-\uDC3A\uDC3C\uDC3D\uDC3F-\uDC4D\uDC50-\uDC5D\uDC80-\uDCFA\uDE80-\uDE9C\uDEA0-\uDED0\uDF00-\uDF1F\uDF2D-\uDF40\uDF42-\uDF49\uDF50-\uDF75\uDF80-\uDF9D\uDFA0-\uDFC3\uDFC8-\uDFCF]|\uD801[\uDC50-\uDC9D\uDD00-\uDD27\uDD30-\uDD63\uDE00-\uDF36\uDF40-\uDF55\uDF60-\uDF67]|\uD802[\uDC00-\uDC05\uDC08\uDC0A-\uDC35\uDC37\uDC38\uDC3C\uDC3F-\uDC55\uDC60-\uDC76\uDC80-\uDC9E\uDCE0-\uDCF2\uDCF4\uDCF5\uDD00-\uDD15\uDD20-\uDD39\uDD80-\uDDB7\uDDBE\uDDBF\uDE00\uDE10-\uDE13\uDE15-\uDE17\uDE19-\uDE35\uDE60-\uDE7C\uDE80-\uDE9C\uDEC0-\uDEC7\uDEC9-\uDEE4\uDF00-\uDF35\uDF40-\uDF55\uDF60-\uDF72\uDF80-\uDF91]|\uD803[\uDC00-\uDC48\uDD00-\uDD23\uDE80-\uDEA9\uDEB0\uDEB1\uDF00-\uDF1C\uDF27\uDF30-\uDF45\uDF70-\uDF81\uDFB0-\uDFC4\uDFE0-\uDFF6]|\uD804[\uDC03-\uDC37\uDC71\uDC72\uDC75\uDC83-\uDCAF\uDCD0-\uDCE8\uDD03-\uDD26\uDD44\uDD47\uDD50-\uDD72\uDD76\uDD83-\uDDB2\uDDC1-\uDDC4\uDDDA\uDDDC\uDE00-\uDE11\uDE13-\uDE2B\uDE80-\uDE86\uDE88\uDE8A-\uDE8D\uDE8F-\uDE9D\uDE9F-\uDEA8\uDEB0-\uDEDE\uDF05-\uDF0C\uDF0F\uDF10\uDF13-\uDF28\uDF2A-\uDF30\uDF32\uDF33\uDF35-\uDF39\uDF3D\uDF50\uDF5D-\uDF61]|\uD805[\uDC00-\uDC34\uDC47-\uDC4A\uDC5F-\uDC61\uDC80-\uDCAF\uDCC4\uDCC5\uDCC7\uDD80-\uDDAE\uDDD8-\uDDDB\uDE00-\uDE2F\uDE44\uDE80-\uDEAA\uDEB8\uDF00-\uDF1A\uDF40-\uDF46]|\uD806[\uDC00-\uDC2B\uDCFF-\uDD06\uDD09\uDD0C-\uDD13\uDD15\uDD16\uDD18-\uDD2F\uDD3F\uDD41\uDDA0-\uDDA7\uDDAA-\uDDD0\uDDE1\uDDE3\uDE00\uDE0B-\uDE32\uDE3A\uDE50\uDE5C-\uDE89\uDE9D\uDEB0-\uDEF8]|\uD807[\uDC00-\uDC08\uDC0A-\uDC2E\uDC40\uDC72-\uDC8F\uDD00-\uDD06\uDD08\uDD09\uDD0B-\uDD30\uDD46\uDD60-\uDD65\uDD67\uDD68\uDD6A-\uDD89\uDD98\uDEE0-\uDEF2\uDFB0]|\uD808[\uDC00-\uDF99]|\uD809[\uDC80-\uDD43]|\uD80B[\uDF90-\uDFF0]|[\uD80C\uD81C-\uD820\uD822\uD840-\uD868\uD86A-\uD86C\uD86F-\uD872\uD874-\uD879\uD880-\uD883][\uDC00-\uDFFF]|\uD80D[\uDC00-\uDC2E]|\uD811[\uDC00-\uDE46]|\uD81A[\uDC00-\uDE38\uDE40-\uDE5E\uDE70-\uDEBE\uDED0-\uDEED\uDF00-\uDF2F\uDF63-\uDF77\uDF7D-\uDF8F]|\uD81B[\uDF00-\uDF4A\uDF50]|\uD821[\uDC00-\uDFF7]|\uD823[\uDC00-\uDCD5\uDD00-\uDD08]|\uD82C[\uDC00-\uDD22\uDD50-\uDD52\uDD64-\uDD67\uDD70-\uDEFB]|\uD82F[\uDC00-\uDC6A\uDC70-\uDC7C\uDC80-\uDC88\uDC90-\uDC99]|𝼊|\uD838[\uDD00-\uDD2C\uDD4E\uDE90-\uDEAD\uDEC0-\uDEEB]|\uD839[\uDFE0-\uDFE6\uDFE8-\uDFEB\uDFED\uDFEE\uDFF0-\uDFFE]|\uD83A[\uDC00-\uDCC4]|\uD83B[\uDE00-\uDE03\uDE05-\uDE1F\uDE21\uDE22\uDE24\uDE27\uDE29-\uDE32\uDE34-\uDE37\uDE39\uDE3B\uDE42\uDE47\uDE49\uDE4B\uDE4D-\uDE4F\uDE51\uDE52\uDE54\uDE57\uDE59\uDE5B\uDE5D\uDE5F\uDE61\uDE62\uDE64\uDE67-\uDE6A\uDE6C-\uDE72\uDE74-\uDE77\uDE79-\uDE7C\uDE7E\uDE80-\uDE89\uDE8B-\uDE9B\uDEA1-\uDEA3\uDEA5-\uDEA9\uDEAB-\uDEBB]|\uD869[\uDC00-\uDEDF\uDF00-\uDFFF]|\uD86D[\uDC00-\uDF38\uDF40-\uDFFF]|\uD86E[\uDC00-\uDC1D\uDC20-\uDFFF]|\uD873[\uDC00-\uDEA1\uDEB0-\uDFFF]|\uD87A[\uDC00-\uDFE0]|\uD87E[\uDC00-\uDE1D]|\uD884[\uDC00-\uDF4A]"},{name:"Lt",alias:"Titlecase_Letter",bmp:"ǅǈǋǲᾈ-ᾏᾘ-ᾟᾨ-ᾯᾼῌῼ"},{name:"Lu",alias:"Uppercase_Letter",bmp:"A-ZÀ-ÖØ-ÞĀĂĄĆĈĊČĎĐĒĔĖĘĚĜĞĠĢĤĦĨĪĬĮİĲĴĶĹĻĽĿŁŃŅŇŊŌŎŐŒŔŖŘŚŜŞŠŢŤŦŨŪŬŮŰŲŴŶŸŹŻŽƁƂƄƆƇƉ-ƋƎ-ƑƓƔƖ-ƘƜƝƟƠƢƤƦƧƩƬƮƯƱ-ƳƵƷƸƼǄǇǊǍǏǑǓǕǗǙǛǞǠǢǤǦǨǪǬǮǱǴǶ-ǸǺǼǾȀȂȄȆȈȊȌȎȐȒȔȖȘȚȜȞȠȢȤȦȨȪȬȮȰȲȺȻȽȾɁɃ-ɆɈɊɌɎͰͲͶͿΆΈ-ΊΌΎΏΑ-ΡΣ-ΫϏϒ-ϔϘϚϜϞϠϢϤϦϨϪϬϮϴϷϹϺϽ-ЯѠѢѤѦѨѪѬѮѰѲѴѶѸѺѼѾҀҊҌҎҐҒҔҖҘҚҜҞҠҢҤҦҨҪҬҮҰҲҴҶҸҺҼҾӀӁӃӅӇӉӋӍӐӒӔӖӘӚӜӞӠӢӤӦӨӪӬӮӰӲӴӶӸӺӼӾԀԂԄԆԈԊԌԎԐԒԔԖԘԚԜԞԠԢԤԦԨԪԬԮԱ-ՖႠ-ჅჇჍᎠ-ᏵᲐ-ᲺᲽ-ᲿḀḂḄḆḈḊḌḎḐḒḔḖḘḚḜḞḠḢḤḦḨḪḬḮḰḲḴḶḸḺḼḾṀṂṄṆṈṊṌṎṐṒṔṖṘṚṜṞṠṢṤṦṨṪṬṮṰṲṴṶṸṺṼṾẀẂẄẆẈẊẌẎẐẒẔẞẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼẾỀỂỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪỬỮỰỲỴỶỸỺỼỾἈ-ἏἘ-ἝἨ-ἯἸ-ἿὈ-ὍὙὛὝὟὨ-ὯᾸ-ΆῈ-ΉῘ-ΊῨ-ῬῸ-Ώℂℇℋ-ℍℐ-ℒℕℙ-ℝℤΩℨK-ℭℰ-ℳℾℿⅅↃⰀ-ⰯⱠⱢ-ⱤⱧⱩⱫⱭ-ⱰⱲⱵⱾ-ⲀⲂⲄⲆⲈⲊⲌⲎⲐⲒⲔⲖⲘⲚⲜⲞⲠⲢⲤⲦⲨⲪⲬⲮⲰⲲⲴⲶⲸⲺⲼⲾⳀⳂⳄⳆⳈⳊⳌⳎⳐⳒⳔⳖⳘⳚⳜⳞⳠⳢⳫⳭⳲꙀꙂꙄꙆꙈꙊꙌꙎꙐꙒꙔꙖꙘꙚꙜꙞꙠꙢꙤꙦꙨꙪꙬꚀꚂꚄꚆꚈꚊꚌꚎꚐꚒꚔꚖꚘꚚꜢꜤꜦꜨꜪꜬꜮꜲꜴꜶꜸꜺꜼꜾꝀꝂꝄꝆꝈꝊꝌꝎꝐꝒꝔꝖꝘꝚꝜꝞꝠꝢꝤꝦꝨꝪꝬꝮꝹꝻꝽꝾꞀꞂꞄꞆꞋꞍꞐꞒꞖꞘꞚꞜꞞꞠꞢꞤꞦꞨꞪ-ꞮꞰ-ꞴꞶꞸꞺꞼꞾꟀꟂꟄ-ꟇꟉꟐꟖꟘꟵＡ-Ｚ",astral:"\uD801[\uDC00-\uDC27\uDCB0-\uDCD3\uDD70-\uDD7A\uDD7C-\uDD8A\uDD8C-\uDD92\uDD94\uDD95]|\uD803[\uDC80-\uDCB2]|\uD806[\uDCA0-\uDCBF]|\uD81B[\uDE40-\uDE5F]|\uD835[\uDC00-\uDC19\uDC34-\uDC4D\uDC68-\uDC81\uDC9C\uDC9E\uDC9F\uDCA2\uDCA5\uDCA6\uDCA9-\uDCAC\uDCAE-\uDCB5\uDCD0-\uDCE9\uDD04\uDD05\uDD07-\uDD0A\uDD0D-\uDD14\uDD16-\uDD1C\uDD38\uDD39\uDD3B-\uDD3E\uDD40-\uDD44\uDD46\uDD4A-\uDD50\uDD6C-\uDD85\uDDA0-\uDDB9\uDDD4-\uDDED\uDE08-\uDE21\uDE3C-\uDE55\uDE70-\uDE89\uDEA8-\uDEC0\uDEE2-\uDEFA\uDF1C-\uDF34\uDF56-\uDF6E\uDF90-\uDFA8\uDFCA]|\uD83A[\uDD00-\uDD21]"},{name:"M",alias:"Mark",bmp:"̀-ͯ҃-҉֑-ׇֽֿׁׂׅׄؐ-ًؚ-ٰٟۖ-ۜ۟-۪ۤۧۨ-ܑۭܰ-݊ަ-ް߫-߽߳ࠖ-࠙ࠛ-ࠣࠥ-ࠧࠩ-࡙࠭-࡛࢘-࢟࣊-ࣣ࣡-ःऺ-़ा-ॏ॑-ॗॢॣঁ-ঃ়া-ৄেৈো-্ৗৢৣ৾ਁ-ਃ਼ਾ-ੂੇੈੋ-੍ੑੰੱੵઁ-ઃ઼ા-ૅે-ૉો-્ૢૣૺ-૿ଁ-ଃ଼ା-ୄେୈୋ-୍୕-ୗୢୣஂா-ூெ-ைொ-்ௗఀ-ఄ఼ా-ౄె-ైొ-్ౕౖౢౣಁ-ಃ಼ಾ-ೄೆ-ೈೊ-್ೕೖೢೣഀ-ഃ഻഼ാ-ൄെ-ൈൊ-്ൗൢൣඁ-ඃ්ා-ුූෘ-ෟෲෳัิ-ฺ็-๎ັິ-ຼ່-ໍ༹༘༙༵༷༾༿ཱ-྄྆྇ྍ-ྗྙ-ྼ࿆ါ-ှၖ-ၙၞ-ၠၢ-ၤၧ-ၭၱ-ၴႂ-ႍႏႚ-ႝ፝-፟ᜒ-᜕ᜲ-᜴ᝒᝓᝲᝳ឴-៓៝᠋-᠍᠏ᢅᢆᢩᤠ-ᤫᤰ-᤻ᨗ-ᨛᩕ-ᩞ᩠-᩿᩼᪰-ᫎᬀ-ᬄ᬴-᭄᭫-᭳ᮀ-ᮂᮡ-ᮭ᯦-᯳ᰤ-᰷᳐-᳔᳒-᳨᳭᳴᳷-᳹᷀-᷿⃐-⃰⳯-⵿⳱ⷠ-〪ⷿ-゙゚〯꙯-꙲ꙴ-꙽ꚞꚟ꛰꛱ꠂ꠆ꠋꠣ-ꠧ꠬ꢀꢁꢴ-ꣅ꣠-꣱ꣿꤦ-꤭ꥇ-꥓ꦀ-ꦃ꦳-꧀ꧥꨩ-ꨶꩃꩌꩍꩻ-ꩽꪰꪲ-ꪴꪷꪸꪾ꪿꫁ꫫ-ꫯꫵ꫶ꯣ-ꯪ꯬꯭ﬞ︀-️︠-︯",astral:"\uD800[\uDDFD\uDEE0\uDF76-\uDF7A]|\uD802[\uDE01-\uDE03\uDE05\uDE06\uDE0C-\uDE0F\uDE38-\uDE3A\uDE3F\uDEE5\uDEE6]|\uD803[\uDD24-\uDD27\uDEAB\uDEAC\uDF46-\uDF50\uDF82-\uDF85]|\uD804[\uDC00-\uDC02\uDC38-\uDC46\uDC70\uDC73\uDC74\uDC7F-\uDC82\uDCB0-\uDCBA\uDCC2\uDD00-\uDD02\uDD27-\uDD34\uDD45\uDD46\uDD73\uDD80-\uDD82\uDDB3-\uDDC0\uDDC9-\uDDCC\uDDCE\uDDCF\uDE2C-\uDE37\uDE3E\uDEDF-\uDEEA\uDF00-\uDF03\uDF3B\uDF3C\uDF3E-\uDF44\uDF47\uDF48\uDF4B-\uDF4D\uDF57\uDF62\uDF63\uDF66-\uDF6C\uDF70-\uDF74]|\uD805[\uDC35-\uDC46\uDC5E\uDCB0-\uDCC3\uDDAF-\uDDB5\uDDB8-\uDDC0\uDDDC\uDDDD\uDE30-\uDE40\uDEAB-\uDEB7\uDF1D-\uDF2B]|\uD806[\uDC2C-\uDC3A\uDD30-\uDD35\uDD37\uDD38\uDD3B-\uDD3E\uDD40\uDD42\uDD43\uDDD1-\uDDD7\uDDDA-\uDDE0\uDDE4\uDE01-\uDE0A\uDE33-\uDE39\uDE3B-\uDE3E\uDE47\uDE51-\uDE5B\uDE8A-\uDE99]|\uD807[\uDC2F-\uDC36\uDC38-\uDC3F\uDC92-\uDCA7\uDCA9-\uDCB6\uDD31-\uDD36\uDD3A\uDD3C\uDD3D\uDD3F-\uDD45\uDD47\uDD8A-\uDD8E\uDD90\uDD91\uDD93-\uDD97\uDEF3-\uDEF6]|\uD81A[\uDEF0-\uDEF4\uDF30-\uDF36]|\uD81B[\uDF4F\uDF51-\uDF87\uDF8F-\uDF92\uDFE4\uDFF0\uDFF1]|\uD82F[\uDC9D\uDC9E]|\uD833[\uDF00-\uDF2D\uDF30-\uDF46]|\uD834[\uDD65-\uDD69\uDD6D-\uDD72\uDD7B-\uDD82\uDD85-\uDD8B\uDDAA-\uDDAD\uDE42-\uDE44]|\uD836[\uDE00-\uDE36\uDE3B-\uDE6C\uDE75\uDE84\uDE9B-\uDE9F\uDEA1-\uDEAF]|\uD838[\uDC00-\uDC06\uDC08-\uDC18\uDC1B-\uDC21\uDC23\uDC24\uDC26-\uDC2A\uDD30-\uDD36\uDEAE\uDEEC-\uDEEF]|\uD83A[\uDCD0-\uDCD6\uDD44-\uDD4A]|\uDB40[\uDD00-\uDDEF]"},{name:"Mc",alias:"Spacing_Mark",bmp:"ःऻा-ीॉ-ौॎॏংঃা-ীেৈোৌৗਃਾ-ੀઃા-ીૉોૌଂଃାୀେୈୋୌୗாிுூெ-ைொ-ௌௗఁ-ఃు-ౄಂಃಾೀ-ೄೇೈೊೋೕೖംഃാ-ീെ-ൈൊ-ൌൗංඃා-ෑෘ-ෟෲෳ༾༿ཿါာေးျြၖၗၢ-ၤၧ-ၭႃႄႇ-ႌႏႚ-ႜ᜕᜴ាើ-ៅះៈᤣ-ᤦᤩ-ᤫᤰᤱᤳ-ᤸᨙᨚᩕᩗᩡᩣᩤᩭ-ᩲᬄᬵᬻᬽ-ᭁᭃ᭄ᮂᮡᮦᮧ᮪ᯧᯪ-ᯬᯮ᯲᯳ᰤ-ᰫᰴᰵ᳡᳷〮〯ꠣꠤꠧꢀꢁꢴ-ꣃꥒ꥓ꦃꦴꦵꦺꦻꦾ-꧀ꨯꨰꨳꨴꩍꩻꩽꫫꫮꫯꫵꯣꯤꯦꯧꯩꯪ꯬",astral:"\uD804[\uDC00\uDC02\uDC82\uDCB0-\uDCB2\uDCB7\uDCB8\uDD2C\uDD45\uDD46\uDD82\uDDB3-\uDDB5\uDDBF\uDDC0\uDDCE\uDE2C-\uDE2E\uDE32\uDE33\uDE35\uDEE0-\uDEE2\uDF02\uDF03\uDF3E\uDF3F\uDF41-\uDF44\uDF47\uDF48\uDF4B-\uDF4D\uDF57\uDF62\uDF63]|\uD805[\uDC35-\uDC37\uDC40\uDC41\uDC45\uDCB0-\uDCB2\uDCB9\uDCBB-\uDCBE\uDCC1\uDDAF-\uDDB1\uDDB8-\uDDBB\uDDBE\uDE30-\uDE32\uDE3B\uDE3C\uDE3E\uDEAC\uDEAE\uDEAF\uDEB6\uDF20\uDF21\uDF26]|\uD806[\uDC2C-\uDC2E\uDC38\uDD30-\uDD35\uDD37\uDD38\uDD3D\uDD40\uDD42\uDDD1-\uDDD3\uDDDC-\uDDDF\uDDE4\uDE39\uDE57\uDE58\uDE97]|\uD807[\uDC2F\uDC3E\uDCA9\uDCB1\uDCB4\uDD8A-\uDD8E\uDD93\uDD94\uDD96\uDEF5\uDEF6]|\uD81B[\uDF51-\uDF87\uDFF0\uDFF1]|\uD834[\uDD65\uDD66\uDD6D-\uDD72]"},{name:"Me",alias:"Enclosing_Mark",bmp:"҈҉᪾⃝-⃠⃢-⃤꙰-꙲"},{name:"Mn",alias:"Nonspacing_Mark",bmp:"̀-ͯ҃-֑҇-ׇֽֿׁׂׅׄؐ-ًؚ-ٰٟۖ-ۜ۟-۪ۤۧۨ-ܑۭܰ-݊ަ-ް߫-߽߳ࠖ-࠙ࠛ-ࠣࠥ-ࠧࠩ-࡙࠭-࡛࢘-࢟࣊-ࣣ࣡-ंऺ़ु-ै्॑-ॗॢॣঁ়ু-ৄ্ৢৣ৾ਁਂ਼ੁੂੇੈੋ-੍ੑੰੱੵઁં઼ુ-ૅેૈ્ૢૣૺ-૿ଁ଼ିୁ-ୄ୍୕ୖୢୣஂீ்ఀఄ఼ా-ీె-ైొ-్ౕౖౢౣಁ಼ಿೆೌ್ೢೣഀഁ഻഼ു-ൄ്ൢൣඁ්ි-ුූัิ-ฺ็-๎ັິ-ຼ່-ໍཱ༹༘༙༵༷-ཾྀ-྄྆྇ྍ-ྗྙ-ྼ࿆ိ-ူဲ-့္်ွှၘၙၞ-ၠၱ-ၴႂႅႆႍႝ፝-፟ᜒ-᜔ᜲᜳᝒᝓᝲᝳ឴឵ិ-ួំ៉-៓៝᠋-᠍᠏ᢅᢆᢩᤠ-ᤢᤧᤨᤲ᤹-᤻ᨘᨗᨛᩖᩘ-ᩞ᩠ᩢᩥ-ᩬᩳ-᩿᩼᪰-᪽ᪿ-ᫎᬀ-ᬃ᬴ᬶ-ᬺᬼᭂ᭫-᭳ᮀᮁᮢ-ᮥᮨᮩ᮫-ᮭ᯦ᯨᯩᯭᯯ-ᯱᰬ-ᰳᰶ᰷᳐-᳔᳒-᳢᳠-᳨᳭᳴᳸᳹᷀-᷿⃐-⃥⃜⃡-⃰⳯-⵿⳱ⷠ-〪ⷿ-゙゚〭꙯ꙴ-꙽ꚞꚟ꛰꛱ꠂ꠆ꠋꠥꠦ꠬꣄ꣅ꣠-꣱ꣿꤦ-꤭ꥇ-ꥑꦀ-ꦂ꦳ꦶ-ꦹꦼꦽꧥꨩ-ꨮꨱꨲꨵꨶꩃꩌꩼꪰꪲ-ꪴꪷꪸꪾ꪿꫁ꫬꫭ꫶ꯥꯨ꯭ﬞ︀-️︠-︯",astral:"\uD800[\uDDFD\uDEE0\uDF76-\uDF7A]|\uD802[\uDE01-\uDE03\uDE05\uDE06\uDE0C-\uDE0F\uDE38-\uDE3A\uDE3F\uDEE5\uDEE6]|\uD803[\uDD24-\uDD27\uDEAB\uDEAC\uDF46-\uDF50\uDF82-\uDF85]|\uD804[\uDC01\uDC38-\uDC46\uDC70\uDC73\uDC74\uDC7F-\uDC81\uDCB3-\uDCB6\uDCB9\uDCBA\uDCC2\uDD00-\uDD02\uDD27-\uDD2B\uDD2D-\uDD34\uDD73\uDD80\uDD81\uDDB6-\uDDBE\uDDC9-\uDDCC\uDDCF\uDE2F-\uDE31\uDE34\uDE36\uDE37\uDE3E\uDEDF\uDEE3-\uDEEA\uDF00\uDF01\uDF3B\uDF3C\uDF40\uDF66-\uDF6C\uDF70-\uDF74]|\uD805[\uDC38-\uDC3F\uDC42-\uDC44\uDC46\uDC5E\uDCB3-\uDCB8\uDCBA\uDCBF\uDCC0\uDCC2\uDCC3\uDDB2-\uDDB5\uDDBC\uDDBD\uDDBF\uDDC0\uDDDC\uDDDD\uDE33-\uDE3A\uDE3D\uDE3F\uDE40\uDEAB\uDEAD\uDEB0-\uDEB5\uDEB7\uDF1D-\uDF1F\uDF22-\uDF25\uDF27-\uDF2B]|\uD806[\uDC2F-\uDC37\uDC39\uDC3A\uDD3B\uDD3C\uDD3E\uDD43\uDDD4-\uDDD7\uDDDA\uDDDB\uDDE0\uDE01-\uDE0A\uDE33-\uDE38\uDE3B-\uDE3E\uDE47\uDE51-\uDE56\uDE59-\uDE5B\uDE8A-\uDE96\uDE98\uDE99]|\uD807[\uDC30-\uDC36\uDC38-\uDC3D\uDC3F\uDC92-\uDCA7\uDCAA-\uDCB0\uDCB2\uDCB3\uDCB5\uDCB6\uDD31-\uDD36\uDD3A\uDD3C\uDD3D\uDD3F-\uDD45\uDD47\uDD90\uDD91\uDD95\uDD97\uDEF3\uDEF4]|\uD81A[\uDEF0-\uDEF4\uDF30-\uDF36]|\uD81B[\uDF4F\uDF8F-\uDF92\uDFE4]|\uD82F[\uDC9D\uDC9E]|\uD833[\uDF00-\uDF2D\uDF30-\uDF46]|\uD834[\uDD67-\uDD69\uDD7B-\uDD82\uDD85-\uDD8B\uDDAA-\uDDAD\uDE42-\uDE44]|\uD836[\uDE00-\uDE36\uDE3B-\uDE6C\uDE75\uDE84\uDE9B-\uDE9F\uDEA1-\uDEAF]|\uD838[\uDC00-\uDC06\uDC08-\uDC18\uDC1B-\uDC21\uDC23\uDC24\uDC26-\uDC2A\uDD30-\uDD36\uDEAE\uDEEC-\uDEEF]|\uD83A[\uDCD0-\uDCD6\uDD44-\uDD4A]|\uDB40[\uDD00-\uDDEF]"},{name:"N",alias:"Number",bmp:"0-9²³¹¼-¾٠-٩۰-۹߀-߉०-९০-৯৴-৹੦-੯૦-૯୦-୯୲-୷௦-௲౦-౯౸-౾೦-೯൘-൞൦-൸෦-෯๐-๙໐-໙༠-༳၀-၉႐-႙፩-፼ᛮ-ᛰ០-៩៰-៹᠐-᠙᥆-᥏᧐-᧚᪀-᪉᪐-᪙᭐-᭙᮰-᮹᱀-᱉᱐-᱙⁰⁴-⁹₀-₉⅐-ↂↅ-↉①-⒛⓪-⓿❶-➓⳽〇〡-〩〸-〺㆒-㆕㈠-㈩㉈-㉏㉑-㉟㊀-㊉㊱-㊿꘠-꘩ꛦ-ꛯ꠰-꠵꣐-꣙꤀-꤉꧐-꧙꧰-꧹꩐-꩙꯰-꯹０-９",astral:"\uD800[\uDD07-\uDD33\uDD40-\uDD78\uDD8A\uDD8B\uDEE1-\uDEFB\uDF20-\uDF23\uDF41\uDF4A\uDFD1-\uDFD5]|\uD801[\uDCA0-\uDCA9]|\uD802[\uDC58-\uDC5F\uDC79-\uDC7F\uDCA7-\uDCAF\uDCFB-\uDCFF\uDD16-\uDD1B\uDDBC\uDDBD\uDDC0-\uDDCF\uDDD2-\uDDFF\uDE40-\uDE48\uDE7D\uDE7E\uDE9D-\uDE9F\uDEEB-\uDEEF\uDF58-\uDF5F\uDF78-\uDF7F\uDFA9-\uDFAF]|\uD803[\uDCFA-\uDCFF\uDD30-\uDD39\uDE60-\uDE7E\uDF1D-\uDF26\uDF51-\uDF54\uDFC5-\uDFCB]|\uD804[\uDC52-\uDC6F\uDCF0-\uDCF9\uDD36-\uDD3F\uDDD0-\uDDD9\uDDE1-\uDDF4\uDEF0-\uDEF9]|\uD805[\uDC50-\uDC59\uDCD0-\uDCD9\uDE50-\uDE59\uDEC0-\uDEC9\uDF30-\uDF3B]|\uD806[\uDCE0-\uDCF2\uDD50-\uDD59]|\uD807[\uDC50-\uDC6C\uDD50-\uDD59\uDDA0-\uDDA9\uDFC0-\uDFD4]|\uD809[\uDC00-\uDC6E]|\uD81A[\uDE60-\uDE69\uDEC0-\uDEC9\uDF50-\uDF59\uDF5B-\uDF61]|\uD81B[\uDE80-\uDE96]|\uD834[\uDEE0-\uDEF3\uDF60-\uDF78]|\uD835[\uDFCE-\uDFFF]|\uD838[\uDD40-\uDD49\uDEF0-\uDEF9]|\uD83A[\uDCC7-\uDCCF\uDD50-\uDD59]|\uD83B[\uDC71-\uDCAB\uDCAD-\uDCAF\uDCB1-\uDCB4\uDD01-\uDD2D\uDD2F-\uDD3D]|\uD83C[\uDD00-\uDD0C]|\uD83E[\uDFF0-\uDFF9]"},{name:"Nd",alias:"Decimal_Number",bmp:"0-9٠-٩۰-۹߀-߉०-९০-৯੦-੯૦-૯୦-୯௦-௯౦-౯೦-೯൦-൯෦-෯๐-๙໐-໙༠-༩၀-၉႐-႙០-៩᠐-᠙᥆-᥏᧐-᧙᪀-᪉᪐-᪙᭐-᭙᮰-᮹᱀-᱉᱐-᱙꘠-꘩꣐-꣙꤀-꤉꧐-꧙꧰-꧹꩐-꩙꯰-꯹０-９",astral:"\uD801[\uDCA0-\uDCA9]|\uD803[\uDD30-\uDD39]|\uD804[\uDC66-\uDC6F\uDCF0-\uDCF9\uDD36-\uDD3F\uDDD0-\uDDD9\uDEF0-\uDEF9]|\uD805[\uDC50-\uDC59\uDCD0-\uDCD9\uDE50-\uDE59\uDEC0-\uDEC9\uDF30-\uDF39]|\uD806[\uDCE0-\uDCE9\uDD50-\uDD59]|\uD807[\uDC50-\uDC59\uDD50-\uDD59\uDDA0-\uDDA9]|\uD81A[\uDE60-\uDE69\uDEC0-\uDEC9\uDF50-\uDF59]|\uD835[\uDFCE-\uDFFF]|\uD838[\uDD40-\uDD49\uDEF0-\uDEF9]|\uD83A[\uDD50-\uDD59]|\uD83E[\uDFF0-\uDFF9]"},{name:"Nl",alias:"Letter_Number",bmp:"ᛮ-ᛰⅠ-ↂↅ-ↈ〇〡-〩〸-〺ꛦ-ꛯ",astral:"\uD800[\uDD40-\uDD74\uDF41\uDF4A\uDFD1-\uDFD5]|\uD809[\uDC00-\uDC6E]"},{name:"No",alias:"Other_Number",bmp:"²³¹¼-¾৴-৹୲-୷௰-௲౸-౾൘-൞൰-൸༪-༳፩-፼៰-៹᧚⁰⁴-⁹₀-₉⅐-⅟↉①-⒛⓪-⓿❶-➓⳽㆒-㆕㈠-㈩㉈-㉏㉑-㉟㊀-㊉㊱-㊿꠰-꠵",astral:"\uD800[\uDD07-\uDD33\uDD75-\uDD78\uDD8A\uDD8B\uDEE1-\uDEFB\uDF20-\uDF23]|\uD802[\uDC58-\uDC5F\uDC79-\uDC7F\uDCA7-\uDCAF\uDCFB-\uDCFF\uDD16-\uDD1B\uDDBC\uDDBD\uDDC0-\uDDCF\uDDD2-\uDDFF\uDE40-\uDE48\uDE7D\uDE7E\uDE9D-\uDE9F\uDEEB-\uDEEF\uDF58-\uDF5F\uDF78-\uDF7F\uDFA9-\uDFAF]|\uD803[\uDCFA-\uDCFF\uDE60-\uDE7E\uDF1D-\uDF26\uDF51-\uDF54\uDFC5-\uDFCB]|\uD804[\uDC52-\uDC65\uDDE1-\uDDF4]|\uD805[\uDF3A\uDF3B]|\uD806[\uDCEA-\uDCF2]|\uD807[\uDC5A-\uDC6C\uDFC0-\uDFD4]|\uD81A[\uDF5B-\uDF61]|\uD81B[\uDE80-\uDE96]|\uD834[\uDEE0-\uDEF3\uDF60-\uDF78]|\uD83A[\uDCC7-\uDCCF]|\uD83B[\uDC71-\uDCAB\uDCAD-\uDCAF\uDCB1-\uDCB4\uDD01-\uDD2D\uDD2F-\uDD3D]|\uD83C[\uDD00-\uDD0C]"},{name:"P",alias:"Punctuation",bmp:"!-#%-\\*,-\\/:;\\?@\\[-\\]_\\{\\}¡§«¶·»¿;·՚-՟։֊־׀׃׆׳״؉؊،؍؛؝-؟٪-٭۔܀-܍߷-߹࠰-࠾࡞।॥॰৽੶૰౷಄෴๏๚๛༄-༒༔༺-༽྅࿐-࿔࿙࿚၊-၏჻፠-፨᐀᙮᚛᚜᛫-᛭᜵᜶។-៖៘-៚᠀-᠊᥄᥅᨞᨟᪠-᪦᪨-᪭᭚-᭠᭽᭾᯼-᯿᰻-᰿᱾᱿᳀-᳇᳓‐-‧‰-⁃⁅-⁑⁓-⁞⁽⁾₍₎⌈-⌋〈〉❨-❵⟅⟆⟦-⟯⦃-⦘⧘-⧛⧼⧽⳹-⳼⳾⳿⵰⸀-⸮⸰-⹏⹒-⹝、-〃〈-】〔-〟〰〽゠・꓾꓿꘍-꘏꙳꙾꛲-꛷꡴-꡷꣎꣏꣸-꣺꣼꤮꤯꥟꧁-꧍꧞꧟꩜-꩟꫞꫟꫰꫱꯫﴾﴿︐-︙︰-﹒﹔-﹡﹣﹨﹪﹫！-＃％-＊，-／：；？＠［-］＿｛｝｟-･",astral:"\uD800[\uDD00-\uDD02\uDF9F\uDFD0]|𐕯|\uD802[\uDC57\uDD1F\uDD3F\uDE50-\uDE58\uDE7F\uDEF0-\uDEF6\uDF39-\uDF3F\uDF99-\uDF9C]|\uD803[\uDEAD\uDF55-\uDF59\uDF86-\uDF89]|\uD804[\uDC47-\uDC4D\uDCBB\uDCBC\uDCBE-\uDCC1\uDD40-\uDD43\uDD74\uDD75\uDDC5-\uDDC8\uDDCD\uDDDB\uDDDD-\uDDDF\uDE38-\uDE3D\uDEA9]|\uD805[\uDC4B-\uDC4F\uDC5A\uDC5B\uDC5D\uDCC6\uDDC1-\uDDD7\uDE41-\uDE43\uDE60-\uDE6C\uDEB9\uDF3C-\uDF3E]|\uD806[\uDC3B\uDD44-\uDD46\uDDE2\uDE3F-\uDE46\uDE9A-\uDE9C\uDE9E-\uDEA2]|\uD807[\uDC41-\uDC45\uDC70\uDC71\uDEF7\uDEF8\uDFFF]|\uD809[\uDC70-\uDC74]|\uD80B[\uDFF1\uDFF2]|\uD81A[\uDE6E\uDE6F\uDEF5\uDF37-\uDF3B\uDF44]|\uD81B[\uDE97-\uDE9A\uDFE2]|𛲟|\uD836[\uDE87-\uDE8B]|\uD83A[\uDD5E\uDD5F]"},{name:"Pc",alias:"Connector_Punctuation",bmp:"_‿⁀⁔︳︴﹍-﹏＿"},{name:"Pd",alias:"Dash_Punctuation",bmp:"\\-֊־᐀᠆‐-―⸗⸚⸺⸻⹀⹝〜〰゠︱︲﹘﹣－",astral:"𐺭"},{name:"Pe",alias:"Close_Punctuation",bmp:"\\)\\]\\}༻༽᚜⁆⁾₎⌉⌋〉❩❫❭❯❱❳❵⟆⟧⟩⟫⟭⟯⦄⦆⦈⦊⦌⦎⦐⦒⦔⦖⦘⧙⧛⧽⸣⸥⸧⸩⹖⹘⹚⹜〉》」』】〕〗〙〛〞〟﴾︘︶︸︺︼︾﹀﹂﹄﹈﹚﹜﹞）］｝｠｣"},{name:"Pf",alias:"Final_Punctuation",bmp:"»’”›⸃⸅⸊⸍⸝⸡"},{name:"Pi",alias:"Initial_Punctuation",bmp:"«‘‛“‟‹⸂⸄⸉⸌⸜⸠"},{name:"Po",alias:"Other_Punctuation",bmp:"!-#%-'\\*,\\.\\/:;\\?@\\¡§¶·¿;·՚-՟։׀׃׆׳״؉؊،؍؛؝-؟٪-٭۔܀-܍߷-߹࠰-࠾࡞।॥॰৽੶૰౷಄෴๏๚๛༄-༒༔྅࿐-࿔࿙࿚၊-၏჻፠-፨᙮᛫-᛭᜵᜶។-៖៘-៚᠀-᠅᠇-᠊᥄᥅᨞᨟᪠-᪦᪨-᪭᭚-᭠᭽᭾᯼-᯿᰻-᰿᱾᱿᳀-᳇᳓‖‗†-‧‰-‸※-‾⁁-⁃⁇-⁑⁓⁕-⁞⳹-⳼⳾⳿⵰⸀⸁⸆-⸈⸋⸎-⸖⸘⸙⸛⸞⸟⸪-⸮⸰-⸹⸼-⸿⹁⹃-⹏⹒-⹔、-〃〽・꓾꓿꘍-꘏꙳꙾꛲-꛷꡴-꡷꣎꣏꣸-꣺꣼꤮꤯꥟꧁-꧍꧞꧟꩜-꩟꫞꫟꫰꫱꯫︐-︖︙︰﹅﹆﹉-﹌﹐-﹒﹔-﹗﹟-﹡﹨﹪﹫！-＃％-＇＊，．／：；？＠＼｡､･",astral:"\uD800[\uDD00-\uDD02\uDF9F\uDFD0]|𐕯|\uD802[\uDC57\uDD1F\uDD3F\uDE50-\uDE58\uDE7F\uDEF0-\uDEF6\uDF39-\uDF3F\uDF99-\uDF9C]|\uD803[\uDF55-\uDF59\uDF86-\uDF89]|\uD804[\uDC47-\uDC4D\uDCBB\uDCBC\uDCBE-\uDCC1\uDD40-\uDD43\uDD74\uDD75\uDDC5-\uDDC8\uDDCD\uDDDB\uDDDD-\uDDDF\uDE38-\uDE3D\uDEA9]|\uD805[\uDC4B-\uDC4F\uDC5A\uDC5B\uDC5D\uDCC6\uDDC1-\uDDD7\uDE41-\uDE43\uDE60-\uDE6C\uDEB9\uDF3C-\uDF3E]|\uD806[\uDC3B\uDD44-\uDD46\uDDE2\uDE3F-\uDE46\uDE9A-\uDE9C\uDE9E-\uDEA2]|\uD807[\uDC41-\uDC45\uDC70\uDC71\uDEF7\uDEF8\uDFFF]|\uD809[\uDC70-\uDC74]|\uD80B[\uDFF1\uDFF2]|\uD81A[\uDE6E\uDE6F\uDEF5\uDF37-\uDF3B\uDF44]|\uD81B[\uDE97-\uDE9A\uDFE2]|𛲟|\uD836[\uDE87-\uDE8B]|\uD83A[\uDD5E\uDD5F]"},{name:"Ps",alias:"Open_Punctuation",bmp:"\\(\\[\\{༺༼᚛‚„⁅⁽₍⌈⌊〈❨❪❬❮❰❲❴⟅⟦⟨⟪⟬⟮⦃⦅⦇⦉⦋⦍⦏⦑⦓⦕⦗⧘⧚⧼⸢⸤⸦⸨⹂⹕⹗⹙⹛〈《「『【〔〖〘〚〝﴿︗︵︷︹︻︽︿﹁﹃﹇﹙﹛﹝（［｛｟｢"},{name:"S",alias:"Symbol",bmp:"\\$\\+<->\\^`\\|~¢-¦¨©¬®-±´¸×÷˂-˅˒-˟˥-˫˭˯-˿͵΄΅϶҂֍-֏؆-؈؋؎؏۞۩۽۾߶߾߿࢈৲৳৺৻૱୰௳-௺౿൏൹฿༁-༃༓༕-༗༚-༟༴༶༸྾-࿅࿇-࿌࿎࿏࿕-࿘႞႟᎐-᎙᙭៛᥀᧞-᧿᭡-᭪᭴-᭼᾽᾿-῁῍-῏῝-῟῭-`´῾⁄⁒⁺-⁼₊-₌₠-⃀℀℁℃-℆℈℉℔№-℘℞-℣℥℧℩℮℺℻⅀-⅄⅊-⅍⅏↊↋←-⌇⌌-⌨⌫-␦⑀-⑊⒜-ⓩ─-❧➔-⟄⟇-⟥⟰-⦂⦙-⧗⧜-⧻⧾-⭳⭶-⮕⮗-⯿⳥-⳪⹐⹑⺀-⺙⺛-⻳⼀-⿕⿰-⿻〄〒〓〠〶〷〾〿゛゜㆐㆑㆖-㆟㇀-㇣㈀-㈞㈪-㉇㉐㉠-㉿㊊-㊰㋀-㏿䷀-䷿꒐-꓆꜀-꜖꜠꜡꞉꞊꠨-꠫꠶-꠹꩷-꩹꭛꭪꭫﬩﮲-﯂﵀-﵏﷏﷼-﷿﹢﹤-﹦﹩＄＋＜-＞＾｀｜～￠-￦￨-￮￼�",astral:"\uD800[\uDD37-\uDD3F\uDD79-\uDD89\uDD8C-\uDD8E\uDD90-\uDD9C\uDDA0\uDDD0-\uDDFC]|\uD802[\uDC77\uDC78\uDEC8]|𑜿|\uD807[\uDFD5-\uDFF1]|\uD81A[\uDF3C-\uDF3F\uDF45]|𛲜|\uD833[\uDF50-\uDFC3]|\uD834[\uDC00-\uDCF5\uDD00-\uDD26\uDD29-\uDD64\uDD6A-\uDD6C\uDD83\uDD84\uDD8C-\uDDA9\uDDAE-\uDDEA\uDE00-\uDE41\uDE45\uDF00-\uDF56]|\uD835[\uDEC1\uDEDB\uDEFB\uDF15\uDF35\uDF4F\uDF6F\uDF89\uDFA9\uDFC3]|\uD836[\uDC00-\uDDFF\uDE37-\uDE3A\uDE6D-\uDE74\uDE76-\uDE83\uDE85\uDE86]|\uD838[\uDD4F\uDEFF]|\uD83B[\uDCAC\uDCB0\uDD2E\uDEF0\uDEF1]|\uD83C[\uDC00-\uDC2B\uDC30-\uDC93\uDCA0-\uDCAE\uDCB1-\uDCBF\uDCC1-\uDCCF\uDCD1-\uDCF5\uDD0D-\uDDAD\uDDE6-\uDE02\uDE10-\uDE3B\uDE40-\uDE48\uDE50\uDE51\uDE60-\uDE65\uDF00-\uDFFF]|\uD83D[\uDC00-\uDED7\uDEDD-\uDEEC\uDEF0-\uDEFC\uDF00-\uDF73\uDF80-\uDFD8\uDFE0-\uDFEB\uDFF0]|\uD83E[\uDC00-\uDC0B\uDC10-\uDC47\uDC50-\uDC59\uDC60-\uDC87\uDC90-\uDCAD\uDCB0\uDCB1\uDD00-\uDE53\uDE60-\uDE6D\uDE70-\uDE74\uDE78-\uDE7C\uDE80-\uDE86\uDE90-\uDEAC\uDEB0-\uDEBA\uDEC0-\uDEC5\uDED0-\uDED9\uDEE0-\uDEE7\uDEF0-\uDEF6\uDF00-\uDF92\uDF94-\uDFCA]"},{name:"Sc",alias:"Currency_Symbol",bmp:"\\$¢-¥֏؋߾߿৲৳৻૱௹฿៛₠-⃀꠸﷼﹩＄￠￡￥￦",astral:"\uD807[\uDFDD-\uDFE0]|𞋿|𞲰"},{name:"Sk",alias:"Modifier_Symbol",bmp:"\\^`¨¯´¸˂-˅˒-˟˥-˫˭˯-˿͵΄΅࢈᾽᾿-῁῍-῏῝-῟῭-`´῾゛゜꜀-꜖꜠꜡꞉꞊꭛꭪꭫﮲-﯂＾｀￣",astral:"\uD83C[\uDFFB-\uDFFF]"},{name:"Sm",alias:"Math_Symbol",bmp:"\\+<->\\|~¬±×÷϶؆-؈⁄⁒⁺-⁼₊-₌℘⅀-⅄⅋←-↔↚↛↠↣↦↮⇎⇏⇒⇔⇴-⋿⌠⌡⍼⎛-⎳⏜-⏡▷◁◸-◿♯⟀-⟄⟇-⟥⟰-⟿⤀-⦂⦙-⧗⧜-⧻⧾-⫿⬰-⭄⭇-⭌﬩﹢﹤-﹦＋＜-＞｜～￢￩-￬",astral:"\uD835[\uDEC1\uDEDB\uDEFB\uDF15\uDF35\uDF4F\uDF6F\uDF89\uDFA9\uDFC3]|\uD83B[\uDEF0\uDEF1]"},{name:"So",alias:"Other_Symbol",bmp:"¦©®°҂֍֎؎؏۞۩۽۾߶৺୰௳-௸௺౿൏൹༁-༃༓༕-༗༚-༟༴༶༸྾-࿅࿇-࿌࿎࿏࿕-࿘႞႟᎐-᎙᙭᥀᧞-᧿᭡-᭪᭴-᭼℀℁℃-℆℈℉℔№℗℞-℣℥℧℩℮℺℻⅊⅌⅍⅏↊↋↕-↙↜-↟↡↢↤↥↧-↭↯-⇍⇐⇑⇓⇕-⇳⌀-⌇⌌-⌟⌢-⌨⌫-⍻⍽-⎚⎴-⏛⏢-␦⑀-⑊⒜-ⓩ─-▶▸-◀◂-◷☀-♮♰-❧➔-➿⠀-⣿⬀-⬯⭅⭆⭍-⭳⭶-⮕⮗-⯿⳥-⳪⹐⹑⺀-⺙⺛-⻳⼀-⿕⿰-⿻〄〒〓〠〶〷〾〿㆐㆑㆖-㆟㇀-㇣㈀-㈞㈪-㉇㉐㉠-㉿㊊-㊰㋀-㏿䷀-䷿꒐-꓆꠨-꠫꠶꠷꠹꩷-꩹﵀-﵏﷏﷽-﷿￤￨￭￮￼�",astral:"\uD800[\uDD37-\uDD3F\uDD79-\uDD89\uDD8C-\uDD8E\uDD90-\uDD9C\uDDA0\uDDD0-\uDDFC]|\uD802[\uDC77\uDC78\uDEC8]|𑜿|\uD807[\uDFD5-\uDFDC\uDFE1-\uDFF1]|\uD81A[\uDF3C-\uDF3F\uDF45]|𛲜|\uD833[\uDF50-\uDFC3]|\uD834[\uDC00-\uDCF5\uDD00-\uDD26\uDD29-\uDD64\uDD6A-\uDD6C\uDD83\uDD84\uDD8C-\uDDA9\uDDAE-\uDDEA\uDE00-\uDE41\uDE45\uDF00-\uDF56]|\uD836[\uDC00-\uDDFF\uDE37-\uDE3A\uDE6D-\uDE74\uDE76-\uDE83\uDE85\uDE86]|𞅏|\uD83B[\uDCAC\uDD2E]|\uD83C[\uDC00-\uDC2B\uDC30-\uDC93\uDCA0-\uDCAE\uDCB1-\uDCBF\uDCC1-\uDCCF\uDCD1-\uDCF5\uDD0D-\uDDAD\uDDE6-\uDE02\uDE10-\uDE3B\uDE40-\uDE48\uDE50\uDE51\uDE60-\uDE65\uDF00-\uDFFA]|\uD83D[\uDC00-\uDED7\uDEDD-\uDEEC\uDEF0-\uDEFC\uDF00-\uDF73\uDF80-\uDFD8\uDFE0-\uDFEB\uDFF0]|\uD83E[\uDC00-\uDC0B\uDC10-\uDC47\uDC50-\uDC59\uDC60-\uDC87\uDC90-\uDCAD\uDCB0\uDCB1\uDD00-\uDE53\uDE60-\uDE6D\uDE70-\uDE74\uDE78-\uDE7C\uDE80-\uDE86\uDE90-\uDEAC\uDEB0-\uDEBA\uDEC0-\uDEC5\uDED0-\uDED9\uDEE0-\uDEE7\uDEF0-\uDEF6\uDF00-\uDF92\uDF94-\uDFCA]"},{name:"Z",alias:"Separator",bmp:"    - \u2028\u2029  　"},{name:"Zl",alias:"Line_Separator",bmp:"\u2028"},{name:"Zp",alias:"Paragraph_Separator",bmp:"\u2029"},{name:"Zs",alias:"Space_Separator",bmp:"    -   　"}];const Mh=On(qh);/*!
 * XRegExp Unicode Categories 5.1.1
 * <xregexp.com>
 * Steven Levithan (c) 2010-present MIT License
 * Unicode data by Mathias Bynens <mathiasbynens.be>
 */const Lh=t=>{if(!t.addUnicodeData)throw new ReferenceError("Unicode Base must be loaded before Unicode Categories");t.addUnicodeData(Mh)};var jh=[{name:"ASCII",bmp:"\0-"},{name:"Alphabetic",bmp:"A-Za-zªµºÀ-ÖØ-öø-ˁˆ-ˑˠ-ˤˬˮͅͰ-ʹͶͷͺ-ͽͿΆΈ-ΊΌΎ-ΡΣ-ϵϷ-ҁҊ-ԯԱ-Ֆՙՠ-ֈְ-ׇֽֿׁׂׅׄא-תׯ-ײؐ-ؚؠ-ٗٙ-ٟٮ-ۓە-ۜۡ-ۭۨ-ۯۺ-ۼۿܐ-ܿݍ-ޱߊ-ߪߴߵߺࠀ-ࠗࠚ-ࠬࡀ-ࡘࡠ-ࡪࡰ-ࢇࢉ-ࢎࢠ-ࣉࣔ-ࣣࣟ-ࣰࣩ-ऻऽ-ौॎ-ॐॕ-ॣॱ-ঃঅ-ঌএঐও-নপ-রলশ-হঽ-ৄেৈোৌৎৗড়ঢ়য়-ৣৰৱৼਁ-ਃਅ-ਊਏਐਓ-ਨਪ-ਰਲਲ਼ਵਸ਼ਸਹਾ-ੂੇੈੋੌੑਖ਼-ੜਫ਼ੰ-ੵઁ-ઃઅ-ઍએ-ઑઓ-નપ-રલળવ-હઽ-ૅે-ૉોૌૐૠ-ૣૹ-ૼଁ-ଃଅ-ଌଏଐଓ-ନପ-ରଲଳଵ-ହଽ-ୄେୈୋୌୖୗଡ଼ଢ଼ୟ-ୣୱஂஃஅ-ஊஎ-ஐஒ-கஙசஜஞடணதந-பம-ஹா-ூெ-ைொ-ௌௐௗఀ-ఃఅ-ఌఎ-ఐఒ-నప-హఽ-ౄె-ైొ-ౌౕౖౘ-ౚౝౠ-ౣಀ-ಃಅ-ಌಎ-ಐಒ-ನಪ-ಳವ-ಹಽ-ೄೆ-ೈೊ-ೌೕೖೝೞೠ-ೣೱೲഀ-ഌഎ-ഐഒ-ഺഽ-ൄെ-ൈൊ-ൌൎൔ-ൗൟ-ൣൺ-ൿඁ-ඃඅ-ඖක-නඳ-රලව-ෆා-ුූෘ-ෟෲෳก-ฺเ-ๆํກຂຄຆ-ຊຌ-ຣລວ-ູົ-ຽເ-ໄໆໍໜ-ໟༀཀ-ཇཉ-ཬཱ-ཱྀྈ-ྗྙ-ྼက-ံးျ-ဿၐ-ႏႚ-ႝႠ-ჅჇჍა-ჺჼ-ቈቊ-ቍቐ-ቖቘቚ-ቝበ-ኈኊ-ኍነ-ኰኲ-ኵኸ-ኾዀዂ-ዅወ-ዖዘ-ጐጒ-ጕጘ-ፚᎀ-ᎏᎠ-Ᏽᏸ-ᏽᐁ-ᙬᙯ-ᙿᚁ-ᚚᚠ-ᛪᛮ-ᛸᜀ-ᜓᜟ-ᜳᝀ-ᝓᝠ-ᝬᝮ-ᝰᝲᝳក-ឳា-ៈៗៜᠠ-ᡸᢀ-ᢪᢰ-ᣵᤀ-ᤞᤠ-ᤫᤰ-ᤸᥐ-ᥭᥰ-ᥴᦀ-ᦫᦰ-ᧉᨀ-ᨛᨠ-ᩞᩡ-ᩴᪧᪿᫀᫌ-ᫎᬀ-ᬳᬵ-ᭃᭅ-ᭌᮀ-ᮩᮬ-ᮯᮺ-ᯥᯧ-ᯱᰀ-ᰶᱍ-ᱏᱚ-ᱽᲀ-ᲈᲐ-ᲺᲽ-Ჿᳩ-ᳬᳮ-ᳳᳵᳶᳺᴀ-ᶿᷧ-ᷴḀ-ἕἘ-Ἕἠ-ὅὈ-Ὅὐ-ὗὙὛὝὟ-ώᾀ-ᾴᾶ-ᾼιῂ-ῄῆ-ῌῐ-ΐῖ-Ίῠ-Ῥῲ-ῴῶ-ῼⁱⁿₐ-ₜℂℇℊ-ℓℕℙ-ℝℤΩℨK-ℭℯ-ℹℼ-ℿⅅ-ⅉⅎⅠ-ↈⒶ-ⓩⰀ-ⳤⳫ-ⳮⳲⳳⴀ-ⴥⴧⴭⴰ-ⵧⵯⶀ-ⶖⶠ-ⶦⶨ-ⶮⶰ-ⶶⶸ-ⶾⷀ-ⷆⷈ-ⷎⷐ-ⷖⷘ-ⷞⷠ-ⷿⸯ々-〇〡-〩〱-〵〸-〼ぁ-ゖゝ-ゟァ-ヺー-ヿㄅ-ㄯㄱ-ㆎㆠ-ㆿㇰ-ㇿ㐀-䶿一-ꒌꓐ-ꓽꔀ-ꘌꘐ-ꘟꘪꘫꙀ-ꙮꙴ-ꙻꙿ-ꛯꜗ-ꜟꜢ-ꞈꞋ-ꟊꟐꟑꟓꟕ-ꟙꟲ-ꠅꠇ-ꠧꡀ-ꡳꢀ-ꣃꣅꣲ-ꣷꣻꣽ-ꣿꤊ-ꤪꤰ-ꥒꥠ-ꥼꦀ-ꦲꦴ-ꦿꧏꧠ-ꧯꧺ-ꧾꨀ-ꨶꩀ-ꩍꩠ-ꩶꩺ-ꪾꫀꫂꫛ-ꫝꫠ-ꫯꫲ-ꫵꬁ-ꬆꬉ-ꬎꬑ-ꬖꬠ-ꬦꬨ-ꬮꬰ-ꭚꭜ-ꭩꭰ-ꯪ가-힣ힰ-ퟆퟋ-ퟻ豈-舘並-龎ﬀ-ﬆﬓ-ﬗיִ-ﬨשׁ-זּטּ-לּמּנּסּףּפּצּ-ﮱﯓ-ﴽﵐ-ﶏﶒ-ﷇﷰ-ﷻﹰ-ﹴﹶ-ﻼＡ-Ｚａ-ｚｦ-ﾾￂ-ￇￊ-ￏￒ-ￗￚ-ￜ",astral:"\uD800[\uDC00-\uDC0B\uDC0D-\uDC26\uDC28-\uDC3A\uDC3C\uDC3D\uDC3F-\uDC4D\uDC50-\uDC5D\uDC80-\uDCFA\uDD40-\uDD74\uDE80-\uDE9C\uDEA0-\uDED0\uDF00-\uDF1F\uDF2D-\uDF4A\uDF50-\uDF7A\uDF80-\uDF9D\uDFA0-\uDFC3\uDFC8-\uDFCF\uDFD1-\uDFD5]|\uD801[\uDC00-\uDC9D\uDCB0-\uDCD3\uDCD8-\uDCFB\uDD00-\uDD27\uDD30-\uDD63\uDD70-\uDD7A\uDD7C-\uDD8A\uDD8C-\uDD92\uDD94\uDD95\uDD97-\uDDA1\uDDA3-\uDDB1\uDDB3-\uDDB9\uDDBB\uDDBC\uDE00-\uDF36\uDF40-\uDF55\uDF60-\uDF67\uDF80-\uDF85\uDF87-\uDFB0\uDFB2-\uDFBA]|\uD802[\uDC00-\uDC05\uDC08\uDC0A-\uDC35\uDC37\uDC38\uDC3C\uDC3F-\uDC55\uDC60-\uDC76\uDC80-\uDC9E\uDCE0-\uDCF2\uDCF4\uDCF5\uDD00-\uDD15\uDD20-\uDD39\uDD80-\uDDB7\uDDBE\uDDBF\uDE00-\uDE03\uDE05\uDE06\uDE0C-\uDE13\uDE15-\uDE17\uDE19-\uDE35\uDE60-\uDE7C\uDE80-\uDE9C\uDEC0-\uDEC7\uDEC9-\uDEE4\uDF00-\uDF35\uDF40-\uDF55\uDF60-\uDF72\uDF80-\uDF91]|\uD803[\uDC00-\uDC48\uDC80-\uDCB2\uDCC0-\uDCF2\uDD00-\uDD27\uDE80-\uDEA9\uDEAB\uDEAC\uDEB0\uDEB1\uDF00-\uDF1C\uDF27\uDF30-\uDF45\uDF70-\uDF81\uDFB0-\uDFC4\uDFE0-\uDFF6]|\uD804[\uDC00-\uDC45\uDC71-\uDC75\uDC82-\uDCB8\uDCC2\uDCD0-\uDCE8\uDD00-\uDD32\uDD44-\uDD47\uDD50-\uDD72\uDD76\uDD80-\uDDBF\uDDC1-\uDDC4\uDDCE\uDDCF\uDDDA\uDDDC\uDE00-\uDE11\uDE13-\uDE34\uDE37\uDE3E\uDE80-\uDE86\uDE88\uDE8A-\uDE8D\uDE8F-\uDE9D\uDE9F-\uDEA8\uDEB0-\uDEE8\uDF00-\uDF03\uDF05-\uDF0C\uDF0F\uDF10\uDF13-\uDF28\uDF2A-\uDF30\uDF32\uDF33\uDF35-\uDF39\uDF3D-\uDF44\uDF47\uDF48\uDF4B\uDF4C\uDF50\uDF57\uDF5D-\uDF63]|\uD805[\uDC00-\uDC41\uDC43-\uDC45\uDC47-\uDC4A\uDC5F-\uDC61\uDC80-\uDCC1\uDCC4\uDCC5\uDCC7\uDD80-\uDDB5\uDDB8-\uDDBE\uDDD8-\uDDDD\uDE00-\uDE3E\uDE40\uDE44\uDE80-\uDEB5\uDEB8\uDF00-\uDF1A\uDF1D-\uDF2A\uDF40-\uDF46]|\uD806[\uDC00-\uDC38\uDCA0-\uDCDF\uDCFF-\uDD06\uDD09\uDD0C-\uDD13\uDD15\uDD16\uDD18-\uDD35\uDD37\uDD38\uDD3B\uDD3C\uDD3F-\uDD42\uDDA0-\uDDA7\uDDAA-\uDDD7\uDDDA-\uDDDF\uDDE1\uDDE3\uDDE4\uDE00-\uDE32\uDE35-\uDE3E\uDE50-\uDE97\uDE9D\uDEB0-\uDEF8]|\uD807[\uDC00-\uDC08\uDC0A-\uDC36\uDC38-\uDC3E\uDC40\uDC72-\uDC8F\uDC92-\uDCA7\uDCA9-\uDCB6\uDD00-\uDD06\uDD08\uDD09\uDD0B-\uDD36\uDD3A\uDD3C\uDD3D\uDD3F-\uDD41\uDD43\uDD46\uDD47\uDD60-\uDD65\uDD67\uDD68\uDD6A-\uDD8E\uDD90\uDD91\uDD93-\uDD96\uDD98\uDEE0-\uDEF6\uDFB0]|\uD808[\uDC00-\uDF99]|\uD809[\uDC00-\uDC6E\uDC80-\uDD43]|\uD80B[\uDF90-\uDFF0]|[\uD80C\uD81C-\uD820\uD822\uD840-\uD868\uD86A-\uD86C\uD86F-\uD872\uD874-\uD879\uD880-\uD883][\uDC00-\uDFFF]|\uD80D[\uDC00-\uDC2E]|\uD811[\uDC00-\uDE46]|\uD81A[\uDC00-\uDE38\uDE40-\uDE5E\uDE70-\uDEBE\uDED0-\uDEED\uDF00-\uDF2F\uDF40-\uDF43\uDF63-\uDF77\uDF7D-\uDF8F]|\uD81B[\uDE40-\uDE7F\uDF00-\uDF4A\uDF4F-\uDF87\uDF8F-\uDF9F\uDFE0\uDFE1\uDFE3\uDFF0\uDFF1]|\uD821[\uDC00-\uDFF7]|\uD823[\uDC00-\uDCD5\uDD00-\uDD08]|\uD82B[\uDFF0-\uDFF3\uDFF5-\uDFFB\uDFFD\uDFFE]|\uD82C[\uDC00-\uDD22\uDD50-\uDD52\uDD64-\uDD67\uDD70-\uDEFB]|\uD82F[\uDC00-\uDC6A\uDC70-\uDC7C\uDC80-\uDC88\uDC90-\uDC99\uDC9E]|\uD835[\uDC00-\uDC54\uDC56-\uDC9C\uDC9E\uDC9F\uDCA2\uDCA5\uDCA6\uDCA9-\uDCAC\uDCAE-\uDCB9\uDCBB\uDCBD-\uDCC3\uDCC5-\uDD05\uDD07-\uDD0A\uDD0D-\uDD14\uDD16-\uDD1C\uDD1E-\uDD39\uDD3B-\uDD3E\uDD40-\uDD44\uDD46\uDD4A-\uDD50\uDD52-\uDEA5\uDEA8-\uDEC0\uDEC2-\uDEDA\uDEDC-\uDEFA\uDEFC-\uDF14\uDF16-\uDF34\uDF36-\uDF4E\uDF50-\uDF6E\uDF70-\uDF88\uDF8A-\uDFA8\uDFAA-\uDFC2\uDFC4-\uDFCB]|\uD837[\uDF00-\uDF1E]|\uD838[\uDC00-\uDC06\uDC08-\uDC18\uDC1B-\uDC21\uDC23\uDC24\uDC26-\uDC2A\uDD00-\uDD2C\uDD37-\uDD3D\uDD4E\uDE90-\uDEAD\uDEC0-\uDEEB]|\uD839[\uDFE0-\uDFE6\uDFE8-\uDFEB\uDFED\uDFEE\uDFF0-\uDFFE]|\uD83A[\uDC00-\uDCC4\uDD00-\uDD43\uDD47\uDD4B]|\uD83B[\uDE00-\uDE03\uDE05-\uDE1F\uDE21\uDE22\uDE24\uDE27\uDE29-\uDE32\uDE34-\uDE37\uDE39\uDE3B\uDE42\uDE47\uDE49\uDE4B\uDE4D-\uDE4F\uDE51\uDE52\uDE54\uDE57\uDE59\uDE5B\uDE5D\uDE5F\uDE61\uDE62\uDE64\uDE67-\uDE6A\uDE6C-\uDE72\uDE74-\uDE77\uDE79-\uDE7C\uDE7E\uDE80-\uDE89\uDE8B-\uDE9B\uDEA1-\uDEA3\uDEA5-\uDEA9\uDEAB-\uDEBB]|\uD83C[\uDD30-\uDD49\uDD50-\uDD69\uDD70-\uDD89]|\uD869[\uDC00-\uDEDF\uDF00-\uDFFF]|\uD86D[\uDC00-\uDF38\uDF40-\uDFFF]|\uD86E[\uDC00-\uDC1D\uDC20-\uDFFF]|\uD873[\uDC00-\uDEA1\uDEB0-\uDFFF]|\uD87A[\uDC00-\uDFE0]|\uD87E[\uDC00-\uDE1D]|\uD884[\uDC00-\uDF4A]"},{name:"Any",isBmpLast:!0,bmp:"\0-￿",astral:"[\uD800-\uDBFF][\uDC00-\uDFFF]"},{name:"Default_Ignorable_Code_Point",bmp:"­͏؜ᅟᅠ឴឵᠋-᠏​-‏‪-‮⁠-⁯ㅤ︀-️\uFEFFﾠ￰-￸",astral:"\uD82F[\uDCA0-\uDCA3]|\uD834[\uDD73-\uDD7A]|[\uDB40-\uDB43][\uDC00-\uDFFF]"},{name:"Lowercase",bmp:"a-zªµºß-öø-ÿāăąćĉċčďđēĕėęěĝğġģĥħĩīĭįıĳĵķĸĺļľŀłńņňŉŋōŏőœŕŗřśŝşšţťŧũūŭůűųŵŷźżž-ƀƃƅƈƌƍƒƕƙ-ƛƞơƣƥƨƪƫƭưƴƶƹƺƽ-ƿǆǉǌǎǐǒǔǖǘǚǜǝǟǡǣǥǧǩǫǭǯǰǳǵǹǻǽǿȁȃȅȇȉȋȍȏȑȓȕȗșțȝȟȡȣȥȧȩȫȭȯȱȳ-ȹȼȿɀɂɇɉɋɍɏ-ʓʕ-ʸˀˁˠ-ˤͅͱͳͷͺ-ͽΐά-ώϐϑϕ-ϗϙϛϝϟϡϣϥϧϩϫϭϯ-ϳϵϸϻϼа-џѡѣѥѧѩѫѭѯѱѳѵѷѹѻѽѿҁҋҍҏґғҕҗҙқҝҟҡңҥҧҩҫҭүұҳҵҷҹһҽҿӂӄӆӈӊӌӎӏӑӓӕӗәӛӝӟӡӣӥӧөӫӭӯӱӳӵӷӹӻӽӿԁԃԅԇԉԋԍԏԑԓԕԗԙԛԝԟԡԣԥԧԩԫԭԯՠ-ֈა-ჺჽ-ჿᏸ-ᏽᲀ-ᲈᴀ-ᶿḁḃḅḇḉḋḍḏḑḓḕḗḙḛḝḟḡḣḥḧḩḫḭḯḱḳḵḷḹḻḽḿṁṃṅṇṉṋṍṏṑṓṕṗṙṛṝṟṡṣṥṧṩṫṭṯṱṳṵṷṹṻṽṿẁẃẅẇẉẋẍẏẑẓẕ-ẝẟạảấầẩẫậắằẳẵặẹẻẽếềểễệỉịọỏốồổỗộớờởỡợụủứừửữựỳỵỷỹỻỽỿ-ἇἐ-ἕἠ-ἧἰ-ἷὀ-ὅὐ-ὗὠ-ὧὰ-ώᾀ-ᾇᾐ-ᾗᾠ-ᾧᾰ-ᾴᾶᾷιῂ-ῄῆῇῐ-ΐῖῗῠ-ῧῲ-ῴῶῷⁱⁿₐ-ₜℊℎℏℓℯℴℹℼℽⅆ-ⅉⅎⅰ-ⅿↄⓐ-ⓩⰰ-ⱟⱡⱥⱦⱨⱪⱬⱱⱳⱴⱶ-ⱽⲁⲃⲅⲇⲉⲋⲍⲏⲑⲓⲕⲗⲙⲛⲝⲟⲡⲣⲥⲧⲩⲫⲭⲯⲱⲳⲵⲷⲹⲻⲽⲿⳁⳃⳅⳇⳉⳋⳍⳏⳑⳓⳕⳗⳙⳛⳝⳟⳡⳣⳤⳬⳮⳳⴀ-ⴥⴧⴭꙁꙃꙅꙇꙉꙋꙍꙏꙑꙓꙕꙗꙙꙛꙝꙟꙡꙣꙥꙧꙩꙫꙭꚁꚃꚅꚇꚉꚋꚍꚏꚑꚓꚕꚗꚙꚛ-ꚝꜣꜥꜧꜩꜫꜭꜯ-ꜱꜳꜵꜷꜹꜻꜽꜿꝁꝃꝅꝇꝉꝋꝍꝏꝑꝓꝕꝗꝙꝛꝝꝟꝡꝣꝥꝧꝩꝫꝭꝯ-ꝸꝺꝼꝿꞁꞃꞅꞇꞌꞎꞑꞓ-ꞕꞗꞙꞛꞝꞟꞡꞣꞥꞧꞩꞯꞵꞷꞹꞻꞽꞿꟁꟃꟈꟊꟑꟓꟕꟗꟙꟶꟸ-ꟺꬰ-ꭚꭜ-ꭨꭰ-ꮿﬀ-ﬆﬓ-ﬗａ-ｚ",astral:"\uD801[\uDC28-\uDC4F\uDCD8-\uDCFB\uDD97-\uDDA1\uDDA3-\uDDB1\uDDB3-\uDDB9\uDDBB\uDDBC\uDF80\uDF83-\uDF85\uDF87-\uDFB0\uDFB2-\uDFBA]|\uD803[\uDCC0-\uDCF2]|\uD806[\uDCC0-\uDCDF]|\uD81B[\uDE60-\uDE7F]|\uD835[\uDC1A-\uDC33\uDC4E-\uDC54\uDC56-\uDC67\uDC82-\uDC9B\uDCB6-\uDCB9\uDCBB\uDCBD-\uDCC3\uDCC5-\uDCCF\uDCEA-\uDD03\uDD1E-\uDD37\uDD52-\uDD6B\uDD86-\uDD9F\uDDBA-\uDDD3\uDDEE-\uDE07\uDE22-\uDE3B\uDE56-\uDE6F\uDE8A-\uDEA5\uDEC2-\uDEDA\uDEDC-\uDEE1\uDEFC-\uDF14\uDF16-\uDF1B\uDF36-\uDF4E\uDF50-\uDF55\uDF70-\uDF88\uDF8A-\uDF8F\uDFAA-\uDFC2\uDFC4-\uDFC9\uDFCB]|\uD837[\uDF00-\uDF09\uDF0B-\uDF1E]|\uD83A[\uDD22-\uDD43]"},{name:"Noncharacter_Code_Point",bmp:"﷐-﷯￾￿",astral:"[\uD83F\uD87F\uD8BF\uD8FF\uD93F\uD97F\uD9BF\uD9FF\uDA3F\uDA7F\uDABF\uDAFF\uDB3F\uDB7F\uDBBF\uDBFF][\uDFFE\uDFFF]"},{name:"Uppercase",bmp:"A-ZÀ-ÖØ-ÞĀĂĄĆĈĊČĎĐĒĔĖĘĚĜĞĠĢĤĦĨĪĬĮİĲĴĶĹĻĽĿŁŃŅŇŊŌŎŐŒŔŖŘŚŜŞŠŢŤŦŨŪŬŮŰŲŴŶŸŹŻŽƁƂƄƆƇƉ-ƋƎ-ƑƓƔƖ-ƘƜƝƟƠƢƤƦƧƩƬƮƯƱ-ƳƵƷƸƼǄǇǊǍǏǑǓǕǗǙǛǞǠǢǤǦǨǪǬǮǱǴǶ-ǸǺǼǾȀȂȄȆȈȊȌȎȐȒȔȖȘȚȜȞȠȢȤȦȨȪȬȮȰȲȺȻȽȾɁɃ-ɆɈɊɌɎͰͲͶͿΆΈ-ΊΌΎΏΑ-ΡΣ-ΫϏϒ-ϔϘϚϜϞϠϢϤϦϨϪϬϮϴϷϹϺϽ-ЯѠѢѤѦѨѪѬѮѰѲѴѶѸѺѼѾҀҊҌҎҐҒҔҖҘҚҜҞҠҢҤҦҨҪҬҮҰҲҴҶҸҺҼҾӀӁӃӅӇӉӋӍӐӒӔӖӘӚӜӞӠӢӤӦӨӪӬӮӰӲӴӶӸӺӼӾԀԂԄԆԈԊԌԎԐԒԔԖԘԚԜԞԠԢԤԦԨԪԬԮԱ-ՖႠ-ჅჇჍᎠ-ᏵᲐ-ᲺᲽ-ᲿḀḂḄḆḈḊḌḎḐḒḔḖḘḚḜḞḠḢḤḦḨḪḬḮḰḲḴḶḸḺḼḾṀṂṄṆṈṊṌṎṐṒṔṖṘṚṜṞṠṢṤṦṨṪṬṮṰṲṴṶṸṺṼṾẀẂẄẆẈẊẌẎẐẒẔẞẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼẾỀỂỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪỬỮỰỲỴỶỸỺỼỾἈ-ἏἘ-ἝἨ-ἯἸ-ἿὈ-ὍὙὛὝὟὨ-ὯᾸ-ΆῈ-ΉῘ-ΊῨ-ῬῸ-Ώℂℇℋ-ℍℐ-ℒℕℙ-ℝℤΩℨK-ℭℰ-ℳℾℿⅅⅠ-ⅯↃⒶ-ⓏⰀ-ⰯⱠⱢ-ⱤⱧⱩⱫⱭ-ⱰⱲⱵⱾ-ⲀⲂⲄⲆⲈⲊⲌⲎⲐⲒⲔⲖⲘⲚⲜⲞⲠⲢⲤⲦⲨⲪⲬⲮⲰⲲⲴⲶⲸⲺⲼⲾⳀⳂⳄⳆⳈⳊⳌⳎⳐⳒⳔⳖⳘⳚⳜⳞⳠⳢⳫⳭⳲꙀꙂꙄꙆꙈꙊꙌꙎꙐꙒꙔꙖꙘꙚꙜꙞꙠꙢꙤꙦꙨꙪꙬꚀꚂꚄꚆꚈꚊꚌꚎꚐꚒꚔꚖꚘꚚꜢꜤꜦꜨꜪꜬꜮꜲꜴꜶꜸꜺꜼꜾꝀꝂꝄꝆꝈꝊꝌꝎꝐꝒꝔꝖꝘꝚꝜꝞꝠꝢꝤꝦꝨꝪꝬꝮꝹꝻꝽꝾꞀꞂꞄꞆꞋꞍꞐꞒꞖꞘꞚꞜꞞꞠꞢꞤꞦꞨꞪ-ꞮꞰ-ꞴꞶꞸꞺꞼꞾꟀꟂꟄ-ꟇꟉꟐꟖꟘꟵＡ-Ｚ",astral:"\uD801[\uDC00-\uDC27\uDCB0-\uDCD3\uDD70-\uDD7A\uDD7C-\uDD8A\uDD8C-\uDD92\uDD94\uDD95]|\uD803[\uDC80-\uDCB2]|\uD806[\uDCA0-\uDCBF]|\uD81B[\uDE40-\uDE5F]|\uD835[\uDC00-\uDC19\uDC34-\uDC4D\uDC68-\uDC81\uDC9C\uDC9E\uDC9F\uDCA2\uDCA5\uDCA6\uDCA9-\uDCAC\uDCAE-\uDCB5\uDCD0-\uDCE9\uDD04\uDD05\uDD07-\uDD0A\uDD0D-\uDD14\uDD16-\uDD1C\uDD38\uDD39\uDD3B-\uDD3E\uDD40-\uDD44\uDD46\uDD4A-\uDD50\uDD6C-\uDD85\uDDA0-\uDDB9\uDDD4-\uDDED\uDE08-\uDE21\uDE3C-\uDE55\uDE70-\uDE89\uDEA8-\uDEC0\uDEE2-\uDEFA\uDF1C-\uDF34\uDF56-\uDF6E\uDF90-\uDFA8\uDFCA]|\uD83A[\uDD00-\uDD21]|\uD83C[\uDD30-\uDD49\uDD50-\uDD69\uDD70-\uDD89]"},{name:"White_Space",bmp:"	-\r    - \u2028\u2029  　"}];const Gh=On(jh);/*!
 * XRegExp Unicode Properties 5.1.1
 * <xregexp.com>
 * Steven Levithan (c) 2012-present MIT License
 * Unicode data by Mathias Bynens <mathiasbynens.be>
 */const Uh=t=>{if(!t.addUnicodeData)throw new ReferenceError("Unicode Base must be loaded before Unicode Properties");const e=Gh;e.push({name:"Assigned",inverseOf:"Cn"}),t.addUnicodeData(e)};var Vh=[{name:"Adlam",astral:"\uD83A[\uDD00-\uDD4B\uDD50-\uDD59\uDD5E\uDD5F]"},{name:"Ahom",astral:"\uD805[\uDF00-\uDF1A\uDF1D-\uDF2B\uDF30-\uDF46]"},{name:"Anatolian_Hieroglyphs",astral:"\uD811[\uDC00-\uDE46]"},{name:"Arabic",bmp:"؀-؄؆-؋؍-ؚ؜-؞ؠ-ؿف-يٖ-ٯٱ-ۜ۞-ۿݐ-ݿࡰ-ࢎ࢐࢑࢘-ࣣ࣡-ࣿﭐ-﯂ﯓ-ﴽ﵀-ﶏﶒ-ﷇ﷏ﷰ-﷿ﹰ-ﹴﹶ-ﻼ",astral:"\uD803[\uDE60-\uDE7E]|\uD83B[\uDE00-\uDE03\uDE05-\uDE1F\uDE21\uDE22\uDE24\uDE27\uDE29-\uDE32\uDE34-\uDE37\uDE39\uDE3B\uDE42\uDE47\uDE49\uDE4B\uDE4D-\uDE4F\uDE51\uDE52\uDE54\uDE57\uDE59\uDE5B\uDE5D\uDE5F\uDE61\uDE62\uDE64\uDE67-\uDE6A\uDE6C-\uDE72\uDE74-\uDE77\uDE79-\uDE7C\uDE7E\uDE80-\uDE89\uDE8B-\uDE9B\uDEA1-\uDEA3\uDEA5-\uDEA9\uDEAB-\uDEBB\uDEF0\uDEF1]"},{name:"Armenian",bmp:"Ա-Ֆՙ-֊֍-֏ﬓ-ﬗ"},{name:"Avestan",astral:"\uD802[\uDF00-\uDF35\uDF39-\uDF3F]"},{name:"Balinese",bmp:"ᬀ-ᭌ᭐-᭾"},{name:"Bamum",bmp:"ꚠ-꛷",astral:"\uD81A[\uDC00-\uDE38]"},{name:"Bassa_Vah",astral:"\uD81A[\uDED0-\uDEED\uDEF0-\uDEF5]"},{name:"Batak",bmp:"ᯀ-᯳᯼-᯿"},{name:"Bengali",bmp:"ঀ-ঃঅ-ঌএঐও-নপ-রলশ-হ়-ৄেৈো-ৎৗড়ঢ়য়-ৣ০-৾"},{name:"Bhaiksuki",astral:"\uD807[\uDC00-\uDC08\uDC0A-\uDC36\uDC38-\uDC45\uDC50-\uDC6C]"},{name:"Bopomofo",bmp:"˪˫ㄅ-ㄯㆠ-ㆿ"},{name:"Brahmi",astral:"\uD804[\uDC00-\uDC4D\uDC52-\uDC75\uDC7F]"},{name:"Braille",bmp:"⠀-⣿"},{name:"Buginese",bmp:"ᨀ-ᨛ᨞᨟"},{name:"Buhid",bmp:"ᝀ-ᝓ"},{name:"Canadian_Aboriginal",bmp:"᐀-ᙿᢰ-ᣵ",astral:"\uD806[\uDEB0-\uDEBF]"},{name:"Carian",astral:"\uD800[\uDEA0-\uDED0]"},{name:"Caucasian_Albanian",astral:"\uD801[\uDD30-\uDD63\uDD6F]"},{name:"Chakma",astral:"\uD804[\uDD00-\uDD34\uDD36-\uDD47]"},{name:"Cham",bmp:"ꨀ-ꨶꩀ-ꩍ꩐-꩙꩜-꩟"},{name:"Cherokee",bmp:"Ꭰ-Ᏽᏸ-ᏽꭰ-ꮿ"},{name:"Chorasmian",astral:"\uD803[\uDFB0-\uDFCB]"},{name:"Common",bmp:"\0-@\\[-`\\{-©«-¹»-¿×÷ʹ-˟˥-˩ˬ-˿ʹ;΅·؅،؛؟ـ۝࣢।॥฿࿕-࿘჻᛫-᛭᜵᜶᠂᠃᠅᳓᳡ᳩ-ᳬᳮ-ᳳᳵ-᳷ᳺ -​‎-⁤⁦-⁰⁴-⁾₀-₎₠-⃀℀-℥℧-℩ℬ-ℱℳ-⅍⅏-⅟↉-↋←-␦⑀-⑊①-⟿⤀-⭳⭶-⮕⮗-⯿⸀-⹝⿰-⿻　-〄〆〈-〠〰-〷〼-〿゛゜゠・ー㆐-㆟㇀-㇣㈠-㉟㉿-㋏㋿㍘-㏿䷀-䷿꜀-꜡ꞈ-꞊꠰-꠹꤮ꧏ꭛꭪꭫﴾﴿︐-︙︰-﹒﹔-﹦﹨-﹫\uFEFF！-＠［-｀｛-･ｰﾞﾟ￠-￦￨-￮￹-�",astral:"\uD800[\uDD00-\uDD02\uDD07-\uDD33\uDD37-\uDD3F\uDD90-\uDD9C\uDDD0-\uDDFC\uDEE1-\uDEFB]|\uD82F[\uDCA0-\uDCA3]|\uD833[\uDF50-\uDFC3]|\uD834[\uDC00-\uDCF5\uDD00-\uDD26\uDD29-\uDD66\uDD6A-\uDD7A\uDD83\uDD84\uDD8C-\uDDA9\uDDAE-\uDDEA\uDEE0-\uDEF3\uDF00-\uDF56\uDF60-\uDF78]|\uD835[\uDC00-\uDC54\uDC56-\uDC9C\uDC9E\uDC9F\uDCA2\uDCA5\uDCA6\uDCA9-\uDCAC\uDCAE-\uDCB9\uDCBB\uDCBD-\uDCC3\uDCC5-\uDD05\uDD07-\uDD0A\uDD0D-\uDD14\uDD16-\uDD1C\uDD1E-\uDD39\uDD3B-\uDD3E\uDD40-\uDD44\uDD46\uDD4A-\uDD50\uDD52-\uDEA5\uDEA8-\uDFCB\uDFCE-\uDFFF]|\uD83B[\uDC71-\uDCB4\uDD01-\uDD3D]|\uD83C[\uDC00-\uDC2B\uDC30-\uDC93\uDCA0-\uDCAE\uDCB1-\uDCBF\uDCC1-\uDCCF\uDCD1-\uDCF5\uDD00-\uDDAD\uDDE6-\uDDFF\uDE01\uDE02\uDE10-\uDE3B\uDE40-\uDE48\uDE50\uDE51\uDE60-\uDE65\uDF00-\uDFFF]|\uD83D[\uDC00-\uDED7\uDEDD-\uDEEC\uDEF0-\uDEFC\uDF00-\uDF73\uDF80-\uDFD8\uDFE0-\uDFEB\uDFF0]|\uD83E[\uDC00-\uDC0B\uDC10-\uDC47\uDC50-\uDC59\uDC60-\uDC87\uDC90-\uDCAD\uDCB0\uDCB1\uDD00-\uDE53\uDE60-\uDE6D\uDE70-\uDE74\uDE78-\uDE7C\uDE80-\uDE86\uDE90-\uDEAC\uDEB0-\uDEBA\uDEC0-\uDEC5\uDED0-\uDED9\uDEE0-\uDEE7\uDEF0-\uDEF6\uDF00-\uDF92\uDF94-\uDFCA\uDFF0-\uDFF9]|\uDB40[\uDC01\uDC20-\uDC7F]"},{name:"Coptic",bmp:"Ϣ-ϯⲀ-ⳳ⳹-⳿"},{name:"Cuneiform",astral:"\uD808[\uDC00-\uDF99]|\uD809[\uDC00-\uDC6E\uDC70-\uDC74\uDC80-\uDD43]"},{name:"Cypriot",astral:"\uD802[\uDC00-\uDC05\uDC08\uDC0A-\uDC35\uDC37\uDC38\uDC3C\uDC3F]"},{name:"Cypro_Minoan",astral:"\uD80B[\uDF90-\uDFF2]"},{name:"Cyrillic",bmp:"Ѐ-҄҇-ԯᲀ-ᲈᴫᵸⷠ-ⷿꙀ-ꚟ︮︯"},{name:"Deseret",astral:"\uD801[\uDC00-\uDC4F]"},{name:"Devanagari",bmp:"ऀ-ॐॕ-ॣ०-ॿ꣠-ꣿ"},{name:"Dives_Akuru",astral:"\uD806[\uDD00-\uDD06\uDD09\uDD0C-\uDD13\uDD15\uDD16\uDD18-\uDD35\uDD37\uDD38\uDD3B-\uDD46\uDD50-\uDD59]"},{name:"Dogra",astral:"\uD806[\uDC00-\uDC3B]"},{name:"Duployan",astral:"\uD82F[\uDC00-\uDC6A\uDC70-\uDC7C\uDC80-\uDC88\uDC90-\uDC99\uDC9C-\uDC9F]"},{name:"Egyptian_Hieroglyphs",astral:"\uD80C[\uDC00-\uDFFF]|\uD80D[\uDC00-\uDC2E\uDC30-\uDC38]"},{name:"Elbasan",astral:"\uD801[\uDD00-\uDD27]"},{name:"Elymaic",astral:"\uD803[\uDFE0-\uDFF6]"},{name:"Ethiopic",bmp:"ሀ-ቈቊ-ቍቐ-ቖቘቚ-ቝበ-ኈኊ-ኍነ-ኰኲ-ኵኸ-ኾዀዂ-ዅወ-ዖዘ-ጐጒ-ጕጘ-ፚ፝-፼ᎀ-᎙ⶀ-ⶖⶠ-ⶦⶨ-ⶮⶰ-ⶶⶸ-ⶾⷀ-ⷆⷈ-ⷎⷐ-ⷖⷘ-ⷞꬁ-ꬆꬉ-ꬎꬑ-ꬖꬠ-ꬦꬨ-ꬮ",astral:"\uD839[\uDFE0-\uDFE6\uDFE8-\uDFEB\uDFED\uDFEE\uDFF0-\uDFFE]"},{name:"Georgian",bmp:"Ⴀ-ჅჇჍა-ჺჼ-ჿᲐ-ᲺᲽ-Ჿⴀ-ⴥⴧⴭ"},{name:"Glagolitic",bmp:"Ⰰ-ⱟ",astral:"\uD838[\uDC00-\uDC06\uDC08-\uDC18\uDC1B-\uDC21\uDC23\uDC24\uDC26-\uDC2A]"},{name:"Gothic",astral:"\uD800[\uDF30-\uDF4A]"},{name:"Grantha",astral:"\uD804[\uDF00-\uDF03\uDF05-\uDF0C\uDF0F\uDF10\uDF13-\uDF28\uDF2A-\uDF30\uDF32\uDF33\uDF35-\uDF39\uDF3C-\uDF44\uDF47\uDF48\uDF4B-\uDF4D\uDF50\uDF57\uDF5D-\uDF63\uDF66-\uDF6C\uDF70-\uDF74]"},{name:"Greek",bmp:"Ͱ-ͳ͵-ͷͺ-ͽͿ΄ΆΈ-ΊΌΎ-ΡΣ-ϡϰ-Ͽᴦ-ᴪᵝ-ᵡᵦ-ᵪᶿἀ-ἕἘ-Ἕἠ-ὅὈ-Ὅὐ-ὗὙὛὝὟ-ώᾀ-ᾴᾶ-ῄῆ-ΐῖ-Ί῝-`ῲ-ῴῶ-῾Ωꭥ",astral:"\uD800[\uDD40-\uDD8E\uDDA0]|\uD834[\uDE00-\uDE45]"},{name:"Gujarati",bmp:"ઁ-ઃઅ-ઍએ-ઑઓ-નપ-રલળવ-હ઼-ૅે-ૉો-્ૐૠ-ૣ૦-૱ૹ-૿"},{name:"Gunjala_Gondi",astral:"\uD807[\uDD60-\uDD65\uDD67\uDD68\uDD6A-\uDD8E\uDD90\uDD91\uDD93-\uDD98\uDDA0-\uDDA9]"},{name:"Gurmukhi",bmp:"ਁ-ਃਅ-ਊਏਐਓ-ਨਪ-ਰਲਲ਼ਵਸ਼ਸਹ਼ਾ-ੂੇੈੋ-੍ੑਖ਼-ੜਫ਼੦-੶"},{name:"Han",bmp:"⺀-⺙⺛-⻳⼀-⿕々〇〡-〩〸-〻㐀-䶿一-鿿豈-舘並-龎",astral:"\uD81B[\uDFE2\uDFE3\uDFF0\uDFF1]|[\uD840-\uD868\uD86A-\uD86C\uD86F-\uD872\uD874-\uD879\uD880-\uD883][\uDC00-\uDFFF]|\uD869[\uDC00-\uDEDF\uDF00-\uDFFF]|\uD86D[\uDC00-\uDF38\uDF40-\uDFFF]|\uD86E[\uDC00-\uDC1D\uDC20-\uDFFF]|\uD873[\uDC00-\uDEA1\uDEB0-\uDFFF]|\uD87A[\uDC00-\uDFE0]|\uD87E[\uDC00-\uDE1D]|\uD884[\uDC00-\uDF4A]"},{name:"Hangul",bmp:"ᄀ-ᇿ〮〯ㄱ-ㆎ㈀-㈞㉠-㉾ꥠ-ꥼ가-힣ힰ-ퟆퟋ-ퟻﾠ-ﾾￂ-ￇￊ-ￏￒ-ￗￚ-ￜ"},{name:"Hanifi_Rohingya",astral:"\uD803[\uDD00-\uDD27\uDD30-\uDD39]"},{name:"Hanunoo",bmp:"ᜠ-᜴"},{name:"Hatran",astral:"\uD802[\uDCE0-\uDCF2\uDCF4\uDCF5\uDCFB-\uDCFF]"},{name:"Hebrew",bmp:"֑-ׇא-תׯ-״יִ-זּטּ-לּמּנּסּףּפּצּ-ﭏ"},{name:"Hiragana",bmp:"ぁ-ゖゝ-ゟ",astral:"\uD82C[\uDC01-\uDD1F\uDD50-\uDD52]|🈀"},{name:"Imperial_Aramaic",astral:"\uD802[\uDC40-\uDC55\uDC57-\uDC5F]"},{name:"Inherited",bmp:"̀-ًͯ҅҆-ٰٕ॑-॔᪰-ᫎ᳐-᳔᳒-᳢᳠-᳨᳭᳴᳸᳹᷀-᷿‌‍⃐-〪⃰-゙゚〭︀-️︠-︭",astral:"\uD800[\uDDFD\uDEE0]|𑌻|\uD833[\uDF00-\uDF2D\uDF30-\uDF46]|\uD834[\uDD67-\uDD69\uDD7B-\uDD82\uDD85-\uDD8B\uDDAA-\uDDAD]|\uDB40[\uDD00-\uDDEF]"},{name:"Inscriptional_Pahlavi",astral:"\uD802[\uDF60-\uDF72\uDF78-\uDF7F]"},{name:"Inscriptional_Parthian",astral:"\uD802[\uDF40-\uDF55\uDF58-\uDF5F]"},{name:"Javanese",bmp:"ꦀ-꧍꧐-꧙꧞꧟"},{name:"Kaithi",astral:"\uD804[\uDC80-\uDCC2\uDCCD]"},{name:"Kannada",bmp:"ಀ-ಌಎ-ಐಒ-ನಪ-ಳವ-ಹ಼-ೄೆ-ೈೊ-್ೕೖೝೞೠ-ೣ೦-೯ೱೲ"},{name:"Katakana",bmp:"ァ-ヺヽ-ヿㇰ-ㇿ㋐-㋾㌀-㍗ｦ-ｯｱ-ﾝ",astral:"\uD82B[\uDFF0-\uDFF3\uDFF5-\uDFFB\uDFFD\uDFFE]|\uD82C[\uDC00\uDD20-\uDD22\uDD64-\uDD67]"},{name:"Kayah_Li",bmp:"꤀-꤭꤯"},{name:"Kharoshthi",astral:"\uD802[\uDE00-\uDE03\uDE05\uDE06\uDE0C-\uDE13\uDE15-\uDE17\uDE19-\uDE35\uDE38-\uDE3A\uDE3F-\uDE48\uDE50-\uDE58]"},{name:"Khitan_Small_Script",astral:"𖿤|\uD822[\uDF00-\uDFFF]|\uD823[\uDC00-\uDCD5]"},{name:"Khmer",bmp:"ក-៝០-៩៰-៹᧠-᧿"},{name:"Khojki",astral:"\uD804[\uDE00-\uDE11\uDE13-\uDE3E]"},{name:"Khudawadi",astral:"\uD804[\uDEB0-\uDEEA\uDEF0-\uDEF9]"},{name:"Lao",bmp:"ກຂຄຆ-ຊຌ-ຣລວ-ຽເ-ໄໆ່-ໍ໐-໙ໜ-ໟ"},{name:"Latin",bmp:"A-Za-zªºÀ-ÖØ-öø-ʸˠ-ˤᴀ-ᴥᴬ-ᵜᵢ-ᵥᵫ-ᵷᵹ-ᶾḀ-ỿⁱⁿₐ-ₜKÅℲⅎⅠ-ↈⱠ-ⱿꜢ-ꞇꞋ-ꟊꟐꟑꟓꟕ-ꟙꟲ-ꟿꬰ-ꭚꭜ-ꭤꭦ-ꭩﬀ-ﬆＡ-Ｚａ-ｚ",astral:"\uD801[\uDF80-\uDF85\uDF87-\uDFB0\uDFB2-\uDFBA]|\uD837[\uDF00-\uDF1E]"},{name:"Lepcha",bmp:"ᰀ-᰷᰻-᱉ᱍ-ᱏ"},{name:"Limbu",bmp:"ᤀ-ᤞᤠ-ᤫᤰ-᤻᥀᥄-᥏"},{name:"Linear_A",astral:"\uD801[\uDE00-\uDF36\uDF40-\uDF55\uDF60-\uDF67]"},{name:"Linear_B",astral:"\uD800[\uDC00-\uDC0B\uDC0D-\uDC26\uDC28-\uDC3A\uDC3C\uDC3D\uDC3F-\uDC4D\uDC50-\uDC5D\uDC80-\uDCFA]"},{name:"Lisu",bmp:"ꓐ-꓿",astral:"𑾰"},{name:"Lycian",astral:"\uD800[\uDE80-\uDE9C]"},{name:"Lydian",astral:"\uD802[\uDD20-\uDD39\uDD3F]"},{name:"Mahajani",astral:"\uD804[\uDD50-\uDD76]"},{name:"Makasar",astral:"\uD807[\uDEE0-\uDEF8]"},{name:"Malayalam",bmp:"ഀ-ഌഎ-ഐഒ-ൄെ-ൈൊ-൏ൔ-ൣ൦-ൿ"},{name:"Mandaic",bmp:"ࡀ-࡛࡞"},{name:"Manichaean",astral:"\uD802[\uDEC0-\uDEE6\uDEEB-\uDEF6]"},{name:"Marchen",astral:"\uD807[\uDC70-\uDC8F\uDC92-\uDCA7\uDCA9-\uDCB6]"},{name:"Masaram_Gondi",astral:"\uD807[\uDD00-\uDD06\uDD08\uDD09\uDD0B-\uDD36\uDD3A\uDD3C\uDD3D\uDD3F-\uDD47\uDD50-\uDD59]"},{name:"Medefaidrin",astral:"\uD81B[\uDE40-\uDE9A]"},{name:"Meetei_Mayek",bmp:"ꫠ-꫶ꯀ-꯭꯰-꯹"},{name:"Mende_Kikakui",astral:"\uD83A[\uDC00-\uDCC4\uDCC7-\uDCD6]"},{name:"Meroitic_Cursive",astral:"\uD802[\uDDA0-\uDDB7\uDDBC-\uDDCF\uDDD2-\uDDFF]"},{name:"Meroitic_Hieroglyphs",astral:"\uD802[\uDD80-\uDD9F]"},{name:"Miao",astral:"\uD81B[\uDF00-\uDF4A\uDF4F-\uDF87\uDF8F-\uDF9F]"},{name:"Modi",astral:"\uD805[\uDE00-\uDE44\uDE50-\uDE59]"},{name:"Mongolian",bmp:"᠀᠁᠄᠆-᠙ᠠ-ᡸᢀ-ᢪ",astral:"\uD805[\uDE60-\uDE6C]"},{name:"Mro",astral:"\uD81A[\uDE40-\uDE5E\uDE60-\uDE69\uDE6E\uDE6F]"},{name:"Multani",astral:"\uD804[\uDE80-\uDE86\uDE88\uDE8A-\uDE8D\uDE8F-\uDE9D\uDE9F-\uDEA9]"},{name:"Myanmar",bmp:"က-႟ꧠ-ꧾꩠ-ꩿ"},{name:"Nabataean",astral:"\uD802[\uDC80-\uDC9E\uDCA7-\uDCAF]"},{name:"Nandinagari",astral:"\uD806[\uDDA0-\uDDA7\uDDAA-\uDDD7\uDDDA-\uDDE4]"},{name:"New_Tai_Lue",bmp:"ᦀ-ᦫᦰ-ᧉ᧐-᧚᧞᧟"},{name:"Newa",astral:"\uD805[\uDC00-\uDC5B\uDC5D-\uDC61]"},{name:"Nko",bmp:"߀-ߺ߽-߿"},{name:"Nushu",astral:"𖿡|\uD82C[\uDD70-\uDEFB]"},{name:"Nyiakeng_Puachue_Hmong",astral:"\uD838[\uDD00-\uDD2C\uDD30-\uDD3D\uDD40-\uDD49\uDD4E\uDD4F]"},{name:"Ogham",bmp:" -᚜"},{name:"Ol_Chiki",bmp:"᱐-᱿"},{name:"Old_Hungarian",astral:"\uD803[\uDC80-\uDCB2\uDCC0-\uDCF2\uDCFA-\uDCFF]"},{name:"Old_Italic",astral:"\uD800[\uDF00-\uDF23\uDF2D-\uDF2F]"},{name:"Old_North_Arabian",astral:"\uD802[\uDE80-\uDE9F]"},{name:"Old_Permic",astral:"\uD800[\uDF50-\uDF7A]"},{name:"Old_Persian",astral:"\uD800[\uDFA0-\uDFC3\uDFC8-\uDFD5]"},{name:"Old_Sogdian",astral:"\uD803[\uDF00-\uDF27]"},{name:"Old_South_Arabian",astral:"\uD802[\uDE60-\uDE7F]"},{name:"Old_Turkic",astral:"\uD803[\uDC00-\uDC48]"},{name:"Old_Uyghur",astral:"\uD803[\uDF70-\uDF89]"},{name:"Oriya",bmp:"ଁ-ଃଅ-ଌଏଐଓ-ନପ-ରଲଳଵ-ହ଼-ୄେୈୋ-୍୕-ୗଡ଼ଢ଼ୟ-ୣ୦-୷"},{name:"Osage",astral:"\uD801[\uDCB0-\uDCD3\uDCD8-\uDCFB]"},{name:"Osmanya",astral:"\uD801[\uDC80-\uDC9D\uDCA0-\uDCA9]"},{name:"Pahawh_Hmong",astral:"\uD81A[\uDF00-\uDF45\uDF50-\uDF59\uDF5B-\uDF61\uDF63-\uDF77\uDF7D-\uDF8F]"},{name:"Palmyrene",astral:"\uD802[\uDC60-\uDC7F]"},{name:"Pau_Cin_Hau",astral:"\uD806[\uDEC0-\uDEF8]"},{name:"Phags_Pa",bmp:"ꡀ-꡷"},{name:"Phoenician",astral:"\uD802[\uDD00-\uDD1B\uDD1F]"},{name:"Psalter_Pahlavi",astral:"\uD802[\uDF80-\uDF91\uDF99-\uDF9C\uDFA9-\uDFAF]"},{name:"Rejang",bmp:"ꤰ-꥓꥟"},{name:"Runic",bmp:"ᚠ-ᛪᛮ-ᛸ"},{name:"Samaritan",bmp:"ࠀ-࠭࠰-࠾"},{name:"Saurashtra",bmp:"ꢀ-ꣅ꣎-꣙"},{name:"Sharada",astral:"\uD804[\uDD80-\uDDDF]"},{name:"Shavian",astral:"\uD801[\uDC50-\uDC7F]"},{name:"Siddham",astral:"\uD805[\uDD80-\uDDB5\uDDB8-\uDDDD]"},{name:"SignWriting",astral:"\uD836[\uDC00-\uDE8B\uDE9B-\uDE9F\uDEA1-\uDEAF]"},{name:"Sinhala",bmp:"ඁ-ඃඅ-ඖක-නඳ-රලව-ෆ්ා-ුූෘ-ෟ෦-෯ෲ-෴",astral:"\uD804[\uDDE1-\uDDF4]"},{name:"Sogdian",astral:"\uD803[\uDF30-\uDF59]"},{name:"Sora_Sompeng",astral:"\uD804[\uDCD0-\uDCE8\uDCF0-\uDCF9]"},{name:"Soyombo",astral:"\uD806[\uDE50-\uDEA2]"},{name:"Sundanese",bmp:"ᮀ-ᮿ᳀-᳇"},{name:"Syloti_Nagri",bmp:"ꠀ-꠬"},{name:"Syriac",bmp:"܀-܍܏-݊ݍ-ݏࡠ-ࡪ"},{name:"Tagalog",bmp:"ᜀ-᜕ᜟ"},{name:"Tagbanwa",bmp:"ᝠ-ᝬᝮ-ᝰᝲᝳ"},{name:"Tai_Le",bmp:"ᥐ-ᥭᥰ-ᥴ"},{name:"Tai_Tham",bmp:"ᨠ-ᩞ᩠-᩿᩼-᪉᪐-᪙᪠-᪭"},{name:"Tai_Viet",bmp:"ꪀ-ꫂꫛ-꫟"},{name:"Takri",astral:"\uD805[\uDE80-\uDEB9\uDEC0-\uDEC9]"},{name:"Tamil",bmp:"ஂஃஅ-ஊஎ-ஐஒ-கஙசஜஞடணதந-பம-ஹா-ூெ-ைொ-்ௐௗ௦-௺",astral:"\uD807[\uDFC0-\uDFF1\uDFFF]"},{name:"Tangsa",astral:"\uD81A[\uDE70-\uDEBE\uDEC0-\uDEC9]"},{name:"Tangut",astral:"𖿠|[\uD81C-\uD820][\uDC00-\uDFFF]|\uD821[\uDC00-\uDFF7]|\uD822[\uDC00-\uDEFF]|\uD823[\uDD00-\uDD08]"},{name:"Telugu",bmp:"ఀ-ఌఎ-ఐఒ-నప-హ఼-ౄె-ైొ-్ౕౖౘ-ౚౝౠ-ౣ౦-౯౷-౿"},{name:"Thaana",bmp:"ހ-ޱ"},{name:"Thai",bmp:"ก-ฺเ-๛"},{name:"Tibetan",bmp:"ༀ-ཇཉ-ཬཱ-ྗྙ-ྼ྾-࿌࿎-࿔࿙࿚"},{name:"Tifinagh",bmp:"ⴰ-ⵧⵯ⵰⵿"},{name:"Tirhuta",astral:"\uD805[\uDC80-\uDCC7\uDCD0-\uDCD9]"},{name:"Toto",astral:"\uD838[\uDE90-\uDEAE]"},{name:"Ugaritic",astral:"\uD800[\uDF80-\uDF9D\uDF9F]"},{name:"Vai",bmp:"ꔀ-ꘫ"},{name:"Vithkuqi",astral:"\uD801[\uDD70-\uDD7A\uDD7C-\uDD8A\uDD8C-\uDD92\uDD94\uDD95\uDD97-\uDDA1\uDDA3-\uDDB1\uDDB3-\uDDB9\uDDBB\uDDBC]"},{name:"Wancho",astral:"\uD838[\uDEC0-\uDEF9\uDEFF]"},{name:"Warang_Citi",astral:"\uD806[\uDCA0-\uDCF2\uDCFF]"},{name:"Yezidi",astral:"\uD803[\uDE80-\uDEA9\uDEAB-\uDEAD\uDEB0\uDEB1]"},{name:"Yi",bmp:"ꀀ-ꒌ꒐-꓆"},{name:"Zanabazar_Square",astral:"\uD806[\uDE00-\uDE47]"}];const Jh=On(Vh);/*!
 * XRegExp Unicode Scripts 5.1.1
 * <xregexp.com>
 * Steven Levithan (c) 2010-present MIT License
 * Unicode data by Mathias Bynens <mathiasbynens.be>
 */const Hh=t=>{if(!t.addUnicodeData)throw new ReferenceError("Unicode Base must be loaded before Unicode Scripts");t.addUnicodeData(Jh,"Script")};$h(B);Bh(B);Rh(B);Lh(B);Uh(B);Hh(B);const Wh=Object.freeze(Object.defineProperty({__proto__:null,default:B},Symbol.toStringTag,{value:"Module"}));function $e(t,e){if(!!!t)throw new Error(e)}function Xt(t){return typeof(t==null?void 0:t.then)=="function"}function ln(t){return typeof t=="object"&&t!==null}function Gt(t,e){if(!!!t)throw new Error(e??"Unexpected invariant triggered.")}const Kh=/\r\n|[\n\r]/g;function ta(t,e){let n=0,r=1;for(const s of t.body.matchAll(Kh)){if(typeof s.index=="number"||Gt(!1),s.index>=e)break;n=s.index+s[0].length,r+=1}return{line:r,column:e+1-n}}function Xh(t){return P1(t.source,ta(t.source,t.start))}function P1(t,e){const n=t.locationOffset.column-1,r="".padStart(n)+t.body,s=e.line-1,o=t.locationOffset.line-1,i=e.line+o,a=e.line===1?n:0,u=e.column+a,c=`${t.name}:${i}:${u}
`,l=r.split(/\r\n|[\n\r]/g),p=l[s];if(p.length>120){const d=Math.floor(u/80),f=u%80,S=[];for(let b=0;b<p.length;b+=80)S.push(p.slice(b,b+80));return c+Ec([[`${i} |`,S[0]],...S.slice(1,d+1).map(b=>["|",b]),["|","^".padStart(f)],["|",S[d+1]]])}return c+Ec([[`${i-1} |`,l[s-1]],[`${i} |`,p],["|","^".padStart(u)],[`${i+1} |`,l[s+1]]])}function Ec(t){const e=t.filter(([r,s])=>s!==void 0),n=Math.max(...e.map(([r])=>r.length));return e.map(([r,s])=>r.padStart(n)+(s?" "+s:"")).join(`
`)}function zh(t){const e=t[0];return e==null||"kind"in e||"length"in e?{nodes:e,source:t[1],positions:t[2],path:t[3],originalError:t[4],extensions:t[5]}:e}class X extends Error{constructor(e,...n){var r,s,o;const{nodes:i,source:a,positions:u,path:c,originalError:l,extensions:p}=zh(n);super(e),this.name="GraphQLError",this.path=c??void 0,this.originalError=l??void 0,this.nodes=yc(Array.isArray(i)?i:i?[i]:void 0);const d=yc((r=this.nodes)===null||r===void 0?void 0:r.map(S=>S.loc).filter(S=>S!=null));this.source=a??(d==null||(s=d[0])===null||s===void 0?void 0:s.source),this.positions=u??(d==null?void 0:d.map(S=>S.start)),this.locations=u&&a?u.map(S=>ta(a,S)):d==null?void 0:d.map(S=>ta(S.source,S.start));const f=ln(l==null?void 0:l.extensions)?l==null?void 0:l.extensions:void 0;this.extensions=(o=p??f)!==null&&o!==void 0?o:Object.create(null),Object.defineProperties(this,{message:{writable:!0,enumerable:!0},name:{enumerable:!1},nodes:{enumerable:!1},source:{enumerable:!1},positions:{enumerable:!1},originalError:{enumerable:!1}}),l!=null&&l.stack?Object.defineProperty(this,"stack",{value:l.stack,writable:!0,configurable:!0}):Error.captureStackTrace?Error.captureStackTrace(this,X):Object.defineProperty(this,"stack",{value:Error().stack,writable:!0,configurable:!0})}get[Symbol.toStringTag](){return"GraphQLError"}toString(){let e=this.message;if(this.nodes)for(const n of this.nodes)n.loc&&(e+=`

`+Xh(n.loc));else if(this.source&&this.locations)for(const n of this.locations)e+=`

`+P1(this.source,n);return e}toJSON(){const e={message:this.message};return this.locations!=null&&(e.locations=this.locations),this.path!=null&&(e.path=this.path),this.extensions!=null&&Object.keys(this.extensions).length>0&&(e.extensions=this.extensions),e}}function yc(t){return t===void 0||t.length===0?void 0:t}function vt(t,e,n){return new X(`Syntax Error: ${n}`,{source:t,positions:[e]})}class Yh{constructor(e,n,r){this.start=e.start,this.end=n.end,this.startToken=e,this.endToken=n,this.source=r}get[Symbol.toStringTag](){return"Location"}toJSON(){return{start:this.start,end:this.end}}}class N1{constructor(e,n,r,s,o,i){this.kind=e,this.start=n,this.end=r,this.line=s,this.column=o,this.value=i,this.prev=null,this.next=null}get[Symbol.toStringTag](){return"Token"}toJSON(){return{kind:this.kind,value:this.value,line:this.line,column:this.column}}}const _1={Name:[],Document:["definitions"],OperationDefinition:["name","variableDefinitions","directives","selectionSet"],VariableDefinition:["variable","type","defaultValue","directives"],Variable:["name"],SelectionSet:["selections"],Field:["alias","name","arguments","directives","selectionSet"],Argument:["name","value"],FragmentSpread:["name","directives"],InlineFragment:["typeCondition","directives","selectionSet"],FragmentDefinition:["name","variableDefinitions","typeCondition","directives","selectionSet"],IntValue:[],FloatValue:[],StringValue:[],BooleanValue:[],NullValue:[],EnumValue:[],ListValue:["values"],ObjectValue:["fields"],ObjectField:["name","value"],Directive:["name","arguments"],NamedType:["name"],ListType:["type"],NonNullType:["type"],SchemaDefinition:["description","directives","operationTypes"],OperationTypeDefinition:["type"],ScalarTypeDefinition:["description","name","directives"],ObjectTypeDefinition:["description","name","interfaces","directives","fields"],FieldDefinition:["description","name","arguments","type","directives"],InputValueDefinition:["description","name","type","defaultValue","directives"],InterfaceTypeDefinition:["description","name","interfaces","directives","fields"],UnionTypeDefinition:["description","name","directives","types"],EnumTypeDefinition:["description","name","directives","values"],EnumValueDefinition:["description","name","directives"],InputObjectTypeDefinition:["description","name","directives","fields"],DirectiveDefinition:["description","name","arguments","locations"],SchemaExtension:["directives","operationTypes"],ScalarTypeExtension:["name","directives"],ObjectTypeExtension:["name","interfaces","directives","fields"],InterfaceTypeExtension:["name","interfaces","directives","fields"],UnionTypeExtension:["name","directives","types"],EnumTypeExtension:["name","directives","values"],InputObjectTypeExtension:["name","directives","fields"]},Zh=new Set(Object.keys(_1));function na(t){const e=t==null?void 0:t.kind;return typeof e=="string"&&Zh.has(e)}var At;(function(t){t.QUERY="query",t.MUTATION="mutation",t.SUBSCRIPTION="subscription"})(At||(At={}));var fe;(function(t){t.QUERY="QUERY",t.MUTATION="MUTATION",t.SUBSCRIPTION="SUBSCRIPTION",t.FIELD="FIELD",t.FRAGMENT_DEFINITION="FRAGMENT_DEFINITION",t.FRAGMENT_SPREAD="FRAGMENT_SPREAD",t.INLINE_FRAGMENT="INLINE_FRAGMENT",t.VARIABLE_DEFINITION="VARIABLE_DEFINITION",t.SCHEMA="SCHEMA",t.SCALAR="SCALAR",t.OBJECT="OBJECT",t.FIELD_DEFINITION="FIELD_DEFINITION",t.ARGUMENT_DEFINITION="ARGUMENT_DEFINITION",t.INTERFACE="INTERFACE",t.UNION="UNION",t.ENUM="ENUM",t.ENUM_VALUE="ENUM_VALUE",t.INPUT_OBJECT="INPUT_OBJECT",t.INPUT_FIELD_DEFINITION="INPUT_FIELD_DEFINITION"})(fe||(fe={}));var I;(function(t){t.NAME="Name",t.DOCUMENT="Document",t.OPERATION_DEFINITION="OperationDefinition",t.VARIABLE_DEFINITION="VariableDefinition",t.SELECTION_SET="SelectionSet",t.FIELD="Field",t.ARGUMENT="Argument",t.FRAGMENT_SPREAD="FragmentSpread",t.INLINE_FRAGMENT="InlineFragment",t.FRAGMENT_DEFINITION="FragmentDefinition",t.VARIABLE="Variable",t.INT="IntValue",t.FLOAT="FloatValue",t.STRING="StringValue",t.BOOLEAN="BooleanValue",t.NULL="NullValue",t.ENUM="EnumValue",t.LIST="ListValue",t.OBJECT="ObjectValue",t.OBJECT_FIELD="ObjectField",t.DIRECTIVE="Directive",t.NAMED_TYPE="NamedType",t.LIST_TYPE="ListType",t.NON_NULL_TYPE="NonNullType",t.SCHEMA_DEFINITION="SchemaDefinition",t.OPERATION_TYPE_DEFINITION="OperationTypeDefinition",t.SCALAR_TYPE_DEFINITION="ScalarTypeDefinition",t.OBJECT_TYPE_DEFINITION="ObjectTypeDefinition",t.FIELD_DEFINITION="FieldDefinition",t.INPUT_VALUE_DEFINITION="InputValueDefinition",t.INTERFACE_TYPE_DEFINITION="InterfaceTypeDefinition",t.UNION_TYPE_DEFINITION="UnionTypeDefinition",t.ENUM_TYPE_DEFINITION="EnumTypeDefinition",t.ENUM_VALUE_DEFINITION="EnumValueDefinition",t.INPUT_OBJECT_TYPE_DEFINITION="InputObjectTypeDefinition",t.DIRECTIVE_DEFINITION="DirectiveDefinition",t.SCHEMA_EXTENSION="SchemaExtension",t.SCALAR_TYPE_EXTENSION="ScalarTypeExtension",t.OBJECT_TYPE_EXTENSION="ObjectTypeExtension",t.INTERFACE_TYPE_EXTENSION="InterfaceTypeExtension",t.UNION_TYPE_EXTENSION="UnionTypeExtension",t.ENUM_TYPE_EXTENSION="EnumTypeExtension",t.INPUT_OBJECT_TYPE_EXTENSION="InputObjectTypeExtension"})(I||(I={}));function ra(t){return t===9||t===32}function Ts(t){return t>=48&&t<=57}function O1(t){return t>=97&&t<=122||t>=65&&t<=90}function Ga(t){return O1(t)||t===95}function $1(t){return O1(t)||Ts(t)||t===95}function Qh(t){var e;let n=Number.MAX_SAFE_INTEGER,r=null,s=-1;for(let i=0;i<t.length;++i){var o;const a=t[i],u=e2(a);u!==a.length&&(r=(o=r)!==null&&o!==void 0?o:i,s=i,i!==0&&u<n&&(n=u))}return t.map((i,a)=>a===0?i:i.slice(n)).slice((e=r)!==null&&e!==void 0?e:0,s+1)}function e2(t){let e=0;for(;e<t.length&&ra(t.charCodeAt(e));)++e;return e}function t2(t,e){const n=t.replace(/"""/g,'\\"""'),r=n.split(/\r\n|[\n\r]/g),s=r.length===1,o=r.length>1&&r.slice(1).every(f=>f.length===0||ra(f.charCodeAt(0))),i=n.endsWith('\\"""'),a=t.endsWith('"')&&!i,u=t.endsWith("\\"),c=a||u,l=!s||t.length>70||c||o||i;let p="";const d=s&&ra(t.charCodeAt(0));return(l&&!d||o)&&(p+=`
`),p+=n,(l||c)&&(p+=`
`),'"""'+p+'"""'}var z;(function(t){t.SOF="<SOF>",t.EOF="<EOF>",t.BANG="!",t.DOLLAR="$",t.AMP="&",t.PAREN_L="(",t.PAREN_R=")",t.SPREAD="...",t.COLON=":",t.EQUALS="=",t.AT="@",t.BRACKET_L="[",t.BRACKET_R="]",t.BRACE_L="{",t.PIPE="|",t.BRACE_R="}",t.NAME="Name",t.INT="Int",t.FLOAT="Float",t.STRING="String",t.BLOCK_STRING="BlockString",t.COMMENT="Comment"})(z||(z={}));class n2{constructor(e){const n=new N1(z.SOF,0,0,0,0);this.source=e,this.lastToken=n,this.token=n,this.line=1,this.lineStart=0}get[Symbol.toStringTag](){return"Lexer"}advance(){return this.lastToken=this.token,this.token=this.lookahead()}lookahead(){let e=this.token;if(e.kind!==z.EOF)do if(e.next)e=e.next;else{const n=s2(this,e.end);e.next=n,n.prev=e,e=n}while(e.kind===z.COMMENT);return e}}function r2(t){return t===z.BANG||t===z.DOLLAR||t===z.AMP||t===z.PAREN_L||t===z.PAREN_R||t===z.SPREAD||t===z.COLON||t===z.EQUALS||t===z.AT||t===z.BRACKET_L||t===z.BRACKET_R||t===z.BRACE_L||t===z.PIPE||t===z.BRACE_R}function es(t){return t>=0&&t<=55295||t>=57344&&t<=1114111}function Zo(t,e){return B1(t.charCodeAt(e))&&R1(t.charCodeAt(e+1))}function B1(t){return t>=55296&&t<=56319}function R1(t){return t>=56320&&t<=57343}function hr(t,e){const n=t.source.body.codePointAt(e);if(n===void 0)return z.EOF;if(n>=32&&n<=126){const r=String.fromCodePoint(n);return r==='"'?`'"'`:`"${r}"`}return"U+"+n.toString(16).toUpperCase().padStart(4,"0")}function St(t,e,n,r,s){const o=t.line,i=1+n-t.lineStart;return new N1(e,n,r,o,i,s)}function s2(t,e){const n=t.source.body,r=n.length;let s=e;for(;s<r;){const o=n.charCodeAt(s);switch(o){case 65279:case 9:case 32:case 44:++s;continue;case 10:++s,++t.line,t.lineStart=s;continue;case 13:n.charCodeAt(s+1)===10?s+=2:++s,++t.line,t.lineStart=s;continue;case 35:return o2(t,s);case 33:return St(t,z.BANG,s,s+1);case 36:return St(t,z.DOLLAR,s,s+1);case 38:return St(t,z.AMP,s,s+1);case 40:return St(t,z.PAREN_L,s,s+1);case 41:return St(t,z.PAREN_R,s,s+1);case 46:if(n.charCodeAt(s+1)===46&&n.charCodeAt(s+2)===46)return St(t,z.SPREAD,s,s+3);break;case 58:return St(t,z.COLON,s,s+1);case 61:return St(t,z.EQUALS,s,s+1);case 64:return St(t,z.AT,s,s+1);case 91:return St(t,z.BRACKET_L,s,s+1);case 93:return St(t,z.BRACKET_R,s,s+1);case 123:return St(t,z.BRACE_L,s,s+1);case 124:return St(t,z.PIPE,s,s+1);case 125:return St(t,z.BRACE_R,s,s+1);case 34:return n.charCodeAt(s+1)===34&&n.charCodeAt(s+2)===34?p2(t,s):a2(t,s)}if(Ts(o)||o===45)return i2(t,s,o);if(Ga(o))return d2(t,s);throw vt(t.source,s,o===39?`Unexpected single quote character ('), did you mean to use a double quote (")?`:es(o)||Zo(n,s)?`Unexpected character: ${hr(t,s)}.`:`Invalid character: ${hr(t,s)}.`)}return St(t,z.EOF,r,r)}function o2(t,e){const n=t.source.body,r=n.length;let s=e+1;for(;s<r;){const o=n.charCodeAt(s);if(o===10||o===13)break;if(es(o))++s;else if(Zo(n,s))s+=2;else break}return St(t,z.COMMENT,e,s,n.slice(e+1,s))}function i2(t,e,n){const r=t.source.body;let s=e,o=n,i=!1;if(o===45&&(o=r.charCodeAt(++s)),o===48){if(o=r.charCodeAt(++s),Ts(o))throw vt(t.source,s,`Invalid number, unexpected digit after 0: ${hr(t,s)}.`)}else s=vi(t,s,o),o=r.charCodeAt(s);if(o===46&&(i=!0,o=r.charCodeAt(++s),s=vi(t,s,o),o=r.charCodeAt(s)),(o===69||o===101)&&(i=!0,o=r.charCodeAt(++s),(o===43||o===45)&&(o=r.charCodeAt(++s)),s=vi(t,s,o),o=r.charCodeAt(s)),o===46||Ga(o))throw vt(t.source,s,`Invalid number, expected digit but got: ${hr(t,s)}.`);return St(t,i?z.FLOAT:z.INT,e,s,r.slice(e,s))}function vi(t,e,n){if(!Ts(n))throw vt(t.source,e,`Invalid number, expected digit but got: ${hr(t,e)}.`);const r=t.source.body;let s=e+1;for(;Ts(r.charCodeAt(s));)++s;return s}function a2(t,e){const n=t.source.body,r=n.length;let s=e+1,o=s,i="";for(;s<r;){const a=n.charCodeAt(s);if(a===34)return i+=n.slice(o,s),St(t,z.STRING,e,s+1,i);if(a===92){i+=n.slice(o,s);const u=n.charCodeAt(s+1)===117?n.charCodeAt(s+2)===123?u2(t,s):c2(t,s):l2(t,s);i+=u.value,s+=u.size,o=s;continue}if(a===10||a===13)break;if(es(a))++s;else if(Zo(n,s))s+=2;else throw vt(t.source,s,`Invalid character within String: ${hr(t,s)}.`)}throw vt(t.source,s,"Unterminated string.")}function u2(t,e){const n=t.source.body;let r=0,s=3;for(;s<12;){const o=n.charCodeAt(e+s++);if(o===125){if(s<5||!es(r))break;return{value:String.fromCodePoint(r),size:s}}if(r=r<<4|cs(o),r<0)break}throw vt(t.source,e,`Invalid Unicode escape sequence: "${n.slice(e,e+s)}".`)}function c2(t,e){const n=t.source.body,r=gc(n,e+2);if(es(r))return{value:String.fromCodePoint(r),size:6};if(B1(r)&&n.charCodeAt(e+6)===92&&n.charCodeAt(e+7)===117){const s=gc(n,e+8);if(R1(s))return{value:String.fromCodePoint(r,s),size:12}}throw vt(t.source,e,`Invalid Unicode escape sequence: "${n.slice(e,e+6)}".`)}function gc(t,e){return cs(t.charCodeAt(e))<<12|cs(t.charCodeAt(e+1))<<8|cs(t.charCodeAt(e+2))<<4|cs(t.charCodeAt(e+3))}function cs(t){return t>=48&&t<=57?t-48:t>=65&&t<=70?t-55:t>=97&&t<=102?t-87:-1}function l2(t,e){const n=t.source.body;switch(n.charCodeAt(e+1)){case 34:return{value:'"',size:2};case 92:return{value:"\\",size:2};case 47:return{value:"/",size:2};case 98:return{value:"\b",size:2};case 102:return{value:"\f",size:2};case 110:return{value:`
`,size:2};case 114:return{value:"\r",size:2};case 116:return{value:"	",size:2}}throw vt(t.source,e,`Invalid character escape sequence: "${n.slice(e,e+2)}".`)}function p2(t,e){const n=t.source.body,r=n.length;let s=t.lineStart,o=e+3,i=o,a="";const u=[];for(;o<r;){const c=n.charCodeAt(o);if(c===34&&n.charCodeAt(o+1)===34&&n.charCodeAt(o+2)===34){a+=n.slice(i,o),u.push(a);const l=St(t,z.BLOCK_STRING,e,o+3,Qh(u).join(`
`));return t.line+=u.length-1,t.lineStart=s,l}if(c===92&&n.charCodeAt(o+1)===34&&n.charCodeAt(o+2)===34&&n.charCodeAt(o+3)===34){a+=n.slice(i,o),i=o+1,o+=4;continue}if(c===10||c===13){a+=n.slice(i,o),u.push(a),c===13&&n.charCodeAt(o+1)===10?o+=2:++o,a="",i=o,s=o;continue}if(es(c))++o;else if(Zo(n,o))o+=2;else throw vt(t.source,o,`Invalid character within String: ${hr(t,o)}.`)}throw vt(t.source,o,"Unterminated string.")}function d2(t,e){const n=t.source.body,r=n.length;let s=e+1;for(;s<r;){const o=n.charCodeAt(s);if($1(o))++s;else break}return St(t,z.NAME,e,s,n.slice(e,s))}const f2=10,x1=2;function te(t){return Qo(t,[])}function Qo(t,e){switch(typeof t){case"string":return JSON.stringify(t);case"function":return t.name?`[function ${t.name}]`:"[function]";case"object":return h2(t,e);default:return String(t)}}function h2(t,e){if(t===null)return"null";if(e.includes(t))return"[Circular]";const n=[...e,t];if(m2(t)){const r=t.toJSON();if(r!==t)return typeof r=="string"?r:Qo(r,n)}else if(Array.isArray(t))return S2(t,n);return D2(t,n)}function m2(t){return typeof t.toJSON=="function"}function D2(t,e){const n=Object.entries(t);return n.length===0?"{}":e.length>x1?"["+E2(t)+"]":"{ "+n.map(([s,o])=>s+": "+Qo(o,e)).join(", ")+" }"}function S2(t,e){if(t.length===0)return"[]";if(e.length>x1)return"[Array]";const n=Math.min(f2,t.length),r=t.length-n,s=[];for(let o=0;o<n;++o)s.push(Qo(t[o],e));return r===1?s.push("... 1 more item"):r>1&&s.push(`... ${r} more items`),"["+s.join(", ")+"]"}function E2(t){const e=Object.prototype.toString.call(t).replace(/^\[object /,"").replace(/]$/,"");if(e==="Object"&&typeof t.constructor=="function"){const n=t.constructor.name;if(typeof n=="string"&&n!=="")return n}return e}const pn=globalThis.process?function(e,n){return e instanceof n}:function(e,n){if(e instanceof n)return!0;if(typeof e=="object"&&e!==null){var r;const s=n.prototype[Symbol.toStringTag],o=Symbol.toStringTag in e?e[Symbol.toStringTag]:(r=e.constructor)===null||r===void 0?void 0:r.name;if(s===o){const i=te(e);throw new Error(`Cannot use ${s} "${i}" from another module or realm.

Ensure that there is only one instance of "graphql" in the node_modules
directory. If different versions of "graphql" are the dependencies of other
relied on modules, use "resolutions" to ensure only one version is installed.

https://yarnpkg.com/en/docs/selective-version-resolutions

Duplicate "graphql" modules cannot be used at the same time since different
versions may have different capabilities and behavior. The data from one
version used in the function from another could produce confusing and
spurious results.`)}}return!1};class Ua{constructor(e,n="GraphQL request",r={line:1,column:1}){typeof e=="string"||$e(!1,`Body must be a string. Received: ${te(e)}.`),this.body=e,this.name=n,this.locationOffset=r,this.locationOffset.line>0||$e(!1,"line in locationOffset is 1-indexed and must be positive."),this.locationOffset.column>0||$e(!1,"column in locationOffset is 1-indexed and must be positive.")}get[Symbol.toStringTag](){return"Source"}}function y2(t){return pn(t,Ua)}function Va(t,e){return new g2(t,e).parseDocument()}let g2=class{constructor(e,n={}){const r=y2(e)?e:new Ua(e);this._lexer=new n2(r),this._options=n,this._tokenCounter=0}parseName(){const e=this.expectToken(z.NAME);return this.node(e,{kind:I.NAME,value:e.value})}parseDocument(){return this.node(this._lexer.token,{kind:I.DOCUMENT,definitions:this.many(z.SOF,this.parseDefinition,z.EOF)})}parseDefinition(){if(this.peek(z.BRACE_L))return this.parseOperationDefinition();const e=this.peekDescription(),n=e?this._lexer.lookahead():this._lexer.token;if(n.kind===z.NAME){switch(n.value){case"schema":return this.parseSchemaDefinition();case"scalar":return this.parseScalarTypeDefinition();case"type":return this.parseObjectTypeDefinition();case"interface":return this.parseInterfaceTypeDefinition();case"union":return this.parseUnionTypeDefinition();case"enum":return this.parseEnumTypeDefinition();case"input":return this.parseInputObjectTypeDefinition();case"directive":return this.parseDirectiveDefinition()}if(e)throw vt(this._lexer.source,this._lexer.token.start,"Unexpected description, descriptions are supported only on type definitions.");switch(n.value){case"query":case"mutation":case"subscription":return this.parseOperationDefinition();case"fragment":return this.parseFragmentDefinition();case"extend":return this.parseTypeSystemExtension()}}throw this.unexpected(n)}parseOperationDefinition(){const e=this._lexer.token;if(this.peek(z.BRACE_L))return this.node(e,{kind:I.OPERATION_DEFINITION,operation:At.QUERY,name:void 0,variableDefinitions:[],directives:[],selectionSet:this.parseSelectionSet()});const n=this.parseOperationType();let r;return this.peek(z.NAME)&&(r=this.parseName()),this.node(e,{kind:I.OPERATION_DEFINITION,operation:n,name:r,variableDefinitions:this.parseVariableDefinitions(),directives:this.parseDirectives(!1),selectionSet:this.parseSelectionSet()})}parseOperationType(){const e=this.expectToken(z.NAME);switch(e.value){case"query":return At.QUERY;case"mutation":return At.MUTATION;case"subscription":return At.SUBSCRIPTION}throw this.unexpected(e)}parseVariableDefinitions(){return this.optionalMany(z.PAREN_L,this.parseVariableDefinition,z.PAREN_R)}parseVariableDefinition(){return this.node(this._lexer.token,{kind:I.VARIABLE_DEFINITION,variable:this.parseVariable(),type:(this.expectToken(z.COLON),this.parseTypeReference()),defaultValue:this.expectOptionalToken(z.EQUALS)?this.parseConstValueLiteral():void 0,directives:this.parseConstDirectives()})}parseVariable(){const e=this._lexer.token;return this.expectToken(z.DOLLAR),this.node(e,{kind:I.VARIABLE,name:this.parseName()})}parseSelectionSet(){return this.node(this._lexer.token,{kind:I.SELECTION_SET,selections:this.many(z.BRACE_L,this.parseSelection,z.BRACE_R)})}parseSelection(){return this.peek(z.SPREAD)?this.parseFragment():this.parseField()}parseField(){const e=this._lexer.token,n=this.parseName();let r,s;return this.expectOptionalToken(z.COLON)?(r=n,s=this.parseName()):s=n,this.node(e,{kind:I.FIELD,alias:r,name:s,arguments:this.parseArguments(!1),directives:this.parseDirectives(!1),selectionSet:this.peek(z.BRACE_L)?this.parseSelectionSet():void 0})}parseArguments(e){const n=e?this.parseConstArgument:this.parseArgument;return this.optionalMany(z.PAREN_L,n,z.PAREN_R)}parseArgument(e=!1){const n=this._lexer.token,r=this.parseName();return this.expectToken(z.COLON),this.node(n,{kind:I.ARGUMENT,name:r,value:this.parseValueLiteral(e)})}parseConstArgument(){return this.parseArgument(!0)}parseFragment(){const e=this._lexer.token;this.expectToken(z.SPREAD);const n=this.expectOptionalKeyword("on");return!n&&this.peek(z.NAME)?this.node(e,{kind:I.FRAGMENT_SPREAD,name:this.parseFragmentName(),directives:this.parseDirectives(!1)}):this.node(e,{kind:I.INLINE_FRAGMENT,typeCondition:n?this.parseNamedType():void 0,directives:this.parseDirectives(!1),selectionSet:this.parseSelectionSet()})}parseFragmentDefinition(){const e=this._lexer.token;return this.expectKeyword("fragment"),this._options.allowLegacyFragmentVariables===!0?this.node(e,{kind:I.FRAGMENT_DEFINITION,name:this.parseFragmentName(),variableDefinitions:this.parseVariableDefinitions(),typeCondition:(this.expectKeyword("on"),this.parseNamedType()),directives:this.parseDirectives(!1),selectionSet:this.parseSelectionSet()}):this.node(e,{kind:I.FRAGMENT_DEFINITION,name:this.parseFragmentName(),typeCondition:(this.expectKeyword("on"),this.parseNamedType()),directives:this.parseDirectives(!1),selectionSet:this.parseSelectionSet()})}parseFragmentName(){if(this._lexer.token.value==="on")throw this.unexpected();return this.parseName()}parseValueLiteral(e){const n=this._lexer.token;switch(n.kind){case z.BRACKET_L:return this.parseList(e);case z.BRACE_L:return this.parseObject(e);case z.INT:return this.advanceLexer(),this.node(n,{kind:I.INT,value:n.value});case z.FLOAT:return this.advanceLexer(),this.node(n,{kind:I.FLOAT,value:n.value});case z.STRING:case z.BLOCK_STRING:return this.parseStringLiteral();case z.NAME:switch(this.advanceLexer(),n.value){case"true":return this.node(n,{kind:I.BOOLEAN,value:!0});case"false":return this.node(n,{kind:I.BOOLEAN,value:!1});case"null":return this.node(n,{kind:I.NULL});default:return this.node(n,{kind:I.ENUM,value:n.value})}case z.DOLLAR:if(e)if(this.expectToken(z.DOLLAR),this._lexer.token.kind===z.NAME){const r=this._lexer.token.value;throw vt(this._lexer.source,n.start,`Unexpected variable "$${r}" in constant value.`)}else throw this.unexpected(n);return this.parseVariable();default:throw this.unexpected()}}parseConstValueLiteral(){return this.parseValueLiteral(!0)}parseStringLiteral(){const e=this._lexer.token;return this.advanceLexer(),this.node(e,{kind:I.STRING,value:e.value,block:e.kind===z.BLOCK_STRING})}parseList(e){const n=()=>this.parseValueLiteral(e);return this.node(this._lexer.token,{kind:I.LIST,values:this.any(z.BRACKET_L,n,z.BRACKET_R)})}parseObject(e){const n=()=>this.parseObjectField(e);return this.node(this._lexer.token,{kind:I.OBJECT,fields:this.any(z.BRACE_L,n,z.BRACE_R)})}parseObjectField(e){const n=this._lexer.token,r=this.parseName();return this.expectToken(z.COLON),this.node(n,{kind:I.OBJECT_FIELD,name:r,value:this.parseValueLiteral(e)})}parseDirectives(e){const n=[];for(;this.peek(z.AT);)n.push(this.parseDirective(e));return n}parseConstDirectives(){return this.parseDirectives(!0)}parseDirective(e){const n=this._lexer.token;return this.expectToken(z.AT),this.node(n,{kind:I.DIRECTIVE,name:this.parseName(),arguments:this.parseArguments(e)})}parseTypeReference(){const e=this._lexer.token;let n;if(this.expectOptionalToken(z.BRACKET_L)){const r=this.parseTypeReference();this.expectToken(z.BRACKET_R),n=this.node(e,{kind:I.LIST_TYPE,type:r})}else n=this.parseNamedType();return this.expectOptionalToken(z.BANG)?this.node(e,{kind:I.NON_NULL_TYPE,type:n}):n}parseNamedType(){return this.node(this._lexer.token,{kind:I.NAMED_TYPE,name:this.parseName()})}peekDescription(){return this.peek(z.STRING)||this.peek(z.BLOCK_STRING)}parseDescription(){if(this.peekDescription())return this.parseStringLiteral()}parseSchemaDefinition(){const e=this._lexer.token,n=this.parseDescription();this.expectKeyword("schema");const r=this.parseConstDirectives(),s=this.many(z.BRACE_L,this.parseOperationTypeDefinition,z.BRACE_R);return this.node(e,{kind:I.SCHEMA_DEFINITION,description:n,directives:r,operationTypes:s})}parseOperationTypeDefinition(){const e=this._lexer.token,n=this.parseOperationType();this.expectToken(z.COLON);const r=this.parseNamedType();return this.node(e,{kind:I.OPERATION_TYPE_DEFINITION,operation:n,type:r})}parseScalarTypeDefinition(){const e=this._lexer.token,n=this.parseDescription();this.expectKeyword("scalar");const r=this.parseName(),s=this.parseConstDirectives();return this.node(e,{kind:I.SCALAR_TYPE_DEFINITION,description:n,name:r,directives:s})}parseObjectTypeDefinition(){const e=this._lexer.token,n=this.parseDescription();this.expectKeyword("type");const r=this.parseName(),s=this.parseImplementsInterfaces(),o=this.parseConstDirectives(),i=this.parseFieldsDefinition();return this.node(e,{kind:I.OBJECT_TYPE_DEFINITION,description:n,name:r,interfaces:s,directives:o,fields:i})}parseImplementsInterfaces(){return this.expectOptionalKeyword("implements")?this.delimitedMany(z.AMP,this.parseNamedType):[]}parseFieldsDefinition(){return this.optionalMany(z.BRACE_L,this.parseFieldDefinition,z.BRACE_R)}parseFieldDefinition(){const e=this._lexer.token,n=this.parseDescription(),r=this.parseName(),s=this.parseArgumentDefs();this.expectToken(z.COLON);const o=this.parseTypeReference(),i=this.parseConstDirectives();return this.node(e,{kind:I.FIELD_DEFINITION,description:n,name:r,arguments:s,type:o,directives:i})}parseArgumentDefs(){return this.optionalMany(z.PAREN_L,this.parseInputValueDef,z.PAREN_R)}parseInputValueDef(){const e=this._lexer.token,n=this.parseDescription(),r=this.parseName();this.expectToken(z.COLON);const s=this.parseTypeReference();let o;this.expectOptionalToken(z.EQUALS)&&(o=this.parseConstValueLiteral());const i=this.parseConstDirectives();return this.node(e,{kind:I.INPUT_VALUE_DEFINITION,description:n,name:r,type:s,defaultValue:o,directives:i})}parseInterfaceTypeDefinition(){const e=this._lexer.token,n=this.parseDescription();this.expectKeyword("interface");const r=this.parseName(),s=this.parseImplementsInterfaces(),o=this.parseConstDirectives(),i=this.parseFieldsDefinition();return this.node(e,{kind:I.INTERFACE_TYPE_DEFINITION,description:n,name:r,interfaces:s,directives:o,fields:i})}parseUnionTypeDefinition(){const e=this._lexer.token,n=this.parseDescription();this.expectKeyword("union");const r=this.parseName(),s=this.parseConstDirectives(),o=this.parseUnionMemberTypes();return this.node(e,{kind:I.UNION_TYPE_DEFINITION,description:n,name:r,directives:s,types:o})}parseUnionMemberTypes(){return this.expectOptionalToken(z.EQUALS)?this.delimitedMany(z.PIPE,this.parseNamedType):[]}parseEnumTypeDefinition(){const e=this._lexer.token,n=this.parseDescription();this.expectKeyword("enum");const r=this.parseName(),s=this.parseConstDirectives(),o=this.parseEnumValuesDefinition();return this.node(e,{kind:I.ENUM_TYPE_DEFINITION,description:n,name:r,directives:s,values:o})}parseEnumValuesDefinition(){return this.optionalMany(z.BRACE_L,this.parseEnumValueDefinition,z.BRACE_R)}parseEnumValueDefinition(){const e=this._lexer.token,n=this.parseDescription(),r=this.parseEnumValueName(),s=this.parseConstDirectives();return this.node(e,{kind:I.ENUM_VALUE_DEFINITION,description:n,name:r,directives:s})}parseEnumValueName(){if(this._lexer.token.value==="true"||this._lexer.token.value==="false"||this._lexer.token.value==="null")throw vt(this._lexer.source,this._lexer.token.start,`${Qs(this._lexer.token)} is reserved and cannot be used for an enum value.`);return this.parseName()}parseInputObjectTypeDefinition(){const e=this._lexer.token,n=this.parseDescription();this.expectKeyword("input");const r=this.parseName(),s=this.parseConstDirectives(),o=this.parseInputFieldsDefinition();return this.node(e,{kind:I.INPUT_OBJECT_TYPE_DEFINITION,description:n,name:r,directives:s,fields:o})}parseInputFieldsDefinition(){return this.optionalMany(z.BRACE_L,this.parseInputValueDef,z.BRACE_R)}parseTypeSystemExtension(){const e=this._lexer.lookahead();if(e.kind===z.NAME)switch(e.value){case"schema":return this.parseSchemaExtension();case"scalar":return this.parseScalarTypeExtension();case"type":return this.parseObjectTypeExtension();case"interface":return this.parseInterfaceTypeExtension();case"union":return this.parseUnionTypeExtension();case"enum":return this.parseEnumTypeExtension();case"input":return this.parseInputObjectTypeExtension()}throw this.unexpected(e)}parseSchemaExtension(){const e=this._lexer.token;this.expectKeyword("extend"),this.expectKeyword("schema");const n=this.parseConstDirectives(),r=this.optionalMany(z.BRACE_L,this.parseOperationTypeDefinition,z.BRACE_R);if(n.length===0&&r.length===0)throw this.unexpected();return this.node(e,{kind:I.SCHEMA_EXTENSION,directives:n,operationTypes:r})}parseScalarTypeExtension(){const e=this._lexer.token;this.expectKeyword("extend"),this.expectKeyword("scalar");const n=this.parseName(),r=this.parseConstDirectives();if(r.length===0)throw this.unexpected();return this.node(e,{kind:I.SCALAR_TYPE_EXTENSION,name:n,directives:r})}parseObjectTypeExtension(){const e=this._lexer.token;this.expectKeyword("extend"),this.expectKeyword("type");const n=this.parseName(),r=this.parseImplementsInterfaces(),s=this.parseConstDirectives(),o=this.parseFieldsDefinition();if(r.length===0&&s.length===0&&o.length===0)throw this.unexpected();return this.node(e,{kind:I.OBJECT_TYPE_EXTENSION,name:n,interfaces:r,directives:s,fields:o})}parseInterfaceTypeExtension(){const e=this._lexer.token;this.expectKeyword("extend"),this.expectKeyword("interface");const n=this.parseName(),r=this.parseImplementsInterfaces(),s=this.parseConstDirectives(),o=this.parseFieldsDefinition();if(r.length===0&&s.length===0&&o.length===0)throw this.unexpected();return this.node(e,{kind:I.INTERFACE_TYPE_EXTENSION,name:n,interfaces:r,directives:s,fields:o})}parseUnionTypeExtension(){const e=this._lexer.token;this.expectKeyword("extend"),this.expectKeyword("union");const n=this.parseName(),r=this.parseConstDirectives(),s=this.parseUnionMemberTypes();if(r.length===0&&s.length===0)throw this.unexpected();return this.node(e,{kind:I.UNION_TYPE_EXTENSION,name:n,directives:r,types:s})}parseEnumTypeExtension(){const e=this._lexer.token;this.expectKeyword("extend"),this.expectKeyword("enum");const n=this.parseName(),r=this.parseConstDirectives(),s=this.parseEnumValuesDefinition();if(r.length===0&&s.length===0)throw this.unexpected();return this.node(e,{kind:I.ENUM_TYPE_EXTENSION,name:n,directives:r,values:s})}parseInputObjectTypeExtension(){const e=this._lexer.token;this.expectKeyword("extend"),this.expectKeyword("input");const n=this.parseName(),r=this.parseConstDirectives(),s=this.parseInputFieldsDefinition();if(r.length===0&&s.length===0)throw this.unexpected();return this.node(e,{kind:I.INPUT_OBJECT_TYPE_EXTENSION,name:n,directives:r,fields:s})}parseDirectiveDefinition(){const e=this._lexer.token,n=this.parseDescription();this.expectKeyword("directive"),this.expectToken(z.AT);const r=this.parseName(),s=this.parseArgumentDefs(),o=this.expectOptionalKeyword("repeatable");this.expectKeyword("on");const i=this.parseDirectiveLocations();return this.node(e,{kind:I.DIRECTIVE_DEFINITION,description:n,name:r,arguments:s,repeatable:o,locations:i})}parseDirectiveLocations(){return this.delimitedMany(z.PIPE,this.parseDirectiveLocation)}parseDirectiveLocation(){const e=this._lexer.token,n=this.parseName();if(Object.prototype.hasOwnProperty.call(fe,n.value))return n;throw this.unexpected(e)}node(e,n){return this._options.noLocation!==!0&&(n.loc=new Yh(e,this._lexer.lastToken,this._lexer.source)),n}peek(e){return this._lexer.token.kind===e}expectToken(e){const n=this._lexer.token;if(n.kind===e)return this.advanceLexer(),n;throw vt(this._lexer.source,n.start,`Expected ${q1(e)}, found ${Qs(n)}.`)}expectOptionalToken(e){return this._lexer.token.kind===e?(this.advanceLexer(),!0):!1}expectKeyword(e){const n=this._lexer.token;if(n.kind===z.NAME&&n.value===e)this.advanceLexer();else throw vt(this._lexer.source,n.start,`Expected "${e}", found ${Qs(n)}.`)}expectOptionalKeyword(e){const n=this._lexer.token;return n.kind===z.NAME&&n.value===e?(this.advanceLexer(),!0):!1}unexpected(e){const n=e??this._lexer.token;return vt(this._lexer.source,n.start,`Unexpected ${Qs(n)}.`)}any(e,n,r){this.expectToken(e);const s=[];for(;!this.expectOptionalToken(r);)s.push(n.call(this));return s}optionalMany(e,n,r){if(this.expectOptionalToken(e)){const s=[];do s.push(n.call(this));while(!this.expectOptionalToken(r));return s}return[]}many(e,n,r){this.expectToken(e);const s=[];do s.push(n.call(this));while(!this.expectOptionalToken(r));return s}delimitedMany(e,n){this.expectOptionalToken(e);const r=[];do r.push(n.call(this));while(this.expectOptionalToken(e));return r}advanceLexer(){const{maxTokens:e}=this._options,n=this._lexer.advance();if(e!==void 0&&n.kind!==z.EOF&&(++this._tokenCounter,this._tokenCounter>e))throw vt(this._lexer.source,n.start,`Document contains more that ${e} tokens. Parsing aborted.`)}};function Qs(t){const e=t.value;return q1(t.kind)+(e!=null?` "${e}"`:"")}function q1(t){return r2(t)?`"${t}"`:t}const v2=5;function Nn(t,e){const[n,r]=e?[t,e]:[void 0,t];let s=" Did you mean ";n&&(s+=n+" ");const o=r.map(u=>`"${u}"`);switch(o.length){case 0:return"";case 1:return s+o[0]+"?";case 2:return s+o[0]+" or "+o[1]+"?"}const i=o.slice(0,v2),a=i.pop();return s+i.join(", ")+", or "+a+"?"}function vc(t){return t}function mr(t,e){const n=Object.create(null);for(const r of t)n[e(r)]=r;return n}function Ja(t,e,n){const r=Object.create(null);for(const s of t)r[e(s)]=n(s);return r}function wn(t,e){const n=Object.create(null);for(const r of Object.keys(t))n[r]=e(t[r],r);return n}function Ha(t,e){let n=0,r=0;for(;n<t.length&&r<e.length;){let s=t.charCodeAt(n),o=e.charCodeAt(r);if(eo(s)&&eo(o)){let i=0;do++n,i=i*10+s-sa,s=t.charCodeAt(n);while(eo(s)&&i>0);let a=0;do++r,a=a*10+o-sa,o=e.charCodeAt(r);while(eo(o)&&a>0);if(i<a)return-1;if(i>a)return 1}else{if(s<o)return-1;if(s>o)return 1;++n,++r}}return t.length-e.length}const sa=48,A2=57;function eo(t){return!isNaN(t)&&sa<=t&&t<=A2}function Yn(t,e){const n=Object.create(null),r=new b2(t),s=Math.floor(t.length*.4)+1;for(const o of e){const i=r.measure(o,s);i!==void 0&&(n[o]=i)}return Object.keys(n).sort((o,i)=>{const a=n[o]-n[i];return a!==0?a:Ha(o,i)})}class b2{constructor(e){this._input=e,this._inputLowerCase=e.toLowerCase(),this._inputArray=Ac(this._inputLowerCase),this._rows=[new Array(e.length+1).fill(0),new Array(e.length+1).fill(0),new Array(e.length+1).fill(0)]}measure(e,n){if(this._input===e)return 0;const r=e.toLowerCase();if(this._inputLowerCase===r)return 1;let s=Ac(r),o=this._inputArray;if(s.length<o.length){const l=s;s=o,o=l}const i=s.length,a=o.length;if(i-a>n)return;const u=this._rows;for(let l=0;l<=a;l++)u[0][l]=l;for(let l=1;l<=i;l++){const p=u[(l-1)%3],d=u[l%3];let f=d[0]=l;for(let S=1;S<=a;S++){const b=s[l-1]===o[S-1]?0:1;let F=Math.min(p[S]+1,d[S-1]+1,p[S-1]+b);if(l>1&&S>1&&s[l-1]===o[S-2]&&s[l-2]===o[S-1]){const y=u[(l-2)%3][S-2];F=Math.min(F,y+1)}F<f&&(f=F),d[S]=F}if(f>n)return}const c=u[i%3][a];return c<=n?c:void 0}}function Ac(t){const e=t.length,n=new Array(e);for(let r=0;r<e;++r)n[r]=t.charCodeAt(r);return n}function Yt(t){if(t==null)return Object.create(null);if(Object.getPrototypeOf(t)===null)return t;const e=Object.create(null);for(const[n,r]of Object.entries(t))e[n]=r;return e}function C2(t){return`"${t.replace(T2,w2)}"`}const T2=/[\x00-\x1f\x22\x5c\x7f-\x9f]/g;function w2(t){return F2[t.charCodeAt(0)]}const F2=["\\u0000","\\u0001","\\u0002","\\u0003","\\u0004","\\u0005","\\u0006","\\u0007","\\b","\\t","\\n","\\u000B","\\f","\\r","\\u000E","\\u000F","\\u0010","\\u0011","\\u0012","\\u0013","\\u0014","\\u0015","\\u0016","\\u0017","\\u0018","\\u0019","\\u001A","\\u001B","\\u001C","\\u001D","\\u001E","\\u001F","","",'\\"',"","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","\\\\","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","\\u007F","\\u0080","\\u0081","\\u0082","\\u0083","\\u0084","\\u0085","\\u0086","\\u0087","\\u0088","\\u0089","\\u008A","\\u008B","\\u008C","\\u008D","\\u008E","\\u008F","\\u0090","\\u0091","\\u0092","\\u0093","\\u0094","\\u0095","\\u0096","\\u0097","\\u0098","\\u0099","\\u009A","\\u009B","\\u009C","\\u009D","\\u009E","\\u009F"],ls=Object.freeze({});function Rs(t,e,n=_1){const r=new Map;for(const y of Object.values(I))r.set(y,Co(e,y));let s,o=Array.isArray(t),i=[t],a=-1,u=[],c=t,l,p;const d=[],f=[];do{a++;const y=a===i.length,T=y&&u.length!==0;if(y){if(l=f.length===0?void 0:d[d.length-1],c=p,p=f.pop(),T)if(o){c=c.slice();let j=0;for(const[M,ee]of u){const ne=M-j;ee===null?(c.splice(ne,1),j++):c[ne]=ee}}else{c=Object.defineProperties({},Object.getOwnPropertyDescriptors(c));for(const[j,M]of u)c[j]=M}a=s.index,i=s.keys,u=s.edits,o=s.inArray,s=s.prev}else if(p){if(l=o?a:i[a],c=p[l],c==null)continue;d.push(l)}let O;if(!Array.isArray(c)){var S,b;na(c)||$e(!1,`Invalid AST Node: ${te(c)}.`);const j=y?(S=r.get(c.kind))===null||S===void 0?void 0:S.leave:(b=r.get(c.kind))===null||b===void 0?void 0:b.enter;if(O=j==null?void 0:j.call(e,c,l,p,d,f),O===ls)break;if(O===!1){if(!y){d.pop();continue}}else if(O!==void 0&&(u.push([l,O]),!y))if(na(O))c=O;else{d.pop();continue}}if(O===void 0&&T&&u.push([l,c]),y)d.pop();else{var F;s={inArray:o,index:a,keys:i,edits:u,prev:s},o=Array.isArray(c),i=o?c:(F=n[c.kind])!==null&&F!==void 0?F:[],a=-1,u=[],p&&f.push(p),p=c}}while(s!==void 0);return u.length!==0?u[u.length-1][1]:t}function M1(t){const e=new Array(t.length).fill(null),n=Object.create(null);for(const r of Object.values(I)){let s=!1;const o=new Array(t.length).fill(void 0),i=new Array(t.length).fill(void 0);for(let u=0;u<t.length;++u){const{enter:c,leave:l}=Co(t[u],r);s||(s=c!=null||l!=null),o[u]=c,i[u]=l}if(!s)continue;const a={enter(...u){const c=u[0];for(let p=0;p<t.length;p++)if(e[p]===null){var l;const d=(l=o[p])===null||l===void 0?void 0:l.apply(t[p],u);if(d===!1)e[p]=c;else if(d===ls)e[p]=ls;else if(d!==void 0)return d}},leave(...u){const c=u[0];for(let p=0;p<t.length;p++)if(e[p]===null){var l;const d=(l=i[p])===null||l===void 0?void 0:l.apply(t[p],u);if(d===ls)e[p]=ls;else if(d!==void 0&&d!==!1)return d}else e[p]===c&&(e[p]=null)}};n[r]=a}return n}function Co(t,e){const n=t[e];return typeof n=="object"?n:typeof n=="function"?{enter:n,leave:void 0}:{enter:t.enter,leave:t.leave}}function mt(t){return Rs(t,k2)}const I2=80,k2={Name:{leave:t=>t.value},Variable:{leave:t=>"$"+t.name},Document:{leave:t=>ie(t.definitions,`

`)},OperationDefinition:{leave(t){const e=Oe("(",ie(t.variableDefinitions,", "),")"),n=ie([t.operation,ie([t.name,e]),ie(t.directives," ")]," ");return(n==="query"?"":n+" ")+t.selectionSet}},VariableDefinition:{leave:({variable:t,type:e,defaultValue:n,directives:r})=>t+": "+e+Oe(" = ",n)+Oe(" ",ie(r," "))},SelectionSet:{leave:({selections:t})=>Qt(t)},Field:{leave({alias:t,name:e,arguments:n,directives:r,selectionSet:s}){const o=Oe("",t,": ")+e;let i=o+Oe("(",ie(n,", "),")");return i.length>I2&&(i=o+Oe(`(
`,So(ie(n,`
`)),`
)`)),ie([i,ie(r," "),s]," ")}},Argument:{leave:({name:t,value:e})=>t+": "+e},FragmentSpread:{leave:({name:t,directives:e})=>"..."+t+Oe(" ",ie(e," "))},InlineFragment:{leave:({typeCondition:t,directives:e,selectionSet:n})=>ie(["...",Oe("on ",t),ie(e," "),n]," ")},FragmentDefinition:{leave:({name:t,typeCondition:e,variableDefinitions:n,directives:r,selectionSet:s})=>`fragment ${t}${Oe("(",ie(n,", "),")")} on ${e} ${Oe("",ie(r," ")," ")}`+s},IntValue:{leave:({value:t})=>t},FloatValue:{leave:({value:t})=>t},StringValue:{leave:({value:t,block:e})=>e?t2(t):C2(t)},BooleanValue:{leave:({value:t})=>t?"true":"false"},NullValue:{leave:()=>"null"},EnumValue:{leave:({value:t})=>t},ListValue:{leave:({values:t})=>"["+ie(t,", ")+"]"},ObjectValue:{leave:({fields:t})=>"{"+ie(t,", ")+"}"},ObjectField:{leave:({name:t,value:e})=>t+": "+e},Directive:{leave:({name:t,arguments:e})=>"@"+t+Oe("(",ie(e,", "),")")},NamedType:{leave:({name:t})=>t},ListType:{leave:({type:t})=>"["+t+"]"},NonNullType:{leave:({type:t})=>t+"!"},SchemaDefinition:{leave:({description:t,directives:e,operationTypes:n})=>Oe("",t,`
`)+ie(["schema",ie(e," "),Qt(n)]," ")},OperationTypeDefinition:{leave:({operation:t,type:e})=>t+": "+e},ScalarTypeDefinition:{leave:({description:t,name:e,directives:n})=>Oe("",t,`
`)+ie(["scalar",e,ie(n," ")]," ")},ObjectTypeDefinition:{leave:({description:t,name:e,interfaces:n,directives:r,fields:s})=>Oe("",t,`
`)+ie(["type",e,Oe("implements ",ie(n," & ")),ie(r," "),Qt(s)]," ")},FieldDefinition:{leave:({description:t,name:e,arguments:n,type:r,directives:s})=>Oe("",t,`
`)+e+(bc(n)?Oe(`(
`,So(ie(n,`
`)),`
)`):Oe("(",ie(n,", "),")"))+": "+r+Oe(" ",ie(s," "))},InputValueDefinition:{leave:({description:t,name:e,type:n,defaultValue:r,directives:s})=>Oe("",t,`
`)+ie([e+": "+n,Oe("= ",r),ie(s," ")]," ")},InterfaceTypeDefinition:{leave:({description:t,name:e,interfaces:n,directives:r,fields:s})=>Oe("",t,`
`)+ie(["interface",e,Oe("implements ",ie(n," & ")),ie(r," "),Qt(s)]," ")},UnionTypeDefinition:{leave:({description:t,name:e,directives:n,types:r})=>Oe("",t,`
`)+ie(["union",e,ie(n," "),Oe("= ",ie(r," | "))]," ")},EnumTypeDefinition:{leave:({description:t,name:e,directives:n,values:r})=>Oe("",t,`
`)+ie(["enum",e,ie(n," "),Qt(r)]," ")},EnumValueDefinition:{leave:({description:t,name:e,directives:n})=>Oe("",t,`
`)+ie([e,ie(n," ")]," ")},InputObjectTypeDefinition:{leave:({description:t,name:e,directives:n,fields:r})=>Oe("",t,`
`)+ie(["input",e,ie(n," "),Qt(r)]," ")},DirectiveDefinition:{leave:({description:t,name:e,arguments:n,repeatable:r,locations:s})=>Oe("",t,`
`)+"directive @"+e+(bc(n)?Oe(`(
`,So(ie(n,`
`)),`
)`):Oe("(",ie(n,", "),")"))+(r?" repeatable":"")+" on "+ie(s," | ")},SchemaExtension:{leave:({directives:t,operationTypes:e})=>ie(["extend schema",ie(t," "),Qt(e)]," ")},ScalarTypeExtension:{leave:({name:t,directives:e})=>ie(["extend scalar",t,ie(e," ")]," ")},ObjectTypeExtension:{leave:({name:t,interfaces:e,directives:n,fields:r})=>ie(["extend type",t,Oe("implements ",ie(e," & ")),ie(n," "),Qt(r)]," ")},InterfaceTypeExtension:{leave:({name:t,interfaces:e,directives:n,fields:r})=>ie(["extend interface",t,Oe("implements ",ie(e," & ")),ie(n," "),Qt(r)]," ")},UnionTypeExtension:{leave:({name:t,directives:e,types:n})=>ie(["extend union",t,ie(e," "),Oe("= ",ie(n," | "))]," ")},EnumTypeExtension:{leave:({name:t,directives:e,values:n})=>ie(["extend enum",t,ie(e," "),Qt(n)]," ")},InputObjectTypeExtension:{leave:({name:t,directives:e,fields:n})=>ie(["extend input",t,ie(e," "),Qt(n)]," ")}};function ie(t,e=""){var n;return(n=t==null?void 0:t.filter(r=>r).join(e))!==null&&n!==void 0?n:""}function Qt(t){return Oe(`{
`,So(ie(t,`
`)),`
}`)}function Oe(t,e,n=""){return e!=null&&e!==""?t+e+n:""}function So(t){return Oe("  ",t.replace(/\n/g,`
  `))}function bc(t){var e;return(e=t==null?void 0:t.some(n=>n.includes(`
`)))!==null&&e!==void 0?e:!1}function oa(t,e){switch(t.kind){case I.NULL:return null;case I.INT:return parseInt(t.value,10);case I.FLOAT:return parseFloat(t.value);case I.STRING:case I.ENUM:case I.BOOLEAN:return t.value;case I.LIST:return t.values.map(n=>oa(n,e));case I.OBJECT:return Ja(t.fields,n=>n.name.value,n=>oa(n.value,e));case I.VARIABLE:return e==null?void 0:e[t.name.value]}}function dn(t){if(t!=null||$e(!1,"Must provide name."),typeof t=="string"||$e(!1,"Expected name to be a string."),t.length===0)throw new X("Expected name to be a non-empty string.");for(let e=1;e<t.length;++e)if(!$1(t.charCodeAt(e)))throw new X(`Names must only contain [_a-zA-Z0-9] but "${t}" does not.`);if(!Ga(t.charCodeAt(0)))throw new X(`Names must start with [_a-zA-Z] but "${t}" does not.`);return t}function P2(t){if(t==="true"||t==="false"||t==="null")throw new X(`Enum values cannot be named: ${t}`);return dn(t)}function Wa(t){return Vt(t)||ge(t)||Be(t)||Ct(t)||Et(t)||Ye(t)||lt(t)||Fe(t)}function Vt(t){return pn(t,vn)}function ge(t){return pn(t,Lt)}function Be(t){return pn(t,Xn)}function Ct(t){return pn(t,ws)}function Et(t){return pn(t,An)}function Ye(t){return pn(t,Dr)}function lt(t){return pn(t,Ft)}function Fe(t){return pn(t,Ce)}function on(t){return Vt(t)||Et(t)||Ye(t)||Ka(t)&&on(t.ofType)}function Ds(t){return Vt(t)||ge(t)||Be(t)||Ct(t)||Et(t)||Ka(t)&&Ds(t.ofType)}function zt(t){return Vt(t)||Et(t)}function Kn(t){return ge(t)||Be(t)||Ct(t)}function Jn(t){return Be(t)||Ct(t)}class Ft{constructor(e){Wa(e)||$e(!1,`Expected ${te(e)} to be a GraphQL type.`),this.ofType=e}get[Symbol.toStringTag](){return"GraphQLList"}toString(){return"["+String(this.ofType)+"]"}toJSON(){return this.toString()}}class Ce{constructor(e){N2(e)||$e(!1,`Expected ${te(e)} to be a GraphQL nullable type.`),this.ofType=e}get[Symbol.toStringTag](){return"GraphQLNonNull"}toString(){return String(this.ofType)+"!"}toJSON(){return this.toString()}}function Ka(t){return lt(t)||Fe(t)}function N2(t){return Wa(t)&&!Fe(t)}function Xa(t){if(t)return Fe(t)?t.ofType:t}function ei(t){return Vt(t)||ge(t)||Be(t)||Ct(t)||Et(t)||Ye(t)}function qt(t){if(t){let e=t;for(;Ka(e);)e=e.ofType;return e}}function L1(t){return typeof t=="function"?t():t}function j1(t){return typeof t=="function"?t():t}class vn{constructor(e){var n,r,s,o;const i=(n=e.parseValue)!==null&&n!==void 0?n:vc;this.name=dn(e.name),this.description=e.description,this.specifiedByURL=e.specifiedByURL,this.serialize=(r=e.serialize)!==null&&r!==void 0?r:vc,this.parseValue=i,this.parseLiteral=(s=e.parseLiteral)!==null&&s!==void 0?s:(a,u)=>i(oa(a,u)),this.extensions=Yt(e.extensions),this.astNode=e.astNode,this.extensionASTNodes=(o=e.extensionASTNodes)!==null&&o!==void 0?o:[],e.specifiedByURL==null||typeof e.specifiedByURL=="string"||$e(!1,`${this.name} must provide "specifiedByURL" as a string, but got: ${te(e.specifiedByURL)}.`),e.serialize==null||typeof e.serialize=="function"||$e(!1,`${this.name} must provide "serialize" function. If this custom Scalar is also used as an input type, ensure "parseValue" and "parseLiteral" functions are also provided.`),e.parseLiteral&&(typeof e.parseValue=="function"&&typeof e.parseLiteral=="function"||$e(!1,`${this.name} must provide both "parseValue" and "parseLiteral" functions.`))}get[Symbol.toStringTag](){return"GraphQLScalarType"}toConfig(){return{name:this.name,description:this.description,specifiedByURL:this.specifiedByURL,serialize:this.serialize,parseValue:this.parseValue,parseLiteral:this.parseLiteral,extensions:this.extensions,astNode:this.astNode,extensionASTNodes:this.extensionASTNodes}}toString(){return this.name}toJSON(){return this.toString()}}class Lt{constructor(e){var n;this.name=dn(e.name),this.description=e.description,this.isTypeOf=e.isTypeOf,this.extensions=Yt(e.extensions),this.astNode=e.astNode,this.extensionASTNodes=(n=e.extensionASTNodes)!==null&&n!==void 0?n:[],this._fields=()=>U1(e),this._interfaces=()=>G1(e),e.isTypeOf==null||typeof e.isTypeOf=="function"||$e(!1,`${this.name} must provide "isTypeOf" as a function, but got: ${te(e.isTypeOf)}.`)}get[Symbol.toStringTag](){return"GraphQLObjectType"}getFields(){return typeof this._fields=="function"&&(this._fields=this._fields()),this._fields}getInterfaces(){return typeof this._interfaces=="function"&&(this._interfaces=this._interfaces()),this._interfaces}toConfig(){return{name:this.name,description:this.description,interfaces:this.getInterfaces(),fields:J1(this.getFields()),isTypeOf:this.isTypeOf,extensions:this.extensions,astNode:this.astNode,extensionASTNodes:this.extensionASTNodes}}toString(){return this.name}toJSON(){return this.toString()}}function G1(t){var e;const n=L1((e=t.interfaces)!==null&&e!==void 0?e:[]);return Array.isArray(n)||$e(!1,`${t.name} interfaces must be an Array or a function which returns an Array.`),n}function U1(t){const e=j1(t.fields);return Vr(e)||$e(!1,`${t.name} fields must be an object with field names as keys or a function which returns such an object.`),wn(e,(n,r)=>{var s;Vr(n)||$e(!1,`${t.name}.${r} field config must be an object.`),n.resolve==null||typeof n.resolve=="function"||$e(!1,`${t.name}.${r} field resolver must be a function if provided, but got: ${te(n.resolve)}.`);const o=(s=n.args)!==null&&s!==void 0?s:{};return Vr(o)||$e(!1,`${t.name}.${r} args must be an object with argument names as keys.`),{name:dn(r),description:n.description,type:n.type,args:V1(o),resolve:n.resolve,subscribe:n.subscribe,deprecationReason:n.deprecationReason,extensions:Yt(n.extensions),astNode:n.astNode}})}function V1(t){return Object.entries(t).map(([e,n])=>({name:dn(e),description:n.description,type:n.type,defaultValue:n.defaultValue,deprecationReason:n.deprecationReason,extensions:Yt(n.extensions),astNode:n.astNode}))}function Vr(t){return ln(t)&&!Array.isArray(t)}function J1(t){return wn(t,e=>({description:e.description,type:e.type,args:H1(e.args),resolve:e.resolve,subscribe:e.subscribe,deprecationReason:e.deprecationReason,extensions:e.extensions,astNode:e.astNode}))}function H1(t){return Ja(t,e=>e.name,e=>({description:e.description,type:e.type,defaultValue:e.defaultValue,deprecationReason:e.deprecationReason,extensions:e.extensions,astNode:e.astNode}))}function xs(t){return Fe(t.type)&&t.defaultValue===void 0}class Xn{constructor(e){var n;this.name=dn(e.name),this.description=e.description,this.resolveType=e.resolveType,this.extensions=Yt(e.extensions),this.astNode=e.astNode,this.extensionASTNodes=(n=e.extensionASTNodes)!==null&&n!==void 0?n:[],this._fields=U1.bind(void 0,e),this._interfaces=G1.bind(void 0,e),e.resolveType==null||typeof e.resolveType=="function"||$e(!1,`${this.name} must provide "resolveType" as a function, but got: ${te(e.resolveType)}.`)}get[Symbol.toStringTag](){return"GraphQLInterfaceType"}getFields(){return typeof this._fields=="function"&&(this._fields=this._fields()),this._fields}getInterfaces(){return typeof this._interfaces=="function"&&(this._interfaces=this._interfaces()),this._interfaces}toConfig(){return{name:this.name,description:this.description,interfaces:this.getInterfaces(),fields:J1(this.getFields()),resolveType:this.resolveType,extensions:this.extensions,astNode:this.astNode,extensionASTNodes:this.extensionASTNodes}}toString(){return this.name}toJSON(){return this.toString()}}class ws{constructor(e){var n;this.name=dn(e.name),this.description=e.description,this.resolveType=e.resolveType,this.extensions=Yt(e.extensions),this.astNode=e.astNode,this.extensionASTNodes=(n=e.extensionASTNodes)!==null&&n!==void 0?n:[],this._types=_2.bind(void 0,e),e.resolveType==null||typeof e.resolveType=="function"||$e(!1,`${this.name} must provide "resolveType" as a function, but got: ${te(e.resolveType)}.`)}get[Symbol.toStringTag](){return"GraphQLUnionType"}getTypes(){return typeof this._types=="function"&&(this._types=this._types()),this._types}toConfig(){return{name:this.name,description:this.description,types:this.getTypes(),resolveType:this.resolveType,extensions:this.extensions,astNode:this.astNode,extensionASTNodes:this.extensionASTNodes}}toString(){return this.name}toJSON(){return this.toString()}}function _2(t){const e=L1(t.types);return Array.isArray(e)||$e(!1,`Must provide Array of types or a function which returns such an array for Union ${t.name}.`),e}class An{constructor(e){var n;this.name=dn(e.name),this.description=e.description,this.extensions=Yt(e.extensions),this.astNode=e.astNode,this.extensionASTNodes=(n=e.extensionASTNodes)!==null&&n!==void 0?n:[],this._values=O2(this.name,e.values),this._valueLookup=new Map(this._values.map(r=>[r.value,r])),this._nameLookup=mr(this._values,r=>r.name)}get[Symbol.toStringTag](){return"GraphQLEnumType"}getValues(){return this._values}getValue(e){return this._nameLookup[e]}serialize(e){const n=this._valueLookup.get(e);if(n===void 0)throw new X(`Enum "${this.name}" cannot represent value: ${te(e)}`);return n.name}parseValue(e){if(typeof e!="string"){const r=te(e);throw new X(`Enum "${this.name}" cannot represent non-string value: ${r}.`+to(this,r))}const n=this.getValue(e);if(n==null)throw new X(`Value "${e}" does not exist in "${this.name}" enum.`+to(this,e));return n.value}parseLiteral(e,n){if(e.kind!==I.ENUM){const s=mt(e);throw new X(`Enum "${this.name}" cannot represent non-enum value: ${s}.`+to(this,s),{nodes:e})}const r=this.getValue(e.value);if(r==null){const s=mt(e);throw new X(`Value "${s}" does not exist in "${this.name}" enum.`+to(this,s),{nodes:e})}return r.value}toConfig(){const e=Ja(this.getValues(),n=>n.name,n=>({description:n.description,value:n.value,deprecationReason:n.deprecationReason,extensions:n.extensions,astNode:n.astNode}));return{name:this.name,description:this.description,values:e,extensions:this.extensions,astNode:this.astNode,extensionASTNodes:this.extensionASTNodes}}toString(){return this.name}toJSON(){return this.toString()}}function to(t,e){const n=t.getValues().map(s=>s.name),r=Yn(e,n);return Nn("the enum value",r)}function O2(t,e){return Vr(e)||$e(!1,`${t} values must be an object with value names as keys.`),Object.entries(e).map(([n,r])=>(Vr(r)||$e(!1,`${t}.${n} must refer to an object with a "value" key representing an internal value but got: ${te(r)}.`),{name:P2(n),description:r.description,value:r.value!==void 0?r.value:n,deprecationReason:r.deprecationReason,extensions:Yt(r.extensions),astNode:r.astNode}))}class Dr{constructor(e){var n;this.name=dn(e.name),this.description=e.description,this.extensions=Yt(e.extensions),this.astNode=e.astNode,this.extensionASTNodes=(n=e.extensionASTNodes)!==null&&n!==void 0?n:[],this._fields=$2.bind(void 0,e)}get[Symbol.toStringTag](){return"GraphQLInputObjectType"}getFields(){return typeof this._fields=="function"&&(this._fields=this._fields()),this._fields}toConfig(){const e=wn(this.getFields(),n=>({description:n.description,type:n.type,defaultValue:n.defaultValue,deprecationReason:n.deprecationReason,extensions:n.extensions,astNode:n.astNode}));return{name:this.name,description:this.description,fields:e,extensions:this.extensions,astNode:this.astNode,extensionASTNodes:this.extensionASTNodes}}toString(){return this.name}toJSON(){return this.toString()}}function $2(t){const e=j1(t.fields);return Vr(e)||$e(!1,`${t.name} fields must be an object with field names as keys or a function which returns such an object.`),wn(e,(n,r)=>(!("resolve"in n)||$e(!1,`${t.name}.${r} field has a resolve property, but Input Types cannot define resolvers.`),{name:dn(r),description:n.description,type:n.type,defaultValue:n.defaultValue,deprecationReason:n.deprecationReason,extensions:Yt(n.extensions),astNode:n.astNode}))}function W1(t){return Fe(t.type)&&t.defaultValue===void 0}function ia(t,e){return t===e?!0:Fe(t)&&Fe(e)||lt(t)&&lt(e)?ia(t.ofType,e.ofType):!1}function Jr(t,e,n){return e===n?!0:Fe(n)?Fe(e)?Jr(t,e.ofType,n.ofType):!1:Fe(e)?Jr(t,e.ofType,n):lt(n)?lt(e)?Jr(t,e.ofType,n.ofType):!1:lt(e)?!1:Jn(n)&&(Be(e)||ge(e))&&t.isSubType(n,e)}function Cc(t,e,n){return e===n?!0:Jn(e)?Jn(n)?t.getPossibleTypes(e).some(r=>t.isSubType(n,r)):t.isSubType(e,n):Jn(n)?t.isSubType(n,e):!1}const Ai=2147483647,bi=-2147483648,aa=new vn({name:"Int",description:"The `Int` scalar type represents non-fractional signed whole numeric values. Int can represent values between -(2^31) and 2^31 - 1.",serialize(t){const e=Ms(t);if(typeof e=="boolean")return e?1:0;let n=e;if(typeof e=="string"&&e!==""&&(n=Number(e)),typeof n!="number"||!Number.isInteger(n))throw new X(`Int cannot represent non-integer value: ${te(e)}`);if(n>Ai||n<bi)throw new X("Int cannot represent non 32-bit signed integer value: "+te(e));return n},parseValue(t){if(typeof t!="number"||!Number.isInteger(t))throw new X(`Int cannot represent non-integer value: ${te(t)}`);if(t>Ai||t<bi)throw new X(`Int cannot represent non 32-bit signed integer value: ${t}`);return t},parseLiteral(t){if(t.kind!==I.INT)throw new X(`Int cannot represent non-integer value: ${mt(t)}`,{nodes:t});const e=parseInt(t.value,10);if(e>Ai||e<bi)throw new X(`Int cannot represent non 32-bit signed integer value: ${t.value}`,{nodes:t});return e}}),ua=new vn({name:"Float",description:"The `Float` scalar type represents signed double-precision fractional values as specified by [IEEE 754](https://en.wikipedia.org/wiki/IEEE_floating_point).",serialize(t){const e=Ms(t);if(typeof e=="boolean")return e?1:0;let n=e;if(typeof e=="string"&&e!==""&&(n=Number(e)),typeof n!="number"||!Number.isFinite(n))throw new X(`Float cannot represent non numeric value: ${te(e)}`);return n},parseValue(t){if(typeof t!="number"||!Number.isFinite(t))throw new X(`Float cannot represent non numeric value: ${te(t)}`);return t},parseLiteral(t){if(t.kind!==I.FLOAT&&t.kind!==I.INT)throw new X(`Float cannot represent non numeric value: ${mt(t)}`,t);return parseFloat(t.value)}}),ct=new vn({name:"String",description:"The `String` scalar type represents textual data, represented as UTF-8 character sequences. The String type is most often used by GraphQL to represent free-form human-readable text.",serialize(t){const e=Ms(t);if(typeof e=="string")return e;if(typeof e=="boolean")return e?"true":"false";if(typeof e=="number"&&Number.isFinite(e))return e.toString();throw new X(`String cannot represent value: ${te(t)}`)},parseValue(t){if(typeof t!="string")throw new X(`String cannot represent a non string value: ${te(t)}`);return t},parseLiteral(t){if(t.kind!==I.STRING)throw new X(`String cannot represent a non string value: ${mt(t)}`,{nodes:t});return t.value}}),Mt=new vn({name:"Boolean",description:"The `Boolean` scalar type represents `true` or `false`.",serialize(t){const e=Ms(t);if(typeof e=="boolean")return e;if(Number.isFinite(e))return e!==0;throw new X(`Boolean cannot represent a non boolean value: ${te(e)}`)},parseValue(t){if(typeof t!="boolean")throw new X(`Boolean cannot represent a non boolean value: ${te(t)}`);return t},parseLiteral(t){if(t.kind!==I.BOOLEAN)throw new X(`Boolean cannot represent a non boolean value: ${mt(t)}`,{nodes:t});return t.value}}),To=new vn({name:"ID",description:'The `ID` scalar type represents a unique identifier, often used to refetch an object or as key for a cache. The ID type appears in a JSON response as a String; however, it is not intended to be human-readable. When expected as an input type, any string (such as `"4"`) or integer (such as `4`) input value will be accepted as an ID.',serialize(t){const e=Ms(t);if(typeof e=="string")return e;if(Number.isInteger(e))return String(e);throw new X(`ID cannot represent value: ${te(t)}`)},parseValue(t){if(typeof t=="string")return t;if(typeof t=="number"&&Number.isInteger(t))return t.toString();throw new X(`ID cannot represent value: ${te(t)}`)},parseLiteral(t){if(t.kind!==I.STRING&&t.kind!==I.INT)throw new X("ID cannot represent a non-string and non-integer value: "+mt(t),{nodes:t});return t.value}}),za=Object.freeze([ct,aa,ua,Mt,To]);function qs(t){return za.some(({name:e})=>t.name===e)}function Ms(t){if(ln(t)){if(typeof t.valueOf=="function"){const e=t.valueOf();if(!ln(e))return e}if(typeof t.toJSON=="function")return t.toJSON()}return t}function K1(t){return pn(t,zn)}class zn{constructor(e){var n,r;this.name=dn(e.name),this.description=e.description,this.locations=e.locations,this.isRepeatable=(n=e.isRepeatable)!==null&&n!==void 0?n:!1,this.extensions=Yt(e.extensions),this.astNode=e.astNode,Array.isArray(e.locations)||$e(!1,`@${e.name} locations must be an Array.`);const s=(r=e.args)!==null&&r!==void 0?r:{};ln(s)&&!Array.isArray(s)||$e(!1,`@${e.name} args must be an object with argument names as keys.`),this.args=V1(s)}get[Symbol.toStringTag](){return"GraphQLDirective"}toConfig(){return{name:this.name,description:this.description,locations:this.locations,args:H1(this.args),isRepeatable:this.isRepeatable,extensions:this.extensions,astNode:this.astNode}}toString(){return"@"+this.name}toJSON(){return this.toString()}}const X1=new zn({name:"include",description:"Directs the executor to include this field or fragment only when the `if` argument is true.",locations:[fe.FIELD,fe.FRAGMENT_SPREAD,fe.INLINE_FRAGMENT],args:{if:{type:new Ce(Mt),description:"Included when true."}}}),z1=new zn({name:"skip",description:"Directs the executor to skip this field or fragment when the `if` argument is true.",locations:[fe.FIELD,fe.FRAGMENT_SPREAD,fe.INLINE_FRAGMENT],args:{if:{type:new Ce(Mt),description:"Skipped when true."}}}),B2="No longer supported",ti=new zn({name:"deprecated",description:"Marks an element of a GraphQL schema as no longer supported.",locations:[fe.FIELD_DEFINITION,fe.ARGUMENT_DEFINITION,fe.INPUT_FIELD_DEFINITION,fe.ENUM_VALUE],args:{reason:{type:ct,description:"Explains why this element was deprecated, usually also including a suggestion for how to access supported similar data. Formatted using the Markdown syntax, as specified by [CommonMark](https://commonmark.org/).",defaultValue:B2}}}),Y1=new zn({name:"specifiedBy",description:"Exposes a URL that specifies the behavior of this scalar.",locations:[fe.SCALAR],args:{url:{type:new Ce(ct),description:"The URL that specifies the behavior of this scalar."}}}),vr=Object.freeze([X1,z1,ti,Y1]);function Z1(t){return vr.some(({name:e})=>e===t.name)}function Ya(t){return typeof t=="object"&&typeof(t==null?void 0:t[Symbol.iterator])=="function"}function Gn(t,e){if(Fe(e)){const n=Gn(t,e.ofType);return(n==null?void 0:n.kind)===I.NULL?null:n}if(t===null)return{kind:I.NULL};if(t===void 0)return null;if(lt(e)){const n=e.ofType;if(Ya(t)){const r=[];for(const s of t){const o=Gn(s,n);o!=null&&r.push(o)}return{kind:I.LIST,values:r}}return Gn(t,n)}if(Ye(e)){if(!ln(t))return null;const n=[];for(const r of Object.values(e.getFields())){const s=Gn(t[r.name],r.type);s&&n.push({kind:I.OBJECT_FIELD,name:{kind:I.NAME,value:r.name},value:s})}return{kind:I.OBJECT,fields:n}}if(zt(e)){const n=e.serialize(t);if(n==null)return null;if(typeof n=="boolean")return{kind:I.BOOLEAN,value:n};if(typeof n=="number"&&Number.isFinite(n)){const r=String(n);return Tc.test(r)?{kind:I.INT,value:r}:{kind:I.FLOAT,value:r}}if(typeof n=="string")return Et(e)?{kind:I.ENUM,value:n}:e===To&&Tc.test(n)?{kind:I.INT,value:n}:{kind:I.STRING,value:n};throw new TypeError(`Cannot convert value to AST: ${te(n)}.`)}Gt(!1,"Unexpected input type: "+te(e))}const Tc=/^-?(?:0|[1-9][0-9]*)$/,Za=new Lt({name:"__Schema",description:"A GraphQL Schema defines the capabilities of a GraphQL server. It exposes all available types and directives on the server, as well as the entry points for query, mutation, and subscription operations.",fields:()=>({description:{type:ct,resolve:t=>t.description},types:{description:"A list of all types supported by this server.",type:new Ce(new Ft(new Ce(un))),resolve(t){return Object.values(t.getTypeMap())}},queryType:{description:"The type that query operations will be rooted at.",type:new Ce(un),resolve:t=>t.getQueryType()},mutationType:{description:"If this server supports mutation, the type that mutation operations will be rooted at.",type:un,resolve:t=>t.getMutationType()},subscriptionType:{description:"If this server support subscription, the type that subscription operations will be rooted at.",type:un,resolve:t=>t.getSubscriptionType()},directives:{description:"A list of all directives supported by this server.",type:new Ce(new Ft(new Ce(Q1))),resolve:t=>t.getDirectives()}})}),Q1=new Lt({name:"__Directive",description:`A Directive provides a way to describe alternate runtime execution and type validation behavior in a GraphQL document.

In some cases, you need to provide options to alter GraphQL's execution behavior in ways field arguments will not suffice, such as conditionally including or skipping a field. Directives provide this by describing additional information to the executor.`,fields:()=>({name:{type:new Ce(ct),resolve:t=>t.name},description:{type:ct,resolve:t=>t.description},isRepeatable:{type:new Ce(Mt),resolve:t=>t.isRepeatable},locations:{type:new Ce(new Ft(new Ce(ep))),resolve:t=>t.locations},args:{type:new Ce(new Ft(new Ce(ni))),args:{includeDeprecated:{type:Mt,defaultValue:!1}},resolve(t,{includeDeprecated:e}){return e?t.args:t.args.filter(n=>n.deprecationReason==null)}}})}),ep=new An({name:"__DirectiveLocation",description:"A Directive can be adjacent to many parts of the GraphQL language, a __DirectiveLocation describes one such possible adjacencies.",values:{QUERY:{value:fe.QUERY,description:"Location adjacent to a query operation."},MUTATION:{value:fe.MUTATION,description:"Location adjacent to a mutation operation."},SUBSCRIPTION:{value:fe.SUBSCRIPTION,description:"Location adjacent to a subscription operation."},FIELD:{value:fe.FIELD,description:"Location adjacent to a field."},FRAGMENT_DEFINITION:{value:fe.FRAGMENT_DEFINITION,description:"Location adjacent to a fragment definition."},FRAGMENT_SPREAD:{value:fe.FRAGMENT_SPREAD,description:"Location adjacent to a fragment spread."},INLINE_FRAGMENT:{value:fe.INLINE_FRAGMENT,description:"Location adjacent to an inline fragment."},VARIABLE_DEFINITION:{value:fe.VARIABLE_DEFINITION,description:"Location adjacent to a variable definition."},SCHEMA:{value:fe.SCHEMA,description:"Location adjacent to a schema definition."},SCALAR:{value:fe.SCALAR,description:"Location adjacent to a scalar definition."},OBJECT:{value:fe.OBJECT,description:"Location adjacent to an object type definition."},FIELD_DEFINITION:{value:fe.FIELD_DEFINITION,description:"Location adjacent to a field definition."},ARGUMENT_DEFINITION:{value:fe.ARGUMENT_DEFINITION,description:"Location adjacent to an argument definition."},INTERFACE:{value:fe.INTERFACE,description:"Location adjacent to an interface definition."},UNION:{value:fe.UNION,description:"Location adjacent to a union definition."},ENUM:{value:fe.ENUM,description:"Location adjacent to an enum definition."},ENUM_VALUE:{value:fe.ENUM_VALUE,description:"Location adjacent to an enum value definition."},INPUT_OBJECT:{value:fe.INPUT_OBJECT,description:"Location adjacent to an input object type definition."},INPUT_FIELD_DEFINITION:{value:fe.INPUT_FIELD_DEFINITION,description:"Location adjacent to an input object field definition."}}}),un=new Lt({name:"__Type",description:"The fundamental unit of any GraphQL Schema is the type. There are many kinds of types in GraphQL as represented by the `__TypeKind` enum.\n\nDepending on the kind of a type, certain fields describe information about that type. Scalar types provide no information beyond a name, description and optional `specifiedByURL`, while Enum types provide their values. Object and Interface types provide the fields they describe. Abstract types, Union and Interface, provide the Object types possible at runtime. List and NonNull types compose other types.",fields:()=>({kind:{type:new Ce(rp),resolve(t){if(Vt(t))return gt.SCALAR;if(ge(t))return gt.OBJECT;if(Be(t))return gt.INTERFACE;if(Ct(t))return gt.UNION;if(Et(t))return gt.ENUM;if(Ye(t))return gt.INPUT_OBJECT;if(lt(t))return gt.LIST;if(Fe(t))return gt.NON_NULL;Gt(!1,`Unexpected type: "${te(t)}".`)}},name:{type:ct,resolve:t=>"name"in t?t.name:void 0},description:{type:ct,resolve:t=>"description"in t?t.description:void 0},specifiedByURL:{type:ct,resolve:t=>"specifiedByURL"in t?t.specifiedByURL:void 0},fields:{type:new Ft(new Ce(tp)),args:{includeDeprecated:{type:Mt,defaultValue:!1}},resolve(t,{includeDeprecated:e}){if(ge(t)||Be(t)){const n=Object.values(t.getFields());return e?n:n.filter(r=>r.deprecationReason==null)}}},interfaces:{type:new Ft(new Ce(un)),resolve(t){if(ge(t)||Be(t))return t.getInterfaces()}},possibleTypes:{type:new Ft(new Ce(un)),resolve(t,e,n,{schema:r}){if(Jn(t))return r.getPossibleTypes(t)}},enumValues:{type:new Ft(new Ce(np)),args:{includeDeprecated:{type:Mt,defaultValue:!1}},resolve(t,{includeDeprecated:e}){if(Et(t)){const n=t.getValues();return e?n:n.filter(r=>r.deprecationReason==null)}}},inputFields:{type:new Ft(new Ce(ni)),args:{includeDeprecated:{type:Mt,defaultValue:!1}},resolve(t,{includeDeprecated:e}){if(Ye(t)){const n=Object.values(t.getFields());return e?n:n.filter(r=>r.deprecationReason==null)}}},ofType:{type:un,resolve:t=>"ofType"in t?t.ofType:void 0}})}),tp=new Lt({name:"__Field",description:"Object and Interface types are described by a list of Fields, each of which has a name, potentially a list of arguments, and a return type.",fields:()=>({name:{type:new Ce(ct),resolve:t=>t.name},description:{type:ct,resolve:t=>t.description},args:{type:new Ce(new Ft(new Ce(ni))),args:{includeDeprecated:{type:Mt,defaultValue:!1}},resolve(t,{includeDeprecated:e}){return e?t.args:t.args.filter(n=>n.deprecationReason==null)}},type:{type:new Ce(un),resolve:t=>t.type},isDeprecated:{type:new Ce(Mt),resolve:t=>t.deprecationReason!=null},deprecationReason:{type:ct,resolve:t=>t.deprecationReason}})}),ni=new Lt({name:"__InputValue",description:"Arguments provided to Fields or Directives and the input fields of an InputObject are represented as Input Values which describe their type and optionally a default value.",fields:()=>({name:{type:new Ce(ct),resolve:t=>t.name},description:{type:ct,resolve:t=>t.description},type:{type:new Ce(un),resolve:t=>t.type},defaultValue:{type:ct,description:"A GraphQL-formatted string representing the default value for this input value.",resolve(t){const{type:e,defaultValue:n}=t,r=Gn(n,e);return r?mt(r):null}},isDeprecated:{type:new Ce(Mt),resolve:t=>t.deprecationReason!=null},deprecationReason:{type:ct,resolve:t=>t.deprecationReason}})}),np=new Lt({name:"__EnumValue",description:"One possible value for a given Enum. Enum values are unique values, not a placeholder for a string or numeric value. However an Enum value is returned in a JSON response as a string.",fields:()=>({name:{type:new Ce(ct),resolve:t=>t.name},description:{type:ct,resolve:t=>t.description},isDeprecated:{type:new Ce(Mt),resolve:t=>t.deprecationReason!=null},deprecationReason:{type:ct,resolve:t=>t.deprecationReason}})});var gt;(function(t){t.SCALAR="SCALAR",t.OBJECT="OBJECT",t.INTERFACE="INTERFACE",t.UNION="UNION",t.ENUM="ENUM",t.INPUT_OBJECT="INPUT_OBJECT",t.LIST="LIST",t.NON_NULL="NON_NULL"})(gt||(gt={}));const rp=new An({name:"__TypeKind",description:"An enum describing what kind of type a given `__Type` is.",values:{SCALAR:{value:gt.SCALAR,description:"Indicates this type is a scalar."},OBJECT:{value:gt.OBJECT,description:"Indicates this type is an object. `fields` and `interfaces` are valid fields."},INTERFACE:{value:gt.INTERFACE,description:"Indicates this type is an interface. `fields`, `interfaces`, and `possibleTypes` are valid fields."},UNION:{value:gt.UNION,description:"Indicates this type is a union. `possibleTypes` is a valid field."},ENUM:{value:gt.ENUM,description:"Indicates this type is an enum. `enumValues` is a valid field."},INPUT_OBJECT:{value:gt.INPUT_OBJECT,description:"Indicates this type is an input object. `inputFields` is a valid field."},LIST:{value:gt.LIST,description:"Indicates this type is a list. `ofType` is a valid field."},NON_NULL:{value:gt.NON_NULL,description:"Indicates this type is a non-null. `ofType` is a valid field."}}}),wo={name:"__schema",type:new Ce(Za),description:"Access the current type schema of this server.",args:[],resolve:(t,e,n,{schema:r})=>r,deprecationReason:void 0,extensions:Object.create(null),astNode:void 0},Fo={name:"__type",type:un,description:"Request the type information of a single type.",args:[{name:"name",description:void 0,type:new Ce(ct),defaultValue:void 0,deprecationReason:void 0,extensions:Object.create(null),astNode:void 0}],resolve:(t,{name:e},n,{schema:r})=>r.getType(e),deprecationReason:void 0,extensions:Object.create(null),astNode:void 0},Io={name:"__typename",type:new Ce(ct),description:"The name of the current Object type at runtime.",args:[],resolve:(t,e,n,{parentType:r})=>r.name,deprecationReason:void 0,extensions:Object.create(null),astNode:void 0},Qa=Object.freeze([Za,Q1,ep,un,tp,ni,np,rp]);function eu(t){return Qa.some(({name:e})=>t.name===e)}function tu(t){return pn(t,nu)}function R2(t){if(!tu(t))throw new Error(`Expected ${te(t)} to be a GraphQL schema.`);return t}class nu{constructor(e){var n,r;this.__validationErrors=e.assumeValid===!0?[]:void 0,ln(e)||$e(!1,"Must provide configuration object."),!e.types||Array.isArray(e.types)||$e(!1,`"types" must be Array if provided but got: ${te(e.types)}.`),!e.directives||Array.isArray(e.directives)||$e(!1,`"directives" must be Array if provided but got: ${te(e.directives)}.`),this.description=e.description,this.extensions=Yt(e.extensions),this.astNode=e.astNode,this.extensionASTNodes=(n=e.extensionASTNodes)!==null&&n!==void 0?n:[],this._queryType=e.query,this._mutationType=e.mutation,this._subscriptionType=e.subscription,this._directives=(r=e.directives)!==null&&r!==void 0?r:vr;const s=new Set(e.types);if(e.types!=null)for(const o of e.types)s.delete(o),sn(o,s);this._queryType!=null&&sn(this._queryType,s),this._mutationType!=null&&sn(this._mutationType,s),this._subscriptionType!=null&&sn(this._subscriptionType,s);for(const o of this._directives)if(K1(o))for(const i of o.args)sn(i.type,s);sn(Za,s),this._typeMap=Object.create(null),this._subTypeMap=Object.create(null),this._implementationsMap=Object.create(null);for(const o of s){if(o==null)continue;const i=o.name;if(i||$e(!1,"One of the provided types for building the Schema is missing a name."),this._typeMap[i]!==void 0)throw new Error(`Schema must contain uniquely named types but contains multiple types named "${i}".`);if(this._typeMap[i]=o,Be(o)){for(const a of o.getInterfaces())if(Be(a)){let u=this._implementationsMap[a.name];u===void 0&&(u=this._implementationsMap[a.name]={objects:[],interfaces:[]}),u.interfaces.push(o)}}else if(ge(o)){for(const a of o.getInterfaces())if(Be(a)){let u=this._implementationsMap[a.name];u===void 0&&(u=this._implementationsMap[a.name]={objects:[],interfaces:[]}),u.objects.push(o)}}}}get[Symbol.toStringTag](){return"GraphQLSchema"}getQueryType(){return this._queryType}getMutationType(){return this._mutationType}getSubscriptionType(){return this._subscriptionType}getRootType(e){switch(e){case At.QUERY:return this.getQueryType();case At.MUTATION:return this.getMutationType();case At.SUBSCRIPTION:return this.getSubscriptionType()}}getTypeMap(){return this._typeMap}getType(e){return this.getTypeMap()[e]}getPossibleTypes(e){return Ct(e)?e.getTypes():this.getImplementations(e).objects}getImplementations(e){const n=this._implementationsMap[e.name];return n??{objects:[],interfaces:[]}}isSubType(e,n){let r=this._subTypeMap[e.name];if(r===void 0){if(r=Object.create(null),Ct(e))for(const s of e.getTypes())r[s.name]=!0;else{const s=this.getImplementations(e);for(const o of s.objects)r[o.name]=!0;for(const o of s.interfaces)r[o.name]=!0}this._subTypeMap[e.name]=r}return r[n.name]!==void 0}getDirectives(){return this._directives}getDirective(e){return this.getDirectives().find(n=>n.name===e)}toConfig(){return{description:this.description,query:this.getQueryType(),mutation:this.getMutationType(),subscription:this.getSubscriptionType(),types:Object.values(this.getTypeMap()),directives:this.getDirectives(),extensions:this.extensions,astNode:this.astNode,extensionASTNodes:this.extensionASTNodes,assumeValid:this.__validationErrors!==void 0}}}function sn(t,e){const n=qt(t);if(!e.has(n)){if(e.add(n),Ct(n))for(const r of n.getTypes())sn(r,e);else if(ge(n)||Be(n)){for(const r of n.getInterfaces())sn(r,e);for(const r of Object.values(n.getFields())){sn(r.type,e);for(const s of r.args)sn(s.type,e)}}else if(Ye(n))for(const r of Object.values(n.getFields()))sn(r.type,e)}return e}function sp(t){if(R2(t),t.__validationErrors)return t.__validationErrors;const e=new x2(t);q2(e),M2(e),L2(e);const n=e.getErrors();return t.__validationErrors=n,n}function op(t){const e=sp(t);if(e.length!==0)throw new Error(e.map(n=>n.message).join(`

`))}class x2{constructor(e){this._errors=[],this.schema=e}reportError(e,n){const r=Array.isArray(n)?n.filter(Boolean):n;this._errors.push(new X(e,{nodes:r}))}getErrors(){return this._errors}}function q2(t){const e=t.schema,n=e.getQueryType();if(!n)t.reportError("Query root type must be provided.",e.astNode);else if(!ge(n)){var r;t.reportError(`Query root type must be Object type, it cannot be ${te(n)}.`,(r=Ci(e,At.QUERY))!==null&&r!==void 0?r:n.astNode)}const s=e.getMutationType();if(s&&!ge(s)){var o;t.reportError(`Mutation root type must be Object type if provided, it cannot be ${te(s)}.`,(o=Ci(e,At.MUTATION))!==null&&o!==void 0?o:s.astNode)}const i=e.getSubscriptionType();if(i&&!ge(i)){var a;t.reportError(`Subscription root type must be Object type if provided, it cannot be ${te(i)}.`,(a=Ci(e,At.SUBSCRIPTION))!==null&&a!==void 0?a:i.astNode)}}function Ci(t,e){var n;return(n=[t.astNode,...t.extensionASTNodes].flatMap(r=>{var s;return(s=r==null?void 0:r.operationTypes)!==null&&s!==void 0?s:[]}).find(r=>r.operation===e))===null||n===void 0?void 0:n.type}function M2(t){for(const n of t.schema.getDirectives()){if(!K1(n)){t.reportError(`Expected directive but got: ${te(n)}.`,n==null?void 0:n.astNode);continue}Sr(t,n);for(const r of n.args)if(Sr(t,r),on(r.type)||t.reportError(`The type of @${n.name}(${r.name}:) must be Input Type but got: ${te(r.type)}.`,r.astNode),xs(r)&&r.deprecationReason!=null){var e;t.reportError(`Required argument @${n.name}(${r.name}:) cannot be deprecated.`,[ru(r.astNode),(e=r.astNode)===null||e===void 0?void 0:e.type])}}}function Sr(t,e){e.name.startsWith("__")&&t.reportError(`Name "${e.name}" must not begin with "__", which is reserved by GraphQL introspection.`,e.astNode)}function L2(t){const e=H2(t),n=t.schema.getTypeMap();for(const r of Object.values(n)){if(!ei(r)){t.reportError(`Expected GraphQL named type but got: ${te(r)}.`,r.astNode);continue}eu(r)||Sr(t,r),ge(r)||Be(r)?(wc(t,r),Fc(t,r)):Ct(r)?U2(t,r):Et(r)?V2(t,r):Ye(r)&&(J2(t,r),e(r))}}function wc(t,e){const n=Object.values(e.getFields());n.length===0&&t.reportError(`Type ${e.name} must define one or more fields.`,[e.astNode,...e.extensionASTNodes]);for(const i of n){if(Sr(t,i),!Ds(i.type)){var r;t.reportError(`The type of ${e.name}.${i.name} must be Output Type but got: ${te(i.type)}.`,(r=i.astNode)===null||r===void 0?void 0:r.type)}for(const a of i.args){const u=a.name;if(Sr(t,a),!on(a.type)){var s;t.reportError(`The type of ${e.name}.${i.name}(${u}:) must be Input Type but got: ${te(a.type)}.`,(s=a.astNode)===null||s===void 0?void 0:s.type)}if(xs(a)&&a.deprecationReason!=null){var o;t.reportError(`Required argument ${e.name}.${i.name}(${u}:) cannot be deprecated.`,[ru(a.astNode),(o=a.astNode)===null||o===void 0?void 0:o.type])}}}}function Fc(t,e){const n=Object.create(null);for(const r of e.getInterfaces()){if(!Be(r)){t.reportError(`Type ${te(e)} must only implement Interface types, it cannot implement ${te(r)}.`,Ss(e,r));continue}if(e===r){t.reportError(`Type ${e.name} cannot implement itself because it would create a circular reference.`,Ss(e,r));continue}if(n[r.name]){t.reportError(`Type ${e.name} can only implement ${r.name} once.`,Ss(e,r));continue}n[r.name]=!0,G2(t,e,r),j2(t,e,r)}}function j2(t,e,n){const r=e.getFields();for(const u of Object.values(n.getFields())){const c=u.name,l=r[c];if(!l){t.reportError(`Interface field ${n.name}.${c} expected but ${e.name} does not provide it.`,[u.astNode,e.astNode,...e.extensionASTNodes]);continue}if(!Jr(t.schema,l.type,u.type)){var s,o;t.reportError(`Interface field ${n.name}.${c} expects type ${te(u.type)} but ${e.name}.${c} is type ${te(l.type)}.`,[(s=u.astNode)===null||s===void 0?void 0:s.type,(o=l.astNode)===null||o===void 0?void 0:o.type])}for(const p of u.args){const d=p.name,f=l.args.find(S=>S.name===d);if(!f){t.reportError(`Interface field argument ${n.name}.${c}(${d}:) expected but ${e.name}.${c} does not provide it.`,[p.astNode,l.astNode]);continue}if(!ia(p.type,f.type)){var i,a;t.reportError(`Interface field argument ${n.name}.${c}(${d}:) expects type ${te(p.type)} but ${e.name}.${c}(${d}:) is type ${te(f.type)}.`,[(i=p.astNode)===null||i===void 0?void 0:i.type,(a=f.astNode)===null||a===void 0?void 0:a.type])}}for(const p of l.args){const d=p.name;!u.args.find(S=>S.name===d)&&xs(p)&&t.reportError(`Object field ${e.name}.${c} includes required argument ${d} that is missing from the Interface field ${n.name}.${c}.`,[p.astNode,u.astNode])}}}function G2(t,e,n){const r=e.getInterfaces();for(const s of n.getInterfaces())r.includes(s)||t.reportError(s===e?`Type ${e.name} cannot implement ${n.name} because it would create a circular reference.`:`Type ${e.name} must implement ${s.name} because it is implemented by ${n.name}.`,[...Ss(n,s),...Ss(e,n)])}function U2(t,e){const n=e.getTypes();n.length===0&&t.reportError(`Union type ${e.name} must define one or more member types.`,[e.astNode,...e.extensionASTNodes]);const r=Object.create(null);for(const s of n){if(r[s.name]){t.reportError(`Union type ${e.name} can only include type ${s.name} once.`,Ic(e,s.name));continue}r[s.name]=!0,ge(s)||t.reportError(`Union type ${e.name} can only include Object types, it cannot include ${te(s)}.`,Ic(e,String(s)))}}function V2(t,e){const n=e.getValues();n.length===0&&t.reportError(`Enum type ${e.name} must define one or more values.`,[e.astNode,...e.extensionASTNodes]);for(const r of n)Sr(t,r)}function J2(t,e){const n=Object.values(e.getFields());n.length===0&&t.reportError(`Input Object type ${e.name} must define one or more fields.`,[e.astNode,...e.extensionASTNodes]);for(const o of n){if(Sr(t,o),!on(o.type)){var r;t.reportError(`The type of ${e.name}.${o.name} must be Input Type but got: ${te(o.type)}.`,(r=o.astNode)===null||r===void 0?void 0:r.type)}if(W1(o)&&o.deprecationReason!=null){var s;t.reportError(`Required input field ${e.name}.${o.name} cannot be deprecated.`,[ru(o.astNode),(s=o.astNode)===null||s===void 0?void 0:s.type])}}}function H2(t){const e=Object.create(null),n=[],r=Object.create(null);return s;function s(o){if(e[o.name])return;e[o.name]=!0,r[o.name]=n.length;const i=Object.values(o.getFields());for(const a of i)if(Fe(a.type)&&Ye(a.type.ofType)){const u=a.type.ofType,c=r[u.name];if(n.push(a),c===void 0)s(u);else{const l=n.slice(c),p=l.map(d=>d.name).join(".");t.reportError(`Cannot reference Input Object "${u.name}" within itself through a series of non-null fields: "${p}".`,l.map(d=>d.astNode))}n.pop()}r[o.name]=void 0}}function Ss(t,e){const{astNode:n,extensionASTNodes:r}=t;return(n!=null?[n,...r]:r).flatMap(o=>{var i;return(i=o.interfaces)!==null&&i!==void 0?i:[]}).filter(o=>o.name.value===e.name)}function Ic(t,e){const{astNode:n,extensionASTNodes:r}=t;return(n!=null?[n,...r]:r).flatMap(o=>{var i;return(i=o.types)!==null&&i!==void 0?i:[]}).filter(o=>o.name.value===e)}function ru(t){var e;return t==null||(e=t.directives)===null||e===void 0?void 0:e.find(n=>n.name.value===ti.name)}function Ut(t,e){switch(e.kind){case I.LIST_TYPE:{const n=Ut(t,e.type);return n&&new Ft(n)}case I.NON_NULL_TYPE:{const n=Ut(t,e.type);return n&&new Ce(n)}case I.NAMED_TYPE:return t.getType(e.name.value)}}class ip{constructor(e,n,r){this._schema=e,this._typeStack=[],this._parentTypeStack=[],this._inputTypeStack=[],this._fieldDefStack=[],this._defaultValueStack=[],this._directive=null,this._argument=null,this._enumValue=null,this._getFieldDef=r??W2,n&&(on(n)&&this._inputTypeStack.push(n),Kn(n)&&this._parentTypeStack.push(n),Ds(n)&&this._typeStack.push(n))}get[Symbol.toStringTag](){return"TypeInfo"}getType(){if(this._typeStack.length>0)return this._typeStack[this._typeStack.length-1]}getParentType(){if(this._parentTypeStack.length>0)return this._parentTypeStack[this._parentTypeStack.length-1]}getInputType(){if(this._inputTypeStack.length>0)return this._inputTypeStack[this._inputTypeStack.length-1]}getParentInputType(){if(this._inputTypeStack.length>1)return this._inputTypeStack[this._inputTypeStack.length-2]}getFieldDef(){if(this._fieldDefStack.length>0)return this._fieldDefStack[this._fieldDefStack.length-1]}getDefaultValue(){if(this._defaultValueStack.length>0)return this._defaultValueStack[this._defaultValueStack.length-1]}getDirective(){return this._directive}getArgument(){return this._argument}getEnumValue(){return this._enumValue}enter(e){const n=this._schema;switch(e.kind){case I.SELECTION_SET:{const s=qt(this.getType());this._parentTypeStack.push(Kn(s)?s:void 0);break}case I.FIELD:{const s=this.getParentType();let o,i;s&&(o=this._getFieldDef(n,s,e),o&&(i=o.type)),this._fieldDefStack.push(o),this._typeStack.push(Ds(i)?i:void 0);break}case I.DIRECTIVE:this._directive=n.getDirective(e.name.value);break;case I.OPERATION_DEFINITION:{const s=n.getRootType(e.operation);this._typeStack.push(ge(s)?s:void 0);break}case I.INLINE_FRAGMENT:case I.FRAGMENT_DEFINITION:{const s=e.typeCondition,o=s?Ut(n,s):qt(this.getType());this._typeStack.push(Ds(o)?o:void 0);break}case I.VARIABLE_DEFINITION:{const s=Ut(n,e.type);this._inputTypeStack.push(on(s)?s:void 0);break}case I.ARGUMENT:{var r;let s,o;const i=(r=this.getDirective())!==null&&r!==void 0?r:this.getFieldDef();i&&(s=i.args.find(a=>a.name===e.name.value),s&&(o=s.type)),this._argument=s,this._defaultValueStack.push(s?s.defaultValue:void 0),this._inputTypeStack.push(on(o)?o:void 0);break}case I.LIST:{const s=Xa(this.getInputType()),o=lt(s)?s.ofType:s;this._defaultValueStack.push(void 0),this._inputTypeStack.push(on(o)?o:void 0);break}case I.OBJECT_FIELD:{const s=qt(this.getInputType());let o,i;Ye(s)&&(i=s.getFields()[e.name.value],i&&(o=i.type)),this._defaultValueStack.push(i?i.defaultValue:void 0),this._inputTypeStack.push(on(o)?o:void 0);break}case I.ENUM:{const s=qt(this.getInputType());let o;Et(s)&&(o=s.getValue(e.value)),this._enumValue=o;break}}}leave(e){switch(e.kind){case I.SELECTION_SET:this._parentTypeStack.pop();break;case I.FIELD:this._fieldDefStack.pop(),this._typeStack.pop();break;case I.DIRECTIVE:this._directive=null;break;case I.OPERATION_DEFINITION:case I.INLINE_FRAGMENT:case I.FRAGMENT_DEFINITION:this._typeStack.pop();break;case I.VARIABLE_DEFINITION:this._inputTypeStack.pop();break;case I.ARGUMENT:this._argument=null,this._defaultValueStack.pop(),this._inputTypeStack.pop();break;case I.LIST:case I.OBJECT_FIELD:this._defaultValueStack.pop(),this._inputTypeStack.pop();break;case I.ENUM:this._enumValue=null;break}}}function W2(t,e,n){const r=n.name.value;if(r===wo.name&&t.getQueryType()===e)return wo;if(r===Fo.name&&t.getQueryType()===e)return Fo;if(r===Io.name&&Kn(e))return Io;if(ge(e)||Be(e))return e.getFields()[r]}function ap(t,e){return{enter(...n){const r=n[0];t.enter(r);const s=Co(e,r.kind).enter;if(s){const o=s.apply(e,n);return o!==void 0&&(t.leave(r),na(o)&&t.enter(o)),o}},leave(...n){const r=n[0],s=Co(e,r.kind).leave;let o;return s&&(o=s.apply(e,n)),t.leave(r),o}}}function K2(t){return up(t)||cp(t)||lp(t)}function up(t){return t.kind===I.OPERATION_DEFINITION||t.kind===I.FRAGMENT_DEFINITION}function cp(t){return t.kind===I.SCHEMA_DEFINITION||Ls(t)||t.kind===I.DIRECTIVE_DEFINITION}function Ls(t){return t.kind===I.SCALAR_TYPE_DEFINITION||t.kind===I.OBJECT_TYPE_DEFINITION||t.kind===I.INTERFACE_TYPE_DEFINITION||t.kind===I.UNION_TYPE_DEFINITION||t.kind===I.ENUM_TYPE_DEFINITION||t.kind===I.INPUT_OBJECT_TYPE_DEFINITION}function lp(t){return t.kind===I.SCHEMA_EXTENSION||su(t)}function su(t){return t.kind===I.SCALAR_TYPE_EXTENSION||t.kind===I.OBJECT_TYPE_EXTENSION||t.kind===I.INTERFACE_TYPE_EXTENSION||t.kind===I.UNION_TYPE_EXTENSION||t.kind===I.ENUM_TYPE_EXTENSION||t.kind===I.INPUT_OBJECT_TYPE_EXTENSION}function X2(t){return{Document(e){for(const n of e.definitions)if(!up(n)){const r=n.kind===I.SCHEMA_DEFINITION||n.kind===I.SCHEMA_EXTENSION?"schema":'"'+n.name.value+'"';t.reportError(new X(`The ${r} definition is not executable.`,{nodes:n}))}return!1}}}function z2(t){return{Field(e){const n=t.getParentType();if(n&&!t.getFieldDef()){const s=t.getSchema(),o=e.name.value;let i=Nn("to use an inline fragment on",Y2(s,n,o));i===""&&(i=Nn(Z2(n,o))),t.reportError(new X(`Cannot query field "${o}" on type "${n.name}".`+i,{nodes:e}))}}}}function Y2(t,e,n){if(!Jn(e))return[];const r=new Set,s=Object.create(null);for(const i of t.getPossibleTypes(e))if(i.getFields()[n]){r.add(i),s[i.name]=1;for(const a of i.getInterfaces()){var o;a.getFields()[n]&&(r.add(a),s[a.name]=((o=s[a.name])!==null&&o!==void 0?o:0)+1)}}return[...r].sort((i,a)=>{const u=s[a.name]-s[i.name];return u!==0?u:Be(i)&&t.isSubType(i,a)?-1:Be(a)&&t.isSubType(a,i)?1:Ha(i.name,a.name)}).map(i=>i.name)}function Z2(t,e){if(ge(t)||Be(t)){const n=Object.keys(t.getFields());return Yn(e,n)}return[]}function Q2(t){return{InlineFragment(e){const n=e.typeCondition;if(n){const r=Ut(t.getSchema(),n);if(r&&!Kn(r)){const s=mt(n);t.reportError(new X(`Fragment cannot condition on non composite type "${s}".`,{nodes:n}))}}},FragmentDefinition(e){const n=Ut(t.getSchema(),e.typeCondition);if(n&&!Kn(n)){const r=mt(e.typeCondition);t.reportError(new X(`Fragment "${e.name.value}" cannot condition on non composite type "${r}".`,{nodes:e.typeCondition}))}}}}function e0(t){return{...pp(t),Argument(e){const n=t.getArgument(),r=t.getFieldDef(),s=t.getParentType();if(!n&&r&&s){const o=e.name.value,i=r.args.map(u=>u.name),a=Yn(o,i);t.reportError(new X(`Unknown argument "${o}" on field "${s.name}.${r.name}".`+Nn(a),{nodes:e}))}}}}function pp(t){const e=Object.create(null),n=t.getSchema(),r=n?n.getDirectives():vr;for(const i of r)e[i.name]=i.args.map(a=>a.name);const s=t.getDocument().definitions;for(const i of s)if(i.kind===I.DIRECTIVE_DEFINITION){var o;const a=(o=i.arguments)!==null&&o!==void 0?o:[];e[i.name.value]=a.map(u=>u.name.value)}return{Directive(i){const a=i.name.value,u=e[a];if(i.arguments&&u)for(const c of i.arguments){const l=c.name.value;if(!u.includes(l)){const p=Yn(l,u);t.reportError(new X(`Unknown argument "${l}" on directive "@${a}".`+Nn(p),{nodes:c}))}}return!1}}}function dp(t){const e=Object.create(null),n=t.getSchema(),r=n?n.getDirectives():vr;for(const o of r)e[o.name]=o.locations;const s=t.getDocument().definitions;for(const o of s)o.kind===I.DIRECTIVE_DEFINITION&&(e[o.name.value]=o.locations.map(i=>i.value));return{Directive(o,i,a,u,c){const l=o.name.value,p=e[l];if(!p){t.reportError(new X(`Unknown directive "@${l}".`,{nodes:o}));return}const d=t0(c);d&&!p.includes(d)&&t.reportError(new X(`Directive "@${l}" may not be used on ${d}.`,{nodes:o}))}}}function t0(t){const e=t[t.length-1];switch("kind"in e||Gt(!1),e.kind){case I.OPERATION_DEFINITION:return n0(e.operation);case I.FIELD:return fe.FIELD;case I.FRAGMENT_SPREAD:return fe.FRAGMENT_SPREAD;case I.INLINE_FRAGMENT:return fe.INLINE_FRAGMENT;case I.FRAGMENT_DEFINITION:return fe.FRAGMENT_DEFINITION;case I.VARIABLE_DEFINITION:return fe.VARIABLE_DEFINITION;case I.SCHEMA_DEFINITION:case I.SCHEMA_EXTENSION:return fe.SCHEMA;case I.SCALAR_TYPE_DEFINITION:case I.SCALAR_TYPE_EXTENSION:return fe.SCALAR;case I.OBJECT_TYPE_DEFINITION:case I.OBJECT_TYPE_EXTENSION:return fe.OBJECT;case I.FIELD_DEFINITION:return fe.FIELD_DEFINITION;case I.INTERFACE_TYPE_DEFINITION:case I.INTERFACE_TYPE_EXTENSION:return fe.INTERFACE;case I.UNION_TYPE_DEFINITION:case I.UNION_TYPE_EXTENSION:return fe.UNION;case I.ENUM_TYPE_DEFINITION:case I.ENUM_TYPE_EXTENSION:return fe.ENUM;case I.ENUM_VALUE_DEFINITION:return fe.ENUM_VALUE;case I.INPUT_OBJECT_TYPE_DEFINITION:case I.INPUT_OBJECT_TYPE_EXTENSION:return fe.INPUT_OBJECT;case I.INPUT_VALUE_DEFINITION:{const n=t[t.length-3];return"kind"in n||Gt(!1),n.kind===I.INPUT_OBJECT_TYPE_DEFINITION?fe.INPUT_FIELD_DEFINITION:fe.ARGUMENT_DEFINITION}default:Gt(!1,"Unexpected kind: "+te(e.kind))}}function n0(t){switch(t){case At.QUERY:return fe.QUERY;case At.MUTATION:return fe.MUTATION;case At.SUBSCRIPTION:return fe.SUBSCRIPTION}}function r0(t){return{FragmentSpread(e){const n=e.name.value;t.getFragment(n)||t.reportError(new X(`Unknown fragment "${n}".`,{nodes:e.name}))}}}function fp(t){const e=t.getSchema(),n=e?e.getTypeMap():Object.create(null),r=Object.create(null);for(const o of t.getDocument().definitions)Ls(o)&&(r[o.name.value]=!0);const s=[...Object.keys(n),...Object.keys(r)];return{NamedType(o,i,a,u,c){const l=o.name.value;if(!n[l]&&!r[l]){var p;const d=(p=c[2])!==null&&p!==void 0?p:a,f=d!=null&&s0(d);if(f&&kc.includes(l))return;const S=Yn(l,f?kc.concat(s):s);t.reportError(new X(`Unknown type "${l}".`+Nn(S),{nodes:o}))}}}}const kc=[...za,...Qa].map(t=>t.name);function s0(t){return"kind"in t&&(cp(t)||lp(t))}function o0(t){let e=0;return{Document(n){e=n.definitions.filter(r=>r.kind===I.OPERATION_DEFINITION).length},OperationDefinition(n){!n.name&&e>1&&t.reportError(new X("This anonymous operation must be the only defined operation.",{nodes:n}))}}}function i0(t){var e,n,r;const s=t.getSchema(),o=(e=(n=(r=s==null?void 0:s.astNode)!==null&&r!==void 0?r:s==null?void 0:s.getQueryType())!==null&&n!==void 0?n:s==null?void 0:s.getMutationType())!==null&&e!==void 0?e:s==null?void 0:s.getSubscriptionType();let i=0;return{SchemaDefinition(a){if(o){t.reportError(new X("Cannot define a new schema within a schema extension.",{nodes:a}));return}i>0&&t.reportError(new X("Must provide only one schema definition.",{nodes:a})),++i}}}function a0(t){const e=Object.create(null),n=[],r=Object.create(null);return{OperationDefinition:()=>!1,FragmentDefinition(o){return s(o),!1}};function s(o){if(e[o.name.value])return;const i=o.name.value;e[i]=!0;const a=t.getFragmentSpreads(o.selectionSet);if(a.length!==0){r[i]=n.length;for(const u of a){const c=u.name.value,l=r[c];if(n.push(u),l===void 0){const p=t.getFragment(c);p&&s(p)}else{const p=n.slice(l),d=p.slice(0,-1).map(f=>'"'+f.name.value+'"').join(", ");t.reportError(new X(`Cannot spread fragment "${c}" within itself`+(d!==""?` via ${d}.`:"."),{nodes:p}))}n.pop()}r[i]=void 0}}}function u0(t){let e=Object.create(null);return{OperationDefinition:{enter(){e=Object.create(null)},leave(n){const r=t.getRecursiveVariableUsages(n);for(const{node:s}of r){const o=s.name.value;e[o]!==!0&&t.reportError(new X(n.name?`Variable "$${o}" is not defined by operation "${n.name.value}".`:`Variable "$${o}" is not defined.`,{nodes:[s,n]}))}}},VariableDefinition(n){e[n.variable.name.value]=!0}}}function c0(t){const e=[],n=[];return{OperationDefinition(r){return e.push(r),!1},FragmentDefinition(r){return n.push(r),!1},Document:{leave(){const r=Object.create(null);for(const s of e)for(const o of t.getRecursivelyReferencedFragments(s))r[o.name.value]=!0;for(const s of n){const o=s.name.value;r[o]!==!0&&t.reportError(new X(`Fragment "${o}" is never used.`,{nodes:s}))}}}}}function l0(t){let e=[];return{OperationDefinition:{enter(){e=[]},leave(n){const r=Object.create(null),s=t.getRecursiveVariableUsages(n);for(const{node:o}of s)r[o.name.value]=!0;for(const o of e){const i=o.variable.name.value;r[i]!==!0&&t.reportError(new X(n.name?`Variable "$${i}" is never used in operation "${n.name.value}".`:`Variable "$${i}" is never used.`,{nodes:o}))}}},VariableDefinition(n){e.push(n)}}}function ou(t){switch(t.kind){case I.OBJECT:return{...t,fields:p0(t.fields)};case I.LIST:return{...t,values:t.values.map(ou)};case I.INT:case I.FLOAT:case I.STRING:case I.BOOLEAN:case I.NULL:case I.ENUM:case I.VARIABLE:return t}}function p0(t){return t.map(e=>({...e,value:ou(e.value)})).sort((e,n)=>Ha(e.name.value,n.name.value))}function hp(t){return Array.isArray(t)?t.map(([e,n])=>`subfields "${e}" conflict because `+hp(n)).join(" and "):t}function d0(t){const e=new E0,n=new Map;return{SelectionSet(r){const s=f0(t,n,e,t.getParentType(),r);for(const[[o,i],a,u]of s){const c=hp(i);t.reportError(new X(`Fields "${o}" conflict because ${c}. Use different aliases on the fields to fetch both if this was intentional.`,{nodes:a.concat(u)}))}}}}function f0(t,e,n,r,s){const o=[],[i,a]=No(t,e,r,s);if(m0(t,o,e,n,i),a.length!==0)for(let u=0;u<a.length;u++){ko(t,o,e,n,!1,i,a[u]);for(let c=u+1;c<a.length;c++)Po(t,o,e,n,!1,a[u],a[c])}return o}function ko(t,e,n,r,s,o,i){const a=t.getFragment(i);if(!a)return;const[u,c]=la(t,n,a);if(o!==u){iu(t,e,n,r,s,o,u);for(const l of c)r.has(l,i,s)||(r.add(l,i,s),ko(t,e,n,r,s,o,l))}}function Po(t,e,n,r,s,o,i){if(o===i||r.has(o,i,s))return;r.add(o,i,s);const a=t.getFragment(o),u=t.getFragment(i);if(!a||!u)return;const[c,l]=la(t,n,a),[p,d]=la(t,n,u);iu(t,e,n,r,s,c,p);for(const f of d)Po(t,e,n,r,s,o,f);for(const f of l)Po(t,e,n,r,s,f,i)}function h0(t,e,n,r,s,o,i,a){const u=[],[c,l]=No(t,e,s,o),[p,d]=No(t,e,i,a);iu(t,u,e,n,r,c,p);for(const f of d)ko(t,u,e,n,r,c,f);for(const f of l)ko(t,u,e,n,r,p,f);for(const f of l)for(const S of d)Po(t,u,e,n,r,f,S);return u}function m0(t,e,n,r,s){for(const[o,i]of Object.entries(s))if(i.length>1)for(let a=0;a<i.length;a++)for(let u=a+1;u<i.length;u++){const c=mp(t,n,r,!1,o,i[a],i[u]);c&&e.push(c)}}function iu(t,e,n,r,s,o,i){for(const[a,u]of Object.entries(o)){const c=i[a];if(c)for(const l of u)for(const p of c){const d=mp(t,n,r,s,a,l,p);d&&e.push(d)}}}function mp(t,e,n,r,s,o,i){const[a,u,c]=o,[l,p,d]=i,f=r||a!==l&&ge(a)&&ge(l);if(!f){const T=u.name.value,O=p.name.value;if(T!==O)return[[s,`"${T}" and "${O}" are different fields`],[u],[p]];if(!D0(u,p))return[[s,"they have differing arguments"],[u],[p]]}const S=c==null?void 0:c.type,b=d==null?void 0:d.type;if(S&&b&&ca(S,b))return[[s,`they return conflicting types "${te(S)}" and "${te(b)}"`],[u],[p]];const F=u.selectionSet,y=p.selectionSet;if(F&&y){const T=h0(t,e,n,f,qt(S),F,qt(b),y);return S0(T,s,u,p)}}function D0(t,e){const n=t.arguments,r=e.arguments;if(n===void 0||n.length===0)return r===void 0||r.length===0;if(r===void 0||r.length===0||n.length!==r.length)return!1;const s=new Map(r.map(({name:o,value:i})=>[o.value,i]));return n.every(o=>{const i=o.value,a=s.get(o.name.value);return a===void 0?!1:Pc(i)===Pc(a)})}function Pc(t){return mt(ou(t))}function ca(t,e){return lt(t)?lt(e)?ca(t.ofType,e.ofType):!0:lt(e)?!0:Fe(t)?Fe(e)?ca(t.ofType,e.ofType):!0:Fe(e)?!0:zt(t)||zt(e)?t!==e:!1}function No(t,e,n,r){const s=e.get(r);if(s)return s;const o=Object.create(null),i=Object.create(null);Dp(t,n,r,o,i);const a=[o,Object.keys(i)];return e.set(r,a),a}function la(t,e,n){const r=e.get(n.selectionSet);if(r)return r;const s=Ut(t.getSchema(),n.typeCondition);return No(t,e,s,n.selectionSet)}function Dp(t,e,n,r,s){for(const o of n.selections)switch(o.kind){case I.FIELD:{const i=o.name.value;let a;(ge(e)||Be(e))&&(a=e.getFields()[i]);const u=o.alias?o.alias.value:i;r[u]||(r[u]=[]),r[u].push([e,o,a]);break}case I.FRAGMENT_SPREAD:s[o.name.value]=!0;break;case I.INLINE_FRAGMENT:{const i=o.typeCondition,a=i?Ut(t.getSchema(),i):e;Dp(t,a,o.selectionSet,r,s);break}}}function S0(t,e,n,r){if(t.length>0)return[[e,t.map(([s])=>s)],[n,...t.map(([,s])=>s).flat()],[r,...t.map(([,,s])=>s).flat()]]}class E0{constructor(){this._data=new Map}has(e,n,r){var s;const[o,i]=e<n?[e,n]:[n,e],a=(s=this._data.get(o))===null||s===void 0?void 0:s.get(i);return a===void 0?!1:r?!0:r===a}add(e,n,r){const[s,o]=e<n?[e,n]:[n,e],i=this._data.get(s);i===void 0?this._data.set(s,new Map([[o,r]])):i.set(o,r)}}function y0(t){return{InlineFragment(e){const n=t.getType(),r=t.getParentType();if(Kn(n)&&Kn(r)&&!Cc(t.getSchema(),n,r)){const s=te(r),o=te(n);t.reportError(new X(`Fragment cannot be spread here as objects of type "${s}" can never be of type "${o}".`,{nodes:e}))}},FragmentSpread(e){const n=e.name.value,r=g0(t,n),s=t.getParentType();if(r&&s&&!Cc(t.getSchema(),r,s)){const o=te(s),i=te(r);t.reportError(new X(`Fragment "${n}" cannot be spread here as objects of type "${o}" can never be of type "${i}".`,{nodes:e}))}}}}function g0(t,e){const n=t.getFragment(e);if(n){const r=Ut(t.getSchema(),n.typeCondition);if(Kn(r))return r}}function v0(t){const e=t.getSchema(),n=Object.create(null);for(const s of t.getDocument().definitions)Ls(s)&&(n[s.name.value]=s);return{ScalarTypeExtension:r,ObjectTypeExtension:r,InterfaceTypeExtension:r,UnionTypeExtension:r,EnumTypeExtension:r,InputObjectTypeExtension:r};function r(s){const o=s.name.value,i=n[o],a=e==null?void 0:e.getType(o);let u;if(i?u=A0[i.kind]:a&&(u=b0(a)),u){if(u!==s.kind){const c=C0(s.kind);t.reportError(new X(`Cannot extend non-${c} type "${o}".`,{nodes:i?[i,s]:s}))}}else{const c=Object.keys({...n,...e==null?void 0:e.getTypeMap()}),l=Yn(o,c);t.reportError(new X(`Cannot extend type "${o}" because it is not defined.`+Nn(l),{nodes:s.name}))}}}const A0={[I.SCALAR_TYPE_DEFINITION]:I.SCALAR_TYPE_EXTENSION,[I.OBJECT_TYPE_DEFINITION]:I.OBJECT_TYPE_EXTENSION,[I.INTERFACE_TYPE_DEFINITION]:I.INTERFACE_TYPE_EXTENSION,[I.UNION_TYPE_DEFINITION]:I.UNION_TYPE_EXTENSION,[I.ENUM_TYPE_DEFINITION]:I.ENUM_TYPE_EXTENSION,[I.INPUT_OBJECT_TYPE_DEFINITION]:I.INPUT_OBJECT_TYPE_EXTENSION};function b0(t){if(Vt(t))return I.SCALAR_TYPE_EXTENSION;if(ge(t))return I.OBJECT_TYPE_EXTENSION;if(Be(t))return I.INTERFACE_TYPE_EXTENSION;if(Ct(t))return I.UNION_TYPE_EXTENSION;if(Et(t))return I.ENUM_TYPE_EXTENSION;if(Ye(t))return I.INPUT_OBJECT_TYPE_EXTENSION;Gt(!1,"Unexpected type: "+te(t))}function C0(t){switch(t){case I.SCALAR_TYPE_EXTENSION:return"scalar";case I.OBJECT_TYPE_EXTENSION:return"object";case I.INTERFACE_TYPE_EXTENSION:return"interface";case I.UNION_TYPE_EXTENSION:return"union";case I.ENUM_TYPE_EXTENSION:return"enum";case I.INPUT_OBJECT_TYPE_EXTENSION:return"input object";default:Gt(!1,"Unexpected kind: "+te(t))}}function T0(t){return{...Sp(t),Field:{leave(e){var n;const r=t.getFieldDef();if(!r)return!1;const s=new Set((n=e.arguments)===null||n===void 0?void 0:n.map(o=>o.name.value));for(const o of r.args)if(!s.has(o.name)&&xs(o)){const i=te(o.type);t.reportError(new X(`Field "${r.name}" argument "${o.name}" of type "${i}" is required, but it was not provided.`,{nodes:e}))}}}}}function Sp(t){var e;const n=Object.create(null),r=t.getSchema(),s=(e=r==null?void 0:r.getDirectives())!==null&&e!==void 0?e:vr;for(const a of s)n[a.name]=mr(a.args.filter(xs),u=>u.name);const o=t.getDocument().definitions;for(const a of o)if(a.kind===I.DIRECTIVE_DEFINITION){var i;const u=(i=a.arguments)!==null&&i!==void 0?i:[];n[a.name.value]=mr(u.filter(w0),c=>c.name.value)}return{Directive:{leave(a){const u=a.name.value,c=n[u];if(c){var l;const p=(l=a.arguments)!==null&&l!==void 0?l:[],d=new Set(p.map(f=>f.name.value));for(const[f,S]of Object.entries(c))if(!d.has(f)){const b=Wa(S.type)?te(S.type):mt(S.type);t.reportError(new X(`Directive "@${u}" argument "${f}" of type "${b}" is required, but it was not provided.`,{nodes:a}))}}}}}}function w0(t){return t.type.kind===I.NON_NULL_TYPE&&t.defaultValue==null}function F0(t){return{Field(e){const n=t.getType(),r=e.selectionSet;if(n){if(zt(qt(n))){if(r){const s=e.name.value,o=te(n);t.reportError(new X(`Field "${s}" must not have a selection since type "${o}" has no subfields.`,{nodes:r}))}}else if(!r){const s=e.name.value,o=te(n);t.reportError(new X(`Field "${s}" of type "${o}" must have a selection of subfields. Did you mean "${s} { ... }"?`,{nodes:e}))}}}}}function Ep(t){return t.map(e=>typeof e=="number"?"["+e.toString()+"]":"."+e).join("")}function Fs(t,e,n){return{prev:t,key:e,typename:n}}function rn(t){const e=[];let n=t;for(;n;)e.push(n.key),n=n.prev;return e.reverse()}function I0(t,e,n=k0){return ps(t,e,n,void 0)}function k0(t,e,n){let r="Invalid value "+te(e);throw t.length>0&&(r+=` at "value${Ep(t)}"`),n.message=r+": "+n.message,n}function ps(t,e,n,r){if(Fe(e)){if(t!=null)return ps(t,e.ofType,n,r);n(rn(r),t,new X(`Expected non-nullable type "${te(e)}" not to be null.`));return}if(t==null)return null;if(lt(e)){const s=e.ofType;return Ya(t)?Array.from(t,(o,i)=>{const a=Fs(r,i,void 0);return ps(o,s,n,a)}):[ps(t,s,n,r)]}if(Ye(e)){if(!ln(t)){n(rn(r),t,new X(`Expected type "${e.name}" to be an object.`));return}const s={},o=e.getFields();for(const i of Object.values(o)){const a=t[i.name];if(a===void 0){if(i.defaultValue!==void 0)s[i.name]=i.defaultValue;else if(Fe(i.type)){const u=te(i.type);n(rn(r),t,new X(`Field "${i.name}" of required type "${u}" was not provided.`))}continue}s[i.name]=ps(a,i.type,n,Fs(r,i.name,e.name))}for(const i of Object.keys(t))if(!o[i]){const a=Yn(i,Object.keys(e.getFields()));n(rn(r),t,new X(`Field "${i}" is not defined by type "${e.name}".`+Nn(a)))}return s}if(zt(e)){let s;try{s=e.parseValue(t)}catch(o){o instanceof X?n(rn(r),t,o):n(rn(r),t,new X(`Expected type "${e.name}". `+o.message,{originalError:o}));return}return s===void 0&&n(rn(r),t,new X(`Expected type "${e.name}".`)),s}Gt(!1,"Unexpected input type: "+te(e))}function Un(t,e,n){if(t){if(t.kind===I.VARIABLE){const r=t.name.value;if(n==null||n[r]===void 0)return;const s=n[r];return s===null&&Fe(e)?void 0:s}if(Fe(e))return t.kind===I.NULL?void 0:Un(t,e.ofType,n);if(t.kind===I.NULL)return null;if(lt(e)){const r=e.ofType;if(t.kind===I.LIST){const o=[];for(const i of t.values)if(Nc(i,n)){if(Fe(r))return;o.push(null)}else{const a=Un(i,r,n);if(a===void 0)return;o.push(a)}return o}const s=Un(t,r,n);return s===void 0?void 0:[s]}if(Ye(e)){if(t.kind!==I.OBJECT)return;const r=Object.create(null),s=mr(t.fields,o=>o.name.value);for(const o of Object.values(e.getFields())){const i=s[o.name];if(!i||Nc(i.value,n)){if(o.defaultValue!==void 0)r[o.name]=o.defaultValue;else if(Fe(o.type))return;continue}const a=Un(i.value,o.type,n);if(a===void 0)return;r[o.name]=a}return r}if(zt(e)){let r;try{r=e.parseLiteral(t,n)}catch{return}return r===void 0?void 0:r}Gt(!1,"Unexpected input type: "+te(e))}}function Nc(t,e){return t.kind===I.VARIABLE&&(e==null||e[t.name.value]===void 0)}function P0(t,e,n,r){const s=[],o=r==null?void 0:r.maxErrors;try{const i=N0(t,e,n,a=>{if(o!=null&&s.length>=o)throw new X("Too many errors processing variables, error limit reached. Execution aborted.");s.push(a)});if(s.length===0)return{coerced:i}}catch(i){s.push(i)}return{errors:s}}function N0(t,e,n,r){const s={};for(const o of e){const i=o.variable.name.value,a=Ut(t,o.type);if(!on(a)){const c=mt(o.type);r(new X(`Variable "$${i}" expected value of type "${c}" which cannot be used as an input type.`,{nodes:o.type}));continue}if(!gp(n,i)){if(o.defaultValue)s[i]=Un(o.defaultValue,a);else if(Fe(a)){const c=te(a);r(new X(`Variable "$${i}" of required type "${c}" was not provided.`,{nodes:o}))}continue}const u=n[i];if(u===null&&Fe(a)){const c=te(a);r(new X(`Variable "$${i}" of non-null type "${c}" must not be null.`,{nodes:o}));continue}s[i]=I0(u,a,(c,l,p)=>{let d=`Variable "$${i}" got invalid value `+te(l);c.length>0&&(d+=` at "${i}${Ep(c)}"`),r(new X(d+"; "+p.message,{nodes:o,originalError:p}))})}return s}function yp(t,e,n){var r;const s={},o=(r=e.arguments)!==null&&r!==void 0?r:[],i=mr(o,a=>a.name.value);for(const a of t.args){const u=a.name,c=a.type,l=i[u];if(!l){if(a.defaultValue!==void 0)s[u]=a.defaultValue;else if(Fe(c))throw new X(`Argument "${u}" of required type "${te(c)}" was not provided.`,{nodes:e});continue}const p=l.value;let d=p.kind===I.NULL;if(p.kind===I.VARIABLE){const S=p.name.value;if(n==null||!gp(n,S)){if(a.defaultValue!==void 0)s[u]=a.defaultValue;else if(Fe(c))throw new X(`Argument "${u}" of required type "${te(c)}" was provided the variable "$${S}" which was not provided a runtime value.`,{nodes:p});continue}d=n[S]==null}if(d&&Fe(c))throw new X(`Argument "${u}" of non-null type "${te(c)}" must not be null.`,{nodes:p});const f=Un(p,c,n);if(f===void 0)throw new X(`Argument "${u}" has invalid value ${mt(p)}.`,{nodes:p});s[u]=f}return s}function _o(t,e,n){var r;const s=(r=e.directives)===null||r===void 0?void 0:r.find(o=>o.name.value===t.name);if(s)return yp(t,s,n)}function gp(t,e){return Object.prototype.hasOwnProperty.call(t,e)}function vp(t,e,n,r,s){const o=new Map;return Oo(t,e,n,r,s,o,new Set),o}function _0(t,e,n,r,s){const o=new Map,i=new Set;for(const a of s)a.selectionSet&&Oo(t,e,n,r,a.selectionSet,o,i);return o}function Oo(t,e,n,r,s,o,i){for(const a of s.selections)switch(a.kind){case I.FIELD:{if(!Ti(n,a))continue;const u=O0(a),c=o.get(u);c!==void 0?c.push(a):o.set(u,[a]);break}case I.INLINE_FRAGMENT:{if(!Ti(n,a)||!_c(t,a,r))continue;Oo(t,e,n,r,a.selectionSet,o,i);break}case I.FRAGMENT_SPREAD:{const u=a.name.value;if(i.has(u)||!Ti(n,a))continue;i.add(u);const c=e[u];if(!c||!_c(t,c,r))continue;Oo(t,e,n,r,c.selectionSet,o,i);break}}}function Ti(t,e){const n=_o(z1,e,t);if((n==null?void 0:n.if)===!0)return!1;const r=_o(X1,e,t);return(r==null?void 0:r.if)!==!1}function _c(t,e,n){const r=e.typeCondition;if(!r)return!0;const s=Ut(t,r);return s===n?!0:Jn(s)?t.isSubType(s,n):!1}function O0(t){return t.alias?t.alias.value:t.name.value}function $0(t){return{OperationDefinition(e){if(e.operation==="subscription"){const n=t.getSchema(),r=n.getSubscriptionType();if(r){const s=e.name?e.name.value:null,o=Object.create(null),i=t.getDocument(),a=Object.create(null);for(const c of i.definitions)c.kind===I.FRAGMENT_DEFINITION&&(a[c.name.value]=c);const u=vp(n,a,o,r,e.selectionSet);if(u.size>1){const p=[...u.values()].slice(1).flat();t.reportError(new X(s!=null?`Subscription "${s}" must select only one top level field.`:"Anonymous Subscription must select only one top level field.",{nodes:p}))}for(const c of u.values())c[0].name.value.startsWith("__")&&t.reportError(new X(s!=null?`Subscription "${s}" must not select an introspection top level field.`:"Anonymous Subscription must not select an introspection top level field.",{nodes:c}))}}}}}function au(t,e){const n=new Map;for(const r of t){const s=e(r),o=n.get(s);o===void 0?n.set(s,[r]):o.push(r)}return n}function B0(t){return{DirectiveDefinition(r){var s;const o=(s=r.arguments)!==null&&s!==void 0?s:[];return n(`@${r.name.value}`,o)},InterfaceTypeDefinition:e,InterfaceTypeExtension:e,ObjectTypeDefinition:e,ObjectTypeExtension:e};function e(r){var s;const o=r.name.value,i=(s=r.fields)!==null&&s!==void 0?s:[];for(const u of i){var a;const c=u.name.value,l=(a=u.arguments)!==null&&a!==void 0?a:[];n(`${o}.${c}`,l)}return!1}function n(r,s){const o=au(s,i=>i.name.value);for(const[i,a]of o)a.length>1&&t.reportError(new X(`Argument "${r}(${i}:)" can only be defined once.`,{nodes:a.map(u=>u.name)}));return!1}}function Ap(t){return{Field:e,Directive:e};function e(n){var r;const s=(r=n.arguments)!==null&&r!==void 0?r:[],o=au(s,i=>i.name.value);for(const[i,a]of o)a.length>1&&t.reportError(new X(`There can be only one argument named "${i}".`,{nodes:a.map(u=>u.name)}))}}function R0(t){const e=Object.create(null),n=t.getSchema();return{DirectiveDefinition(r){const s=r.name.value;if(n!=null&&n.getDirective(s)){t.reportError(new X(`Directive "@${s}" already exists in the schema. It cannot be redefined.`,{nodes:r.name}));return}return e[s]?t.reportError(new X(`There can be only one directive named "@${s}".`,{nodes:[e[s],r.name]})):e[s]=r.name,!1}}}function bp(t){const e=Object.create(null),n=t.getSchema(),r=n?n.getDirectives():vr;for(const a of r)e[a.name]=!a.isRepeatable;const s=t.getDocument().definitions;for(const a of s)a.kind===I.DIRECTIVE_DEFINITION&&(e[a.name.value]=!a.repeatable);const o=Object.create(null),i=Object.create(null);return{enter(a){if(!("directives"in a)||!a.directives)return;let u;if(a.kind===I.SCHEMA_DEFINITION||a.kind===I.SCHEMA_EXTENSION)u=o;else if(Ls(a)||su(a)){const c=a.name.value;u=i[c],u===void 0&&(i[c]=u=Object.create(null))}else u=Object.create(null);for(const c of a.directives){const l=c.name.value;e[l]&&(u[l]?t.reportError(new X(`The directive "@${l}" can only be used once at this location.`,{nodes:[u[l],c]})):u[l]=c)}}}}function x0(t){const e=t.getSchema(),n=e?e.getTypeMap():Object.create(null),r=Object.create(null);return{EnumTypeDefinition:s,EnumTypeExtension:s};function s(o){var i;const a=o.name.value;r[a]||(r[a]=Object.create(null));const u=(i=o.values)!==null&&i!==void 0?i:[],c=r[a];for(const l of u){const p=l.name.value,d=n[a];Et(d)&&d.getValue(p)?t.reportError(new X(`Enum value "${a}.${p}" already exists in the schema. It cannot also be defined in this type extension.`,{nodes:l.name})):c[p]?t.reportError(new X(`Enum value "${a}.${p}" can only be defined once.`,{nodes:[c[p],l.name]})):c[p]=l.name}return!1}}function q0(t){const e=t.getSchema(),n=e?e.getTypeMap():Object.create(null),r=Object.create(null);return{InputObjectTypeDefinition:s,InputObjectTypeExtension:s,InterfaceTypeDefinition:s,InterfaceTypeExtension:s,ObjectTypeDefinition:s,ObjectTypeExtension:s};function s(o){var i;const a=o.name.value;r[a]||(r[a]=Object.create(null));const u=(i=o.fields)!==null&&i!==void 0?i:[],c=r[a];for(const l of u){const p=l.name.value;M0(n[a],p)?t.reportError(new X(`Field "${a}.${p}" already exists in the schema. It cannot also be defined in this type extension.`,{nodes:l.name})):c[p]?t.reportError(new X(`Field "${a}.${p}" can only be defined once.`,{nodes:[c[p],l.name]})):c[p]=l.name}return!1}}function M0(t,e){return ge(t)||Be(t)||Ye(t)?t.getFields()[e]!=null:!1}function L0(t){const e=Object.create(null);return{OperationDefinition:()=>!1,FragmentDefinition(n){const r=n.name.value;return e[r]?t.reportError(new X(`There can be only one fragment named "${r}".`,{nodes:[e[r],n.name]})):e[r]=n.name,!1}}}function Cp(t){const e=[];let n=Object.create(null);return{ObjectValue:{enter(){e.push(n),n=Object.create(null)},leave(){const r=e.pop();r||Gt(!1),n=r}},ObjectField(r){const s=r.name.value;n[s]?t.reportError(new X(`There can be only one input field named "${s}".`,{nodes:[n[s],r.name]})):n[s]=r.name}}}function j0(t){const e=Object.create(null);return{OperationDefinition(n){const r=n.name;return r&&(e[r.value]?t.reportError(new X(`There can be only one operation named "${r.value}".`,{nodes:[e[r.value],r]})):e[r.value]=r),!1},FragmentDefinition:()=>!1}}function G0(t){const e=t.getSchema(),n=Object.create(null),r=e?{query:e.getQueryType(),mutation:e.getMutationType(),subscription:e.getSubscriptionType()}:{};return{SchemaDefinition:s,SchemaExtension:s};function s(o){var i;const a=(i=o.operationTypes)!==null&&i!==void 0?i:[];for(const u of a){const c=u.operation,l=n[c];r[c]?t.reportError(new X(`Type for ${c} already defined in the schema. It cannot be redefined.`,{nodes:u})):l?t.reportError(new X(`There can be only one ${c} type in schema.`,{nodes:[l,u]})):n[c]=u}return!1}}function U0(t){const e=Object.create(null),n=t.getSchema();return{ScalarTypeDefinition:r,ObjectTypeDefinition:r,InterfaceTypeDefinition:r,UnionTypeDefinition:r,EnumTypeDefinition:r,InputObjectTypeDefinition:r};function r(s){const o=s.name.value;if(n!=null&&n.getType(o)){t.reportError(new X(`Type "${o}" already exists in the schema. It cannot also be defined in this type definition.`,{nodes:s.name}));return}return e[o]?t.reportError(new X(`There can be only one type named "${o}".`,{nodes:[e[o],s.name]})):e[o]=s.name,!1}}function V0(t){return{OperationDefinition(e){var n;const r=(n=e.variableDefinitions)!==null&&n!==void 0?n:[],s=au(r,o=>o.variable.name.value);for(const[o,i]of s)i.length>1&&t.reportError(new X(`There can be only one variable named "$${o}".`,{nodes:i.map(a=>a.variable.name)}))}}}function J0(t){return{ListValue(e){const n=Xa(t.getParentInputType());if(!lt(n))return nr(t,e),!1},ObjectValue(e){const n=qt(t.getInputType());if(!Ye(n))return nr(t,e),!1;const r=mr(e.fields,s=>s.name.value);for(const s of Object.values(n.getFields()))if(!r[s.name]&&W1(s)){const i=te(s.type);t.reportError(new X(`Field "${n.name}.${s.name}" of required type "${i}" was not provided.`,{nodes:e}))}},ObjectField(e){const n=qt(t.getParentInputType());if(!t.getInputType()&&Ye(n)){const s=Yn(e.name.value,Object.keys(n.getFields()));t.reportError(new X(`Field "${e.name.value}" is not defined by type "${n.name}".`+Nn(s),{nodes:e}))}},NullValue(e){const n=t.getInputType();Fe(n)&&t.reportError(new X(`Expected value of type "${te(n)}", found ${mt(e)}.`,{nodes:e}))},EnumValue:e=>nr(t,e),IntValue:e=>nr(t,e),FloatValue:e=>nr(t,e),StringValue:e=>nr(t,e),BooleanValue:e=>nr(t,e)}}function nr(t,e){const n=t.getInputType();if(!n)return;const r=qt(n);if(!zt(r)){const s=te(n);t.reportError(new X(`Expected value of type "${s}", found ${mt(e)}.`,{nodes:e}));return}try{if(r.parseLiteral(e,void 0)===void 0){const o=te(n);t.reportError(new X(`Expected value of type "${o}", found ${mt(e)}.`,{nodes:e}))}}catch(s){const o=te(n);s instanceof X?t.reportError(s):t.reportError(new X(`Expected value of type "${o}", found ${mt(e)}; `+s.message,{nodes:e,originalError:s}))}}function H0(t){return{VariableDefinition(e){const n=Ut(t.getSchema(),e.type);if(n!==void 0&&!on(n)){const r=e.variable.name.value,s=mt(e.type);t.reportError(new X(`Variable "$${r}" cannot be non-input type "${s}".`,{nodes:e.type}))}}}}function W0(t){let e=Object.create(null);return{OperationDefinition:{enter(){e=Object.create(null)},leave(n){const r=t.getRecursiveVariableUsages(n);for(const{node:s,type:o,defaultValue:i}of r){const a=s.name.value,u=e[a];if(u&&o){const c=t.getSchema(),l=Ut(c,u.type);if(l&&!K0(c,l,u.defaultValue,o,i)){const p=te(l),d=te(o);t.reportError(new X(`Variable "$${a}" of type "${p}" used in position expecting type "${d}".`,{nodes:[u,s]}))}}}}},VariableDefinition(n){e[n.variable.name.value]=n}}}function K0(t,e,n,r,s){if(Fe(r)&&!Fe(e)){if(!(n!=null&&n.kind!==I.NULL)&&!(s!==void 0))return!1;const a=r.ofType;return Jr(t,e,a)}return Jr(t,e,r)}const X0=Object.freeze([X2,j0,o0,$0,fp,Q2,H0,F0,z2,L0,r0,c0,y0,a0,V0,u0,l0,dp,bp,e0,Ap,J0,T0,W0,d0,Cp]),z0=Object.freeze([i0,G0,U0,x0,q0,B0,R0,fp,dp,bp,v0,pp,Ap,Cp,Sp]);class Tp{constructor(e,n){this._ast=e,this._fragments=void 0,this._fragmentSpreads=new Map,this._recursivelyReferencedFragments=new Map,this._onError=n}get[Symbol.toStringTag](){return"ASTValidationContext"}reportError(e){this._onError(e)}getDocument(){return this._ast}getFragment(e){let n;if(this._fragments)n=this._fragments;else{n=Object.create(null);for(const r of this.getDocument().definitions)r.kind===I.FRAGMENT_DEFINITION&&(n[r.name.value]=r);this._fragments=n}return n[e]}getFragmentSpreads(e){let n=this._fragmentSpreads.get(e);if(!n){n=[];const r=[e];let s;for(;s=r.pop();)for(const o of s.selections)o.kind===I.FRAGMENT_SPREAD?n.push(o):o.selectionSet&&r.push(o.selectionSet);this._fragmentSpreads.set(e,n)}return n}getRecursivelyReferencedFragments(e){let n=this._recursivelyReferencedFragments.get(e);if(!n){n=[];const r=Object.create(null),s=[e.selectionSet];let o;for(;o=s.pop();)for(const i of this.getFragmentSpreads(o)){const a=i.name.value;if(r[a]!==!0){r[a]=!0;const u=this.getFragment(a);u&&(n.push(u),s.push(u.selectionSet))}}this._recursivelyReferencedFragments.set(e,n)}return n}}class Y0 extends Tp{constructor(e,n,r){super(e,r),this._schema=n}get[Symbol.toStringTag](){return"SDLValidationContext"}getSchema(){return this._schema}}class Z0 extends Tp{constructor(e,n,r,s){super(n,s),this._schema=e,this._typeInfo=r,this._variableUsages=new Map,this._recursiveVariableUsages=new Map}get[Symbol.toStringTag](){return"ValidationContext"}getSchema(){return this._schema}getVariableUsages(e){let n=this._variableUsages.get(e);if(!n){const r=[],s=new ip(this._schema);Rs(e,ap(s,{VariableDefinition:()=>!1,Variable(o){r.push({node:o,type:s.getInputType(),defaultValue:s.getDefaultValue()})}})),n=r,this._variableUsages.set(e,n)}return n}getRecursiveVariableUsages(e){let n=this._recursiveVariableUsages.get(e);if(!n){n=this.getVariableUsages(e);for(const r of this.getRecursivelyReferencedFragments(e))n=n.concat(this.getVariableUsages(r));this._recursiveVariableUsages.set(e,n)}return n}getType(){return this._typeInfo.getType()}getParentType(){return this._typeInfo.getParentType()}getInputType(){return this._typeInfo.getInputType()}getParentInputType(){return this._typeInfo.getParentInputType()}getFieldDef(){return this._typeInfo.getFieldDef()}getDirective(){return this._typeInfo.getDirective()}getArgument(){return this._typeInfo.getArgument()}getEnumValue(){return this._typeInfo.getEnumValue()}}function Q0(t,e,n=X0,r,s=new ip(t)){var o;const i=(o=void 0)!==null&&o!==void 0?o:100;e||$e(!1,"Must provide document."),op(t);const a=Object.freeze({}),u=[],c=new Z0(t,e,s,p=>{if(u.length>=i)throw u.push(new X("Too many validation errors, error limit reached. Validation aborted.")),a;u.push(p)}),l=M1(n.map(p=>p(c)));try{Rs(e,ap(s,l))}catch(p){if(p!==a)throw p}return u}function em(t,e,n=z0){const r=[],s=new Y0(t,e,i=>{r.push(i)}),o=n.map(i=>i(s));return Rs(t,M1(o)),r}function tm(t){const e=em(t);if(e.length!==0)throw new Error(e.map(n=>n.message).join(`

`))}function nm(t){let e;return function(r,s,o){e===void 0&&(e=new WeakMap);let i=e.get(r);i===void 0&&(i=new WeakMap,e.set(r,i));let a=i.get(s);a===void 0&&(a=new WeakMap,i.set(s,a));let u=a.get(o);return u===void 0&&(u=t(r,s,o),a.set(o,u)),u}}function Oc(t){return Promise.all(Object.values(t)).then(e=>{const n=Object.create(null);for(const[r,s]of Object.keys(t).entries())n[s]=e[r];return n})}function rm(t,e,n){let r=n;for(const s of t)r=Xt(r)?r.then(o=>e(o,s)):e(r,s);return r}function sm(t){return t instanceof Error?t:new om(t)}class om extends Error{constructor(e){super("Unexpected error value: "+te(e)),this.name="NonErrorThrown",this.thrownValue=e}}function $o(t,e,n){var r;const s=sm(t);return im(s)?s:new X(s.message,{nodes:(r=s.nodes)!==null&&r!==void 0?r:e,source:s.source,positions:s.positions,path:n,originalError:s})}function im(t){return Array.isArray(t.path)}const am=nm((t,e,n)=>_0(t.schema,t.fragments,t.variableValues,e,n));function um(t){arguments.length<2||$e(!1,"graphql@16 dropped long-deprecated support for positional arguments, please pass an object instead.");const{schema:e,document:n,variableValues:r,rootValue:s}=t;cm(e,n,r);const o=lm(t);if(!("schema"in o))return{errors:o};try{const{operation:i}=o,a=pm(o,i,s);return Xt(a)?a.then(u=>no(u,o.errors),u=>(o.errors.push(u),no(null,o.errors))):no(a,o.errors)}catch(i){return o.errors.push(i),no(null,o.errors)}}function no(t,e){return e.length===0?{data:t}:{errors:e,data:t}}function cm(t,e,n){e||$e(!1,"Must provide document."),op(t),n==null||ln(n)||$e(!1,"Variables must be provided as an Object where each property is a variable value. Perhaps look to see if an unparsed JSON string was provided.")}function lm(t){var e,n;const{schema:r,document:s,rootValue:o,contextValue:i,variableValues:a,operationName:u,fieldResolver:c,typeResolver:l,subscribeFieldResolver:p}=t;let d;const f=Object.create(null);for(const F of s.definitions)switch(F.kind){case I.OPERATION_DEFINITION:if(u==null){if(d!==void 0)return[new X("Must provide operation name if query contains multiple operations.")];d=F}else((e=F.name)===null||e===void 0?void 0:e.value)===u&&(d=F);break;case I.FRAGMENT_DEFINITION:f[F.name.value]=F;break}if(!d)return u!=null?[new X(`Unknown operation named "${u}".`)]:[new X("Must provide an operation.")];const S=(n=d.variableDefinitions)!==null&&n!==void 0?n:[],b=P0(r,S,a??{},{maxErrors:50});return b.errors?b.errors:{schema:r,fragments:f,rootValue:o,contextValue:i,operation:d,variableValues:b.coerced,fieldResolver:c??Rc,typeResolver:l??Sm,subscribeFieldResolver:p??Rc,errors:[]}}function pm(t,e,n){const r=t.schema.getRootType(e.operation);if(r==null)throw new X(`Schema is not configured to execute ${e.operation} operation.`,{nodes:e});const s=vp(t.schema,t.fragments,t.variableValues,r,e.selectionSet),o=void 0;switch(e.operation){case At.QUERY:return Bo(t,r,n,o,s);case At.MUTATION:return dm(t,r,n,o,s);case At.SUBSCRIPTION:return Bo(t,r,n,o,s)}}function dm(t,e,n,r,s){return rm(s.entries(),(o,[i,a])=>{const u=Fs(r,i,e.name),c=wp(t,e,n,a,u);return c===void 0?o:Xt(c)?c.then(l=>(o[i]=l,o)):(o[i]=c,o)},Object.create(null))}function Bo(t,e,n,r,s){const o=Object.create(null);let i=!1;try{for(const[a,u]of s.entries()){const c=Fs(r,a,e.name),l=wp(t,e,n,u,c);l!==void 0&&(o[a]=l,Xt(l)&&(i=!0))}}catch(a){if(i)return Oc(o).finally(()=>{throw a});throw a}return i?Oc(o):o}function wp(t,e,n,r,s){var o;const i=Em(t.schema,e,r[0]);if(!i)return;const a=i.type,u=(o=i.resolve)!==null&&o!==void 0?o:t.fieldResolver,c=fm(t,i,r,e,s);try{const l=yp(i,r[0],t.variableValues),p=t.contextValue,d=u(n,l,p,c);let f;return Xt(d)?f=d.then(S=>Is(t,a,r,c,s,S)):f=Is(t,a,r,c,s,d),Xt(f)?f.then(void 0,S=>{const b=$o(S,r,rn(s));return Ro(b,a,t)}):f}catch(l){const p=$o(l,r,rn(s));return Ro(p,a,t)}}function fm(t,e,n,r,s){return{fieldName:e.name,fieldNodes:n,returnType:e.type,parentType:r,path:s,schema:t.schema,fragments:t.fragments,rootValue:t.rootValue,operation:t.operation,variableValues:t.variableValues}}function Ro(t,e,n){if(Fe(e))throw t;return n.errors.push(t),null}function Is(t,e,n,r,s,o){if(o instanceof Error)throw o;if(Fe(e)){const i=Is(t,e.ofType,n,r,s,o);if(i===null)throw new Error(`Cannot return null for non-nullable field ${r.parentType.name}.${r.fieldName}.`);return i}if(o==null)return null;if(lt(e))return hm(t,e,n,r,s,o);if(zt(e))return mm(e,o);if(Jn(e))return Dm(t,e,n,r,s,o);if(ge(e))return pa(t,e,n,r,s,o);Gt(!1,"Cannot complete value of unexpected output type: "+te(e))}function hm(t,e,n,r,s,o){if(!Ya(o))throw new X(`Expected Iterable, but did not find one for field "${r.parentType.name}.${r.fieldName}".`);const i=e.ofType;let a=!1;const u=Array.from(o,(c,l)=>{const p=Fs(s,l,void 0);try{let d;return Xt(c)?d=c.then(f=>Is(t,i,n,r,p,f)):d=Is(t,i,n,r,p,c),Xt(d)?(a=!0,d.then(void 0,f=>{const S=$o(f,n,rn(p));return Ro(S,i,t)})):d}catch(d){const f=$o(d,n,rn(p));return Ro(f,i,t)}});return a?Promise.all(u):u}function mm(t,e){const n=t.serialize(e);if(n==null)throw new Error(`Expected \`${te(t)}.serialize(${te(e)})\` to return non-nullable value, returned: ${te(n)}`);return n}function Dm(t,e,n,r,s,o){var i;const a=(i=e.resolveType)!==null&&i!==void 0?i:t.typeResolver,u=t.contextValue,c=a(o,u,r,e);return Xt(c)?c.then(l=>pa(t,$c(l,t,e,n,r,o),n,r,s,o)):pa(t,$c(c,t,e,n,r,o),n,r,s,o)}function $c(t,e,n,r,s,o){if(t==null)throw new X(`Abstract type "${n.name}" must resolve to an Object type at runtime for field "${s.parentType.name}.${s.fieldName}". Either the "${n.name}" type should provide a "resolveType" function or each possible type should provide an "isTypeOf" function.`,r);if(ge(t))throw new X("Support for returning GraphQLObjectType from resolveType was removed in graphql-js@16.0.0 please return type name instead.");if(typeof t!="string")throw new X(`Abstract type "${n.name}" must resolve to an Object type at runtime for field "${s.parentType.name}.${s.fieldName}" with value ${te(o)}, received "${te(t)}".`);const i=e.schema.getType(t);if(i==null)throw new X(`Abstract type "${n.name}" was resolved to a type "${t}" that does not exist inside the schema.`,{nodes:r});if(!ge(i))throw new X(`Abstract type "${n.name}" was resolved to a non-object type "${t}".`,{nodes:r});if(!e.schema.isSubType(n,i))throw new X(`Runtime Object type "${i.name}" is not a possible type for "${n.name}".`,{nodes:r});return i}function pa(t,e,n,r,s,o){const i=am(t,e,n);if(e.isTypeOf){const a=e.isTypeOf(o,t.contextValue,r);if(Xt(a))return a.then(u=>{if(!u)throw Bc(e,o,n);return Bo(t,e,o,s,i)});if(!a)throw Bc(e,o,n)}return Bo(t,e,o,s,i)}function Bc(t,e,n){return new X(`Expected value of type "${t.name}" but got: ${te(e)}.`,{nodes:n})}const Sm=function(t,e,n,r){if(ln(t)&&typeof t.__typename=="string")return t.__typename;const s=n.schema.getPossibleTypes(r),o=[];for(let i=0;i<s.length;i++){const a=s[i];if(a.isTypeOf){const u=a.isTypeOf(t,e,n);if(Xt(u))o[i]=u;else if(u)return a.name}}if(o.length)return Promise.all(o).then(i=>{for(let a=0;a<i.length;a++)if(i[a])return s[a].name})},Rc=function(t,e,n,r){if(ln(t)||typeof t=="function"){const s=t[r.fieldName];return typeof s=="function"?t[r.fieldName](e,n,r):s}};function Em(t,e,n){const r=n.name.value;return r===wo.name&&t.getQueryType()===e?wo:r===Fo.name&&t.getQueryType()===e?Fo:r===Io.name?Io:e.getFields()[r]}function ym(t){return new Promise(e=>e(Fp(t)))}function gm(t){const e=Fp(t);if(Xt(e))throw new Error("GraphQL execution failed to complete synchronously.");return e}function Fp(t){arguments.length<2||$e(!1,"graphql@16 dropped long-deprecated support for positional arguments, please pass an object instead.");const{schema:e,source:n,rootValue:r,contextValue:s,variableValues:o,operationName:i,fieldResolver:a,typeResolver:u}=t,c=sp(e);if(c.length>0)return{errors:c};let l;try{l=Va(n)}catch(d){return{errors:[d]}}const p=Q0(e,l);return p.length>0?{errors:p}:um({schema:e,document:l,rootValue:r,contextValue:s,variableValues:o,operationName:i,fieldResolver:a,typeResolver:u})}function vm(t,e,n){var r,s,o,i;const a=[],u=Object.create(null),c=[];let l;const p=[];for(const v of e.definitions)if(v.kind===I.SCHEMA_DEFINITION)l=v;else if(v.kind===I.SCHEMA_EXTENSION)p.push(v);else if(Ls(v))a.push(v);else if(su(v)){const C=v.name.value,m=u[C];u[C]=m?m.concat([v]):[v]}else v.kind===I.DIRECTIVE_DEFINITION&&c.push(v);if(Object.keys(u).length===0&&a.length===0&&c.length===0&&p.length===0&&l==null)return t;const d=Object.create(null);for(const v of t.types)d[v.name]=T(v);for(const v of a){var f;const C=v.name.value;d[C]=(f=xc[C])!==null&&f!==void 0?f:x(v)}const S={query:t.query&&F(t.query),mutation:t.mutation&&F(t.mutation),subscription:t.subscription&&F(t.subscription),...l&&de([l]),...de(p)};return{description:(r=l)===null||r===void 0||(s=r.description)===null||s===void 0?void 0:s.value,...S,types:Object.values(d),directives:[...t.directives.map(y),...c.map(Te)],extensions:Object.create(null),astNode:(o=l)!==null&&o!==void 0?o:t.astNode,extensionASTNodes:t.extensionASTNodes.concat(p),assumeValid:(i=n==null?void 0:n.assumeValid)!==null&&i!==void 0?i:!1};function b(v){return lt(v)?new Ft(b(v.ofType)):Fe(v)?new Ce(b(v.ofType)):F(v)}function F(v){return d[v.name]}function y(v){const C=v.toConfig();return new zn({...C,args:wn(C.args,pe)})}function T(v){if(eu(v)||qs(v))return v;if(Vt(v))return M(v);if(ge(v))return ee(v);if(Be(v))return ne(v);if(Ct(v))return Ne(v);if(Et(v))return j(v);if(Ye(v))return O(v);Gt(!1,"Unexpected type: "+te(v))}function O(v){var C;const m=v.toConfig(),A=(C=u[m.name])!==null&&C!==void 0?C:[];return new Dr({...m,fields:()=>({...wn(m.fields,$=>({...$,type:b($.type)})),...ce(A)}),extensionASTNodes:m.extensionASTNodes.concat(A)})}function j(v){var C;const m=v.toConfig(),A=(C=u[v.name])!==null&&C!==void 0?C:[];return new An({...m,values:{...m.values,...Ze(A)},extensionASTNodes:m.extensionASTNodes.concat(A)})}function M(v){var C;const m=v.toConfig(),A=(C=u[m.name])!==null&&C!==void 0?C:[];let $=m.specifiedByURL;for(const E of A){var g;$=(g=qc(E))!==null&&g!==void 0?g:$}return new vn({...m,specifiedByURL:$,extensionASTNodes:m.extensionASTNodes.concat(A)})}function ee(v){var C;const m=v.toConfig(),A=(C=u[m.name])!==null&&C!==void 0?C:[];return new Lt({...m,interfaces:()=>[...v.getInterfaces().map(F),...ke(A)],fields:()=>({...wn(m.fields,L),...Ge(A)}),extensionASTNodes:m.extensionASTNodes.concat(A)})}function ne(v){var C;const m=v.toConfig(),A=(C=u[m.name])!==null&&C!==void 0?C:[];return new Xn({...m,interfaces:()=>[...v.getInterfaces().map(F),...ke(A)],fields:()=>({...wn(m.fields,L),...Ge(A)}),extensionASTNodes:m.extensionASTNodes.concat(A)})}function Ne(v){var C;const m=v.toConfig(),A=(C=u[m.name])!==null&&C!==void 0?C:[];return new ws({...m,types:()=>[...v.getTypes().map(F),...Z(A)],extensionASTNodes:m.extensionASTNodes.concat(A)})}function L(v){return{...v,type:b(v.type),args:v.args&&wn(v.args,pe)}}function pe(v){return{...v,type:b(v.type)}}function de(v){const C={};for(const A of v){var m;const $=(m=A.operationTypes)!==null&&m!==void 0?m:[];for(const g of $)C[g.operation]=re(g.type)}return C}function re(v){var C;const m=v.name.value,A=(C=xc[m])!==null&&C!==void 0?C:d[m];if(A===void 0)throw new Error(`Unknown type: "${m}".`);return A}function he(v){return v.kind===I.LIST_TYPE?new Ft(he(v.type)):v.kind===I.NON_NULL_TYPE?new Ce(he(v.type)):re(v)}function Te(v){var C;return new zn({name:v.name.value,description:(C=v.description)===null||C===void 0?void 0:C.value,locations:v.locations.map(({value:m})=>m),isRepeatable:v.repeatable,args:qe(v.arguments),astNode:v})}function Ge(v){const C=Object.create(null);for(const $ of v){var m;const g=(m=$.fields)!==null&&m!==void 0?m:[];for(const E of g){var A;C[E.name.value]={type:he(E.type),description:(A=E.description)===null||A===void 0?void 0:A.value,args:qe(E.arguments),deprecationReason:ro(E),astNode:E}}}return C}function qe(v){const C=v??[],m=Object.create(null);for(const $ of C){var A;const g=he($.type);m[$.name.value]={type:g,description:(A=$.description)===null||A===void 0?void 0:A.value,defaultValue:Un($.defaultValue,g),deprecationReason:ro($),astNode:$}}return m}function ce(v){const C=Object.create(null);for(const $ of v){var m;const g=(m=$.fields)!==null&&m!==void 0?m:[];for(const E of g){var A;const N=he(E.type);C[E.name.value]={type:N,description:(A=E.description)===null||A===void 0?void 0:A.value,defaultValue:Un(E.defaultValue,N),deprecationReason:ro(E),astNode:E}}}return C}function Ze(v){const C=Object.create(null);for(const $ of v){var m;const g=(m=$.values)!==null&&m!==void 0?m:[];for(const E of g){var A;C[E.name.value]={description:(A=E.description)===null||A===void 0?void 0:A.value,deprecationReason:ro(E),astNode:E}}}return C}function ke(v){return v.flatMap(C=>{var m,A;return(m=(A=C.interfaces)===null||A===void 0?void 0:A.map(re))!==null&&m!==void 0?m:[]})}function Z(v){return v.flatMap(C=>{var m,A;return(m=(A=C.types)===null||A===void 0?void 0:A.map(re))!==null&&m!==void 0?m:[]})}function x(v){var C;const m=v.name.value,A=(C=u[m])!==null&&C!==void 0?C:[];switch(v.kind){case I.OBJECT_TYPE_DEFINITION:{var $;const V=[v,...A];return new Lt({name:m,description:($=v.description)===null||$===void 0?void 0:$.value,interfaces:()=>ke(V),fields:()=>Ge(V),astNode:v,extensionASTNodes:A})}case I.INTERFACE_TYPE_DEFINITION:{var g;const V=[v,...A];return new Xn({name:m,description:(g=v.description)===null||g===void 0?void 0:g.value,interfaces:()=>ke(V),fields:()=>Ge(V),astNode:v,extensionASTNodes:A})}case I.ENUM_TYPE_DEFINITION:{var E;const V=[v,...A];return new An({name:m,description:(E=v.description)===null||E===void 0?void 0:E.value,values:Ze(V),astNode:v,extensionASTNodes:A})}case I.UNION_TYPE_DEFINITION:{var N;const V=[v,...A];return new ws({name:m,description:(N=v.description)===null||N===void 0?void 0:N.value,types:()=>Z(V),astNode:v,extensionASTNodes:A})}case I.SCALAR_TYPE_DEFINITION:{var k;return new vn({name:m,description:(k=v.description)===null||k===void 0?void 0:k.value,specifiedByURL:qc(v),astNode:v,extensionASTNodes:A})}case I.INPUT_OBJECT_TYPE_DEFINITION:{var U;const V=[v,...A];return new Dr({name:m,description:(U=v.description)===null||U===void 0?void 0:U.value,fields:()=>ce(V),astNode:v,extensionASTNodes:A})}}}}const xc=mr([...za,...Qa],t=>t.name);function ro(t){const e=_o(ti,t);return e==null?void 0:e.reason}function qc(t){const e=_o(Y1,t);return e==null?void 0:e.url}function Ip(t,e){t!=null&&t.kind===I.DOCUMENT||$e(!1,"Must provide valid Document AST."),(e==null?void 0:e.assumeValid)!==!0&&(e==null?void 0:e.assumeValidSDL)!==!0&&tm(t);const r=vm({description:void 0,types:[],directives:[],extensions:Object.create(null),extensionASTNodes:[],assumeValid:!1},t,e);if(r.astNode==null)for(const o of r.types)switch(o.name){case"Query":r.query=o;break;case"Mutation":r.mutation=o;break;case"Subscription":r.subscription=o;break}const s=[...r.directives,...vr.filter(o=>r.directives.every(i=>i.name!==o.name))];return new nu({...r,directives:s})}function Am(t,e){const n=Va(t,{noLocation:e==null?void 0:e.noLocation,allowLegacyFragmentVariables:e==null?void 0:e.allowLegacyFragmentVariables});return Ip(n,{assumeValidSDL:e==null?void 0:e.assumeValidSDL,assumeValid:e==null?void 0:e.assumeValid})}const kp=t=>Array.isArray(t)?t:t?[t]:[];function bm(t,e){return String(t)<String(e)?-1:String(t)>String(e)?1:0}function Mc(t){var e,n;let r;return"alias"in t&&(r=(e=t.alias)===null||e===void 0?void 0:e.value),r==null&&"name"in t&&(r=(n=t.name)===null||n===void 0?void 0:n.value),r==null&&(r=t.kind),r}function ri(t,e,n){const r=Mc(t),s=Mc(e);return typeof n=="function"?n(r,s):bm(r,s)}function si(t){return t!=null}function Cm(t){return"errors"in t&&Array.isArray(t.errors)}const Pp=3;function Tm(t){return oi(t,[])}function oi(t,e){switch(typeof t){case"string":return JSON.stringify(t);case"function":return t.name?`[function ${t.name}]`:"[function]";case"object":return wm(t,e);default:return String(t)}}function Lc(t){return t instanceof X?t.toString():`${t.name}: ${t.message};
 ${t.stack}`}function wm(t,e){if(t===null)return"null";if(t instanceof Error)return Cm(t)?Lc(t)+`
`+jc(t.errors,e):Lc(t);if(e.includes(t))return"[Circular]";const n=[...e,t];if(Fm(t)){const r=t.toJSON();if(r!==t)return typeof r=="string"?r:oi(r,n)}else if(Array.isArray(t))return jc(t,n);return Im(t,n)}function Fm(t){return typeof t.toJSON=="function"}function Im(t,e){const n=Object.entries(t);return n.length===0?"{}":e.length>Pp?"["+km(t)+"]":"{ "+n.map(([s,o])=>s+": "+oi(o,e)).join(", ")+" }"}function jc(t,e){if(t.length===0)return"[]";if(e.length>Pp)return"[Array]";const n=t.length,r=[];for(let s=0;s<n;++s)r.push(oi(t[s],e));return"["+r.join(", ")+"]"}function km(t){const e=Object.prototype.toString.call(t).replace(/^\[object /,"").replace(/]$/,"");if(e==="Object"&&typeof t.constructor=="function"){const n=t.constructor.name;if(typeof n=="string"&&n!=="")return n}return e}function uu(t,e=["directives"]){return e.reduce((n,r)=>n==null?n:n[r],t==null?void 0:t.extensions)}function _n(t){if(Fe(t)){const e=_n(t.ofType);if(e.kind===I.NON_NULL_TYPE)throw new Error(`Invalid type node ${Tm(t)}. Inner type of non-null type cannot be a non-null type.`);return{kind:I.NON_NULL_TYPE,type:e}}else if(lt(t))return{kind:I.LIST_TYPE,type:_n(t.ofType)};return{kind:I.NAMED_TYPE,name:{kind:I.NAME,value:t.name}}}function da(t){if(t===null)return{kind:I.NULL};if(t===void 0)return null;if(Array.isArray(t)){const e=[];for(const n of t){const r=da(n);r!=null&&e.push(r)}return{kind:I.LIST,values:e}}if(typeof t=="object"){const e=[];for(const n in t){const r=t[n],s=da(r);s&&e.push({kind:I.OBJECT_FIELD,name:{kind:I.NAME,value:n},value:s})}return{kind:I.OBJECT,fields:e}}if(typeof t=="boolean")return{kind:I.BOOLEAN,value:t};if(typeof t=="number"&&isFinite(t)){const e=String(t);return Pm.test(e)?{kind:I.INT,value:e}:{kind:I.FLOAT,value:e}}if(typeof t=="string")return{kind:I.STRING,value:t};throw new TypeError(`Cannot convert value to AST: ${t}.`)}const Pm=/^-?(?:0|[1-9][0-9]*)$/;function Nm(t){const e=new WeakMap;return function(r){const s=e.get(r);if(s===void 0){const o=t(r);return e.set(r,o),o}return s}}const _m=Nm(function(e){const n=new Map,r=e.getQueryType();r&&n.set("query",r);const s=e.getMutationType();s&&n.set("mutation",s);const o=e.getSubscriptionType();return o&&n.set("subscription",o),n});function Om(t,e={}){const n=e.pathToDirectivesInExtensions,r=t.getTypeMap(),s=$m(t,n),o=s!=null?[s]:[],i=t.getDirectives();for(const a of i)Z1(a)||o.push(Bm(a,t,n));for(const a in r){const u=r[a],c=qs(u),l=eu(u);if(!(c||l))if(ge(u))o.push(Rm(u,t,n));else if(Be(u))o.push(xm(u,t,n));else if(Ct(u))o.push(qm(u,t,n));else if(Ye(u))o.push(Mm(u,t,n));else if(Et(u))o.push(Lm(u,t,n));else if(Vt(u))o.push(jm(u,t,n));else throw new Error(`Unknown type ${u}.`)}return{kind:I.DOCUMENT,definitions:o}}function $m(t,e){var n,r;const s=new Map([["query",void 0],["mutation",void 0],["subscription",void 0]]),o=[];if(t.astNode!=null&&o.push(t.astNode),t.extensionASTNodes!=null)for(const l of t.extensionASTNodes)o.push(l);for(const l of o)if(l.operationTypes)for(const p of l.operationTypes)s.set(p.operation,p);const i=_m(t);for(const[l,p]of s){const d=i.get(l);if(d!=null){const f=_n(d);p!=null?p.type=f:s.set(l,{kind:I.OPERATION_TYPE_DEFINITION,operation:l,type:f})}}const a=[...s.values()].filter(si),u=ts(t,t,e);if(!a.length&&!u.length)return null;const c={kind:a!=null?I.SCHEMA_DEFINITION:I.SCHEMA_EXTENSION,operationTypes:a,directives:u};return c.description=((r=(n=t.astNode)===null||n===void 0?void 0:n.description)!==null&&r!==void 0?r:t.description!=null)?{kind:I.STRING,value:t.description,block:!0}:void 0,c}function Bm(t,e,n){var r,s,o,i;return{kind:I.DIRECTIVE_DEFINITION,description:(s=(r=t.astNode)===null||r===void 0?void 0:r.description)!==null&&s!==void 0?s:t.description?{kind:I.STRING,value:t.description}:void 0,name:{kind:I.NAME,value:t.name},arguments:(o=t.args)===null||o===void 0?void 0:o.map(a=>Np(a,e,n)),repeatable:t.isRepeatable,locations:((i=t.locations)===null||i===void 0?void 0:i.map(a=>({kind:I.NAME,value:a})))||[]}}function ts(t,e,n){const r=uu(t,n);let s=[];t.astNode!=null&&s.push(t.astNode),"extensionASTNodes"in t&&t.extensionASTNodes!=null&&(s=s.concat(t.extensionASTNodes));let o;if(r!=null)o=cu(e,r);else{o=[];for(const i of s)i.directives&&o.push(...i.directives)}return o}function ii(t,e,n){var r,s;let o=[],i=null;const a=uu(t,n);let u;return a!=null?u=cu(e,a):u=(r=t.astNode)===null||r===void 0?void 0:r.directives,u!=null&&(o=u.filter(c=>c.name.value!=="deprecated"),t.deprecationReason!=null&&(i=(s=u.filter(c=>c.name.value==="deprecated"))===null||s===void 0?void 0:s[0])),t.deprecationReason!=null&&i==null&&(i=Vm(t.deprecationReason)),i==null?o:[i].concat(o)}function Np(t,e,n){var r,s,o;return{kind:I.INPUT_VALUE_DEFINITION,description:(s=(r=t.astNode)===null||r===void 0?void 0:r.description)!==null&&s!==void 0?s:t.description?{kind:I.STRING,value:t.description,block:!0}:void 0,name:{kind:I.NAME,value:t.name},type:_n(t.type),defaultValue:t.defaultValue!==void 0&&(o=Gn(t.defaultValue,t.type))!==null&&o!==void 0?o:void 0,directives:ii(t,e,n)}}function Rm(t,e,n){var r,s;return{kind:I.OBJECT_TYPE_DEFINITION,description:(s=(r=t.astNode)===null||r===void 0?void 0:r.description)!==null&&s!==void 0?s:t.description?{kind:I.STRING,value:t.description,block:!0}:void 0,name:{kind:I.NAME,value:t.name},fields:Object.values(t.getFields()).map(o=>_p(o,e,n)),interfaces:Object.values(t.getInterfaces()).map(o=>_n(o)),directives:ts(t,e,n)}}function xm(t,e,n){var r,s;const o={kind:I.INTERFACE_TYPE_DEFINITION,description:(s=(r=t.astNode)===null||r===void 0?void 0:r.description)!==null&&s!==void 0?s:t.description?{kind:I.STRING,value:t.description,block:!0}:void 0,name:{kind:I.NAME,value:t.name},fields:Object.values(t.getFields()).map(i=>_p(i,e,n)),directives:ts(t,e,n)};return"getInterfaces"in t&&(o.interfaces=Object.values(t.getInterfaces()).map(i=>_n(i))),o}function qm(t,e,n){var r,s;return{kind:I.UNION_TYPE_DEFINITION,description:(s=(r=t.astNode)===null||r===void 0?void 0:r.description)!==null&&s!==void 0?s:t.description?{kind:I.STRING,value:t.description,block:!0}:void 0,name:{kind:I.NAME,value:t.name},directives:ts(t,e,n),types:t.getTypes().map(o=>_n(o))}}function Mm(t,e,n){var r,s;return{kind:I.INPUT_OBJECT_TYPE_DEFINITION,description:(s=(r=t.astNode)===null||r===void 0?void 0:r.description)!==null&&s!==void 0?s:t.description?{kind:I.STRING,value:t.description,block:!0}:void 0,name:{kind:I.NAME,value:t.name},fields:Object.values(t.getFields()).map(o=>Gm(o,e,n)),directives:ts(t,e,n)}}function Lm(t,e,n){var r,s;return{kind:I.ENUM_TYPE_DEFINITION,description:(s=(r=t.astNode)===null||r===void 0?void 0:r.description)!==null&&s!==void 0?s:t.description?{kind:I.STRING,value:t.description,block:!0}:void 0,name:{kind:I.NAME,value:t.name},values:Object.values(t.getValues()).map(o=>Um(o,e,n)),directives:ts(t,e,n)}}function jm(t,e,n){var r,s,o;const i=uu(t,n),a=i?cu(e,i):((r=t.astNode)===null||r===void 0?void 0:r.directives)||[],u=t.specifiedByUrl||t.specifiedByURL;if(u&&!a.some(c=>c.name.value==="specifiedBy")){const c={url:u};a.push(xo("specifiedBy",c))}return{kind:I.SCALAR_TYPE_DEFINITION,description:(o=(s=t.astNode)===null||s===void 0?void 0:s.description)!==null&&o!==void 0?o:t.description?{kind:I.STRING,value:t.description,block:!0}:void 0,name:{kind:I.NAME,value:t.name},directives:a}}function _p(t,e,n){var r,s;return{kind:I.FIELD_DEFINITION,description:(s=(r=t.astNode)===null||r===void 0?void 0:r.description)!==null&&s!==void 0?s:t.description?{kind:I.STRING,value:t.description,block:!0}:void 0,name:{kind:I.NAME,value:t.name},arguments:t.args.map(o=>Np(o,e,n)),type:_n(t.type),directives:ii(t,e,n)}}function Gm(t,e,n){var r,s,o;return{kind:I.INPUT_VALUE_DEFINITION,description:(s=(r=t.astNode)===null||r===void 0?void 0:r.description)!==null&&s!==void 0?s:t.description?{kind:I.STRING,value:t.description,block:!0}:void 0,name:{kind:I.NAME,value:t.name},type:_n(t.type),directives:ii(t,e,n),defaultValue:(o=Gn(t.defaultValue,t.type))!==null&&o!==void 0?o:void 0}}function Um(t,e,n){var r,s;return{kind:I.ENUM_VALUE_DEFINITION,description:(s=(r=t.astNode)===null||r===void 0?void 0:r.description)!==null&&s!==void 0?s:t.description?{kind:I.STRING,value:t.description,block:!0}:void 0,name:{kind:I.NAME,value:t.name},directives:ii(t,e,n)}}function Vm(t){return xo("deprecated",{reason:t},ti)}function xo(t,e,n){const r=[];if(n!=null)for(const s of n.args){const o=s.name,i=e[o];if(i!==void 0){const a=Gn(i,s.type);a&&r.push({kind:I.ARGUMENT,name:{kind:I.NAME,value:o},value:a})}}else for(const s in e){const o=e[s],i=da(o);i&&r.push({kind:I.ARGUMENT,name:{kind:I.NAME,value:s},value:i})}return{kind:I.DIRECTIVE,name:{kind:I.NAME,value:t},arguments:r}}function cu(t,e){const n=[];for(const r in e){const s=e[r],o=t==null?void 0:t.getDirective(r);if(Array.isArray(s))for(const i of s)n.push(xo(r,i,o));else n.push(xo(r,s,o))}return n}const Jm=80;let Hr={};function fa(){Hr={}}function Hm(t){var e;const n=(e=t.name)===null||e===void 0?void 0:e.value;if(n!=null)switch(so(t,n),t.kind){case"EnumTypeDefinition":if(t.values)for(const r of t.values)so(r,n,r.name.value);break;case"ObjectTypeDefinition":case"InputObjectTypeDefinition":case"InterfaceTypeDefinition":if(t.fields){for(const r of t.fields)if(so(r,n,r.name.value),Zm(r)&&r.arguments)for(const s of r.arguments)so(s,n,r.name.value,s.name.value)}break}}function so(t,e,n,r){const s=Qm(t);if(typeof s!="string"||s.length===0)return;const o=[e];n&&(o.push(n),r&&o.push(r));const i=o.join(".");Hr[i]||(Hr[i]=[]),Hr[i].push(s)}function Wm(t){return`
# `+t.replace(/\n/g,`
# `)}function oe(t,e){return t?t.filter(n=>n).join(e||""):""}function Gc(t){var e;return(e=t==null?void 0:t.some(n=>n.includes(`
`)))!==null&&e!==void 0?e:!1}function Km(t){return(e,n,r,s,o)=>{var i;const a=[],u=s.reduce((p,d)=>(["fields","arguments","values"].includes(d)&&p.name&&a.push(p.name.value),p[d]),o[0]),c=[...a,(i=u==null?void 0:u.name)===null||i===void 0?void 0:i.value].filter(Boolean).join("."),l=[];return e.kind.includes("Definition")&&Hr[c]&&l.push(...Hr[c]),oe([...l.map(Wm),e.description,t(e,n,r,s,o)],`
`)}}function Es(t){return t&&`  ${t.replace(/\n/g,`
  `)}`}function en(t){return t&&t.length!==0?`{
${Es(oe(t,`
`))}
}`:""}function ut(t,e,n){return e?t+e+(n||""):""}function Xm(t,e=!1){const n=t.replace(/"""/g,'\\"""');return(t[0]===" "||t[0]==="	")&&t.indexOf(`
`)===-1?`"""${n.replace(/"$/,`"
`)}"""`:`"""
${e?n:Es(n)}
"""`}const Uc={Name:{leave:t=>t.value},Variable:{leave:t=>"$"+t.name},Document:{leave:t=>oe(t.definitions,`

`)},OperationDefinition:{leave:t=>{const e=ut("(",oe(t.variableDefinitions,", "),")");return oe([t.operation,oe([t.name,e]),oe(t.directives," ")]," ")+" "+t.selectionSet}},VariableDefinition:{leave:({variable:t,type:e,defaultValue:n,directives:r})=>t+": "+e+ut(" = ",n)+ut(" ",oe(r," "))},SelectionSet:{leave:({selections:t})=>en(t)},Field:{leave({alias:t,name:e,arguments:n,directives:r,selectionSet:s}){const o=ut("",t,": ")+e;let i=o+ut("(",oe(n,", "),")");return i.length>Jm&&(i=o+ut(`(
`,Es(oe(n,`
`)),`
)`)),oe([i,oe(r," "),s]," ")}},Argument:{leave:({name:t,value:e})=>t+": "+e},FragmentSpread:{leave:({name:t,directives:e})=>"..."+t+ut(" ",oe(e," "))},InlineFragment:{leave:({typeCondition:t,directives:e,selectionSet:n})=>oe(["...",ut("on ",t),oe(e," "),n]," ")},FragmentDefinition:{leave:({name:t,typeCondition:e,variableDefinitions:n,directives:r,selectionSet:s})=>`fragment ${t}${ut("(",oe(n,", "),")")} on ${e} ${ut("",oe(r," ")," ")}`+s},IntValue:{leave:({value:t})=>t},FloatValue:{leave:({value:t})=>t},StringValue:{leave:({value:t,block:e})=>e?Xm(t):JSON.stringify(t)},BooleanValue:{leave:({value:t})=>t?"true":"false"},NullValue:{leave:()=>"null"},EnumValue:{leave:({value:t})=>t},ListValue:{leave:({values:t})=>"["+oe(t,", ")+"]"},ObjectValue:{leave:({fields:t})=>"{"+oe(t,", ")+"}"},ObjectField:{leave:({name:t,value:e})=>t+": "+e},Directive:{leave:({name:t,arguments:e})=>"@"+t+ut("(",oe(e,", "),")")},NamedType:{leave:({name:t})=>t},ListType:{leave:({type:t})=>"["+t+"]"},NonNullType:{leave:({type:t})=>t+"!"},SchemaDefinition:{leave:({directives:t,operationTypes:e})=>oe(["schema",oe(t," "),en(e)]," ")},OperationTypeDefinition:{leave:({operation:t,type:e})=>t+": "+e},ScalarTypeDefinition:{leave:({name:t,directives:e})=>oe(["scalar",t,oe(e," ")]," ")},ObjectTypeDefinition:{leave:({name:t,interfaces:e,directives:n,fields:r})=>oe(["type",t,ut("implements ",oe(e," & ")),oe(n," "),en(r)]," ")},FieldDefinition:{leave:({name:t,arguments:e,type:n,directives:r})=>t+(Gc(e)?ut(`(
`,Es(oe(e,`
`)),`
)`):ut("(",oe(e,", "),")"))+": "+n+ut(" ",oe(r," "))},InputValueDefinition:{leave:({name:t,type:e,defaultValue:n,directives:r})=>oe([t+": "+e,ut("= ",n),oe(r," ")]," ")},InterfaceTypeDefinition:{leave:({name:t,interfaces:e,directives:n,fields:r})=>oe(["interface",t,ut("implements ",oe(e," & ")),oe(n," "),en(r)]," ")},UnionTypeDefinition:{leave:({name:t,directives:e,types:n})=>oe(["union",t,oe(e," "),ut("= ",oe(n," | "))]," ")},EnumTypeDefinition:{leave:({name:t,directives:e,values:n})=>oe(["enum",t,oe(e," "),en(n)]," ")},EnumValueDefinition:{leave:({name:t,directives:e})=>oe([t,oe(e," ")]," ")},InputObjectTypeDefinition:{leave:({name:t,directives:e,fields:n})=>oe(["input",t,oe(e," "),en(n)]," ")},DirectiveDefinition:{leave:({name:t,arguments:e,repeatable:n,locations:r})=>"directive @"+t+(Gc(e)?ut(`(
`,Es(oe(e,`
`)),`
)`):ut("(",oe(e,", "),")"))+(n?" repeatable":"")+" on "+oe(r," | ")},SchemaExtension:{leave:({directives:t,operationTypes:e})=>oe(["extend schema",oe(t," "),en(e)]," ")},ScalarTypeExtension:{leave:({name:t,directives:e})=>oe(["extend scalar",t,oe(e," ")]," ")},ObjectTypeExtension:{leave:({name:t,interfaces:e,directives:n,fields:r})=>oe(["extend type",t,ut("implements ",oe(e," & ")),oe(n," "),en(r)]," ")},InterfaceTypeExtension:{leave:({name:t,interfaces:e,directives:n,fields:r})=>oe(["extend interface",t,ut("implements ",oe(e," & ")),oe(n," "),en(r)]," ")},UnionTypeExtension:{leave:({name:t,directives:e,types:n})=>oe(["extend union",t,oe(e," "),ut("= ",oe(n," | "))]," ")},EnumTypeExtension:{leave:({name:t,directives:e,values:n})=>oe(["extend enum",t,oe(e," "),en(n)]," ")},InputObjectTypeExtension:{leave:({name:t,directives:e,fields:n})=>oe(["extend input",t,oe(e," "),en(n)]," ")}},zm=Object.keys(Uc).reduce((t,e)=>({...t,[e]:{leave:Km(Uc[e].leave)}}),{});function Ym(t){return Rs(t,zm)}function Zm(t){return t.kind==="FieldDefinition"}function Qm(t){const e=eD(t);if(e!==void 0)return tD(`
${e}`)}function eD(t){const e=t.loc;if(!e)return;const n=[];let r=e.startToken.prev;for(;r!=null&&r.kind===z.COMMENT&&r.next!=null&&r.prev!=null&&r.line+1===r.next.line&&r.line!==r.prev.line;){const s=String(r.value);n.push(s),r=r.prev}return n.length>0?n.reverse().join(`
`):void 0}function tD(t){const e=t.split(/\r\n|[\n\r]/g),n=nD(e);if(n!==0)for(let r=1;r<e.length;r++)e[r]=e[r].slice(n);for(;e.length>0&&Vc(e[0]);)e.shift();for(;e.length>0&&Vc(e[e.length-1]);)e.pop();return e.join(`
`)}function nD(t){let e=null;for(let n=1;n<t.length;n++){const r=t[n],s=Op(r);if(s!==r.length&&(e===null||s<e)&&(e=s,e===0))break}return e===null?0:e}function Op(t){let e=0;for(;e<t.length&&(t[e]===" "||t[e]==="	");)e++;return e}function Vc(t){return Op(t)===t.length}var Se;(function(t){t.TYPE="MapperKind.TYPE",t.SCALAR_TYPE="MapperKind.SCALAR_TYPE",t.ENUM_TYPE="MapperKind.ENUM_TYPE",t.COMPOSITE_TYPE="MapperKind.COMPOSITE_TYPE",t.OBJECT_TYPE="MapperKind.OBJECT_TYPE",t.INPUT_OBJECT_TYPE="MapperKind.INPUT_OBJECT_TYPE",t.ABSTRACT_TYPE="MapperKind.ABSTRACT_TYPE",t.UNION_TYPE="MapperKind.UNION_TYPE",t.INTERFACE_TYPE="MapperKind.INTERFACE_TYPE",t.ROOT_OBJECT="MapperKind.ROOT_OBJECT",t.QUERY="MapperKind.QUERY",t.MUTATION="MapperKind.MUTATION",t.SUBSCRIPTION="MapperKind.SUBSCRIPTION",t.DIRECTIVE="MapperKind.DIRECTIVE",t.FIELD="MapperKind.FIELD",t.COMPOSITE_FIELD="MapperKind.COMPOSITE_FIELD",t.OBJECT_FIELD="MapperKind.OBJECT_FIELD",t.ROOT_FIELD="MapperKind.ROOT_FIELD",t.QUERY_ROOT_FIELD="MapperKind.QUERY_ROOT_FIELD",t.MUTATION_ROOT_FIELD="MapperKind.MUTATION_ROOT_FIELD",t.SUBSCRIPTION_ROOT_FIELD="MapperKind.SUBSCRIPTION_ROOT_FIELD",t.INTERFACE_FIELD="MapperKind.INTERFACE_FIELD",t.INPUT_OBJECT_FIELD="MapperKind.INPUT_OBJECT_FIELD",t.ARGUMENT="MapperKind.ARGUMENT",t.ENUM_VALUE="MapperKind.ENUM_VALUE"})(Se||(Se={}));function Cr(t,e){if(e){const n=t[e.name];if(ge(n))return n}}function rD(t){if("getFields"in t){const e=t.getFields();for(const n in e)return e[n].name==="_fake"}return!1}function sD(t){switch(t.name){case aa.name:return aa;case ua.name:return ua;case ct.name:return ct;case Mt.name:return Mt;case To.name:return To;default:return t}}function oD(t,e){const n=Object.create(null);for(const d in t)n[d]=t[d];const r=Object.create(null);for(const d in n){const f=n[d];if(f==null||d.startsWith("__"))continue;const S=f.name;if(!S.startsWith("__")){if(r[S]!=null){console.warn(`Duplicate schema type name ${S} found; keeping the existing one found in the schema`);continue}r[S]=f}}for(const d in r)r[d]=a(r[d]);const s=e.map(d=>o(d));return{typeMap:r,directives:s};function o(d){if(Z1(d))return d;const f=d.toConfig();return f.args=i(f.args),new zn(f)}function i(d){const f={};for(const S in d){const b=d[S],F=p(b.type);F!=null&&(b.type=F,f[S]=b)}return f}function a(d){if(ge(d)){const f=d.toConfig(),S={...f,fields:()=>u(f.fields),interfaces:()=>l(f.interfaces)};return new Lt(S)}else if(Be(d)){const f=d.toConfig(),S={...f,fields:()=>u(f.fields)};return"interfaces"in S&&(S.interfaces=()=>l(f.interfaces)),new Xn(S)}else if(Ct(d)){const f=d.toConfig(),S={...f,types:()=>l(f.types)};return new ws(S)}else if(Ye(d)){const f=d.toConfig(),S={...f,fields:()=>c(f.fields)};return new Dr(S)}else if(Et(d)){const f=d.toConfig();return new An(f)}else if(Vt(d)){if(qs(d))return d;const f=d.toConfig();return new vn(f)}throw new Error(`Unexpected schema type: ${d}`)}function u(d){const f={};for(const S in d){const b=d[S],F=p(b.type);F!=null&&b.args&&(b.type=F,b.args=i(b.args),f[S]=b)}return f}function c(d){const f={};for(const S in d){const b=d[S],F=p(b.type);F!=null&&(b.type=F,f[S]=b)}return f}function l(d){const f=[];for(const S of d){const b=p(S);b!=null&&f.push(b)}return f}function p(d){if(lt(d)){const f=p(d.ofType);return f!=null?new Ft(f):null}else if(Fe(d)){const f=p(d.ofType);return f!=null?new Ce(f):null}else if(ei(d)){let f=n[d.name];return f===void 0&&(f=rD(d)?sD(d):a(d),r[f.name]=n[d.name]=f),f!=null?r[f.name]:null}return null}}function qo(t,e,n=null,r=null){if(e==null)return e;const s=Xa(t);if(zt(s))return n!=null?n(s,e):e;if(lt(s))return kp(e).map(o=>qo(s.ofType,o,n,r));if(Ye(s)){const o=s.getFields(),i={};for(const a in e){const u=o[a];u!=null&&(i[a]=qo(u.type,e[a],n,r))}return r!=null?r(s,i):i}}function $p(t,e){return qo(t,e,(n,r)=>{try{return n.serialize(r)}catch{return r}})}function Bp(t,e){return qo(t,e,(n,r)=>{try{return n.parseValue(r)}catch{return r}})}function ha(t,e={}){const n=xp(Rp(ma(Jc(iD(ma(Jc(t.getTypeMap(),t,$p),t,e,a=>zt(a)),t,e),t,Bp),t,e,a=>!zt(a)),t,e),t,e),r=t.getDirectives(),s=aD(r,t,e),{typeMap:o,directives:i}=oD(n,s);return new nu({...t.toConfig(),query:Cr(o,Cr(n,t.getQueryType())),mutation:Cr(o,Cr(n,t.getMutationType())),subscription:Cr(o,Cr(n,t.getSubscriptionType())),types:Object.values(o),directives:i})}function ma(t,e,n,r=()=>!0){const s={};for(const o in t)if(!o.startsWith("__")){const i=t[o];if(i==null||!r(i)){s[o]=i;continue}const a=cD(e,n,o);if(a==null){s[o]=i;continue}const u=a(i,e);if(u===void 0){s[o]=i;continue}s[o]=u}return s}function iD(t,e,n){const r=hD(n);return r?ma(t,e,{[Se.ENUM_TYPE]:s=>{const o=s.toConfig(),i=o.values,a={};for(const u in i){const c=i[u],l=r(c,s.name,e,u);if(l===void 0)a[u]=c;else if(Array.isArray(l)){const[p,d]=l;a[p]=d===void 0?c:d}else l!==null&&(a[u]=l)}return Eo(new An({...o,values:a}))}},s=>Et(s)):t}function Jc(t,e,n){const r=xp(t,e,{[Se.ARGUMENT]:s=>{if(s.defaultValue===void 0)return s;const o=Mo(t,s.type);if(o!=null)return{...s,defaultValue:n(o,s.defaultValue)}}});return Rp(r,e,{[Se.INPUT_OBJECT_FIELD]:s=>{if(s.defaultValue===void 0)return s;const o=Mo(r,s.type);if(o!=null)return{...s,defaultValue:n(o,s.defaultValue)}}})}function Mo(t,e){if(lt(e)){const n=Mo(t,e.ofType);return n!=null?new Ft(n):null}else if(Fe(e)){const n=Mo(t,e.ofType);return n!=null?new Ce(n):null}else if(ei(e)){const n=t[e.name];return n??null}return null}function Rp(t,e,n){const r={};for(const s in t)if(!s.startsWith("__")){const o=t[s];if(!ge(o)&&!Be(o)&&!Ye(o)){r[s]=o;continue}const i=pD(e,n,s);if(i==null){r[s]=o;continue}const a=o.toConfig(),u=a.fields,c={};for(const l in u){const p=u[l],d=i(p,l,s,e);if(d===void 0)c[l]=p;else if(Array.isArray(d)){const[f,S]=d;S.astNode!=null&&(S.astNode={...S.astNode,name:{...S.astNode.name,value:f}}),c[f]=S===void 0?p:S}else d!==null&&(c[l]=d)}ge(o)?r[s]=Eo(new Lt({...a,fields:c})):Be(o)?r[s]=Eo(new Xn({...a,fields:c})):r[s]=Eo(new Dr({...a,fields:c}))}return r}function xp(t,e,n){const r={};for(const s in t)if(!s.startsWith("__")){const o=t[s];if(!ge(o)&&!Be(o)){r[s]=o;continue}const i=dD(n);if(i==null){r[s]=o;continue}const a=o.toConfig(),u=a.fields,c={};for(const l in u){const p=u[l],d=p.args;if(d==null){c[l]=p;continue}const f=Object.keys(d);if(!f.length){c[l]=p;continue}const S={};for(const b of f){const F=d[b],y=i(F,l,s,e);if(y===void 0)S[b]=F;else if(Array.isArray(y)){const[T,O]=y;S[T]=O}else y!==null&&(S[b]=y)}c[l]={...p,args:S}}ge(o)?r[s]=new Lt({...a,fields:c}):Be(o)?r[s]=new Xn({...a,fields:c}):r[s]=new Dr({...a,fields:c})}return r}function aD(t,e,n){const r=fD(n);if(r==null)return t.slice();const s=[];for(const o of t){const i=r(o,e);i===void 0?s.push(o):i!==null&&s.push(i)}return s}function uD(t,e){var n,r,s;const o=t.getType(e),i=[Se.TYPE];return ge(o)?(i.push(Se.COMPOSITE_TYPE,Se.OBJECT_TYPE),e===((n=t.getQueryType())===null||n===void 0?void 0:n.name)?i.push(Se.ROOT_OBJECT,Se.QUERY):e===((r=t.getMutationType())===null||r===void 0?void 0:r.name)?i.push(Se.ROOT_OBJECT,Se.MUTATION):e===((s=t.getSubscriptionType())===null||s===void 0?void 0:s.name)&&i.push(Se.ROOT_OBJECT,Se.SUBSCRIPTION)):Ye(o)?i.push(Se.INPUT_OBJECT_TYPE):Be(o)?i.push(Se.COMPOSITE_TYPE,Se.ABSTRACT_TYPE,Se.INTERFACE_TYPE):Ct(o)?i.push(Se.COMPOSITE_TYPE,Se.ABSTRACT_TYPE,Se.UNION_TYPE):Et(o)?i.push(Se.ENUM_TYPE):Vt(o)&&i.push(Se.SCALAR_TYPE),i}function cD(t,e,n){const r=uD(t,n);let s;const o=[...r];for(;!s&&o.length>0;){const i=o.pop();s=e[i]}return s??null}function lD(t,e){var n,r,s;const o=t.getType(e),i=[Se.FIELD];return ge(o)?(i.push(Se.COMPOSITE_FIELD,Se.OBJECT_FIELD),e===((n=t.getQueryType())===null||n===void 0?void 0:n.name)?i.push(Se.ROOT_FIELD,Se.QUERY_ROOT_FIELD):e===((r=t.getMutationType())===null||r===void 0?void 0:r.name)?i.push(Se.ROOT_FIELD,Se.MUTATION_ROOT_FIELD):e===((s=t.getSubscriptionType())===null||s===void 0?void 0:s.name)&&i.push(Se.ROOT_FIELD,Se.SUBSCRIPTION_ROOT_FIELD)):Be(o)?i.push(Se.COMPOSITE_FIELD,Se.INTERFACE_FIELD):Ye(o)&&i.push(Se.INPUT_OBJECT_FIELD),i}function pD(t,e,n){const r=lD(t,n);let s;const o=[...r];for(;!s&&o.length>0;){const i=o.pop();s=e[i]}return s??null}function dD(t){const e=t[Se.ARGUMENT];return e??null}function fD(t){const e=t[Se.DIRECTIVE];return e??null}function hD(t){const e=t[Se.ENUM_VALUE];return e??null}function Eo(t){if(ge(t)){const e=t.toConfig();if(e.astNode!=null){const n=[];for(const r in e.fields){const s=e.fields[r];s.astNode!=null&&n.push(s.astNode)}e.astNode={...e.astNode,kind:I.OBJECT_TYPE_DEFINITION,fields:n}}return e.extensionASTNodes!=null&&(e.extensionASTNodes=e.extensionASTNodes.map(n=>({...n,kind:I.OBJECT_TYPE_EXTENSION,fields:void 0}))),new Lt(e)}else if(Be(t)){const e=t.toConfig();if(e.astNode!=null){const n=[];for(const r in e.fields){const s=e.fields[r];s.astNode!=null&&n.push(s.astNode)}e.astNode={...e.astNode,kind:I.INTERFACE_TYPE_DEFINITION,fields:n}}return e.extensionASTNodes!=null&&(e.extensionASTNodes=e.extensionASTNodes.map(n=>({...n,kind:I.INTERFACE_TYPE_EXTENSION,fields:void 0}))),new Xn(e)}else if(Ye(t)){const e=t.toConfig();if(e.astNode!=null){const n=[];for(const r in e.fields){const s=e.fields[r];s.astNode!=null&&n.push(s.astNode)}e.astNode={...e.astNode,kind:I.INPUT_OBJECT_TYPE_DEFINITION,fields:n}}return e.extensionASTNodes!=null&&(e.extensionASTNodes=e.extensionASTNodes.map(n=>({...n,kind:I.INPUT_OBJECT_TYPE_EXTENSION,fields:void 0}))),new Dr(e)}else if(Et(t)){const e=t.toConfig();if(e.astNode!=null){const n=[];for(const r in e.values){const s=e.values[r];s.astNode!=null&&n.push(s.astNode)}e.astNode={...e.astNode,values:n}}return e.extensionASTNodes!=null&&(e.extensionASTNodes=e.extensionASTNodes.map(n=>({...n,values:void 0}))),new An(e)}else return t}function mD(t){return DD(t.getTypeMap(),t.getDirectives()),t}function DD(t,e){const n=Object.create(null);for(const c in t){const l=t[c];if(l==null||c.startsWith("__"))continue;const p=l.name;if(!p.startsWith("__")){if(n[p]!=null){console.warn(`Duplicate schema type name ${p} found; keeping the existing one found in the schema`);continue}n[p]=l}}for(const c in n){const l=n[c];t[c]=l}for(const c of e)c.args=c.args.filter(l=>(l.type=u(l.type),l.type!==null));for(const c in t){const l=t[c];!c.startsWith("__")&&c in n&&l!=null&&r(l)}for(const c in t)!c.startsWith("__")&&!(c in n)&&delete t[c];function r(c){if(ge(c)){s(c),o(c);return}else if(Be(c)){s(c),"getInterfaces"in c&&o(c);return}else if(Ct(c)){a(c);return}else if(Ye(c)){i(c);return}else if(zt(c))return;throw new Error(`Unexpected schema type: ${c}`)}function s(c){const l=c.getFields();for(const[p,d]of Object.entries(l))d.args.map(f=>(f.type=u(f.type),f.type===null?null:f)).filter(Boolean),d.type=u(d.type),d.type===null&&delete l[p]}function o(c){if("getInterfaces"in c){const l=c.getInterfaces();l.push(...l.splice(0).map(p=>u(p)).filter(Boolean))}}function i(c){const l=c.getFields();for(const[p,d]of Object.entries(l))d.type=u(d.type),d.type===null&&delete l[p]}function a(c){const l=c.getTypes();l.push(...l.splice(0).map(p=>u(p)).filter(Boolean))}function u(c){if(lt(c)){const l=u(c.ofType);return l!=null?new Ft(l):null}else if(Fe(c)){const l=u(c.ofType);return l!=null?new Ce(l):null}else if(ei(c)){const l=t[c.name];if(l&&c!==l)return l}return c}}function qp(t,e){const n=t.getTypeMap();for(const r in n){const s=n[r];if(!qt(s).name.startsWith("__")&&ge(s)){const o=s.getFields();for(const i in o){const a=o[i];e(a,r,i)}}}}function Hc(t,e){const n=t.getTypeMap();for(const r in n){const s=n[r];if(!qt(s).name.startsWith("__")){if(ge(s)){const o=s.getFields();for(const i in o){const a=o[i];for(const u of a.args)u.defaultValue=e(u.type,u.defaultValue)}}else if(Ye(s)){const o=s.getFields();for(const i in o){const a=o[i];a.defaultValue=e(a.type,a.defaultValue)}}}}}function ai(t,e=!1){const n=t[0]||{},r={};e&&Object.setPrototypeOf(r,Object.create(Object.getPrototypeOf(n)));for(const s of t)if(wi(n)&&wi(s)){if(e){const o=Object.getPrototypeOf(r),i=Object.getPrototypeOf(s);if(i)for(const a of Object.getOwnPropertyNames(i)){const u=Object.getOwnPropertyDescriptor(i,a);si(u)&&Object.defineProperty(o,a,u)}}for(const o in s)wi(s[o])?o in r?r[o]=ai([r[o],s[o]],e):Object.assign(r,{[o]:s[o]}):Object.assign(r,{[o]:s[o]})}return r}function wi(t){return t&&typeof t=="object"&&!Array.isArray(t)}function SD(t){return t&&typeof t=="object"&&"kind"in t&&t.kind===I.DOCUMENT}function ED(t,e={}){const{requireResolversForArgs:n,requireResolversForNonScalar:r,requireResolversForAllFields:s}=e;if(s&&(n||r))throw new TypeError("requireResolversForAllFields takes precedence over the more specific assertions. Please configure either requireResolversForAllFields or requireResolversForArgs / requireResolversForNonScalar, but not a combination of them.");qp(t,(o,i,a)=>{s&&Fi("requireResolversForAllFields",s,o,i,a),n&&o.args.length>0&&Fi("requireResolversForArgs",n,o,i,a),r!=="ignore"&&!Vt(qt(o.type))&&Fi("requireResolversForNonScalar",r,o,i,a)})}function Fi(t,e,n,r,s){if(!n.resolve){const o=`Resolver missing for "${r}.${s}".
To disable this validator, use:
  resolverValidationOptions: {
    ${t}: 'ignore'
  }`;if(e==="error")throw new Error(o);e==="warn"&&console.warn(o);return}if(typeof n.resolve!="function")throw new Error(`Resolver "${r}.${s}" must be a function`)}function yD(t,e){ha(t,{[Se.ABSTRACT_TYPE]:n=>{if(!n.resolveType){const r=`Type "${n.name}" is missing a "__resolveType" resolver. Pass 'ignore' into "resolverValidationOptions.requireResolversForResolveType" to disable this error.`;if(e==="error")throw new Error(r);e==="warn"&&console.warn(r)}}})}function gD(t,e){const n={},r=t.getTypeMap();for(const s in r){const o=r[s];if("getInterfaces"in o){n[s]={};for(const a of o.getInterfaces())if(e[a.name])for(const u in e[a.name])(u==="__isTypeOf"||!u.startsWith("__"))&&(n[s][u]=e[a.name][u]);const i=e[s];n[s]={...n[s],...i}}else{const i=e[s];i!=null&&(n[s]=i)}}return n}function vD({schema:t,resolvers:e,defaultFieldResolver:n,resolverValidationOptions:r={},inheritResolversFromInterfaces:s=!1,updateResolversInPlace:o=!1}){const{requireResolversToMatchSchema:i="error",requireResolversForResolveType:a}=r,u=s?gD(t,e):e;for(const c in u){const l=u[c];if(typeof l!=="object")throw new Error(`"${c}" defined in resolvers, but has invalid value "${l}". The resolver's value must be of type object.`);const d=t.getType(c);if(d==null){if(i==="ignore")continue;throw new Error(`"${c}" defined in resolvers, but not in schema`)}else if(qs(d))for(const f in l)f.startsWith("__")?d[f.substring(2)]=l[f]:d[f]=l[f];else if(Et(d)){const f=d.getValues();for(const S in l)if(!S.startsWith("__")&&!f.some(b=>b.name===S)&&i&&i!=="ignore")throw new Error(`${d.name}.${S} was defined in resolvers, but not present within ${d.name}`)}else if(Ct(d)){for(const f in l)if(!f.startsWith("__")&&i&&i!=="ignore")throw new Error(`${d.name}.${f} was defined in resolvers, but ${d.name} is not an object or interface type`)}else if(ge(d)||Be(d)){for(const f in l)if(!f.startsWith("__"))if(d.getFields()[f]==null){if(i&&i!=="ignore")throw new Error(`${c}.${f} defined in resolvers, but not in schema`)}else{const F=l[f];if(typeof F!="function"&&typeof F!="object")throw new Error(`Resolver ${c}.${f} must be object or function`)}}}return t=o?AD(t,u,n):bD(t,u,n),a&&a!=="ignore"&&yD(t,a),t}function AD(t,e,n){var r,s,o,i,a,u,c,l,p,d,f,S;const b=t.getTypeMap();for(const F in e){const y=t.getType(F),T=e[F];if(Vt(y))for(const O in T)O.startsWith("__")?y[O.substring(2)]=T[O]:O==="astNode"&&y.astNode!=null?y.astNode={...y.astNode,description:(s=(r=T==null?void 0:T.astNode)===null||r===void 0?void 0:r.description)!==null&&s!==void 0?s:y.astNode.description,directives:((o=y.astNode.directives)!==null&&o!==void 0?o:[]).concat((a=(i=T==null?void 0:T.astNode)===null||i===void 0?void 0:i.directives)!==null&&a!==void 0?a:[])}:O==="extensionASTNodes"&&y.extensionASTNodes!=null?y.extensionASTNodes=y.extensionASTNodes.concat((u=T==null?void 0:T.extensionASTNodes)!==null&&u!==void 0?u:[]):O==="extensions"&&y.extensions!=null&&T.extensions!=null?y.extensions=Object.assign(Object.create(null),y.extensions,T.extensions):y[O]=T[O];else if(Et(y)){const O=y.toConfig(),j=O.values;for(const M in T)M.startsWith("__")?O[M.substring(2)]=T[M]:M==="astNode"&&O.astNode!=null?O.astNode={...O.astNode,description:(l=(c=T==null?void 0:T.astNode)===null||c===void 0?void 0:c.description)!==null&&l!==void 0?l:O.astNode.description,directives:((p=O.astNode.directives)!==null&&p!==void 0?p:[]).concat((f=(d=T==null?void 0:T.astNode)===null||d===void 0?void 0:d.directives)!==null&&f!==void 0?f:[])}:M==="extensionASTNodes"&&O.extensionASTNodes!=null?O.extensionASTNodes=O.extensionASTNodes.concat((S=T==null?void 0:T.extensionASTNodes)!==null&&S!==void 0?S:[]):M==="extensions"&&y.extensions!=null&&T.extensions!=null?y.extensions=Object.assign(Object.create(null),y.extensions,T.extensions):j[M]&&(j[M].value=T[M]);b[F]=new An(O)}else if(Ct(y))for(const O in T)O.startsWith("__")&&(y[O.substring(2)]=T[O]);else if(ge(y)||Be(y))for(const O in T){if(O.startsWith("__")){y[O.substring(2)]=T[O];continue}const M=y.getFields()[O];if(M!=null){const ee=T[O];typeof ee=="function"?M.resolve=ee.bind(T):Mp(M,ee)}}}return Hc(t,$p),mD(t),Hc(t,Bp),n!=null&&qp(t,F=>{F.resolve||(F.resolve=n)}),t}function bD(t,e,n){return t=ha(t,{[Se.SCALAR_TYPE]:r=>{var s,o,i,a,u,c;const l=r.toConfig(),p=e[r.name];if(!qs(r)&&p!=null){for(const d in p)d.startsWith("__")?l[d.substring(2)]=p[d]:d==="astNode"&&l.astNode!=null?l.astNode={...l.astNode,description:(o=(s=p==null?void 0:p.astNode)===null||s===void 0?void 0:s.description)!==null&&o!==void 0?o:l.astNode.description,directives:((i=l.astNode.directives)!==null&&i!==void 0?i:[]).concat((u=(a=p==null?void 0:p.astNode)===null||a===void 0?void 0:a.directives)!==null&&u!==void 0?u:[])}:d==="extensionASTNodes"&&l.extensionASTNodes!=null?l.extensionASTNodes=l.extensionASTNodes.concat((c=p==null?void 0:p.extensionASTNodes)!==null&&c!==void 0?c:[]):d==="extensions"&&l.extensions!=null&&p.extensions!=null?l.extensions=Object.assign(Object.create(null),r.extensions,p.extensions):l[d]=p[d];return new vn(l)}},[Se.ENUM_TYPE]:r=>{var s,o,i,a,u,c;const l=e[r.name],p=r.toConfig(),d=p.values;if(l!=null){for(const f in l)f.startsWith("__")?p[f.substring(2)]=l[f]:f==="astNode"&&p.astNode!=null?p.astNode={...p.astNode,description:(o=(s=l==null?void 0:l.astNode)===null||s===void 0?void 0:s.description)!==null&&o!==void 0?o:p.astNode.description,directives:((i=p.astNode.directives)!==null&&i!==void 0?i:[]).concat((u=(a=l==null?void 0:l.astNode)===null||a===void 0?void 0:a.directives)!==null&&u!==void 0?u:[])}:f==="extensionASTNodes"&&p.extensionASTNodes!=null?p.extensionASTNodes=p.extensionASTNodes.concat((c=l==null?void 0:l.extensionASTNodes)!==null&&c!==void 0?c:[]):f==="extensions"&&p.extensions!=null&&l.extensions!=null?p.extensions=Object.assign(Object.create(null),r.extensions,l.extensions):d[f]&&(d[f].value=l[f]);return new An(p)}},[Se.UNION_TYPE]:r=>{const s=e[r.name];if(s!=null){const o=r.toConfig();return s.__resolveType&&(o.resolveType=s.__resolveType),new ws(o)}},[Se.OBJECT_TYPE]:r=>{const s=e[r.name];if(s!=null){const o=r.toConfig();return s.__isTypeOf&&(o.isTypeOf=s.__isTypeOf),new Lt(o)}},[Se.INTERFACE_TYPE]:r=>{const s=e[r.name];if(s!=null){const o=r.toConfig();return s.__resolveType&&(o.resolveType=s.__resolveType),new Xn(o)}},[Se.COMPOSITE_FIELD]:(r,s,o)=>{const i=e[o];if(i!=null){const a=i[s];if(a!=null){const u={...r};return typeof a=="function"?u.resolve=a.bind(i):Mp(u,a),u}}}}),n!=null&&(t=ha(t,{[Se.OBJECT_FIELD]:r=>({...r,resolve:r.resolve!=null?r.resolve:n})})),t}function Mp(t,e){for(const n in e)t[n]=e[n]}function Lp(t,e){if(!t||Array.isArray(t)&&t.length===0)return{};if(!Array.isArray(t))return t;if(t.length===1)return t[0]||{};const n=new Array;for(let s of t)Array.isArray(s)&&(s=Lp(s)),typeof s=="object"&&s&&n.push(s);return ai(n,!0)}function CD(t,e,n){const r=TD([...e,...t].filter(si),n);return n&&n.sort&&r.sort(ri),r}function TD(t,e){return t.reduce((n,r)=>{const s=n.findIndex(o=>o.name.value===r.name.value);return s===-1?n.concat([r]):(e!=null&&e.reverseArguments||(n[s]=r),n)},[])}function wD(t,e){return!!t.find(n=>n.name.value===e.name.value)}function jp(t,e){var n;return!!(!((n=e==null?void 0:e[t.name.value])===null||n===void 0)&&n.repeatable)}function FD(t,e){return e.some(({value:n})=>n===t.value)}function Gp(t,e){const n=[...e];for(const r of t){const s=n.findIndex(o=>o.name.value===r.name.value);if(s>-1){const o=n[s];if(o.value.kind==="ListValue"){const i=o.value.values,a=r.value.values;o.value.values=ND(i,a,(u,c)=>{const l=u.value;return!l||!c.some(p=>p.value===l)})}else o.value=r.value}else n.push(r)}return n}function ID(t,e){return t.map((n,r,s)=>{const o=s.findIndex(i=>i.name.value===n.name.value);if(o!==r&&!jp(n,e)){const i=s[o];return n.arguments=Gp(n.arguments,i.arguments),null}return n}).filter(si)}function $n(t=[],e=[],n,r){const s=n&&n.reverseDirectives,o=s?t:e,i=s?e:t,a=ID([...o],r);for(const u of i)if(wD(a,u)&&!jp(u,r)){const c=a.findIndex(p=>p.name.value===u.name.value),l=a[c];a[c].arguments=Gp(u.arguments||[],l.arguments||[])}else a.push(u);return a}function kD(t,e){const n=mt({...t,description:void 0}),r=mt({...e,description:void 0}),s=new RegExp("(directive @w*d*)|( on .*$)","g");if(!(n.replace(s,"")===r.replace(s,"")))throw new Error(`Unable to merge GraphQL directive "${t.name.value}". 
Existing directive:  
	${r} 
Received directive: 
	${n}`)}function PD(t,e){return e?(kD(t,e),{...t,locations:[...e.locations,...t.locations.filter(n=>!FD(n,e.locations))]}):t}function ND(t,e,n){return t.concat(e.filter(r=>n(r,t)))}function _D(t,e,n,r){if(n!=null&&n.consistentEnumMerge){const i=[];t&&i.push(...t),t=e,e=i}const s=new Map;if(t)for(const i of t)s.set(i.name.value,i);if(e)for(const i of e){const a=i.name.value;if(s.has(a)){const u=s.get(a);u.description=i.description||u.description,u.directives=$n(i.directives,u.directives,r)}else s.set(a,i)}const o=[...s.values()];return n&&n.sort&&o.sort(ri),o}function OD(t,e,n,r){return e?{name:t.name,description:t.description||e.description,kind:n!=null&&n.convertExtensions||t.kind==="EnumTypeDefinition"||e.kind==="EnumTypeDefinition"?"EnumTypeDefinition":"EnumTypeExtension",loc:t.loc,directives:$n(t.directives,e.directives,n,r),values:_D(t.values,e.values,n)}:n!=null&&n.convertExtensions?{...t,kind:I.ENUM_TYPE_DEFINITION}:t}function $D(t){return typeof t=="string"}function BD(t){return t instanceof Ua}function Wc(t){let e=t;for(;e.kind===I.LIST_TYPE||e.kind==="NonNullType";)e=e.type;return e}function Kc(t){return t.kind!==I.NAMED_TYPE}function Da(t){return t.kind===I.LIST_TYPE}function cr(t){return t.kind===I.NON_NULL_TYPE}function Lo(t){return Da(t)?`[${Lo(t.type)}]`:cr(t)?`${Lo(t.type)}!`:t.name.value}var Ln;(function(t){t[t.A_SMALLER_THAN_B=-1]="A_SMALLER_THAN_B",t[t.A_EQUALS_B=0]="A_EQUALS_B",t[t.A_GREATER_THAN_B=1]="A_GREATER_THAN_B"})(Ln||(Ln={}));function RD(t,e){return t==null&&e==null?Ln.A_EQUALS_B:t==null?Ln.A_SMALLER_THAN_B:e==null?Ln.A_GREATER_THAN_B:t<e?Ln.A_SMALLER_THAN_B:t>e?Ln.A_GREATER_THAN_B:Ln.A_EQUALS_B}function xD(t,e){const n=t.findIndex(r=>r.name.value===e.name.value);return[n>-1?t[n]:null,n]}function lu(t,e,n,r,s){const o=[];if(n!=null&&o.push(...n),e!=null)for(const i of e){const[a,u]=xD(o,i);if(a&&!(r!=null&&r.ignoreFieldConflicts)){const c=(r==null?void 0:r.onFieldTypeConflict)&&r.onFieldTypeConflict(a,i,t,r==null?void 0:r.throwOnConflict)||qD(t,a,i,r==null?void 0:r.throwOnConflict);c.arguments=CD(i.arguments||[],a.arguments||[],r),c.directives=$n(i.directives,a.directives,r,s),c.description=i.description||a.description,o[u]=c}else o.push(i)}if(r&&r.sort&&o.sort(ri),r&&r.exclusions){const i=r.exclusions;return o.filter(a=>!i.includes(`${t.name.value}.${a.name.value}`))}return o}function qD(t,e,n,r=!1){const s=Lo(e.type),o=Lo(n.type);if(s!==o){const i=Wc(e.type),a=Wc(n.type);if(i.name.value!==a.name.value)throw new Error(`Field "${n.name.value}" already defined with a different type. Declared as "${i.name.value}", but you tried to override with "${a.name.value}"`);if(!ds(e.type,n.type,!r))throw new Error(`Field '${t.name.value}.${e.name.value}' changed type from '${s}' to '${o}'`)}return cr(n.type)&&!cr(e.type)&&(e.type=n.type),e}function ds(t,e,n=!1){if(!Kc(t)&&!Kc(e))return t.toString()===e.toString();if(cr(e)){const r=cr(t)?t.type:t;return ds(r,e.type)}return cr(t)?ds(e,t,n):Da(t)?Da(e)&&ds(t.type,e.type)||cr(e)&&ds(t,e.type):!1}function MD(t,e,n,r){if(e)try{return{name:t.name,description:t.description||e.description,kind:n!=null&&n.convertExtensions||t.kind==="InputObjectTypeDefinition"||e.kind==="InputObjectTypeDefinition"?"InputObjectTypeDefinition":"InputObjectTypeExtension",loc:t.loc,fields:lu(t,t.fields,e.fields,n),directives:$n(t.directives,e.directives,n,r)}}catch(s){throw new Error(`Unable to merge GraphQL input type "${t.name.value}": ${s.message}`)}return n!=null&&n.convertExtensions?{...t,kind:I.INPUT_OBJECT_TYPE_DEFINITION}:t}function LD(t,e){return!!t.find(n=>n.name.value===e.name.value)}function pu(t=[],e=[],n={}){const r=[...e,...t.filter(s=>!LD(e,s))];return n&&n.sort&&r.sort(ri),r}function jD(t,e,n,r){if(e)try{return{name:t.name,description:t.description||e.description,kind:n!=null&&n.convertExtensions||t.kind==="InterfaceTypeDefinition"||e.kind==="InterfaceTypeDefinition"?"InterfaceTypeDefinition":"InterfaceTypeExtension",loc:t.loc,fields:lu(t,t.fields,e.fields,n),directives:$n(t.directives,e.directives,n,r),interfaces:t.interfaces?pu(t.interfaces,e.interfaces,n):void 0}}catch(s){throw new Error(`Unable to merge GraphQL interface "${t.name.value}": ${s.message}`)}return n!=null&&n.convertExtensions?{...t,kind:I.INTERFACE_TYPE_DEFINITION}:t}function GD(t,e,n,r){if(e)try{return{name:t.name,description:t.description||e.description,kind:n!=null&&n.convertExtensions||t.kind==="ObjectTypeDefinition"||e.kind==="ObjectTypeDefinition"?"ObjectTypeDefinition":"ObjectTypeExtension",loc:t.loc,fields:lu(t,t.fields,e.fields,n),directives:$n(t.directives,e.directives,n,r),interfaces:pu(t.interfaces,e.interfaces,n)}}catch(s){throw new Error(`Unable to merge GraphQL type "${t.name.value}": ${s.message}`)}return n!=null&&n.convertExtensions?{...t,kind:I.OBJECT_TYPE_DEFINITION}:t}function UD(t,e,n,r){return e?{name:t.name,description:t.description||e.description,kind:n!=null&&n.convertExtensions||t.kind==="ScalarTypeDefinition"||e.kind==="ScalarTypeDefinition"?"ScalarTypeDefinition":"ScalarTypeExtension",loc:t.loc,directives:$n(t.directives,e.directives,n,r)}:n!=null&&n.convertExtensions?{...t,kind:I.SCALAR_TYPE_DEFINITION}:t}function VD(t,e,n,r){return e?{name:t.name,description:t.description||e.description,directives:$n(t.directives,e.directives,n,r),kind:n!=null&&n.convertExtensions||t.kind==="UnionTypeDefinition"||e.kind==="UnionTypeDefinition"?I.UNION_TYPE_DEFINITION:I.UNION_TYPE_EXTENSION,loc:t.loc,types:pu(t.types,e.types,n)}:n!=null&&n.convertExtensions?{...t,kind:I.UNION_TYPE_DEFINITION}:t}const Sa={query:"Query",mutation:"Mutation",subscription:"Subscription"};function JD(t=[],e=[]){const n=[];for(const r in Sa){const s=t.find(o=>o.operation===r)||e.find(o=>o.operation===r);s&&n.push(s)}return n}function HD(t,e,n,r){return e?{kind:t.kind===I.SCHEMA_DEFINITION||e.kind===I.SCHEMA_DEFINITION?I.SCHEMA_DEFINITION:I.SCHEMA_EXTENSION,description:t.description||e.description,directives:$n(t.directives,e.directives,n,r),operationTypes:JD(t.operationTypes,e.operationTypes)}:n!=null&&n.convertExtensions?{...t,kind:I.SCHEMA_DEFINITION}:t}const jr="SCHEMA_DEF_SYMBOL";function WD(t){return"name"in t}function Xc(t,e,n={}){var r,s,o;const i=n;for(const a of t)if(WD(a)){const u=(r=a.name)===null||r===void 0?void 0:r.value;if(e!=null&&e.commentDescriptions&&Hm(a),u==null)continue;if(!((s=e==null?void 0:e.exclusions)===null||s===void 0)&&s.includes(u+".*")||!((o=e==null?void 0:e.exclusions)===null||o===void 0)&&o.includes(u))delete i[u];else switch(a.kind){case I.OBJECT_TYPE_DEFINITION:case I.OBJECT_TYPE_EXTENSION:i[u]=GD(a,i[u],e,n);break;case I.ENUM_TYPE_DEFINITION:case I.ENUM_TYPE_EXTENSION:i[u]=OD(a,i[u],e,n);break;case I.UNION_TYPE_DEFINITION:case I.UNION_TYPE_EXTENSION:i[u]=VD(a,i[u],e,n);break;case I.SCALAR_TYPE_DEFINITION:case I.SCALAR_TYPE_EXTENSION:i[u]=UD(a,i[u],e,n);break;case I.INPUT_OBJECT_TYPE_DEFINITION:case I.INPUT_OBJECT_TYPE_EXTENSION:i[u]=MD(a,i[u],e,n);break;case I.INTERFACE_TYPE_DEFINITION:case I.INTERFACE_TYPE_EXTENSION:i[u]=jD(a,i[u],e,n);break;case I.DIRECTIVE_DEFINITION:i[u]=PD(a,i[u]);break}}else(a.kind===I.SCHEMA_DEFINITION||a.kind===I.SCHEMA_EXTENSION)&&(i[jr]=HD(a,i[jr],e));return i}function zc(t,e){fa();const n={kind:I.DOCUMENT,definitions:KD(t,{useSchemaDefinition:!0,forceSchemaDefinition:!1,throwOnConflict:!1,commentDescriptions:!1,...e})};let r;return e!=null&&e.commentDescriptions?r=Ym(n):r=n,fa(),r}function qr(t,e,n=[],r=[],s=new Set){if(t&&!s.has(t))if(s.add(t),typeof t=="function")qr(t(),e,n,r,s);else if(Array.isArray(t))for(const o of t)qr(o,e,n,r,s);else if(tu(t)){const o=Om(t,e);qr(o.definitions,e,n,r,s)}else if($D(t)||BD(t)){const o=Va(t,e);qr(o.definitions,e,n,r,s)}else if(typeof t=="object"&&K2(t))t.kind===I.DIRECTIVE_DEFINITION?n.push(t):r.push(t);else if(SD(t))qr(t.definitions,e,n,r,s);else throw new Error(`typeDefs must contain only strings, documents, schemas, or functions, got ${typeof t}`);return{allDirectives:n,allNodes:r}}function KD(t,e){var n,r,s;fa();const{allDirectives:o,allNodes:i}=qr(t,e),a=Xc(o,e),u=Xc(i,e,a);if(e!=null&&e.useSchemaDefinition){const l=u[jr]||{kind:I.SCHEMA_DEFINITION,operationTypes:[]},p=l.operationTypes;for(const d in Sa)if(!p.find(S=>S.operation===d)){const S=Sa[d],b=u[S];b!=null&&b.name!=null&&p.push({kind:I.OPERATION_TYPE_DEFINITION,type:{kind:I.NAMED_TYPE,name:b.name},operation:d})}((n=l==null?void 0:l.operationTypes)===null||n===void 0?void 0:n.length)!=null&&l.operationTypes.length>0&&(u[jr]=l)}e!=null&&e.forceSchemaDefinition&&!(!((s=(r=u[jr])===null||r===void 0?void 0:r.operationTypes)===null||s===void 0)&&s.length)&&(u[jr]={kind:I.SCHEMA_DEFINITION,operationTypes:[{kind:I.OPERATION_TYPE_DEFINITION,operation:"query",type:{kind:I.NAMED_TYPE,name:{kind:I.NAME,value:"Query"}}}]});const c=Object.values(u);if(e!=null&&e.sort){const l=typeof e.sort=="function"?e.sort:RD;c.sort((p,d)=>{var f,S;return l((f=p.name)===null||f===void 0?void 0:f.value,(S=d.name)===null||S===void 0?void 0:S.value)})}return c}function XD(t){return ai(t)}function Tr(t,e){t&&(t.extensions=ai([t.extensions||{},e||{}]))}function zD(t,e){Tr(t,e.schemaExtensions);for(const[n,r]of Object.entries(e.types||{})){const s=t.getType(n);if(s){if(Tr(s,r.extensions),r.type==="object"||r.type==="interface")for(const[o,i]of Object.entries(r.fields)){const a=s.getFields()[o];if(a){Tr(a,i.extensions);for(const[u,c]of Object.entries(i.arguments))Tr(a.args.find(l=>l.name===u),c)}}else if(r.type==="input")for(const[o,i]of Object.entries(r.fields)){const a=s.getFields()[o];Tr(a,i.extensions)}else if(r.type==="enum")for(const[o,i]of Object.entries(r.values)){const a=s.getValue(o);Tr(a,i)}}}return t}function YD({typeDefs:t,resolvers:e={},resolverValidationOptions:n={},inheritResolversFromInterfaces:r=!1,updateResolversInPlace:s=!1,schemaExtensions:o,...i}){if(typeof n!="object")throw new Error("Expected `resolverValidationOptions` to be an object");if(!t)throw new Error("Must provide typeDefs");let a;if(tu(t))a=t;else if(i!=null&&i.commentDescriptions){const u=zc(t,{...i,commentDescriptions:!0});a=Am(u,i)}else{const u=zc(t,i);a=Ip(u,i)}return a=vD({schema:a,resolvers:Lp(e),resolverValidationOptions:n,inheritResolversFromInterfaces:r,updateResolversInPlace:s}),Object.keys(n).length>0&&ED(a,n),o&&(o=XD(kp(o)),zD(a,o)),a}const ZD=new Error("request for lock canceled");var QD=function(t,e,n,r){function s(o){return o instanceof n?o:new n(function(i){i(o)})}return new(n||(n=Promise))(function(o,i){function a(l){try{c(r.next(l))}catch(p){i(p)}}function u(l){try{c(r.throw(l))}catch(p){i(p)}}function c(l){l.done?o(l.value):s(l.value).then(a,u)}c((r=r.apply(t,[])).next())})};class e3{constructor(e,n=ZD){this._value=e,this._cancelError=n,this._weightedQueues=[],this._weightedWaiters=[]}acquire(e=1){if(e<=0)throw new Error(`invalid weight ${e}: must be positive`);return new Promise((n,r)=>{this._weightedQueues[e-1]||(this._weightedQueues[e-1]=[]),this._weightedQueues[e-1].push({resolve:n,reject:r}),this._dispatch()})}runExclusive(e,n=1){return QD(this,void 0,void 0,function*(){const[r,s]=yield this.acquire(n);try{return yield e(r)}finally{s()}})}waitForUnlock(e=1){if(e<=0)throw new Error(`invalid weight ${e}: must be positive`);return new Promise(n=>{this._weightedWaiters[e-1]||(this._weightedWaiters[e-1]=[]),this._weightedWaiters[e-1].push(n),this._dispatch()})}isLocked(){return this._value<=0}getValue(){return this._value}setValue(e){this._value=e,this._dispatch()}release(e=1){if(e<=0)throw new Error(`invalid weight ${e}: must be positive`);this._value+=e,this._dispatch()}cancel(){this._weightedQueues.forEach(e=>e.forEach(n=>n.reject(this._cancelError))),this._weightedQueues=[]}_dispatch(){var e;for(let n=this._value;n>0;n--){const r=(e=this._weightedQueues[n-1])===null||e===void 0?void 0:e.shift();if(!r)continue;const s=this._value,o=n;this._value-=n,n=this._value+1,r.resolve([s,this._newReleaser(o)])}this._drainUnlockWaiters()}_newReleaser(e){let n=!1;return()=>{n||(n=!0,this.release(e))}}_drainUnlockWaiters(){for(let e=this._value;e>0;e--)this._weightedWaiters[e-1]&&(this._weightedWaiters[e-1].forEach(n=>n()),this._weightedWaiters[e-1]=[])}}var t3=function(t,e,n,r){function s(o){return o instanceof n?o:new n(function(i){i(o)})}return new(n||(n=Promise))(function(o,i){function a(l){try{c(r.next(l))}catch(p){i(p)}}function u(l){try{c(r.throw(l))}catch(p){i(p)}}function c(l){l.done?o(l.value):s(l.value).then(a,u)}c((r=r.apply(t,[])).next())})};class n3{constructor(e){this._semaphore=new e3(1,e)}acquire(){return t3(this,void 0,void 0,function*(){const[,e]=yield this._semaphore.acquire();return e})}runExclusive(e){return this._semaphore.runExclusive(()=>e())}isLocked(){return this._semaphore.isLocked()}waitForUnlock(){return this._semaphore.waitForUnlock()}release(){this._semaphore.isLocked()&&this._semaphore.release()}cancel(){return this._semaphore.cancel()}}var Up={};Up.calculate=function(t){if(t==null)return null;for(var e=r3(t),n=-1,r=e.length,s=0,o=r,i;s<o;++s)i=(n^e[s])&255,n=n>>>8^s3[i];return(n^-1)>>>0};function r3(t){for(var e=[],n=0,r=t.length,s;n<r;++n)s=t.charCodeAt(n),s<128?e.push(s):s<2048?e.push(s>>6|192,s&63|128):e.push(s>>12|224,s>>6&63|128,s&63|128);return e}var s3=[0,1996959894,3993919788,2567524794,124634137,1886057615,3915621685,2657392035,249268274,2044508324,3772115230,2547177864,162941995,2125561021,3887607047,2428444049,498536548,1789927666,4089016648,2227061214,450548861,1843258603,4107580753,2211677639,325883990,1684777152,4251122042,2321926636,335633487,1661365465,4195302755,2366115317,997073096,1281953886,3579855332,2724688242,1006888145,1258607687,3524101629,2768942443,901097722,1119000684,3686517206,2898065728,853044451,1172266101,3705015759,2882616665,651767980,1373503546,3369554304,3218104598,565507253,1454621731,3485111705,3099436303,671266974,1594198024,3322730930,2970347812,795835527,1483230225,3244367275,3060149565,1994146192,31158534,2563907772,4023717930,1907459465,112637215,2680153253,3904427059,2013776290,251722036,2517215374,3775830040,2137656763,141376813,2439277719,3865271297,1802195444,476864866,2238001368,4066508878,1812370925,453092731,2181625025,4111451223,1706088902,314042704,2344532202,4240017532,1658658271,366619977,2362670323,4224994405,1303535960,984961486,2747007092,3569037538,1256170817,1037604311,2765210733,3554079995,1131014506,879679996,2909243462,3663771856,1141124467,855842277,2852801631,3708648649,1342533948,654459306,3188396048,3373015174,1466479909,544179635,3110523913,3462522015,1591671054,702138776,2966460450,3352799412,1504918807,783551873,3082640443,3233442989,3988292384,2596254646,62317068,1957810842,3939845945,2647816111,81470997,1943803523,3814918930,2489596804,225274430,2053790376,3826175755,2466906013,167816743,2097651377,4027552580,2265490386,503444072,1762050814,4150417245,2154129355,426522225,1852507879,4275313526,2312317920,282753626,1742555852,4189708143,2394877945,397917763,1622183637,3604390888,2714866558,953729732,1340076626,3518719985,2797360999,1068828381,1219638859,3624741850,2936675148,906185462,1090812512,3747672003,2825379669,829329135,1181335161,3412177804,3160834842,628085408,1382605366,3423369109,3138078467,570562233,1426400815,3317316542,2998733608,733239954,1555261956,3268935591,3050360625,752459403,1541320221,2607071920,3965973030,1969922972,40735498,2617837225,3943577151,1913087877,83908371,2512341634,3803740692,2075208622,213261112,2463272603,3855990285,2094854071,198958881,2262029012,4057260610,1759359992,534414190,2176718541,4139329115,1873836001,414664567,2282248934,4279200368,1711684554,285281116,2405801727,4167216745,1634467795,376229701,2685067896,3608007406,1308918612,956543938,2808555105,3495958263,1231636301,1047427035,2932959818,3654703836,1088359270,936918e3,2847714899,3736837829,1202900863,817233897,3183342108,3401237130,1404277552,615818150,3134207493,3453421203,1423857449,601450431,3009837614,3294710456,1567103746,711928724,3020668471,3272380065,1510334235,755167117],o3=Up;const Vp=On(o3);var Ea={exports:{}};/**
 * @license BitSet.js v5.1.1 2/1/2020
 * http://www.xarg.org/2014/03/javascript-bit-array/
 *
 * Copyright (c) 2020, Robert Eisele (robert@xarg.org)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 **/(function(t,e){(function(n){var r=32,s=5;function o(p){return p-=p>>>1&1431655765,p=(p&858993459)+(p>>>2&858993459),(p+(p>>>4)&252645135)*16843009>>>24}function i(p,d){for(var f=0,S=0;S<p.length;S++){f*=2;var b=(p[S]+f)/d|0;f=(p[S]+f)%d,p[S]=b}return f}function a(p,d){if(d==null){p.data=[0,0,0,0,0,0,0,0,0,0],p._=0;return}if(d instanceof u){p.data=d.data,p._=d._;return}switch(typeof d){case"number":p.data=[d|0],p._=0;break;case"string":var f=2,S=r;d.indexOf("0b")===0?d=d.substr(2):d.indexOf("0x")===0&&(d=d.substr(2),f=16,S=8),p.data=[],p._=0;var b=d.length-S,F=d.length;do{var y=parseInt(d.slice(b>0?b:0,F),f);if(isNaN(y))throw SyntaxError("Invalid param");if(p.data.push(y|0),b<=0)break;b-=S,F-=S}while(!0);break;default:p.data=[0];var T=p.data;if(d instanceof Array){for(var O=d.length-1;O>=0;O--){var j=d[O];j===1/0?p._=-1:(c(p,j),T[j>>>s]|=1<<j)}break}if(Uint8Array&&d instanceof Uint8Array){var M=8;c(p,d.length*M);for(var O=0;O<d.length;O++)for(var ee=d[O],ne=0;ne<M;ne++){var Ne=O*M+ne;T[Ne>>>s]|=(ee>>ne&1)<<Ne}break}throw SyntaxError("Invalid param")}}function u(p){if(!(this instanceof u))return new u(p);a(this,p),this.data=this.data.slice()}function c(p,d){for(var f=d>>>s,S=p.data,b=p._,F=S.length;f>=F;f--)S.push(b)}var l={data:[],_:0};u.prototype={data:[],_:0,set:function(p,d){return p|=0,c(this,p),d===void 0||d?this.data[p>>>s]|=1<<p:this.data[p>>>s]&=~(1<<p),this},get:function(p){p|=0;var d=this.data,f=p>>>s;return f>=d.length?this._&1:d[f]>>>p&1},not:function(){for(var p=this.clone(),d=p.data,f=0;f<d.length;f++)d[f]=~d[f];return p._=~p._,p},and:function(p){a(l,p);var d=this.clone(),f=d.data,S=l.data,b=S.length,F=l._,y=d._;y!==0&&c(d,b*r-1);for(var T=f.length,O=Math.min(b,T),j=0;j<O;j++)f[j]&=S[j];for(;j<T;j++)f[j]&=F;return d._&=F,d},or:function(p){a(l,p);for(var d=this.clone(),f=d.data,S=l.data,b=S.length-1,F=f.length-1,y=Math.min(F,b),T=b;T>y;T--)f[T]=S[T];for(;T>=0;T--)f[T]|=S[T];return d._|=l._,d},xor:function(p){a(l,p);var d=this.clone(),f=d.data,S=l.data,b=d._,F=l._,y=0,T=f.length-1,O=S.length-1;for(y=T;y>O;y--)f[y]^=F;for(y=O;y>T;y--)f[y]=b^S[y];for(;y>=0;y--)f[y]^=S[y];return d._^=F,d},andNot:function(p){return this.and(new u(p).flip())},flip:function(p,d){if(p===void 0){for(var f=this.data,S=0;S<f.length;S++)f[S]=~f[S];this._=~this._}else if(d===void 0)c(this,p),this.data[p>>>s]^=1<<p;else if(0<=p&&p<=d){c(this,d);for(var S=p;S<=d;S++)this.data[S>>>s]^=1<<S}return this},clear:function(p,d){var f=this.data;if(p===void 0){for(var S=f.length-1;S>=0;S--)f[S]=0;this._=0}else if(d===void 0)p|=0,c(this,p),f[p>>>s]&=~(1<<p);else if(p<=d){c(this,d);for(var S=p;S<=d;S++)f[S>>>s]&=~(1<<S)}return this},slice:function(p,d){if(p===void 0)return this.clone();if(d===void 0){d=this.data.length*r;var f=Object.create(u.prototype);f._=this._,f.data=[0];for(var S=p;S<=d;S++)f.set(S-p,this.get(S));return f}else if(p<=d&&0<=p){var f=Object.create(u.prototype);f.data=[0];for(var S=p;S<=d;S++)f.set(S-p,this.get(S));return f}return null},setRange:function(p,d,f){for(var S=p;S<=d;S++)this.set(S,f);return this},clone:function(){var p=Object.create(u.prototype);return p.data=this.data.slice(),p._=this._,p},toArray:Math.clz32?function(){for(var p=[],d=this.data,f=d.length-1;f>=0;f--)for(var S=d[f];S!==0;){var b=31-Math.clz32(S);S^=1<<b,p.unshift(f*r+b)}return this._!==0&&p.push(1/0),p}:function(){for(var p=[],d=this.data,f=0;f<d.length;f++)for(var S=d[f];S!==0;){var b=S&-S;S^=b,p.push(f*r+o(b-1))}return this._!==0&&p.push(1/0),p},toString:function(p){var d=this.data;if(p||(p=2),!(p&p-1)&&p<36){for(var f="",S=2+Math.log(4294967295)/Math.log(p)|0,b=d.length-1;b>=0;b--){var F=d[b];F<0&&(F+=4294967296);var y=F.toString(p);f!==""&&(f+="0".repeat(S-y.length-1)),f+=y}return this._===0?(f=f.replace(/^0+/,""),f===""&&(f="0"),f):(f="1111"+f,f.replace(/^1+/,"...1111"))}else{if(2>p||p>36)throw SyntaxError("Invalid base");for(var f=[],T=[],b=d.length;b--;)for(var O=r;O--;)T.push(d[b]>>>O&1);do f.unshift(i(T,p).toString(p));while(!T.every(function(M){return M===0}));return f.join("")}},isEmpty:function(){if(this._!==0)return!1;for(var p=this.data,d=p.length-1;d>=0;d--)if(p[d]!==0)return!1;return!0},cardinality:function(){if(this._!==0)return 1/0;for(var p=0,d=this.data,f=0;f<d.length;f++){var S=d[f];S!==0&&(p+=o(S))}return p},msb:Math.clz32?function(){if(this._!==0)return 1/0;for(var p=this.data,d=p.length;d-- >0;){var f=Math.clz32(p[d]);if(f!==r)return d*r+r-1-f}return 1/0}:function(){if(this._!==0)return 1/0;for(var p=this.data,d=p.length;d-- >0;){var f=p[d],S=0;if(f){for(;(f>>>=1)>0;S++);return d*r+S}}return 1/0},ntz:function(){for(var p=this.data,d=0;d<p.length;d++){var f=p[d];if(f!==0)return f=(f^f-1)>>>1,d*r+o(f)}return 1/0},lsb:function(){for(var p=this.data,d=0;d<p.length;d++){var f=p[d],S=0;if(f){for(var b=f&-f;b>>>=1;S++);return r*d+S}}return this._&1},equals:function(p){a(l,p);var d=this.data,f=l.data,S=this._,b=l._,F=d.length-1,y=f.length-1;if(b!==S)return!1;for(var T=F<y?F:y,O=0;O<=T;O++)if(d[O]!==f[O])return!1;for(O=F;O>y;O--)if(d[O]!==b)return!1;for(O=y;O>F;O--)if(f[O]!==S)return!1;return!0},[Symbol.iterator]:function(){var p=this.data,d=0;if(this._===0){for(var f=0,S=p.length-1;S>=0;S--)if(p[S]!==0){f=S;break}return{next:function(){var b=d>>>s;return{done:b>f||b===f&&p[b]>>>d===0,value:b>f?0:p[b]>>>d++&1}}}}else return{next:function(){var b=d>>>s;return{done:!1,value:b<p.length?p[b]>>>d++&1:1}}}}},u.fromBinaryString=function(p){return new u("0b"+p)},u.fromHexString=function(p){return new u("0x"+p)},u.Random=function(p){(p===void 0||p<0)&&(p=r);for(var d=p%r,f=[],S=Math.ceil(p/r),b=Object.create(u.prototype),F=0;F<S;F++)f.push(Math.random()*4294967296|0);return d>0&&(f[S-1]&=(1<<d)-1),b.data=f,b._=0,b},Object.defineProperty(e,"__esModule",{value:!0}),u.default=u,u.BitSet=u,t.exports=u})()})(Ea,Ea.exports);var i3=Ea.exports;const Jp=On(i3),a3="proskomma-core",u3="0.10.14",c3="A Scripture Runtime Engine",l3=["dist"],p3="./dist/index.js",d3="./dist/module.mjs",f3={".":{require:"./dist/index.js",import:"./dist/index.mjs"}},h3={build:"rm -fr dist && vite build",test:'rm -fr dist && vite build && export PKSRC=dist && bash -c "tape -r @babel/register test/code/**/*.cjs | node_modules/tap-summary/bin/cmd.js"',"win:test":'rm -fr dist && vite build && set PKSRC=dist&& bash -c "tape -r @babel/register test/code/**/*.cjs | node_modules/tap-summary/bin/cmd.js"',rawTest:'rm -fr dist && vite build && export PKSRC=dist && bash -c "tape -r @babel/register test/code/**/*.cjs"',oneTest:'rm -fr dist && vite build && export PKSRC=dist && bash -c "tape -r @babel/register test/code/$TESTSCRIPT.cjs"',prepublishOnly:"npm run build"},m3={type:"git",url:"git+https://github.com/Proskomma/proskomma-core.git"},D3=["USFM","USX","Scripture","parser","lexer","Proskomma"],S3="Mark Howe",E3="MIT",y3={url:"https://github.com/Proskomma/proskomma-core/issues"},g3="https://github.com/Proskomma/proskomma-core#readme",v3={"@babel/preset-env":"^7.20.2","@graphql-tools/schema":"^9.0.3","async-mutex":"^0.4.0","base-64":"^1.0.0","base64-js":"^1.5.1",bitset:"^5.1.1",buffer:"^6.0.3","deep-copy-all":"^1.3.4","deep-equal":"^2.0.5","easy-crc32":"^0.0.2","fs-extra":"^11.1.0",graphql:"^v16.6.0","proskomma-json-tools":"^0.6.5","pure-uuid":"^1.6.2",sax:"^1.2.4",stream:"0.0.2",string_decoder:"^1.3.0","utf8-string-bytes":"^1.0.3",util:"^0.12.4",xregexp:"^5.1.1"},A3={"@babel/eslint-parser":"^7.19.1","@babel/register":"^7.18.9","@esbuild-plugins/node-globals-polyfill":"^0.2.3",events:"^3.3.0",parcel:"^2.12.0",process:"^0.11.10","stream-browserify":"^3.0.0","tap-summary":"^4.0.0",tape:"^5.7.5",typescript:"^4.9.5",vite:"^4.1.4"},b3={name:a3,version:u3,description:c3,files:l3,main:p3,module:d3,exports:f3,scripts:h3,repository:m3,keywords:D3,author:S3,license:E3,bugs:y3,homepage:g3,dependencies:v3,devDependencies:A3},C3=function(t){for(var e=[],n=0,r=0;r<t.length;r++){var s=t.charCodeAt(r);s<128?e[n++]=s:s<2048?(e[n++]=s>>6|192,e[n++]=s&63|128):(s&64512)==55296&&r+1<t.length&&(t.charCodeAt(r+1)&64512)==56320?(s=65536+((s&1023)<<10)+(t.charCodeAt(++r)&1023),e[n++]=s>>18|240,e[n++]=s>>12&63|128,e[n++]=s>>6&63|128,e[n++]=s&63|128):(e[n++]=s>>12|224,e[n++]=s>>6&63|128,e[n++]=s&63|128)}return e},T3=function(t){for(var e=[],n=0,r=0;n<t.length;){var s=t[n++];if(s<128)e[r++]=String.fromCharCode(s);else if(s>191&&s<224){var o=t[n++];e[r++]=String.fromCharCode((s&31)<<6|o&63)}else if(s>239&&s<365){var o=t[n++],i=t[n++],a=t[n++],u=((s&7)<<18|(o&63)<<12|(i&63)<<6|a&63)-65536;e[r++]=String.fromCharCode(55296+(u>>10)),e[r++]=String.fromCharCode(56320+(u&1023))}else{var o=t[n++],i=t[n++];e[r++]=String.fromCharCode((s&15)<<12|(o&63)<<6|i&63)}}return e.join("")};var Yc={utf8ByteArrayToString:T3,stringToUtf8ByteArray:C3},zr={};zr.byteLength=I3;zr.toByteArray=P3;zr.fromByteArray=O3;var Sn=[],Wt=[],w3=typeof Uint8Array<"u"?Uint8Array:Array,Ii="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";for(var wr=0,F3=Ii.length;wr<F3;++wr)Sn[wr]=Ii[wr],Wt[Ii.charCodeAt(wr)]=wr;Wt[45]=62;Wt[95]=63;function Hp(t){var e=t.length;if(e%4>0)throw new Error("Invalid string. Length must be a multiple of 4");var n=t.indexOf("=");n===-1&&(n=e);var r=n===e?0:4-n%4;return[n,r]}function I3(t){var e=Hp(t),n=e[0],r=e[1];return(n+r)*3/4-r}function k3(t,e,n){return(e+n)*3/4-n}function P3(t){var e,n=Hp(t),r=n[0],s=n[1],o=new w3(k3(t,r,s)),i=0,a=s>0?r-4:r,u;for(u=0;u<a;u+=4)e=Wt[t.charCodeAt(u)]<<18|Wt[t.charCodeAt(u+1)]<<12|Wt[t.charCodeAt(u+2)]<<6|Wt[t.charCodeAt(u+3)],o[i++]=e>>16&255,o[i++]=e>>8&255,o[i++]=e&255;return s===2&&(e=Wt[t.charCodeAt(u)]<<2|Wt[t.charCodeAt(u+1)]>>4,o[i++]=e&255),s===1&&(e=Wt[t.charCodeAt(u)]<<10|Wt[t.charCodeAt(u+1)]<<4|Wt[t.charCodeAt(u+2)]>>2,o[i++]=e>>8&255,o[i++]=e&255),o}function N3(t){return Sn[t>>18&63]+Sn[t>>12&63]+Sn[t>>6&63]+Sn[t&63]}function _3(t,e,n){for(var r,s=[],o=e;o<n;o+=3)r=(t[o]<<16&16711680)+(t[o+1]<<8&65280)+(t[o+2]&255),s.push(N3(r));return s.join("")}function O3(t){for(var e,n=t.length,r=n%3,s=[],o=16383,i=0,a=n-r;i<a;i+=o)s.push(_3(t,i,i+o>a?a:i+o));return r===1?(e=t[n-1],s.push(Sn[e>>2]+Sn[e<<4&63]+"==")):r===2&&(e=(t[n-2]<<8)+t[n-1],s.push(Sn[e>>10]+Sn[e>>4&63]+Sn[e<<2&63]+"=")),s.join("")}const _t=(t,e,n)=>{if(typeof t!="number")throw new Error(`Argument ${n} of ${e} should be a number, not '${t}' (${typeof t})`)};let ks=class{constructor(e,n){e=e||64,n=n||0,this.growMax=1024*16,this.length=n,this.byteArray=new Uint8Array(e)}byte(e){if(_t(e,"byte","n"),e>this.length-1)throw Error(`Attempt to read byte ${e} of ByteArray of length ${this.length}`);return this.byteArray[e]}bytes(e,n){if(_t(e,"bytes","n"),_t(n,"bytes","l"),e+n>this.length)throw Error(`Attempt to read ${n} bytes from start ${e} of ByteArray of length ${this.length}`);return this.byteArray.subarray(e,e+n)}setByte(e,n){if(_t(e,"setByte","n"),_t(n,"setByte","v"),e>this.length-1)throw Error(`Attempt to set byte ${e} of ByteArray of length ${this.length}`);if(typeof n!="number"||n<0||n>255)throw Error(`Expected value 0-255 when setting ByteArray, found ${n}`);this.byteArray[e]=n}setBytes(e,n){if(_t(e,"setBytes","n"),e+n.length>this.length)throw Error(`Attempt to set ${n.length} bytes from start ${e} of ByteArray of length ${this.length}`);this.byteArray.set(n,e)}pushByte(e){if(typeof e!="number"||e<0||e>255)throw Error(`Expected value 0-255 when pushing to ByteArray, found ${e}`);this.length===this.byteArray.length&&this.grow(),this.byteArray[this.length]=e,this.length++}grow(e){const n=new Uint8Array(Math.max(e||0,this.byteArray.length+Math.min(this.growMax,Math.max(16,this.byteArray.length))));n.set(this.byteArray),this.byteArray=n}trim(){const e=new Uint8Array(this.length);e.set(this.byteArray.subarray(0,this.length)),this.byteArray=e}pushBytes(e){for(const n of e)this.pushByte(n)}pushNByte(e){if(_t(e,"pushNByte","v"),typeof e!="number"||e<0)throw Error(`Expected positive number in pushNByte, found ${e}`);if(e<128)this.pushByte(e+128);else{const n=e%128;this.pushByte(n),this.pushNByte(e>>7)}}pushNBytes(e){for(const n of e)try{this.pushNByte(n)}catch{throw Error(`Error from pushNByte, called as pushNBytes(${JSON.stringify(e)})`)}}nByte(e){if(_t(e,"nByte","n"),e>this.length-1)throw Error(`Attempt to read nByte ${e} of ByteArray of length ${this.length}`);const n=this.byteArray[e];return n>127?n-128:n+128*this.nByte(e+1)}nBytes(e,n){_t(e,"nBytes","n"),_t(n,"nBytes","nValues");const r=[];for(;n>0;){let s=!1,o=0,i=1;do{if(e>this.length-1)throw Error(`Attempt to read nByte ${e} of ByteArray of length ${this.length} in nBytes(${e}, ${n})`);const a=this.byteArray[e];a>127?(o+=(a-128)*i,r.push(o),o=0,s=!0):(o+=a*i,i*=128),e++}while(!s);n--}return r}nByteLength(e){if(_t(e,"nByteLength","v"),e>=128**4)throw new Error("> 4 bytes found in nByteLength");let n=1;for(;e>127;)e=e>>7,n+=1;return n}pushCountedString(e){const n=Yc.stringToUtf8ByteArray(e);this.pushByte(n.length),this.pushBytes(n)}countedString(e){_t(e,"countedString","n");const n=this.byte(e);return Yc.utf8ByteArrayToString(this.bytes(e+1,n))}clear(){this.byteArray.fill(0),this.length=0}base64(){return zr.fromByteArray(this.byteArray)}fromBase64(e){this.byteArray=zr.toByteArray(e),this.length=this.byteArray.length}deleteItem(e){_t(e,"deleteItem","n");const n=this.byte(e)&63;if(this.length-=n,this.length>e){const r=this.byteArray.slice(e+n);this.byteArray.set(r,e)}}insert(e,n){_t(e,"insert","n");const r=n.length,s=this.length+r;if(s>=this.byteArray.length+r&&this.grow(s),e<s){const o=this.byteArray.slice(e,this.length);this.byteArray.set(o,e+r)}this.byteArray.set(n.byteArray.slice(0,n.length),e),this.length=s}};const Wp=[{code:"GEN",categories:["ot","pentateuch"]},{code:"EXO",categories:["ot","pentateuch"]},{code:"LEV",categories:["ot","pentateuch"]},{code:"NUM",categories:["ot","pentateuch"]},{code:"DEU",categories:["ot","pentateuch"]},{code:"JOS",categories:["ot","history"]},{code:"JDG",categories:["ot","history"]},{code:"RUT",categories:["ot","history"]},{code:"1SA",categories:["ot","history"]},{code:"2SA",categories:["ot","history"]},{code:"1KI",categories:["ot","history"]},{code:"2KI",categories:["ot","history"]},{code:"1CH",categories:["ot","history"]},{code:"2CH",categories:["ot","history"]},{code:"EZR",categories:["ot","history"]},{code:"NEH",categories:["ot","history"]},{code:"EST",categories:["ot","history"]},{code:"JOB",categories:["ot","wisdom"]},{code:"PSA",categories:["ot","wisdom"]},{code:"PRO",categories:["ot","wisdom"]},{code:"ECC",categories:["ot","wisdom"]},{code:"SNG",categories:["ot","wisdom"]},{code:"ISA",categories:["ot","prophecy"]},{code:"JER",categories:["ot","prophecy"]},{code:"LAM",categories:["ot","prophecy"]},{code:"EZK",categories:["ot","prophecy"]},{code:"DAN",categories:["ot","prophecy"]},{code:"HOS",categories:["ot","prophecy"]},{code:"JOL",categories:["ot","prophecy"]},{code:"AMO",categories:["ot","prophecy"]},{code:"OBA",categories:["ot","prophecy"]},{code:"JON",categories:["ot","prophecy"]},{code:"MIC",categories:["ot","prophecy"]},{code:"NAM",categories:["ot","prophecy"]},{code:"HAB",categories:["ot","prophecy"]},{code:"ZEP",categories:["ot","prophecy"]},{code:"HAG",categories:["ot","prophecy"]},{code:"ZEC",categories:["ot","prophecy"]},{code:"MAL",categories:["ot","prophecy"]},{code:"MAT",categories:["nt","gospel","synoptic"]},{code:"MRK",categories:["nt","gospel","synoptic"]},{code:"LUK",categories:["nt","gospel","synoptic"]},{code:"JHN",categories:["nt","gospel"]},{code:"ACT",categories:["nt","gospel"]},{code:"ROM",categories:["nt","epistle"]},{code:"1CO",categories:["nt","epistle"]},{code:"2CO",categories:["nt","epistle"]},{code:"GAL",categories:["nt","epistle"]},{code:"EPH",categories:["nt","epistle"]},{code:"PHP",categories:["nt","epistle"]},{code:"COL",categories:["nt","epistle"]},{code:"1TH",categories:["nt","epistle"]},{code:"2TH",categories:["nt","epistle"]},{code:"1TI",categories:["nt","epistle"]},{code:"2TI",categories:["nt","epistle"]},{code:"TIT",categories:["nt","epistle"]},{code:"PHM",categories:["nt","epistle"]},{code:"HEB",categories:["nt","epistle"]},{code:"JAS",categories:["nt","epistle"]},{code:"1PE",categories:["nt","epistle"]},{code:"2PE",categories:["nt","epistle"]},{code:"1JN",categories:["nt","epistle"]},{code:"2JN",categories:["nt","epistle"]},{code:"3JN",categories:["nt","epistle"]},{code:"JUD",categories:["nt","epistle"]},{code:"REV",categories:["nt","epistle"]},{code:"TOB",categories:["dc"]},{code:"JDT",categories:["dc"]},{code:"ESG",categories:["dc","history"]},{code:"WIS",categories:["dc","wisdom"]},{code:"SIR",categories:["dc","wisdom"]},{code:"BAR",categories:["dc","prophecy"]},{code:"LJE",categories:["dc"]},{code:"S3Y",categories:["dc"]},{code:"SUS",categories:["dc"]},{code:"BEL",categories:["dc"]},{code:"1MA",categories:["dc"]},{code:"2MA",categories:["dc"]},{code:"3MA",categories:["dc"]},{code:"4MA",categories:["dc"]},{code:"1ES",categories:["dc"]},{code:"2ES",categories:["dc"]},{code:"MAN",categories:["dc"]},{code:"PS2",categories:["dc"]},{code:"ODA",categories:["dc"]},{code:"PSS",categories:["dc"]},{code:"JSA",categories:["dc"]},{code:"JDB",categories:["dc"]},{code:"TBS",categories:["dc"]},{code:"SST",categories:["dc"]},{code:"DNT",categories:["dc"]},{code:"BLT",categories:["dc"]},{code:"EZA",categories:["dc"]},{code:"5EZ",categories:["dc"]},{code:"6EZ",categories:["dc"]},{code:"DAG",categories:["dc"]},{code:"PS3",categories:["dc"]},{code:"2BA",categories:["dc"]},{code:"LBA",categories:["dc"]},{code:"JUB",categories:["dc"]},{code:"ENO",categories:["dc"]},{code:"1MQ",categories:["dc"]},{code:"2MQ",categories:["dc"]},{code:"3MQ",categories:["dc"]},{code:"REP",categories:["dc"]},{code:"4BA",categories:["dc"]},{code:"LAO",categories:["dc"]}];let Kp={};for(const t of Wp.entries())Kp[t[1].code]={...t[1],position:t[0]};const $3={ptBookArray:Wp,ptBooks:Kp},B3=(t,e)=>{let n=0,r=0;for(;n<t.length;){const s=t.byte(n);if(t.countedString(n)===e)return r;n+=s+1,r+=1}return-1},R3=(t,e)=>{let n=0,r=0;const s=[];for(;n<t.length;){const o=t.byte(n),i=t.countedString(n);B.exec(i,B(e,"i"))&&s.push([r,i]),n+=o+1,r+=1}return s},x3={enumStringIndex:B3,enumRegexIndexTuples:R3};var Xp={exports:{}};/*!
**  Pure-UUID -- Pure JavaScript Based Universally Unique Identifier (UUID)
**  Copyright (c) 2004-2023 Dr. Ralf S. Engelschall <rse@engelschall.com>
**
**  Permission is hereby granted, free of charge, to any person obtaining
**  a copy of this software and associated documentation files (the
**  "Software"), to deal in the Software without restriction, including
**  without limitation the rights to use, copy, modify, merge, publish,
**  distribute, sublicense, and/or sell copies of the Software, and to
**  permit persons to whom the Software is furnished to do so, subject to
**  the following conditions:
**
**  The above copyright notice and this permission notice shall be included
**  in all copies or substantial portions of the Software.
**
**  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
**  EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
**  MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
**  IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
**  CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
**  TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
**  SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/(function(t){(function(e,n,r){t.exports=r(e),t.exports.default=t.exports})(pr,"UUID",function(){var e=function(v,C,m,A,$,g){for(var E=function(k,U){var V=k.toString(16);return V.length<2&&(V="0"+V),U&&(V=V.toUpperCase()),V},N=C;N<=m;N++)$[g++]=E(v[N],A);return $},n=function(v,C,m,A,$){for(var g=C;g<=m;g+=2)A[$++]=parseInt(v.substr(g,2),16)},r="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.-:+=^!/*?&<>()[]{}@%$#".split(""),s=[0,68,0,84,83,82,72,0,75,76,70,65,0,63,62,69,0,1,2,3,4,5,6,7,8,9,64,0,73,66,74,71,81,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,77,0,78,67,0,0,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,79,0,80,0,0],o=function(v,C){for(var m="",A=0,$=0;A<C;)if($=$*256+v[A++],A%4===0){for(var g=52200625;g>=1;){var E=Math.floor($/g)%85;m+=r[E],g/=85}$=0}return m},i=function(v,C){var m=v.length;if(m%5!==0)throw new Error("z85_decode: invalid input length (multiple of 5 expected)");typeof C>"u"&&(C=new Array(m*4/5));for(var A=0,$=0,g=0;A<m;){var E=v.charCodeAt(A++)-32;if(E<0||E>=s.length)break;if(g=g*85+s[E],A%5===0){for(var N=16777216;N>=1;)C[$++]=Math.trunc(g/N%256),N/=256;g=0}}return C},a=function(v,C){var m={ibits:8,obits:8,obigendian:!0};for(var A in C)typeof m[A]<"u"&&(m[A]=C[A]);for(var $=[],g=0,E,N,k=0,U,V=0,Y=v.length;k===0&&(N=v.charCodeAt(g++)),E=N>>m.ibits-(k+8)&255,k=(k+8)%m.ibits,m.obigendian?V===0?U=E<<m.obits-8:U|=E<<m.obits-8-V:V===0?U=E:U|=E<<V,V=(V+8)%m.obits,!(V===0&&($.push(U),g>=Y)););return $},u=function(v,C){var m={ibits:32,ibigendian:!0};for(var A in C)typeof m[A]<"u"&&(m[A]=C[A]);var $="",g=4294967295;m.ibits<32&&(g=(1<<m.ibits)-1);for(var E=v.length,N=0;N<E;N++)for(var k=v[N]&g,U=0;U<m.ibits;U+=8)m.ibigendian?$+=String.fromCharCode(k>>m.ibits-8-U&255):$+=String.fromCharCode(k>>U&255);return $},c=8,l=8,p=256,d=function(v,C,m,A,$,g,E,N){return[N,E,g,$,A,m,C,v]},f=function(){return d(0,0,0,0,0,0,0,0)},S=function(v){return v.slice(0)},b=function(v){for(var C=f(),m=0;m<c;m++)C[m]=Math.floor(v%p),v/=p;return C},F=function(v){for(var C=0,m=c-1;m>=0;m--)C*=p,C+=v[m];return Math.floor(C)},y=function(v,C){for(var m=0,A=0;A<c;A++)m+=v[A]+C[A],v[A]=Math.floor(m%p),m=Math.floor(m/p);return m},T=function(v,C){for(var m=0,A=0;A<c;A++)m+=v[A]*C,v[A]=Math.floor(m%p),m=Math.floor(m/p);return m},O=function(v,C){var m,A,$=new Array(c+c);for(m=0;m<c+c;m++)$[m]=0;var g;for(m=0;m<c;m++){for(g=0,A=0;A<c;A++)g+=v[m]*C[A]+$[m+A],$[m+A]=g%p,g/=p;for(;A<c+c-m;A++)g+=$[m+A],$[m+A]=g%p,g/=p}for(m=0;m<c;m++)v[m]=$[m];return $.slice(c,c)},j=function(v,C){for(var m=0;m<c;m++)v[m]&=C[m];return v},M=function(v,C){for(var m=0;m<c;m++)v[m]|=C[m];return v},ee=function(v,C){for(var m=f(),A=Math.floor(C/l),$=0;$<A;$++){for(var g=c-1-1;g>=0;g--)m[g+1]=m[g];for(m[0]=v[0],g=0;g<c-1;g++)v[g]=v[g+1];v[g]=0}return F(m)},ne=function(v,C){if(C>c*l)throw new Error("ui64_ror: invalid number of bits to shift");var m=new Array(c+c),A;for(A=0;A<c;A++)m[A+c]=v[A],m[A]=0;var $=Math.floor(C/l),g=C%l;for(A=$;A<c+c-1;A++)m[A-$]=(m[A]>>>g|m[A+1]<<l-g)&(1<<l)-1;for(m[c+c-1-$]=m[c+c-1]>>>g&(1<<l)-1,A=c+c-1-$+1;A<c+c;A++)m[A]=0;for(A=0;A<c;A++)v[A]=m[A+c];return m.slice(0,c)},Ne=function(v,C){if(C>c*l)throw new Error("ui64_rol: invalid number of bits to shift");var m=new Array(c+c),A;for(A=0;A<c;A++)m[A+c]=0,m[A]=v[A];var $=Math.floor(C/l),g=C%l;for(A=c-1-$;A>0;A--)m[A+$]=(m[A]<<g|m[A-1]>>>l-g)&(1<<l)-1;for(m[0+$]=m[0]<<g&(1<<l)-1,A=0+$-1;A>=0;A--)m[A]=0;for(A=0;A<c;A++)v[A]=m[A];return m.slice(c,c)},L=function(v,C){for(var m=0;m<c;m++)v[m]^=C[m]},pe=function(v,C){var m=(v&65535)+(C&65535),A=(v>>16)+(C>>16)+(m>>16);return A<<16|m&65535},de=function(v,C){return v<<C&4294967295|v>>>32-C&4294967295},re=function(v,C){function m(Ve,je,Ae,Re){return Ve<20?je&Ae|~je&Re:Ve<40?je^Ae^Re:Ve<60?je&Ae|je&Re|Ae&Re:je^Ae^Re}function A(Ve){return Ve<20?1518500249:Ve<40?1859775393:Ve<60?-1894007588:-899497514}v[C>>5]|=128<<24-C%32,v[(C+64>>9<<4)+15]=C;for(var $=Array(80),g=1732584193,E=-271733879,N=-1732584194,k=271733878,U=-1009589776,V=0;V<v.length;V+=16){for(var Y=g,Le=E,rt=N,Xe=k,Ue=U,ye=0;ye<80;ye++){ye<16?$[ye]=v[V+ye]:$[ye]=de($[ye-3]^$[ye-8]^$[ye-14]^$[ye-16],1);var He=pe(pe(de(g,5),m(ye,E,N,k)),pe(pe(U,$[ye]),A(ye)));U=k,k=N,N=de(E,30),E=g,g=He}g=pe(g,Y),E=pe(E,Le),N=pe(N,rt),k=pe(k,Xe),U=pe(U,Ue)}return[g,E,N,k,U]},he=function(v){return u(re(a(v,{ibits:8,obits:32,obigendian:!0}),v.length*8),{ibits:32,ibigendian:!0})},Te=function(v,C){function m(ye,He,Ve,je,Ae,Re){return pe(de(pe(pe(He,ye),pe(je,Re)),Ae),Ve)}function A(ye,He,Ve,je,Ae,Re,It){return m(He&Ve|~He&je,ye,He,Ae,Re,It)}function $(ye,He,Ve,je,Ae,Re,It){return m(He&je|Ve&~je,ye,He,Ae,Re,It)}function g(ye,He,Ve,je,Ae,Re,It){return m(He^Ve^je,ye,He,Ae,Re,It)}function E(ye,He,Ve,je,Ae,Re,It){return m(Ve^(He|~je),ye,He,Ae,Re,It)}v[C>>5]|=128<<C%32,v[(C+64>>>9<<4)+14]=C;for(var N=1732584193,k=-271733879,U=-1732584194,V=271733878,Y=0;Y<v.length;Y+=16){var Le=N,rt=k,Xe=U,Ue=V;N=A(N,k,U,V,v[Y+0],7,-680876936),V=A(V,N,k,U,v[Y+1],12,-389564586),U=A(U,V,N,k,v[Y+2],17,606105819),k=A(k,U,V,N,v[Y+3],22,-1044525330),N=A(N,k,U,V,v[Y+4],7,-176418897),V=A(V,N,k,U,v[Y+5],12,1200080426),U=A(U,V,N,k,v[Y+6],17,-1473231341),k=A(k,U,V,N,v[Y+7],22,-45705983),N=A(N,k,U,V,v[Y+8],7,1770035416),V=A(V,N,k,U,v[Y+9],12,-1958414417),U=A(U,V,N,k,v[Y+10],17,-42063),k=A(k,U,V,N,v[Y+11],22,-1990404162),N=A(N,k,U,V,v[Y+12],7,1804603682),V=A(V,N,k,U,v[Y+13],12,-40341101),U=A(U,V,N,k,v[Y+14],17,-1502002290),k=A(k,U,V,N,v[Y+15],22,1236535329),N=$(N,k,U,V,v[Y+1],5,-165796510),V=$(V,N,k,U,v[Y+6],9,-1069501632),U=$(U,V,N,k,v[Y+11],14,643717713),k=$(k,U,V,N,v[Y+0],20,-373897302),N=$(N,k,U,V,v[Y+5],5,-701558691),V=$(V,N,k,U,v[Y+10],9,38016083),U=$(U,V,N,k,v[Y+15],14,-660478335),k=$(k,U,V,N,v[Y+4],20,-405537848),N=$(N,k,U,V,v[Y+9],5,568446438),V=$(V,N,k,U,v[Y+14],9,-1019803690),U=$(U,V,N,k,v[Y+3],14,-187363961),k=$(k,U,V,N,v[Y+8],20,1163531501),N=$(N,k,U,V,v[Y+13],5,-1444681467),V=$(V,N,k,U,v[Y+2],9,-51403784),U=$(U,V,N,k,v[Y+7],14,1735328473),k=$(k,U,V,N,v[Y+12],20,-1926607734),N=g(N,k,U,V,v[Y+5],4,-378558),V=g(V,N,k,U,v[Y+8],11,-2022574463),U=g(U,V,N,k,v[Y+11],16,1839030562),k=g(k,U,V,N,v[Y+14],23,-35309556),N=g(N,k,U,V,v[Y+1],4,-1530992060),V=g(V,N,k,U,v[Y+4],11,1272893353),U=g(U,V,N,k,v[Y+7],16,-155497632),k=g(k,U,V,N,v[Y+10],23,-1094730640),N=g(N,k,U,V,v[Y+13],4,681279174),V=g(V,N,k,U,v[Y+0],11,-358537222),U=g(U,V,N,k,v[Y+3],16,-722521979),k=g(k,U,V,N,v[Y+6],23,76029189),N=g(N,k,U,V,v[Y+9],4,-640364487),V=g(V,N,k,U,v[Y+12],11,-421815835),U=g(U,V,N,k,v[Y+15],16,530742520),k=g(k,U,V,N,v[Y+2],23,-995338651),N=E(N,k,U,V,v[Y+0],6,-198630844),V=E(V,N,k,U,v[Y+7],10,1126891415),U=E(U,V,N,k,v[Y+14],15,-1416354905),k=E(k,U,V,N,v[Y+5],21,-57434055),N=E(N,k,U,V,v[Y+12],6,1700485571),V=E(V,N,k,U,v[Y+3],10,-1894986606),U=E(U,V,N,k,v[Y+10],15,-1051523),k=E(k,U,V,N,v[Y+1],21,-2054922799),N=E(N,k,U,V,v[Y+8],6,1873313359),V=E(V,N,k,U,v[Y+15],10,-30611744),U=E(U,V,N,k,v[Y+6],15,-1560198380),k=E(k,U,V,N,v[Y+13],21,1309151649),N=E(N,k,U,V,v[Y+4],6,-145523070),V=E(V,N,k,U,v[Y+11],10,-1120210379),U=E(U,V,N,k,v[Y+2],15,718787259),k=E(k,U,V,N,v[Y+9],21,-343485551),N=pe(N,Le),k=pe(k,rt),U=pe(U,Xe),V=pe(V,Ue)}return[N,k,U,V]},Ge=function(v){return u(Te(a(v,{ibits:8,obits:32,obigendian:!1}),v.length*8),{ibits:32,ibigendian:!1})},qe=function(v){this.mul=d(88,81,244,45,76,149,127,45),this.inc=d(20,5,123,126,247,103,129,79),this.mask=d(0,0,0,0,255,255,255,255),this.state=S(this.inc),this.next(),j(this.state,this.mask);var C;v!==void 0?v=b(v>>>0):typeof window=="object"&&typeof window.crypto=="object"&&typeof window.crypto.getRandomValues=="function"?(C=new Uint32Array(2),window.crypto.getRandomValues(C),v=M(b(C[0]>>>0),ne(b(C[1]>>>0),32))):typeof globalThis=="object"&&typeof globalThis.crypto=="object"&&typeof globalThis.crypto.getRandomValues=="function"?(C=new Uint32Array(2),globalThis.crypto.getRandomValues(C),v=M(b(C[0]>>>0),ne(b(C[1]>>>0),32))):(v=b(Math.random()*4294967295>>>0),M(v,ne(b(new Date().getTime()),32))),M(this.state,v),this.next()};qe.prototype.next=function(){var v=S(this.state);O(this.state,this.mul),y(this.state,this.inc);var C=S(v);ne(C,18),L(C,v),ne(C,27);var m=S(v);ne(m,59),j(C,this.mask);var A=F(m),$=S(C);return Ne($,32-A),ne(C,A),L(C,$),F(C)},qe.prototype.reseed=function(v){if(typeof v!="string")throw new Error("UUID: PCG: seed: invalid argument (string expected)");for(var C=re(a(v,{ibits:8,obits:32,obigendian:!0}),v.length*8),m=0;m<C.length;m++)L(ce.state,b(C[m]>>>0))};var ce=new qe;qe.reseed=function(v){ce.reseed(v)};var Ze=function(v,C){for(var m=[],A=0;A<v;A++)m[A]=ce.next()%C;return m},ke=0,Z=0,x=function(){if(arguments.length===1&&typeof arguments[0]=="string")this.parse.apply(this,arguments);else if(arguments.length>=1&&typeof arguments[0]=="number")this.make.apply(this,arguments);else{if(arguments.length>=1)throw new Error("UUID: constructor: invalid arguments");for(var v=0;v<16;v++)this[v]=0}};return typeof Uint8Array<"u"?x.prototype=new Uint8Array(16):Buffer?x.prototype=Buffer.alloc(16):x.prototype=new Array(16),x.prototype.constructor=x,x.prototype.make=function(v){var C,m=this;if(v===1){var A=new Date,$=A.getTime();$!==ke?Z=0:Z++,ke=$;var g=b($);T(g,1e3*10),y(g,d(1,178,29,210,19,129,64,0)),Z>0&&y(g,b(Z));var E;E=ee(g,8),m[3]=E&255,E=ee(g,8),m[2]=E&255,E=ee(g,8),m[1]=E&255,E=ee(g,8),m[0]=E&255,E=ee(g,8),m[5]=E&255,E=ee(g,8),m[4]=E&255,E=ee(g,8),m[7]=E&255,E=ee(g,8),m[6]=E&15;var N=Ze(2,255);m[8]=N[0],m[9]=N[1];var k=Ze(6,255);for(k[0]|=1,k[0]|=2,C=0;C<6;C++)m[10+C]=k[C]}else if(v===4){var U=Ze(16,255);for(C=0;C<16;C++)this[C]=U[C]}else if(v===3||v===5){var V="",Y=typeof arguments[1]=="object"&&arguments[1]instanceof x?arguments[1]:new x().parse(arguments[1]);for(C=0;C<16;C++)V+=String.fromCharCode(Y[C]);V+=arguments[2];var Le=v===3?Ge(V):he(V);for(C=0;C<16;C++)m[C]=Le.charCodeAt(C)}else throw new Error("UUID: make: invalid version");return m[6]&=15,m[6]|=v<<4,m[8]&=63,m[8]|=128,m},x.prototype.format=function(v){var C,m;return v==="z85"?C=o(this,16):v==="b16"?(m=Array(32),e(this,0,15,!0,m,0),C=m.join("")):(v===void 0||v==="std")&&(m=new Array(36),e(this,0,3,!1,m,0),m[8]="-",e(this,4,5,!1,m,9),m[13]="-",e(this,6,7,!1,m,14),m[18]="-",e(this,8,9,!1,m,19),m[23]="-",e(this,10,15,!1,m,24),C=m.join("")),C},x.prototype.toString=function(v){return this.format(v)},x.prototype.toJSON=function(){return this.format("std")},x.prototype.parse=function(v,C){if(typeof v!="string")throw new Error("UUID: parse: invalid argument (type string expected)");if(C==="z85")i(v,this);else if(C==="b16")n(v,0,35,this,0);else if(C===void 0||C==="std"){var m={nil:"00000000-0000-0000-0000-000000000000","ns:DNS":"6ba7b810-9dad-11d1-80b4-00c04fd430c8","ns:URL":"6ba7b811-9dad-11d1-80b4-00c04fd430c8","ns:OID":"6ba7b812-9dad-11d1-80b4-00c04fd430c8","ns:X500":"6ba7b814-9dad-11d1-80b4-00c04fd430c8"};if(m[v]!==void 0)v=m[v];else if(!v.match(/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/))throw new Error('UUID: parse: invalid string representation (expected "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")');n(v,0,7,this,0),n(v,9,12,this,4),n(v,14,17,this,6),n(v,19,22,this,8),n(v,24,35,this,10)}return this},x.prototype.export=function(){for(var v=Array(16),C=0;C<16;C++)v[C]=this[C];return v},x.prototype.import=function(v){if(!(typeof v=="object"&&v instanceof Array))throw new Error("UUID: import: invalid argument (type Array expected)");if(v.length!==16)throw new Error("UUID: import: invalid argument (Array of length 16 expected)");for(var C=0;C<16;C++){if(typeof v[C]!="number")throw new Error("UUID: import: invalid array element #"+C+" (type Number expected)");if(!(isFinite(v[C])&&Math.floor(v[C])===v[C]))throw new Error("UUID: import: invalid array element #"+C+" (Number with integer value expected)");if(!(v[C]>=0&&v[C]<=255))throw new Error("UUID: import: invalid array element #"+C+" (Number with integer value in range 0...255 expected)");this[C]=v[C]}return this},x.prototype.compare=function(v){if(typeof v!="object")throw new Error("UUID: compare: invalid argument (type UUID expected)");if(!(v instanceof x))throw new Error("UUID: compare: invalid argument (type UUID expected)");for(var C=0;C<16;C++){if(this[C]<v[C])return-1;if(this[C]>v[C])return 1}return 0},x.prototype.equal=function(v){return this.compare(v)===0},x.prototype.fold=function(v){if(typeof v>"u")throw new Error("UUID: fold: invalid argument (number of fold operations expected)");if(v<1||v>4)throw new Error("UUID: fold: invalid argument (1-4 fold operations expected)");for(var C=16/Math.pow(2,v),m=new Array(C),A=0;A<C;A++){for(var $=0,g=0;A+g<16;g+=C)$^=this[A+g];m[A]=$}return m},x.PCG=qe,x})})(Xp);var q3=Xp.exports;const M3=On(q3);var jo={exports:{}};/*! https://mths.be/base64 v1.0.0 by @mathias | MIT license */jo.exports;(function(t,e){(function(n){var r=e,s=t&&t.exports==r&&t,o=typeof pr=="object"&&pr;(o.global===o||o.window===o)&&(n=o);var i=function(S){this.message=S};i.prototype=new Error,i.prototype.name="InvalidCharacterError";var a=function(S){throw new i(S)},u="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",c=/[\t\n\f\r ]/g,l=function(S){S=String(S).replace(c,"");var b=S.length;b%4==0&&(S=S.replace(/==?$/,""),b=S.length),(b%4==1||/[^+a-zA-Z0-9/]/.test(S))&&a("Invalid character: the string to be decoded is not correctly encoded.");for(var F=0,y,T,O="",j=-1;++j<b;)T=u.indexOf(S.charAt(j)),y=F%4?y*64+T:T,F++%4&&(O+=String.fromCharCode(255&y>>(-2*F&6)));return O},p=function(S){S=String(S),/[^\0-\xFF]/.test(S)&&a("The string to be encoded contains characters outside of the Latin1 range.");for(var b=S.length%3,F="",y=-1,T,O,j,M,ee=S.length-b;++y<ee;)T=S.charCodeAt(y)<<16,O=S.charCodeAt(++y)<<8,j=S.charCodeAt(++y),M=T+O+j,F+=u.charAt(M>>18&63)+u.charAt(M>>12&63)+u.charAt(M>>6&63)+u.charAt(M&63);return b==2?(T=S.charCodeAt(y)<<8,O=S.charCodeAt(++y),M=T+O,F+=u.charAt(M>>10)+u.charAt(M>>4&63)+u.charAt(M<<2&63)+"="):b==1&&(M=S.charCodeAt(y),F+=u.charAt(M>>2)+u.charAt(M<<4&63)+"=="),F},d={encode:p,decode:l,version:"1.0.0"};if(r&&!r.nodeType)if(s)s.exports=d;else for(var f in d)d.hasOwnProperty(f)&&(r[f]=d[f]);else n.base64=d})(pr)})(jo,jo.exports);var L3=jo.exports;const j3=On(L3),G3=()=>j3.encode(new M3(4)).substring(0,12),U3={heading:"block",title:"block",endTitle:"block",remark:"block",footnote:"inline",xref:"inline",noteCaller:"inline",esbCat:"inline",table:"block",tree:"block",kv:"block"},V3={graftLocation:U3},zp={wordLike:0,punctuation:1,lineSpace:2,eol:3,softLineBreak:4,noBreakSpace:5,bareSlash:6,unknown:7},J3=Object.entries(zp).sort((t,e)=>t[1]-e[1]).map(t=>t[0]),H3={wordLike:"wordLike",punctuation:"notWordLike",lineSpace:"notWordLike",eol:"notWordLike",softLineBreak:"notWordLike",noBreakSpace:"notWordLike",bareSlash:"notWordLike",unknown:"notWordLike"},Go={tokenEnum:zp,tokenEnumLabels:J3,tokenCategory:H3},Yp={blockTag:0,inline:1,chapter:2,pubChapter:3,altChapter:4,verses:5,verse:6,pubVerse:7,altVerse:8,esbCat:9,span:10,table:11,cell:12,milestone:13,spanWithAtts:14,attribute:15,hangingGraft:16,orphanTokens:17,tTableRow:18,tTableCol:19,tTreeNode:20,tTreeParent:21,tTreeChild:22,tTreeContent:23,kvPrimary:24,kvSecondary:25,kvField:26},W3=Object.entries(Yp).sort((t,e)=>t[1]-e[1]).map(t=>t[0]),K3=t=>{const e=B.exec(t,B("([^1-9]+)(.*)")),n=e[1],r=e[2].length>0?e[2]:"1";return[n,r]},X3=t=>{const e={th:{type:"colHeading",align:"left"},thr:{type:"colHeading",align:"right"},tc:{type:"body",align:"left"},tcr:{type:"body",align:"right"}},[n,r]=K3(t);let s="1";if(r.includes("-")){const[o,i]=r.split("-");s=`${parseInt(i)-parseInt(o)+1}`}return`cell/${e[n].type}/${e[n].align}/${s}`},z3=(t,e)=>{switch(t){case"blockTag":return`blockTag/${e[0]}`;case"inline":return`inline/${e[0]}`;case"chapter":return`chapter/${e[0]}`;case"verses":return`verses/${e[0]}`;case"verse":return`verse/${e[0]}`;case"span":return`span/${e[0]}`;case"table":return"table";case"cell":return X3(e[0]);case"milestone":return`milestone/${e[0]}`;case"spanWithAtts":return`spanWithAtts/${e[0]}`;case"attribute":return`attribute/${e[0]}/${e[1]}/${e[2]}/${e[3]}`;case"orphanTokens":return"orphanTokens";case"hangingGraft":return"hangingGraft";case"pubChapter":return`pubChapter/${e[0]}`;case"pubVerse":return`pubVerse/${e[0]}`;case"altChapter":return`altChapter/${e[0]}`;case"altVerse":return`altVerse/${e[0]}`;case"esbCat":return`esbCat/${e[0]}`;case"tTableRow":return`tTableRow/${e[0]}`;case"tTableCol":return`tTableCol/${e[0]}`;case"tTreeNode":return`tTreeNode/${e[0]}`;case"tTreeParent":return`tTreeParent/${e[0]}`;case"tTreeChild":return`tTreeChild/${e[0]}/${e[1]}`;case"tTreeContent":return`tTreeContent/${e[0]}`;case"kvPrimary":return`kvPrimary/${e[0]}`;case"kvSecondary":return`kvSecondary/${e[0]}/${e[1]}`;case"kvField":return`kvField/${e[0]}`;default:throw new Error(`Unknown scope type '${t}' in labelForScope`)}},Y3=t=>{switch(t){case"orphanTokens":case"hangingGraft":case"table":return 1;case"blockTag":case"inline":case"chapter":case"verses":case"verse":case"span":case"milestone":case"spanWithAtts":case"pubChapter":case"altChapter":case"pubVerse":case"altVerse":case"esbCat":case"tTableRow":case"tTableCol":case"tTreeNode":case"tTreeParent":case"tTreeContent":case"kvPrimary":case"kvField":return 2;case"tTreeChild":case"kvSecondary":return 3;case"cell":return 4;case"attribute":return 6;default:throw new Error(`Unknown scope type '${t}' in nComponentsForScope`)}},Ps={scopeEnum:Yp,scopeEnumLabels:W3,labelForScope:z3,nComponentsForScope:Y3},Zp={token:0,graft:1,startScope:2,endScope:3},Z3=Object.entries(Zp).sort((t,e)=>t[1]-e[1]).map(t=>t[0]),Qp=t=>({type:t[0],subType:t[1],payload:t[2]}),ed=t=>[t.type,t.subType,t.payload],Q3=t=>t.map(e=>Qp(e)),eS=t=>t.map(e=>ed(e)),Ns={itemEnum:Zp,itemEnumLabels:Z3,itemArray2Object:Qp,itemObject2Array:ed,itemArrays2Objects:Q3,itemObjects2Arrays:eS},tS=(t,e)=>{const n=t.byte(e),r=n>>6,s=n&63,o=t.byte(e+1);return[s,r,o]},nS=(t,e,n,r,s)=>{const o=Go.tokenCategory[Go.tokenEnumLabels[r]],i=e[o][n.nByte(s+2)];return t[o].countedString(i)},rS=(t,e,n,r,s)=>{const o=Ps.scopeEnumLabels[r];let i=Ps.nComponentsForScope(o),a=2,u="";for(;i>1;){const c=n.nByte(s+a),l=e.scopeBits[c],p=t.scopeBits.countedString(l);u+=`/${p}`,a+=n.nByteLength(c),i--}return`${o}${u}`},sS=t=>Ps.scopeEnumLabels[t],oS=(t,e,n)=>{const r=e.graftTypes[n];return t.graftTypes.countedString(r)},iS=(t,e,n,r)=>{const s=e.ids[n.nByte(r+2)];return t.ids.countedString(s)},aS=t=>{const e={};for(const[n,r]of Object.entries(t))e[n]=td(n,r);return e},td=(t,e)=>{const n=new Uint32Array(e.length);let r=0,s=0;for(;r<e.length;){n[s]=r;const o=e.byte(r);r+=o+1,s+=1}return n},uS=(t,e)=>{e||(e=!1);let n=0,r=0;const s=[];for(;n<t.length;){const o=t.byte(n),i=t.countedString(n);s.push(e?[r,i]:i),n+=o+1,r++}return s},dr=(t,e)=>{throw new Error(`Undefined or null argument '${e}' in '${t}'`)},cS=(t,e,n)=>{e==null&&dr("pushSuccinctTokenBytes","tokenEnumIndex"),n==null&&dr("pushSuccinctTokenBytes","charsEnumIndex");const r=t.length;t.pushByte(0),t.pushByte(e),t.pushNByte(n),t.setByte(r,t.length-r|Ns.itemEnum.token<<6)},lS=(t,e,n)=>{e==null&&dr("pushSuccinctGraftBytes","graftTypeEnumIndex"),n==null&&dr("pushSuccinctGraftBytes","seqEnumIndex");const r=t.length;t.pushByte(0),t.pushByte(e),t.pushNByte(n),t.setByte(r,t.length-r|Ns.itemEnum.graft<<6)},pS=(t,e,n,r)=>{e==null&&dr("pushSuccinctScopeBytes","itemTypeByte"),n==null&&dr("pushSuccinctScopeBytes","scopeTypeByte"),r==null&&dr("pushSuccinctScopeBytes","scopeBitBytes");const s=t.length;t.pushByte(0),t.pushByte(n);for(const o of r)t.pushNByte(o);t.setByte(s,t.length-s|e<<6)},jn={enumIndex:td,enumIndexes:aS,headerBytes:tS,pushSuccinctTokenBytes:cS,pushSuccinctGraftBytes:lS,pushSuccinctScopeBytes:pS,succinctTokenChars:nS,succinctScopeLabel:rS,succinctScopeType:sS,succinctGraftName:oS,succinctGraftSeqId:iS,unpackEnum:uS},dS=t=>{const e=new ks;e.fromBase64(t);const n=[];n.push(`* Char length ${e.length} *`);for(const[r,s]of jn.unpackEnum(e,!0))n.push(`${r}	"${s}"`);return n.join(`
`)},fS=(t,e)=>{const n=new ks;n.fromBase64(t);const r={};for(const[a,u]of Object.entries(e))r[a]=new ks,r[a].fromBase64(u);const s=jn.enumIndexes(r),o=[];o.push(`* Char length ${n.length} *`);let i=0;for(;i<n.length;){const[a,u,c]=jn.headerBytes(n,i);let l=c,p="";switch(Ns.itemEnumLabels[u]){case"token":l=Go.tokenEnumLabels[c],p=`"${jn.succinctTokenChars(r,s,n,c,i)}"`;break;case"startScope":case"endScope":l=Ps.scopeEnumLabels[c],p=jn.succinctScopeLabel(r,s,n,c,i);break;case"graft":l=jn.succinctGraftName(r,s,c),p=jn.succinctGraftSeqId(r,s,n,i)}o.push(`${Ns.itemEnumLabels[u]}	${l}	(${a})	${p}`),i+=a}return o.join(`
`)},hS={inspectEnum:dS,inspectSuccinct:fS},mS={usfm:{baseSequenceTypes:{main:"1",introduction:"*",introTitle:"?",introEndTitle:"?",title:"?",endTitle:"?",heading:"*",header:"*",remark:"*",sidebar:"*",table:"*",tree:"*",kv:"*"},inlineSequenceTypes:{footnote:"*",noteCaller:"*",xref:"*",pubNumber:"*",altNumber:"*",esbCat:"*",fig:"*",temp:"?"}}},DS=t=>{for(const e of t)ui(e)},ui=t=>{if(!B.exec(t,/^[a-z][A-za-z0-9]*(:.+)?$/))throw new Error(`Tag '${t}' is not valid (should be [a-z][A-za-z0-9]*(:.+)?)`)},SS=(t,e)=>{ui(e),t.add(e)},ES=(t,e)=>{ui(e),t.delete(e)},yS={validateTags:DS,validateTag:ui,addTag:SS,removeTag:ES},gS=2,Uo=3,ci=["GEN","EXO","LEV","NUM","DEU","JOS","JDG","RUT","1SA","2SA","1KI","2KI","1CH","2CH","EZR","NEH","EST","JOB","PSA","PRO","ECC","SNG","ISA","JER","LAM","EZK","DAN","HOS","JOL","AMO","OBA","JON","MIC","NAM","HAB","ZEP","HAG","ZEC","MAL","MAT","MRK","LUK","JHN","ACT","ROM","1CO","2CO","GAL","EPH","PHP","COL","1TH","2TH","1TI","2TI","TIT","PHM","HEB","JAS","1PE","2PE","1JN","2JN","3JN","JUD","REV","TOB","JDT","ESG","WIS","SIR","BAR","LJE","S3Y","SUS","BEL","1MA","2MA","3MA","4MA","1ES","2ES","MAN","PS2","ODA","PSS","JSA","JDB","TBS","SST","DNT","BLT","EZA","5EZ","6EZ","DAG","PS3","2BA","LBA","JUB","ENO","1MQ","2MQ","3MQ","REP","4BA","LAO"],nd=()=>{const t={};for(const[e,n]of Object.entries(ci))t[n]=parseInt(e);return t},vS=t=>{const e={};for(const n of t.split(/[\n\r]+/).map(r=>r.trim()).map(r=>B.exec(r,B("^([A-Z1-6]{3} [0-9]+:[0-9]+(-[0-9]+)?) = ([A-Z1-6]{3} [0-9]+:[0-9]+[a-z]?(-[0-9]+)?)$"))))n&&(n[1]in e||(e[n[1]]=[]),e[n[1]].push(n[3]));return{mappedVerses:e}},AS=t=>{const e={};for(const[n,r]of Object.entries(t.mappedVerses))for(const s of r)s in e?e[s].push(n):e[s]=[n];return{reverseMappedVerses:e}},rd=t=>{const e={};for(let[n,r]of Object.entries(t)){typeof r=="string"&&(r=[r]);const[s,o]=n.split(" "),i=r[0].split(" ")[0],a=i===s?["cv"]:["bcv"];let[u,c]=o.split(":"),l=c;if(c.includes("-")){const p=c.split("-");c=p[0],l=p[1]}a.push([parseInt(c),parseInt(l)]),a.push([]);for(const p of r.map(d=>d.split(" ")[1])){let[d,f]=p.split(":"),S=f;if(f.includes("-")){const b=f.split("-");f=b[0],S=b[1]}a[0]==="cv"?a[2].push([parseInt(d),parseInt(f),parseInt(S)]):a[2].push([parseInt(d),parseInt(f),parseInt(S),i])}s in e||(e[s]={}),u in e[s]||(e[s][u]=[]),e[s][u].push(a)}return e},bS=t=>{const e={},n=nd();for(const[r,s]of Object.entries(rd(t))){e[r]={};for(const[o,i]of Object.entries(s))e[r][o]=sd(i,n)}return e},sd=(t,e)=>{const n=(s,o)=>o+s*64,r=new ks(64);for(const[s,[o,i],a]of t){const u=r.length,c=s==="bcv"?Uo:gS;if(r.pushNBytes([0,o,i]),c===Uo){const p=e[a[0][3]];r.pushNByte(p)}r.pushNByte(a.length);for(const[p,d]of a)r.pushNBytes([p,d]);const l=r.length-u;if(l>63)throw new Error(`Mapping in succinctifyVerseMapping ${JSON.stringify(a)} is too long (${l} bytes)`);r.setByte(u,n(c,l))}return r.trim(),r},od=(t,e)=>{const n=t.byte(e);return[n>>6,n%64]},CS=(t,e,n)=>{const r=[];let s=0;for(;s<t.length;){let o=s;const i={},[a,u]=od(t,s);if(o++,i.fromVerseStart=t.nByte(o),o+=t.nByteLength(i.fromVerseStart),i.fromVerseEnd=t.nByte(o),o+=t.nByteLength(i.fromVerseEnd),i.bookCode=e,a===Uo){const p=t.nByte(o);i.bookCode=ci[p],o+=t.nByteLength(p)}const c=t.nByte(o);o+=t.nByteLength(c);const l=[];for(;l.length<c;){const p={};p.ch=t.nByte(o),o+=t.nByteLength(p.ch),p.verseStart=t.nByte(o),o+=t.nByteLength(p.verseStart),l.push(p)}i.mapping=l,r.push(i),s+=u}return r},TS=(t,e,n,r)=>{let s=null,o=0;for(;o<t.length;){let i=o;const[a,u]=od(t,o);i++;const c=t.nByte(i);i+=t.nByteLength(c);const l=t.nByte(i);if(i+=t.nByteLength(l),r<c||r>l){o+=u;continue}let p=e;if(a===Uo){const f=t.nByte(i);p=ci[f],i+=t.nByteLength(f)}s=[p,[]];const d=t.nByte(i);for(i+=t.nByteLength(d);s[1].length<d;){const f=t.nByte(i);i+=t.nByteLength(f);const S=t.nByte(i);i+=t.nByteLength(S),s[1].push([f,r-c+S])}break}return s||[e,[[n,r]]]},wS={vrs2json:vS,reverseVersification:AS,preSuccinctVerseMapping:rd,bookCodes:ci,succinctifyVerseMapping:sd,succinctifyVerseMappings:bS,unsuccinctifyVerseMapping:CS,bookCodeIndex:nd,mapVerse:TS},Q={ByteArray:ks,canons:$3,enums:x3,generateId:G3,graftDefs:V3,inspect:hS,itemDefs:Ns,parserConstants:mS,scopeDefs:Ps,succinct:jn,tags:yS,tokenDefs:Go,versification:wS},Zc=(t,e)=>{if(typeof e!="object")throw new Error(`DocSet constructor expects selectors to be object, found ${typeof t.selectors}`);const n={};for(const r of t.processor.selectors)n[r.name]=r;for(const[r,s]of Object.entries(e)){if(!(r in n))throw new Error(`Unexpected selector '${r}' (expected one of [${Object.keys(n).join(", ")}])`);if(typeof s=="string"&&n[r].type!=="string"||typeof s=="number"&&n[r].type!=="integer")throw new Error(`Selector '${r}' is of type ${typeof s} (expected ${n[r].type})`);if(typeof s=="number"){if(!Number.isInteger(s))throw new Error(`Value '${s}' of integer selector '${r}' is not an integer`);if("min"in n[r]&&s<n[r].min)throw new Error(`Value '${s}' is less than ${n[r].min}`);if("max"in n[r]&&s>n[r].max)throw new Error(`Value '${s}' is greater than ${n[r].max}`)}else if("regex"in n[r]&&!B.exec(s,B(n[r].regex),0))throw new Error(`Value '${s}' does not match regex '${n[r].regex}'`);if("enum"in n[r]&&!n[r].enum.includes(s))throw new Error(`Value '${s}' of selector '${r}' is not in enum`)}for(const r of Object.keys(n))if(!(r in e))throw new Error(`Expected selector '${r}' not found`);return e},FS=(t,e,n)=>{const r=(i,a,u)=>[...t.unsuccinctifyScopes(i.os).map(l=>l[2]),...t.unsuccinctifyScopes(i.is).map(l=>l[2])].filter(l=>l.startsWith("chapter/")).map(l=>parseInt(l.split("/")[1])).filter(l=>l>a&&l<u).length>0,s=(i,a,u)=>[...t.unsuccinctifyScopes(i.os).map(l=>l[2]),...t.unsuccinctifyScopes(i.is).map(l=>l[2])].includes(`chapter/${a}`)&&t.blockHasMatchingItem(i,(l,p)=>p.has(`chapter/${a}`)?Array.from(p).filter(d=>d.startsWith("verse/")).filter(d=>parseInt(d.split("/")[1])>=u).length>0||u===0&&l[0]==="token"&&l[2]&&Array.from(p).filter(d=>d.startsWith("verse")).length===0:!1,{}),o=(i,a,u)=>[...t.unsuccinctifyScopes(i.os).map(l=>l[2]),...t.unsuccinctifyScopes(i.is).map(l=>l[2])].includes(`chapter/${a}`)&&t.blockHasMatchingItem(i,(l,p)=>p.has(`chapter/${a}`)?Array.from(p).filter(d=>d.startsWith("verse/")).filter(d=>parseInt(d.split("/")[1])<=u).length>0||u===0&&l[0]==="token"&&l[2]&&Array.from(p).filter(d=>d.startsWith("verse")).length===0:!1,{});if(B.exec(n,B("^[1-9][0-9]*$"))){const i=[`chapter/${n}`];return e.filter(a=>t.allScopesInBlock(a,i))}else if(B.exec(n,B("^[1-9][0-9]*-[1-9][0-9]*$"))){const[i,a]=n.split("-").map(c=>parseInt(c));if(i>a)throw new Error(`Chapter range must be from min to max, not '${n}'`);const u=[...Array(a-i+1).keys()].map(c=>`chapter/${c+i}`);return e.filter(c=>t.anyScopeInBlock(c,u))}else if(B.exec(n,B("^[1-9][0-9]*:[0-9]+$"))){const[i,a]=n.split(":").map(u=>parseInt(u));if(a===0){const u=[`chapter/${i}`];return e.filter(c=>t.allScopesInBlock(c,u)).filter(c=>[...t.allBlockScopes(c)].filter(l=>l.startsWith("verse")).length===0)}else{const u=[`chapter/${i}`,`verse/${a}`];return e.filter(c=>t.allScopesInBlock(c,u))}}else if(B.exec(n,B("^[1-9][0-9]*:[0-9]+-[1-9][0-9]*$"))){const[i,a]=n.split(":"),[u,c]=a.split("-").map(d=>parseInt(d));if(u>c)throw new Error(`Verse range must be from min to max, not '${a}'`);const l=[`chapter/${i}`],p=[...Array(c-u+1).keys()].map(d=>`verse/${d+u}`);return e.filter(d=>t.allScopesInBlock(d,l)).filter(d=>t.anyScopeInBlock(d,p)||u===0&&[...t.allBlockScopes(d)].filter(f=>f.startsWith("verse")).length===0)}else if(B.exec(n,B("^[1-9][0-9]*:[0-9]+-[1-9][0-9]*:[0-9]+$"))){const[i,a]=n.split("-"),[u,c]=i.split(":").map(S=>parseInt(S)),[l,p]=a.split(":").map(S=>parseInt(S));if(u>l)throw new Error(`Chapter range must be from min to max, not '${u}-${p}'`);const d=[...Array(l-u+1).keys()].map(S=>`chapter/${S+u}`);return e.filter(S=>t.anyScopeInBlock(S,d)).filter(S=>r(S,u,l)||s(S,u,c)||o(S,l,p))}else throw new Error(`Bad cv reference '${n}'`)},IS=(t,e)=>{const[n,r,s]=Q.succinct.headerBytes(e.bs,0),o=t.unsuccinctifyScope(e.bs,r,s,0);return new Set([...t.unsuccinctifyScopes(e.os).map(i=>i[2]),...t.unsuccinctifyScopes(e.is).map(i=>i[2]),o[2]])},kS=(t,e,n)=>{const r=t.allBlockScopes(e);for(const s of n)if(!r.has(s))return!1;return!0},PS=(t,e,n)=>{const r=t.allBlockScopes(e);for(const s of n)if(r.has(s))return!0;return!1},NS=(t,e,n)=>{const[r,s,o]=Q.succinct.headerBytes(e.bs,0);return t.unsuccinctifyScope(e.bs,s,o,0)[2]===n},_S=(t,e,n)=>{let r=!1,s=0;const o=e.c;if(n.includes(-1))return!1;for(;!r&&s<o.length;){const[i,a]=Q.succinct.headerBytes(o,s);a===Q.itemDefs.itemEnum.token&&n.includes(o.nByte(s+2))&&(r=!0),s+=i}return r},OS=(t,e,n,r)=>{const s=new Set(t.unsuccinctifyScopes(e.os).map(o=>o[2]));for(const o of t.unsuccinctifyItems(e.c,r,0)){if(o[0]==="scope"&&o[1]==="start"&&s.add(o[2]),n(o,s))return!0;o[0]==="scope"&&o[1]==="end"&&s.delete(o[2])}return!1},$S=(t,e,n)=>{t.maybeBuildEnumIndexes();const r=e.bs,[s,o,i]=Q.succinct.headerBytes(r,0),a=t.unsuccinctifyScope(r,o,i,0),u=t.unsuccinctifyGrafts(e.bg),c=t.unsuccinctifyScopes(e.os),l=t.unsuccinctifyScopes(e.is),p=e.nt.nByte(0),d=t.unsuccinctifyItems(e.c,n||{},p);return{bs:a,bg:u,c:d,os:c,is:l,nt:p}},BS=(t,e,n,r,s)=>{if(r===void 0)throw new Error("nextToken (previously includeContext) must now be provided to unsuccinctifyItems");if(r!==null&&typeof r!="number")throw new Error(`nextToken (previously includeContext) must be null or an integer, not ${typeof r} '${JSON.stringify(r)}' in unsuccinctifyItems`);const o=[];let i=0,a=r||0;const u=new Set(s||[]),c=[Q.itemDefs.itemEnum.startScope,Q.itemDefs.itemEnum.endScope];for(;i<e.length;){const[l,p,d]=Q.succinct.headerBytes(e,i);if(Object.keys(n).length>0){if(!n.scopes&&c.includes(p)){i+=l;continue}if(!n.tokens&&p===Q.itemDefs.itemEnum.token){i+=l;continue}if(!n.grafts&&p===Q.itemDefs.itemEnum.graft){i+=l;continue}}if(c.includes(p)){const S=Q.succinct.succinctScopeType(d);if(Object.keys(n).length>0&&n.scopes&&n.excludeScopeTypes&&n.excludeScopeTypes.includes(S)){i+=l;continue}}const f=t.unsuccinctifyItem(e,i,{})[0];f[0]==="token"?(Object.keys(n).length===0||n.tokens)&&(r!==null&&(f.push(f[0]==="token"&&f[1]==="wordLike"?a++:null),f.push([...u])),o.push(f)):f[0]==="scope"&&f[1]==="start"?(Object.keys(n).length===0||n.scopes)&&(u.add(f[2]),o.push(f)):f[0]==="scope"&&f[1]==="end"?(Object.keys(n).length===0||n.scopes)&&(u.delete(f[2]),o.push(f)):f[0]==="graft"&&(Object.keys(n).length===0||n.grafts)&&o.push(f),i+=l}return o},RS=(t,e,n,r)=>{let s=null;const[o,i,a]=Q.succinct.headerBytes(e,n);switch(i){case Q.itemDefs.itemEnum.token:(Object.keys(r).length===0||r.tokens)&&(s=t.unsuccinctifyToken(e,a,n));break;case Q.itemDefs.itemEnum.startScope:case Q.itemDefs.itemEnum.endScope:(Object.keys(r).length===0||r.scopes)&&(s=t.unsuccinctifyScope(e,i,a,n));break;case Q.itemDefs.itemEnum.graft:(Object.keys(r).length===0||r.grafts)&&(s=t.unsuccinctifyGraft(e,a,n));break}return[s,o]},xS=(t,e,n)=>{const r=new Set(t.unsuccinctifyScopes(e.os).map(p=>p[2])),s=n.requiredScopes||[],u=n.anyScope||!1?()=>{for(const p of s)if(r.has(p))return!0;return s.length===0}:()=>{for(const p of s)if(!r.has(p))return!1;return!0},c=p=>!n.withChars||n.withChars.length===0||p[0]==="token"&&n.withChars.includes(p[2]),l=[];for(const p of t.unsuccinctifyItems(e.c,n,e.nt.nByte(0),r))p[0]==="scope"&&p[1]==="start"&&r.add(p[2]),u()&&c(p)&&l.push(p),p[0]==="scope"&&p[1]==="end"&&r.delete(p[2]);return l},qS=(t,e,n,r)=>{r=r||{};const s=new Set(t.unsuccinctifyScopes(e.os).map(c=>c[2])),i=(()=>{if(B.exec(n,B("^[1-9][0-9]*$")))return()=>s.has(`chapter/${n}`);if(B.exec(n,B("^[1-9][0-9]*-[1-9][0-9]*$")))return()=>{const[c,l]=n.split("-").map(p=>parseInt(p));if(c>l)throw new Error(`Chapter range must be from min to max, not '${n}'`);for(const p of[...Array(l-c+1).keys()].map(d=>`chapter/${d+c}`))if(s.has(p))return!0;return!1};if(B.exec(n,B("^[1-9][0-9]*:[0-9]+$")))return()=>{const[c,l]=n.split(":").map(p=>parseInt(p));if(l===0)return s.has(`chapter/${c}`)&&[...s].filter(p=>p.startsWith("verse")).length===0;for(const p of[`chapter/${c}`,`verse/${l}`])if(!s.has(p))return!1;return!0};if(B.exec(n,B("^[1-9][0-9]*:[0-9]+-[1-9][0-9]*$")))return()=>{const[c,l]=n.split(":"),[p,d]=l.split("-").map(b=>parseInt(b));if(p>d)throw new Error(`Verse range must be from min to max, not '${l}'`);const f=`chapter/${c}`,S=[...Array(d-p+1).keys()].map(b=>`verse/${b+p}`);if(!s.has(f))return!1;for(const b of S)if(s.has(b))return!0;return p===0&&[...s].filter(b=>b.startsWith("verse")).length===0};if(B.exec(n,B("^[1-9][0-9]*:[0-9]+-[1-9][0-9]*:[0-9]+$")))return()=>{const[c,l]=n.split("-"),[p,d]=c.split(":").map(T=>parseInt(T)),[f,S]=l.split(":").map(T=>parseInt(T));if(p>f)throw new Error(`Chapter range must be from min to max, not '${p}-${S}'`);const b=[...s],F=b.filter(T=>T.startsWith("chapter/"));if(F.length>1)throw new Error(`Expected zero or one chapter for item, found ${F.length}`);const y=parseInt(F[0].split("/")[1]);return y<p||y>f?!1:y===p?b.filter(T=>T.startsWith("verse/")&&parseInt(T.split("/")[1])>=d).length>0||d===0&&b.filter(T=>T.startsWith("verse")).length===0:y===f?b.filter(T=>T.startsWith("verse/")&&parseInt(T.split("/")[1])<=S).length>0||S===0&&b.filter(T=>T.startsWith("verse")).length===0:!0};throw new Error(`Bad cv reference '${n}'`)})(),a=c=>{if(!r||Object.keys(r).length===0)return!0;{const l=c[0];return l==="token"&&"tokens"in r||l==="graft"&&"grafts"in r||l==="scope"&&"scopes"in r}},u=[];if(r.excludeScopeTypes)for(const c of t.unsuccinctifyItems(e.c,r,e.nt.nByte(0)))c[0]==="scope"&&c[1]==="start"&&s.add(c[2]),i()&&a(c)&&u.push(c),c[0]==="scope"&&c[1]==="end"&&s.delete(c[2]);else for(const c of t.unsuccinctifyItems(e.c,{},e.nt.nByte(0)))c[0]==="scope"&&c[1]==="start"&&s.add(c[2]),i()&&a(c)&&u.push(c),c[0]==="scope"&&c[1]==="end"&&s.delete(c[2]);return u},MS=(t,e)=>{const n=new Map;let r=0,s=0;for(;r<e.length;)n.set(e.countedString(r),{enum:s++,frequency:0}),r+=e.byte(r)+1;return n},LS=(t,e,n)=>{if(!(e in t.preEnums))throw new Error(`Unknown category ${e} in recordPreEnum. Maybe call buildPreEnums()?`);n.length>255&&console.log("Value length of",n.length,"in recordPreEnum"),t.preEnums[e].has(n)?t.preEnums[e].get(n).frequency++:t.preEnums[e].set(n,{enum:t.preEnums[e].size,frequency:1})},jS=(t,e,n)=>{const r=new Map([...n.entries()]);for(const s of r.keys())s.length>255&&console.log("enum text for",e,"has length",s.length,"in buildEnum - truncating"),t.enums[e].pushCountedString(s.substring(0,255));t.enums[e].trim()},GS=(t,e,n,r)=>{if(r||(r=!1),!(e in t.preEnums))throw new Error(`Unknown category ${e} in preEnums. Maybe call buildPreEnums()?`);if(t.preEnums[e].has(n))return t.preEnums[e].get(n).enum;if(r)return t.preEnums[e].set(n,{enum:t.preEnums[e].size,frequency:1}),t.enums[e].pushCountedString(n),t.buildEnumIndex(e),t.preEnums[e].get(n).enum;throw new Error(`Unknown value '${n}' for category ${e} in enumForCategoryValue. Maybe call buildPreEnums()?`)},US=(t,e)=>{let n=0,r=0;for(;r<e.length;){n++;const o=e.byte(r)&63;r+=o}return n},VS=(t,e,n,r)=>{let s=[];if(!n)return s;let o=n.startBlock,i=n.nextToken;for(;o<=n.endBlock;){let a=t.unsuccinctifyItems(e.blocks[o].c,{},i);const u=t.unsuccinctifyScopes(e.blocks[o].bs)[0],c=t.unsuccinctifyGrafts(e.blocks[o].bg);if(o===n.startBlock&&o===n.endBlock?a=a.slice(n.startItem,n.endItem+1):o===n.startBlock?a=a.slice(n.startItem):o===n.endBlock&&(a=a.slice(0,n.endItem+1)),r){let l=[];for(const p of a)l.push(p.concat([p[0]==="token"&&p[1]==="wordLike"?i++:null]));a=l}s.push([...c,["scope","start",u[2]],...a,["scope","end",u[2]]]),o++}return s},JS=(t,e,n)=>{let r=[];const s=()=>{for(const c of n)if(!o(c))return!1;return!0},o=c=>{for(const l of r)if(l.startsWith(c))return l;return null};t.maybeBuildEnumIndexes();const i=[];let a=new Set([]),u=!0;for(const[c,l]of e.entries()){const[p,d,f]=Q.succinct.headerBytes(l.bs,0),S=t.unsuccinctifyScope(l.bs,d,f,0)[2],b=["scope","start",S],F=["scope","end",S],y=t.unsuccinctifyGrafts(l.bg);r=new Set(t.unsuccinctifyScopes(l.os).map(T=>T[2]).concat([S]));for(const T of y.concat([b,...t.unsuccinctifyItems(l.c,{},l.nt.nByte(0),r),F]).concat(c!==e.length-1?[["token","lineSpace"," "]]:[])){if(T[0]==="scope"&&T[1]==="start"&&a.add(T[2]),T[0]==="token"&&a.size>0){for(const O of Array.from(a))r.add(O);a.clear()}s()?(u&&i.push([[...r],[]]),i[i.length-1][1].push(T),u=!1):u=!0,T[0]==="scope"&&T[1]==="end"&&(r.delete(T[2]),a.delete(T[2]))}}return i},HS=(t,e,n)=>{let r=new Set([]);const s=i=>i[0]==="scope"&&i[1]==="start"&&n.includes(i[2]);t.maybeBuildEnumIndexes();const o=[[[],[]]];for(const i of e){const[a,u,c]=Q.succinct.headerBytes(i.bs,0),l=t.unsuccinctifyScope(i.bs,u,c,0)[2],p=t.unsuccinctifyGrafts(i.bg);r.add(l),t.unsuccinctifyScopes(i.os).forEach(f=>r.add(f[2]));const d=p.concat([l].concat(t.unsuccinctifyItems(i.c,{},i.nt.nByte(0))));for(const f of d){if(f[0]==="scope"&&f[1]==="start"&&r.add(f[2]),s(f)){o[o.length-1][0]=[...r].sort(),o.push([[],[]]);for(const S of[...r].filter(b=>["blockTag","verse","verses","chapter"].includes(b.split("/")[0])||n.includes(b)))r.delete(S);r.add(l)}o[o.length-1][1].push(f)}o[o.length-1][1].push(["scope","end",l]),o[o.length-1][1].push(["token","punctuation",`
`])}return o[o.length-1][0]=[...r].sort(),o},WS=t=>{t.preEnums={};for(const n of Object.keys(t.enums))t.preEnums[n]=new Map;t.maybeBuildEnumIndexes();for(const n of t.documents())for(const r of Object.values(n.sequences))n.rerecordPreEnums(t,r);t.sortPreEnums();const e=t.makeRehashEnumMap();for(const n of t.documents())for(const r of Object.values(n.sequences))n.rewriteSequenceBlocks(r.id,e);return t.buildEnums(),t.buildEnumIndexes(),!0},KS=t=>{const e={};for(const[n,r]of Object.entries(t.enums)){e[n]=[];let s=0;for(;s<r.length;){const o=r.byte(s),i=r.countedString(s);t.preEnums[n].has(i)?e[n].push(t.preEnums[n].get(i).enum):e[n].push(null),s+=o+1}}return e},_s=Q.ByteArray,{pushSuccinctGraftBytes:XS,pushSuccinctScopeBytes:du,pushSuccinctTokenBytes:zS}=Q.succinct,{itemEnum:fu}=Q.itemDefs,{scopeEnum:hu}=Q.scopeDefs,{tokenCategory:YS,tokenEnum:ZS}=Q.tokenDefs,js=(t,e,n,r,s,o)=>{const i=t.processor.documents[e];if(!i)throw new Error(`Document '${e}' not found`);let a;if(n){if(a=i.sequences[n],!a)throw new Error(`Sequence '${n}' not found`)}else a=i.sequences[i.mainId];if(a.blocks.length<=r)throw new Error(`Could not find block ${r} (length=${a.blocks.length})`);const u=a.blocks[r],c=new _s(o.length);t.maybeBuildPreEnums();let l=0;r<0&&(l=a.blocks[r-1].nt.nByte(0));let p,d,f,S,b,F=null;for(const y of o)switch(y.type){case"token":p=t.enumForCategoryValue(YS[y.subType],y.payload,!0),zS(c,ZS[y.subType],p),l++;break;case"graft":d=t.enumForCategoryValue("graftTypes",y.subType,!0),f=t.enumForCategoryValue("ids",y.payload,!0),XS(c,d,f);break;case"scope":if(S=y.payload.split("/"),b=hu[S[0]],!b&&b!==0)throw new Error(`"${S[0]}" is not a scope type`);F=S.slice(1).map(T=>t.enumForCategoryValue("scopeBits",T,!0)),du(c,fu[`${y.subType}Scope`],b,F);break}return c.trim(),u[s]=c,s==="c"&&(u.nt.clear(),u.nt.pushNByte(l)),!0},QS=(t,e,n,r,s)=>js(t,e,n,r,"c",s),id=(t,e,n,r,s)=>js(t,e,n,r,"bg",s),eE=(t,e,n,r,s)=>js(t,e,n,r,"bs",[s]),tE=(t,e,n,r,s)=>js(t,e,n,r,"os",s),nE=(t,e,n,r,s)=>js(t,e,n,r,"is",s),rE=(t,e,n)=>{const r=(l,p)=>{for(const d of Array.from(l))if(!p.has(d))return!1;for(const d of Array.from(p))if(!l.has(d))return!1;return!0},s=(l,p,d)=>{const f=d.split("/"),S=hu[f[0]];if(!S&&S!==0)throw new Error(`"${f[0]}" is not a scope type`);const b=f.slice(1).map(F=>l.enumForCategoryValue("scopeBits",F,!0));du(p,fu.startScope,S,b)},o=e.blocks[n],i=new Set,a=new Set;for(const l of t.unsuccinctifyScopes(o.os))a.add(l[2]);for(const l of t.unsuccinctifyItems(o.c,{scopes:!0},null))l[1]==="start"?(i.add(l[2]),a.add(l[2])):a.delete(l[2]);const u=Array.from(i),c=new _s(u.length);for(const l of u)s(t,c,l);if(c.trim(),o.is=c,n<e.blocks.length-1){const l=e.blocks[n+1],p=l.os,d=new Set(t.unsuccinctifyScopes(p).map(f=>f[2]));if(!r(a,d)){const f=new _s(d.length);for(const S of Array.from(a))s(t,f,S);f.trim(),l.os=f,t.updateBlockIndexesAfterEdit(e,n+1)}}},sE=(t,e)=>{const n=(s,o,i)=>{const a=i.split("/"),u=hu[a[0]];if(!u&&u!==0)throw new Error(`"${a[0]}" is not a scope type`);const c=a.slice(1).map(l=>s.enumForCategoryValue("scopeBits",l,!0));du(o,fu.startScope,u,c)},r=new Set;for(const s of e.blocks){const o=Array.from(r),i=new _s(o.length);for(const l of o)n(t,i,l);i.trim(),s.os=i;const a=new Set;for(const l of t.unsuccinctifyItems(s.c,{scopes:!0},null))l[1]==="start"?(a.add(l[2]),r.add(l[2])):r.delete(l[2]);const u=Array.from(a),c=new _s(u.length);for(const l of u)n(t,c,l);c.trim(),s.is=c}},oE=t=>{const e={id:t.id,metadata:{selectors:t.selectors},enums:{},docs:{},tags:Array.from(t.tags)};for(const[n,r]of Object.entries(t.enums))r.trim(),e.enums[n]=r.base64();e.docs={};for(const n of t.docIds)e.docs[n]=t.processor.documents[n].serializeSuccinct();return e},Fr=Q.ByteArray,{addTag:iE,removeTag:aE,validateTags:Qc}=Q.tags,{succinctGraftName:uE,succinctGraftSeqId:cE,succinctScopeLabel:lE,succinctTokenChars:pE,headerBytes:ki,enumIndex:dE,enumIndexes:fE}=Q.succinct,{itemEnum:hE}=Q.itemDefs,{tokenEnumLabels:mE}=Q.tokenDefs;class el{constructor(e,n,r,s){this.processor=e,this.preEnums={},this.enumIndexes={},this.docIds=[],s?this.fromSuccinct(e,s):this.fromScratch(e,n,r),Qc(this.tags)}fromScratch(e,n,r){const s=n||e.selectors;this.selectors=Zc(this,s),this.id=this.selectorString(),this.tags=new Set(r||[]),this.enums={ids:new Fr(512),wordLike:new Fr(8192),notWordLike:new Fr(256),scopeBits:new Fr(256),graftTypes:new Fr(10)}}fromSuccinct(e,n){const r=s=>{const o=new Fr(256);return o.fromBase64(s),o.trim(),o};this.id=n.id,this.selectors=Zc(this,n.metadata.selectors),this.tags=new Set(n.tags),Qc(this.tags),this.preEnums={},this.enums={ids:r(n.enums.ids),wordLike:r(n.enums.wordLike),notWordLike:r(n.enums.notWordLike),scopeBits:r(n.enums.scopeBits),graftTypes:r(n.enums.graftTypes)},this.enumIndexes={},this.docIds=[]}addTag(e){iE(this.tags,e)}removeTag(e){aE(this.tags,e)}selectorString(){return this.processor.selectorString(this.selectors)}documents(){return this.docIds.map(e=>this.processor.documents[e])}documentWithBook(e){const n=Object.values(this.documents()).filter(r=>"bookCode"in r.headers&&r.headers.bookCode===e);return n.length===1?n[0]:null}maybeBuildPreEnums(){Object.keys(this.preEnums).length===0&&this.buildPreEnums()}buildPreEnums(){for(const[e,n]of Object.entries(this.enums))this.preEnums[e]=MS(this,n)}recordPreEnum(e,n){LS(this,e,n)}sortPreEnums(){for(const e of Object.keys(this.preEnums)){this.preEnums[e]=new Map([...this.preEnums[e].entries()].sort((r,s)=>s[1].frequency-r[1].frequency));let n=0;for(const[r,s]of this.preEnums[e])s.enum=n++}}enumForCategoryValue(e,n,r){return GS(this,e,n,r)}buildEnums(){for(const[e,n]of Object.entries(this.preEnums))this.enums[e].clear(),this.buildEnum(e,n)}buildEnum(e,n){jS(this,e,n)}maybeBuildEnumIndexes(){Object.keys(this.enumIndexes).length===0&&this.buildEnumIndexes()}buildEnumIndexes(){this.enumIndexes=fE(this.enums)}buildEnumIndex(e){this.enumIndexes[e]=dE(e,this.enums[e])}unsuccinctifyBlock(e,n){return $S(this,e,n)}unsuccinctifyItems(e,n,r,s){return BS(this,e,n,r,s)}unsuccinctifyItem(e,n,r){return RS(this,e,n,r)}unsuccinctifyPrunedItems(e,n){return xS(this,e,n)}unsuccinctifyScopes(e){const n=[];let r=0;for(;r<e.length;){const[s,o,i]=ki(e,r);n.push(this.unsuccinctifyScope(e,o,i,r)),r+=s}return n}unsuccinctifyGrafts(e){const n=[];let r=0;for(;r<e.length;){const[s,o,i]=ki(e,r);n.push(this.unsuccinctifyGraft(e,i,r)),r+=s}return n}unsuccinctifyToken(e,n,r){try{return["token",mE[n],this.succinctTokenChars(e,n,r)]}catch(s){throw new Error(`Error from unsuccinctifyToken: ${s}`)}}unsuccinctifyScope(e,n,r,s){try{return["scope",n===hE.startScope?"start":"end",this.succinctScopeLabel(e,r,s)]}catch(o){throw new Error(`Error from unsuccinctifyScope: ${o}`)}}unsuccinctifyGraft(e,n,r){try{return["graft",this.succinctGraftName(n),this.succinctGraftSeqId(e,r)]}catch(s){throw new Error(`Error from unsuccinctifyGraft: ${s}`)}}unsuccinctifyBlockScopeLabelsSet(e){const[n,r,s]=ki(e.bs,0),o=this.unsuccinctifyScope(e.bs,r,s,0);return new Set(this.unsuccinctifyScopes(e.os).concat(this.unsuccinctifyScopes(e.is)).concat([o]).map(i=>i[2]))}unsuccinctifyItemsWithScriptureCV(e,n,r){return qS(this,e,n,r)}succinctTokenChars(e,n,r){return pE(this.enums,this.enumIndexes,e,n,r)}succinctScopeLabel(e,n,r){return lE(this.enums,this.enumIndexes,e,n,r)}succinctGraftName(e){return uE(this.enums,this.enumIndexes,e)}succinctGraftSeqId(e,n){return cE(this.enums,this.enumIndexes,e,n)}countItems(e){return US(this,e)}itemsByIndex(e,n,r){return VS(this,e,n,r)}blocksWithScriptureCV(e,n){return FS(this,e,n)}allBlockScopes(e){return IS(this,e)}allScopesInBlock(e,n){return kS(this,e,n)}anyScopeInBlock(e,n){return PS(this,e,n)}blockHasBlockScope(e,n){return NS(this,e,n)}blockHasChars(e,n){return _S(this,e,n)}blockHasMatchingItem(e,n,r){return OS(this,e,n,r)}sequenceItemsByScopes(e,n){return JS(this,e,n)}sequenceItemsByMilestones(e,n){return HS(this,e,n)}rehash(){return WS(this)}makeRehashEnumMap(){return KS(this)}updateItems(e,n,r,s){return QS(this,e,n,r,s)}updateBlockGrafts(e,n,r,s){return id(this,e,n,r,s)}updateBlockScope(e,n,r,s){return eE(this,e,n,r,s)}updateOpenScopes(e,n,r,s){return tE(this,e,n,r,s)}updateIncludedScopes(e,n,r,s){return nE(this,e,n,r,s)}updateBlockIndexesAfterEdit(e,n){rE(this,e,n)}updateBlockIndexesAfterFilter(e){sE(this,e)}serializeSuccinct(){return oE(this)}checksum(){const e=[...this.docIds].sort().join(" ");return Vp.calculate(e)}}var ya={exports:{}},ad={},cn={},Yr={},Gs={},Ie={},Os={};(function(t){Object.defineProperty(t,"__esModule",{value:!0}),t.regexpCode=t.getEsmExportName=t.getProperty=t.safeStringify=t.stringify=t.strConcat=t.addCodeArg=t.str=t._=t.nil=t._Code=t.Name=t.IDENTIFIER=t._CodeOrName=void 0;class e{}t._CodeOrName=e,t.IDENTIFIER=/^[a-z$_][a-z$_0-9]*$/i;class n extends e{constructor(T){if(super(),!t.IDENTIFIER.test(T))throw new Error("CodeGen: name must be a valid identifier");this.str=T}toString(){return this.str}emptyStr(){return!1}get names(){return{[this.str]:1}}}t.Name=n;class r extends e{constructor(T){super(),this._items=typeof T=="string"?[T]:T}toString(){return this.str}emptyStr(){if(this._items.length>1)return!1;const T=this._items[0];return T===""||T==='""'}get str(){var T;return(T=this._str)!==null&&T!==void 0?T:this._str=this._items.reduce((O,j)=>`${O}${j}`,"")}get names(){var T;return(T=this._names)!==null&&T!==void 0?T:this._names=this._items.reduce((O,j)=>(j instanceof n&&(O[j.str]=(O[j.str]||0)+1),O),{})}}t._Code=r,t.nil=new r("");function s(y,...T){const O=[y[0]];let j=0;for(;j<T.length;)a(O,T[j]),O.push(y[++j]);return new r(O)}t._=s;const o=new r("+");function i(y,...T){const O=[f(y[0])];let j=0;for(;j<T.length;)O.push(o),a(O,T[j]),O.push(o,f(y[++j]));return u(O),new r(O)}t.str=i;function a(y,T){T instanceof r?y.push(...T._items):T instanceof n?y.push(T):y.push(p(T))}t.addCodeArg=a;function u(y){let T=1;for(;T<y.length-1;){if(y[T]===o){const O=c(y[T-1],y[T+1]);if(O!==void 0){y.splice(T-1,3,O);continue}y[T++]="+"}T++}}function c(y,T){if(T==='""')return y;if(y==='""')return T;if(typeof y=="string")return T instanceof n||y[y.length-1]!=='"'?void 0:typeof T!="string"?`${y.slice(0,-1)}${T}"`:T[0]==='"'?y.slice(0,-1)+T.slice(1):void 0;if(typeof T=="string"&&T[0]==='"'&&!(y instanceof n))return`"${y}${T.slice(1)}`}function l(y,T){return T.emptyStr()?y:y.emptyStr()?T:i`${y}${T}`}t.strConcat=l;function p(y){return typeof y=="number"||typeof y=="boolean"||y===null?y:f(Array.isArray(y)?y.join(","):y)}function d(y){return new r(f(y))}t.stringify=d;function f(y){return JSON.stringify(y).replace(/\u2028/g,"\\u2028").replace(/\u2029/g,"\\u2029")}t.safeStringify=f;function S(y){return typeof y=="string"&&t.IDENTIFIER.test(y)?new r(`.${y}`):s`[${y}]`}t.getProperty=S;function b(y){if(typeof y=="string"&&t.IDENTIFIER.test(y))return new r(`${y}`);throw new Error(`CodeGen: invalid export name: ${y}, use explicit $id name mapping`)}t.getEsmExportName=b;function F(y){return new r(y.toString())}t.regexpCode=F})(Os);var ga={};(function(t){Object.defineProperty(t,"__esModule",{value:!0}),t.ValueScope=t.ValueScopeName=t.Scope=t.varKinds=t.UsedValueState=void 0;const e=Os;class n extends Error{constructor(c){super(`CodeGen: "code" for ${c} not defined`),this.value=c.value}}var r;(function(u){u[u.Started=0]="Started",u[u.Completed=1]="Completed"})(r||(t.UsedValueState=r={})),t.varKinds={const:new e.Name("const"),let:new e.Name("let"),var:new e.Name("var")};class s{constructor({prefixes:c,parent:l}={}){this._names={},this._prefixes=c,this._parent=l}toName(c){return c instanceof e.Name?c:this.name(c)}name(c){return new e.Name(this._newName(c))}_newName(c){const l=this._names[c]||this._nameGroup(c);return`${c}${l.index++}`}_nameGroup(c){var l,p;if(!((p=(l=this._parent)===null||l===void 0?void 0:l._prefixes)===null||p===void 0)&&p.has(c)||this._prefixes&&!this._prefixes.has(c))throw new Error(`CodeGen: prefix "${c}" is not allowed in this scope`);return this._names[c]={prefix:c,index:0}}}t.Scope=s;class o extends e.Name{constructor(c,l){super(l),this.prefix=c}setValue(c,{property:l,itemIndex:p}){this.value=c,this.scopePath=(0,e._)`.${new e.Name(l)}[${p}]`}}t.ValueScopeName=o;const i=(0,e._)`\n`;class a extends s{constructor(c){super(c),this._values={},this._scope=c.scope,this.opts={...c,_n:c.lines?i:e.nil}}get(){return this._scope}name(c){return new o(c,this._newName(c))}value(c,l){var p;if(l.ref===void 0)throw new Error("CodeGen: ref must be passed in value");const d=this.toName(c),{prefix:f}=d,S=(p=l.key)!==null&&p!==void 0?p:l.ref;let b=this._values[f];if(b){const T=b.get(S);if(T)return T}else b=this._values[f]=new Map;b.set(S,d);const F=this._scope[f]||(this._scope[f]=[]),y=F.length;return F[y]=l.ref,d.setValue(l,{property:f,itemIndex:y}),d}getValue(c,l){const p=this._values[c];if(p)return p.get(l)}scopeRefs(c,l=this._values){return this._reduceValues(l,p=>{if(p.scopePath===void 0)throw new Error(`CodeGen: name "${p}" has no value`);return(0,e._)`${c}${p.scopePath}`})}scopeCode(c=this._values,l,p){return this._reduceValues(c,d=>{if(d.value===void 0)throw new Error(`CodeGen: name "${d}" has no value`);return d.value.code},l,p)}_reduceValues(c,l,p={},d){let f=e.nil;for(const S in c){const b=c[S];if(!b)continue;const F=p[S]=p[S]||new Map;b.forEach(y=>{if(F.has(y))return;F.set(y,r.Started);let T=l(y);if(T){const O=this.opts.es5?t.varKinds.var:t.varKinds.const;f=(0,e._)`${f}${O} ${y} = ${T};${this.opts._n}`}else if(T=d==null?void 0:d(y))f=(0,e._)`${f}${T}${this.opts._n}`;else throw new n(y);F.set(y,r.Completed)})}return f}}t.ValueScope=a})(ga);(function(t){Object.defineProperty(t,"__esModule",{value:!0}),t.or=t.and=t.not=t.CodeGen=t.operators=t.varKinds=t.ValueScopeName=t.ValueScope=t.Scope=t.Name=t.regexpCode=t.stringify=t.getProperty=t.nil=t.strConcat=t.str=t._=void 0;const e=Os,n=ga;var r=Os;Object.defineProperty(t,"_",{enumerable:!0,get:function(){return r._}}),Object.defineProperty(t,"str",{enumerable:!0,get:function(){return r.str}}),Object.defineProperty(t,"strConcat",{enumerable:!0,get:function(){return r.strConcat}}),Object.defineProperty(t,"nil",{enumerable:!0,get:function(){return r.nil}}),Object.defineProperty(t,"getProperty",{enumerable:!0,get:function(){return r.getProperty}}),Object.defineProperty(t,"stringify",{enumerable:!0,get:function(){return r.stringify}}),Object.defineProperty(t,"regexpCode",{enumerable:!0,get:function(){return r.regexpCode}}),Object.defineProperty(t,"Name",{enumerable:!0,get:function(){return r.Name}});var s=ga;Object.defineProperty(t,"Scope",{enumerable:!0,get:function(){return s.Scope}}),Object.defineProperty(t,"ValueScope",{enumerable:!0,get:function(){return s.ValueScope}}),Object.defineProperty(t,"ValueScopeName",{enumerable:!0,get:function(){return s.ValueScopeName}}),Object.defineProperty(t,"varKinds",{enumerable:!0,get:function(){return s.varKinds}}),t.operators={GT:new e._Code(">"),GTE:new e._Code(">="),LT:new e._Code("<"),LTE:new e._Code("<="),EQ:new e._Code("==="),NEQ:new e._Code("!=="),NOT:new e._Code("!"),OR:new e._Code("||"),AND:new e._Code("&&"),ADD:new e._Code("+")};class o{optimizeNodes(){return this}optimizeNames(m,A){return this}}class i extends o{constructor(m,A,$){super(),this.varKind=m,this.name=A,this.rhs=$}render({es5:m,_n:A}){const $=m?n.varKinds.var:this.varKind,g=this.rhs===void 0?"":` = ${this.rhs}`;return`${$} ${this.name}${g};`+A}optimizeNames(m,A){if(m[this.name.str])return this.rhs&&(this.rhs=Te(this.rhs,m,A)),this}get names(){return this.rhs instanceof e._CodeOrName?this.rhs.names:{}}}class a extends o{constructor(m,A,$){super(),this.lhs=m,this.rhs=A,this.sideEffects=$}render({_n:m}){return`${this.lhs} = ${this.rhs};`+m}optimizeNames(m,A){if(!(this.lhs instanceof e.Name&&!m[this.lhs.str]&&!this.sideEffects))return this.rhs=Te(this.rhs,m,A),this}get names(){const m=this.lhs instanceof e.Name?{}:{...this.lhs.names};return he(m,this.rhs)}}class u extends a{constructor(m,A,$,g){super(m,$,g),this.op=A}render({_n:m}){return`${this.lhs} ${this.op}= ${this.rhs};`+m}}class c extends o{constructor(m){super(),this.label=m,this.names={}}render({_n:m}){return`${this.label}:`+m}}class l extends o{constructor(m){super(),this.label=m,this.names={}}render({_n:m}){return`break${this.label?` ${this.label}`:""};`+m}}class p extends o{constructor(m){super(),this.error=m}render({_n:m}){return`throw ${this.error};`+m}get names(){return this.error.names}}class d extends o{constructor(m){super(),this.code=m}render({_n:m}){return`${this.code};`+m}optimizeNodes(){return`${this.code}`?this:void 0}optimizeNames(m,A){return this.code=Te(this.code,m,A),this}get names(){return this.code instanceof e._CodeOrName?this.code.names:{}}}class f extends o{constructor(m=[]){super(),this.nodes=m}render(m){return this.nodes.reduce((A,$)=>A+$.render(m),"")}optimizeNodes(){const{nodes:m}=this;let A=m.length;for(;A--;){const $=m[A].optimizeNodes();Array.isArray($)?m.splice(A,1,...$):$?m[A]=$:m.splice(A,1)}return m.length>0?this:void 0}optimizeNames(m,A){const{nodes:$}=this;let g=$.length;for(;g--;){const E=$[g];E.optimizeNames(m,A)||(Ge(m,E.names),$.splice(g,1))}return $.length>0?this:void 0}get names(){return this.nodes.reduce((m,A)=>re(m,A.names),{})}}class S extends f{render(m){return"{"+m._n+super.render(m)+"}"+m._n}}class b extends f{}class F extends S{}F.kind="else";class y extends S{constructor(m,A){super(A),this.condition=m}render(m){let A=`if(${this.condition})`+super.render(m);return this.else&&(A+="else "+this.else.render(m)),A}optimizeNodes(){super.optimizeNodes();const m=this.condition;if(m===!0)return this.nodes;let A=this.else;if(A){const $=A.optimizeNodes();A=this.else=Array.isArray($)?new F($):$}if(A)return m===!1?A instanceof y?A:A.nodes:this.nodes.length?this:new y(qe(m),A instanceof y?[A]:A.nodes);if(!(m===!1||!this.nodes.length))return this}optimizeNames(m,A){var $;if(this.else=($=this.else)===null||$===void 0?void 0:$.optimizeNames(m,A),!!(super.optimizeNames(m,A)||this.else))return this.condition=Te(this.condition,m,A),this}get names(){const m=super.names;return he(m,this.condition),this.else&&re(m,this.else.names),m}}y.kind="if";class T extends S{}T.kind="for";class O extends T{constructor(m){super(),this.iteration=m}render(m){return`for(${this.iteration})`+super.render(m)}optimizeNames(m,A){if(super.optimizeNames(m,A))return this.iteration=Te(this.iteration,m,A),this}get names(){return re(super.names,this.iteration.names)}}class j extends T{constructor(m,A,$,g){super(),this.varKind=m,this.name=A,this.from=$,this.to=g}render(m){const A=m.es5?n.varKinds.var:this.varKind,{name:$,from:g,to:E}=this;return`for(${A} ${$}=${g}; ${$}<${E}; ${$}++)`+super.render(m)}get names(){const m=he(super.names,this.from);return he(m,this.to)}}class M extends T{constructor(m,A,$,g){super(),this.loop=m,this.varKind=A,this.name=$,this.iterable=g}render(m){return`for(${this.varKind} ${this.name} ${this.loop} ${this.iterable})`+super.render(m)}optimizeNames(m,A){if(super.optimizeNames(m,A))return this.iterable=Te(this.iterable,m,A),this}get names(){return re(super.names,this.iterable.names)}}class ee extends S{constructor(m,A,$){super(),this.name=m,this.args=A,this.async=$}render(m){return`${this.async?"async ":""}function ${this.name}(${this.args})`+super.render(m)}}ee.kind="func";class ne extends f{render(m){return"return "+super.render(m)}}ne.kind="return";class Ne extends S{render(m){let A="try"+super.render(m);return this.catch&&(A+=this.catch.render(m)),this.finally&&(A+=this.finally.render(m)),A}optimizeNodes(){var m,A;return super.optimizeNodes(),(m=this.catch)===null||m===void 0||m.optimizeNodes(),(A=this.finally)===null||A===void 0||A.optimizeNodes(),this}optimizeNames(m,A){var $,g;return super.optimizeNames(m,A),($=this.catch)===null||$===void 0||$.optimizeNames(m,A),(g=this.finally)===null||g===void 0||g.optimizeNames(m,A),this}get names(){const m=super.names;return this.catch&&re(m,this.catch.names),this.finally&&re(m,this.finally.names),m}}class L extends S{constructor(m){super(),this.error=m}render(m){return`catch(${this.error})`+super.render(m)}}L.kind="catch";class pe extends S{render(m){return"finally"+super.render(m)}}pe.kind="finally";class de{constructor(m,A={}){this._values={},this._blockStarts=[],this._constants={},this.opts={...A,_n:A.lines?`
`:""},this._extScope=m,this._scope=new n.Scope({parent:m}),this._nodes=[new b]}toString(){return this._root.render(this.opts)}name(m){return this._scope.name(m)}scopeName(m){return this._extScope.name(m)}scopeValue(m,A){const $=this._extScope.value(m,A);return(this._values[$.prefix]||(this._values[$.prefix]=new Set)).add($),$}getScopeValue(m,A){return this._extScope.getValue(m,A)}scopeRefs(m){return this._extScope.scopeRefs(m,this._values)}scopeCode(){return this._extScope.scopeCode(this._values)}_def(m,A,$,g){const E=this._scope.toName(A);return $!==void 0&&g&&(this._constants[E.str]=$),this._leafNode(new i(m,E,$)),E}const(m,A,$){return this._def(n.varKinds.const,m,A,$)}let(m,A,$){return this._def(n.varKinds.let,m,A,$)}var(m,A,$){return this._def(n.varKinds.var,m,A,$)}assign(m,A,$){return this._leafNode(new a(m,A,$))}add(m,A){return this._leafNode(new u(m,t.operators.ADD,A))}code(m){return typeof m=="function"?m():m!==e.nil&&this._leafNode(new d(m)),this}object(...m){const A=["{"];for(const[$,g]of m)A.length>1&&A.push(","),A.push($),($!==g||this.opts.es5)&&(A.push(":"),(0,e.addCodeArg)(A,g));return A.push("}"),new e._Code(A)}if(m,A,$){if(this._blockNode(new y(m)),A&&$)this.code(A).else().code($).endIf();else if(A)this.code(A).endIf();else if($)throw new Error('CodeGen: "else" body without "then" body');return this}elseIf(m){return this._elseNode(new y(m))}else(){return this._elseNode(new F)}endIf(){return this._endBlockNode(y,F)}_for(m,A){return this._blockNode(m),A&&this.code(A).endFor(),this}for(m,A){return this._for(new O(m),A)}forRange(m,A,$,g,E=this.opts.es5?n.varKinds.var:n.varKinds.let){const N=this._scope.toName(m);return this._for(new j(E,N,A,$),()=>g(N))}forOf(m,A,$,g=n.varKinds.const){const E=this._scope.toName(m);if(this.opts.es5){const N=A instanceof e.Name?A:this.var("_arr",A);return this.forRange("_i",0,(0,e._)`${N}.length`,k=>{this.var(E,(0,e._)`${N}[${k}]`),$(E)})}return this._for(new M("of",g,E,A),()=>$(E))}forIn(m,A,$,g=this.opts.es5?n.varKinds.var:n.varKinds.const){if(this.opts.ownProperties)return this.forOf(m,(0,e._)`Object.keys(${A})`,$);const E=this._scope.toName(m);return this._for(new M("in",g,E,A),()=>$(E))}endFor(){return this._endBlockNode(T)}label(m){return this._leafNode(new c(m))}break(m){return this._leafNode(new l(m))}return(m){const A=new ne;if(this._blockNode(A),this.code(m),A.nodes.length!==1)throw new Error('CodeGen: "return" should have one node');return this._endBlockNode(ne)}try(m,A,$){if(!A&&!$)throw new Error('CodeGen: "try" without "catch" and "finally"');const g=new Ne;if(this._blockNode(g),this.code(m),A){const E=this.name("e");this._currNode=g.catch=new L(E),A(E)}return $&&(this._currNode=g.finally=new pe,this.code($)),this._endBlockNode(L,pe)}throw(m){return this._leafNode(new p(m))}block(m,A){return this._blockStarts.push(this._nodes.length),m&&this.code(m).endBlock(A),this}endBlock(m){const A=this._blockStarts.pop();if(A===void 0)throw new Error("CodeGen: not in self-balancing block");const $=this._nodes.length-A;if($<0||m!==void 0&&$!==m)throw new Error(`CodeGen: wrong number of nodes: ${$} vs ${m} expected`);return this._nodes.length=A,this}func(m,A=e.nil,$,g){return this._blockNode(new ee(m,A,$)),g&&this.code(g).endFunc(),this}endFunc(){return this._endBlockNode(ee)}optimize(m=1){for(;m-- >0;)this._root.optimizeNodes(),this._root.optimizeNames(this._root.names,this._constants)}_leafNode(m){return this._currNode.nodes.push(m),this}_blockNode(m){this._currNode.nodes.push(m),this._nodes.push(m)}_endBlockNode(m,A){const $=this._currNode;if($ instanceof m||A&&$ instanceof A)return this._nodes.pop(),this;throw new Error(`CodeGen: not in block "${A?`${m.kind}/${A.kind}`:m.kind}"`)}_elseNode(m){const A=this._currNode;if(!(A instanceof y))throw new Error('CodeGen: "else" without "if"');return this._currNode=A.else=m,this}get _root(){return this._nodes[0]}get _currNode(){const m=this._nodes;return m[m.length-1]}set _currNode(m){const A=this._nodes;A[A.length-1]=m}}t.CodeGen=de;function re(C,m){for(const A in m)C[A]=(C[A]||0)+(m[A]||0);return C}function he(C,m){return m instanceof e._CodeOrName?re(C,m.names):C}function Te(C,m,A){if(C instanceof e.Name)return $(C);if(!g(C))return C;return new e._Code(C._items.reduce((E,N)=>(N instanceof e.Name&&(N=$(N)),N instanceof e._Code?E.push(...N._items):E.push(N),E),[]));function $(E){const N=A[E.str];return N===void 0||m[E.str]!==1?E:(delete m[E.str],N)}function g(E){return E instanceof e._Code&&E._items.some(N=>N instanceof e.Name&&m[N.str]===1&&A[N.str]!==void 0)}}function Ge(C,m){for(const A in m)C[A]=(C[A]||0)-(m[A]||0)}function qe(C){return typeof C=="boolean"||typeof C=="number"||C===null?!C:(0,e._)`!${v(C)}`}t.not=qe;const ce=x(t.operators.AND);function Ze(...C){return C.reduce(ce)}t.and=Ze;const ke=x(t.operators.OR);function Z(...C){return C.reduce(ke)}t.or=Z;function x(C){return(m,A)=>m===e.nil?A:A===e.nil?m:(0,e._)`${v(m)} ${C} ${v(A)}`}function v(C){return C instanceof e.Name?C:(0,e._)`(${C})`}})(Ie);var se={};Object.defineProperty(se,"__esModule",{value:!0});se.checkStrictMode=se.getErrorPath=se.Type=se.useFunc=se.setEvaluated=se.evaluatedPropsToName=se.mergeEvaluated=se.eachItem=se.unescapeJsonPointer=se.escapeJsonPointer=se.escapeFragment=se.unescapeFragment=se.schemaRefOrVal=se.schemaHasRulesButRef=se.schemaHasRules=se.checkUnknownRules=se.alwaysValidSchema=se.toHash=void 0;const Ke=Ie,DE=Os;function SE(t){const e={};for(const n of t)e[n]=!0;return e}se.toHash=SE;function EE(t,e){return typeof e=="boolean"?e:Object.keys(e).length===0?!0:(ud(t,e),!cd(e,t.self.RULES.all))}se.alwaysValidSchema=EE;function ud(t,e=t.schema){const{opts:n,self:r}=t;if(!n.strictSchema||typeof e=="boolean")return;const s=r.RULES.keywords;for(const o in e)s[o]||dd(t,`unknown keyword: "${o}"`)}se.checkUnknownRules=ud;function cd(t,e){if(typeof t=="boolean")return!t;for(const n in t)if(e[n])return!0;return!1}se.schemaHasRules=cd;function yE(t,e){if(typeof t=="boolean")return!t;for(const n in t)if(n!=="$ref"&&e.all[n])return!0;return!1}se.schemaHasRulesButRef=yE;function gE({topSchemaRef:t,schemaPath:e},n,r,s){if(!s){if(typeof n=="number"||typeof n=="boolean")return n;if(typeof n=="string")return(0,Ke._)`${n}`}return(0,Ke._)`${t}${e}${(0,Ke.getProperty)(r)}`}se.schemaRefOrVal=gE;function vE(t){return ld(decodeURIComponent(t))}se.unescapeFragment=vE;function AE(t){return encodeURIComponent(mu(t))}se.escapeFragment=AE;function mu(t){return typeof t=="number"?`${t}`:t.replace(/~/g,"~0").replace(/\//g,"~1")}se.escapeJsonPointer=mu;function ld(t){return t.replace(/~1/g,"/").replace(/~0/g,"~")}se.unescapeJsonPointer=ld;function bE(t,e){if(Array.isArray(t))for(const n of t)e(n);else e(t)}se.eachItem=bE;function tl({mergeNames:t,mergeToName:e,mergeValues:n,resultToName:r}){return(s,o,i,a)=>{const u=i===void 0?o:i instanceof Ke.Name?(o instanceof Ke.Name?t(s,o,i):e(s,o,i),i):o instanceof Ke.Name?(e(s,i,o),o):n(o,i);return a===Ke.Name&&!(u instanceof Ke.Name)?r(s,u):u}}se.mergeEvaluated={props:tl({mergeNames:(t,e,n)=>t.if((0,Ke._)`${n} !== true && ${e} !== undefined`,()=>{t.if((0,Ke._)`${e} === true`,()=>t.assign(n,!0),()=>t.assign(n,(0,Ke._)`${n} || {}`).code((0,Ke._)`Object.assign(${n}, ${e})`))}),mergeToName:(t,e,n)=>t.if((0,Ke._)`${n} !== true`,()=>{e===!0?t.assign(n,!0):(t.assign(n,(0,Ke._)`${n} || {}`),Du(t,n,e))}),mergeValues:(t,e)=>t===!0?!0:{...t,...e},resultToName:pd}),items:tl({mergeNames:(t,e,n)=>t.if((0,Ke._)`${n} !== true && ${e} !== undefined`,()=>t.assign(n,(0,Ke._)`${e} === true ? true : ${n} > ${e} ? ${n} : ${e}`)),mergeToName:(t,e,n)=>t.if((0,Ke._)`${n} !== true`,()=>t.assign(n,e===!0?!0:(0,Ke._)`${n} > ${e} ? ${n} : ${e}`)),mergeValues:(t,e)=>t===!0?!0:Math.max(t,e),resultToName:(t,e)=>t.var("items",e)})};function pd(t,e){if(e===!0)return t.var("props",!0);const n=t.var("props",(0,Ke._)`{}`);return e!==void 0&&Du(t,n,e),n}se.evaluatedPropsToName=pd;function Du(t,e,n){Object.keys(n).forEach(r=>t.assign((0,Ke._)`${e}${(0,Ke.getProperty)(r)}`,!0))}se.setEvaluated=Du;const nl={};function CE(t,e){return t.scopeValue("func",{ref:e,code:nl[e.code]||(nl[e.code]=new DE._Code(e.code))})}se.useFunc=CE;var va;(function(t){t[t.Num=0]="Num",t[t.Str=1]="Str"})(va||(se.Type=va={}));function TE(t,e,n){if(t instanceof Ke.Name){const r=e===va.Num;return n?r?(0,Ke._)`"[" + ${t} + "]"`:(0,Ke._)`"['" + ${t} + "']"`:r?(0,Ke._)`"/" + ${t}`:(0,Ke._)`"/" + ${t}.replace(/~/g, "~0").replace(/\\//g, "~1")`}return n?(0,Ke.getProperty)(t).toString():"/"+mu(t)}se.getErrorPath=TE;function dd(t,e,n=t.opts.strictSchema){if(n){if(e=`strict mode: ${e}`,n===!0)throw new Error(e);t.self.logger.warn(e)}}se.checkStrictMode=dd;var bn={};Object.defineProperty(bn,"__esModule",{value:!0});const kt=Ie,wE={data:new kt.Name("data"),valCxt:new kt.Name("valCxt"),instancePath:new kt.Name("instancePath"),parentData:new kt.Name("parentData"),parentDataProperty:new kt.Name("parentDataProperty"),rootData:new kt.Name("rootData"),dynamicAnchors:new kt.Name("dynamicAnchors"),vErrors:new kt.Name("vErrors"),errors:new kt.Name("errors"),this:new kt.Name("this"),self:new kt.Name("self"),scope:new kt.Name("scope"),json:new kt.Name("json"),jsonPos:new kt.Name("jsonPos"),jsonLen:new kt.Name("jsonLen"),jsonPart:new kt.Name("jsonPart")};bn.default=wE;(function(t){Object.defineProperty(t,"__esModule",{value:!0}),t.extendErrors=t.resetErrorsCount=t.reportExtraError=t.reportError=t.keyword$DataError=t.keywordError=void 0;const e=Ie,n=se,r=bn;t.keywordError={message:({keyword:F})=>(0,e.str)`must pass "${F}" keyword validation`},t.keyword$DataError={message:({keyword:F,schemaType:y})=>y?(0,e.str)`"${F}" keyword must be ${y} ($data)`:(0,e.str)`"${F}" keyword is invalid ($data)`};function s(F,y=t.keywordError,T,O){const{it:j}=F,{gen:M,compositeRule:ee,allErrors:ne}=j,Ne=p(F,y,T);O??(ee||ne)?u(M,Ne):c(j,(0,e._)`[${Ne}]`)}t.reportError=s;function o(F,y=t.keywordError,T){const{it:O}=F,{gen:j,compositeRule:M,allErrors:ee}=O,ne=p(F,y,T);u(j,ne),M||ee||c(O,r.default.vErrors)}t.reportExtraError=o;function i(F,y){F.assign(r.default.errors,y),F.if((0,e._)`${r.default.vErrors} !== null`,()=>F.if(y,()=>F.assign((0,e._)`${r.default.vErrors}.length`,y),()=>F.assign(r.default.vErrors,null)))}t.resetErrorsCount=i;function a({gen:F,keyword:y,schemaValue:T,data:O,errsCount:j,it:M}){if(j===void 0)throw new Error("ajv implementation error");const ee=F.name("err");F.forRange("i",j,r.default.errors,ne=>{F.const(ee,(0,e._)`${r.default.vErrors}[${ne}]`),F.if((0,e._)`${ee}.instancePath === undefined`,()=>F.assign((0,e._)`${ee}.instancePath`,(0,e.strConcat)(r.default.instancePath,M.errorPath))),F.assign((0,e._)`${ee}.schemaPath`,(0,e.str)`${M.errSchemaPath}/${y}`),M.opts.verbose&&(F.assign((0,e._)`${ee}.schema`,T),F.assign((0,e._)`${ee}.data`,O))})}t.extendErrors=a;function u(F,y){const T=F.const("err",y);F.if((0,e._)`${r.default.vErrors} === null`,()=>F.assign(r.default.vErrors,(0,e._)`[${T}]`),(0,e._)`${r.default.vErrors}.push(${T})`),F.code((0,e._)`${r.default.errors}++`)}function c(F,y){const{gen:T,validateName:O,schemaEnv:j}=F;j.$async?T.throw((0,e._)`new ${F.ValidationError}(${y})`):(T.assign((0,e._)`${O}.errors`,y),T.return(!1))}const l={keyword:new e.Name("keyword"),schemaPath:new e.Name("schemaPath"),params:new e.Name("params"),propertyName:new e.Name("propertyName"),message:new e.Name("message"),schema:new e.Name("schema"),parentSchema:new e.Name("parentSchema")};function p(F,y,T){const{createErrors:O}=F.it;return O===!1?(0,e._)`{}`:d(F,y,T)}function d(F,y,T={}){const{gen:O,it:j}=F,M=[f(j,T),S(F,T)];return b(F,y,M),O.object(...M)}function f({errorPath:F},{instancePath:y}){const T=y?(0,e.str)`${F}${(0,n.getErrorPath)(y,n.Type.Str)}`:F;return[r.default.instancePath,(0,e.strConcat)(r.default.instancePath,T)]}function S({keyword:F,it:{errSchemaPath:y}},{schemaPath:T,parentSchema:O}){let j=O?y:(0,e.str)`${y}/${F}`;return T&&(j=(0,e.str)`${j}${(0,n.getErrorPath)(T,n.Type.Str)}`),[l.schemaPath,j]}function b(F,{params:y,message:T},O){const{keyword:j,data:M,schemaValue:ee,it:ne}=F,{opts:Ne,propertyName:L,topSchemaRef:pe,schemaPath:de}=ne;O.push([l.keyword,j],[l.params,typeof y=="function"?y(F):y||(0,e._)`{}`]),Ne.messages&&O.push([l.message,typeof T=="function"?T(F):T]),Ne.verbose&&O.push([l.schema,ee],[l.parentSchema,(0,e._)`${pe}${de}`],[r.default.data,M]),L&&O.push([l.propertyName,L])}})(Gs);Object.defineProperty(Yr,"__esModule",{value:!0});Yr.boolOrEmptySchema=Yr.topBoolOrEmptySchema=void 0;const FE=Gs,IE=Ie,kE=bn,PE={message:"boolean schema is false"};function NE(t){const{gen:e,schema:n,validateName:r}=t;n===!1?fd(t,!1):typeof n=="object"&&n.$async===!0?e.return(kE.default.data):(e.assign((0,IE._)`${r}.errors`,null),e.return(!0))}Yr.topBoolOrEmptySchema=NE;function _E(t,e){const{gen:n,schema:r}=t;r===!1?(n.var(e,!1),fd(t)):n.var(e,!0)}Yr.boolOrEmptySchema=_E;function fd(t,e){const{gen:n,data:r}=t,s={gen:n,keyword:"false schema",data:r,schema:!1,schemaCode:!1,schemaValue:!1,params:{},it:t};(0,FE.reportError)(s,PE,void 0,e)}var yt={},Er={};Object.defineProperty(Er,"__esModule",{value:!0});Er.getRules=Er.isJSONType=void 0;const OE=["string","number","integer","boolean","null","object","array"],$E=new Set(OE);function BE(t){return typeof t=="string"&&$E.has(t)}Er.isJSONType=BE;function RE(){const t={number:{type:"number",rules:[]},string:{type:"string",rules:[]},array:{type:"array",rules:[]},object:{type:"object",rules:[]}};return{types:{...t,integer:!0,boolean:!0,null:!0},rules:[{rules:[]},t.number,t.string,t.array,t.object],post:{rules:[]},all:{},keywords:{}}}Er.getRules=RE;var kn={};Object.defineProperty(kn,"__esModule",{value:!0});kn.shouldUseRule=kn.shouldUseGroup=kn.schemaHasRulesForType=void 0;function xE({schema:t,self:e},n){const r=e.RULES.types[n];return r&&r!==!0&&hd(t,r)}kn.schemaHasRulesForType=xE;function hd(t,e){return e.rules.some(n=>md(t,n))}kn.shouldUseGroup=hd;function md(t,e){var n;return t[e.keyword]!==void 0||((n=e.definition.implements)===null||n===void 0?void 0:n.some(r=>t[r]!==void 0))}kn.shouldUseRule=md;Object.defineProperty(yt,"__esModule",{value:!0});yt.reportTypeError=yt.checkDataTypes=yt.checkDataType=yt.coerceAndCheckDataType=yt.getJSONTypes=yt.getSchemaTypes=yt.DataType=void 0;const qE=Er,ME=kn,LE=Gs,ve=Ie,Dd=se;var Wr;(function(t){t[t.Correct=0]="Correct",t[t.Wrong=1]="Wrong"})(Wr||(yt.DataType=Wr={}));function jE(t){const e=Sd(t.type);if(e.includes("null")){if(t.nullable===!1)throw new Error("type: null contradicts nullable: false")}else{if(!e.length&&t.nullable!==void 0)throw new Error('"nullable" cannot be used without "type"');t.nullable===!0&&e.push("null")}return e}yt.getSchemaTypes=jE;function Sd(t){const e=Array.isArray(t)?t:t?[t]:[];if(e.every(qE.isJSONType))return e;throw new Error("type must be JSONType or JSONType[]: "+e.join(","))}yt.getJSONTypes=Sd;function GE(t,e){const{gen:n,data:r,opts:s}=t,o=UE(e,s.coerceTypes),i=e.length>0&&!(o.length===0&&e.length===1&&(0,ME.schemaHasRulesForType)(t,e[0]));if(i){const a=Su(e,r,s.strictNumbers,Wr.Wrong);n.if(a,()=>{o.length?VE(t,e,o):Eu(t)})}return i}yt.coerceAndCheckDataType=GE;const Ed=new Set(["string","number","integer","boolean","null"]);function UE(t,e){return e?t.filter(n=>Ed.has(n)||e==="array"&&n==="array"):[]}function VE(t,e,n){const{gen:r,data:s,opts:o}=t,i=r.let("dataType",(0,ve._)`typeof ${s}`),a=r.let("coerced",(0,ve._)`undefined`);o.coerceTypes==="array"&&r.if((0,ve._)`${i} == 'object' && Array.isArray(${s}) && ${s}.length == 1`,()=>r.assign(s,(0,ve._)`${s}[0]`).assign(i,(0,ve._)`typeof ${s}`).if(Su(e,s,o.strictNumbers),()=>r.assign(a,s))),r.if((0,ve._)`${a} !== undefined`);for(const c of n)(Ed.has(c)||c==="array"&&o.coerceTypes==="array")&&u(c);r.else(),Eu(t),r.endIf(),r.if((0,ve._)`${a} !== undefined`,()=>{r.assign(s,a),JE(t,a)});function u(c){switch(c){case"string":r.elseIf((0,ve._)`${i} == "number" || ${i} == "boolean"`).assign(a,(0,ve._)`"" + ${s}`).elseIf((0,ve._)`${s} === null`).assign(a,(0,ve._)`""`);return;case"number":r.elseIf((0,ve._)`${i} == "boolean" || ${s} === null
              || (${i} == "string" && ${s} && ${s} == +${s})`).assign(a,(0,ve._)`+${s}`);return;case"integer":r.elseIf((0,ve._)`${i} === "boolean" || ${s} === null
              || (${i} === "string" && ${s} && ${s} == +${s} && !(${s} % 1))`).assign(a,(0,ve._)`+${s}`);return;case"boolean":r.elseIf((0,ve._)`${s} === "false" || ${s} === 0 || ${s} === null`).assign(a,!1).elseIf((0,ve._)`${s} === "true" || ${s} === 1`).assign(a,!0);return;case"null":r.elseIf((0,ve._)`${s} === "" || ${s} === 0 || ${s} === false`),r.assign(a,null);return;case"array":r.elseIf((0,ve._)`${i} === "string" || ${i} === "number"
              || ${i} === "boolean" || ${s} === null`).assign(a,(0,ve._)`[${s}]`)}}}function JE({gen:t,parentData:e,parentDataProperty:n},r){t.if((0,ve._)`${e} !== undefined`,()=>t.assign((0,ve._)`${e}[${n}]`,r))}function Aa(t,e,n,r=Wr.Correct){const s=r===Wr.Correct?ve.operators.EQ:ve.operators.NEQ;let o;switch(t){case"null":return(0,ve._)`${e} ${s} null`;case"array":o=(0,ve._)`Array.isArray(${e})`;break;case"object":o=(0,ve._)`${e} && typeof ${e} == "object" && !Array.isArray(${e})`;break;case"integer":o=i((0,ve._)`!(${e} % 1) && !isNaN(${e})`);break;case"number":o=i();break;default:return(0,ve._)`typeof ${e} ${s} ${t}`}return r===Wr.Correct?o:(0,ve.not)(o);function i(a=ve.nil){return(0,ve.and)((0,ve._)`typeof ${e} == "number"`,a,n?(0,ve._)`isFinite(${e})`:ve.nil)}}yt.checkDataType=Aa;function Su(t,e,n,r){if(t.length===1)return Aa(t[0],e,n,r);let s;const o=(0,Dd.toHash)(t);if(o.array&&o.object){const i=(0,ve._)`typeof ${e} != "object"`;s=o.null?i:(0,ve._)`!${e} || ${i}`,delete o.null,delete o.array,delete o.object}else s=ve.nil;o.number&&delete o.integer;for(const i in o)s=(0,ve.and)(s,Aa(i,e,n,r));return s}yt.checkDataTypes=Su;const HE={message:({schema:t})=>`must be ${t}`,params:({schema:t,schemaValue:e})=>typeof t=="string"?(0,ve._)`{type: ${t}}`:(0,ve._)`{type: ${e}}`};function Eu(t){const e=WE(t);(0,LE.reportError)(e,HE)}yt.reportTypeError=Eu;function WE(t){const{gen:e,data:n,schema:r}=t,s=(0,Dd.schemaRefOrVal)(t,r,"type");return{gen:e,keyword:"type",data:n,schema:r.type,schemaCode:s,schemaValue:s,parentSchema:r,params:{},it:t}}var li={};Object.defineProperty(li,"__esModule",{value:!0});li.assignDefaults=void 0;const Ir=Ie,KE=se;function XE(t,e){const{properties:n,items:r}=t.schema;if(e==="object"&&n)for(const s in n)rl(t,s,n[s].default);else e==="array"&&Array.isArray(r)&&r.forEach((s,o)=>rl(t,o,s.default))}li.assignDefaults=XE;function rl(t,e,n){const{gen:r,compositeRule:s,data:o,opts:i}=t;if(n===void 0)return;const a=(0,Ir._)`${o}${(0,Ir.getProperty)(e)}`;if(s){(0,KE.checkStrictMode)(t,`default is ignored for: ${a}`);return}let u=(0,Ir._)`${a} === undefined`;i.useDefaults==="empty"&&(u=(0,Ir._)`${u} || ${a} === null || ${a} === ""`),r.if(u,(0,Ir._)`${a} = ${(0,Ir.stringify)(n)}`)}var yn={},we={};Object.defineProperty(we,"__esModule",{value:!0});we.validateUnion=we.validateArray=we.usePattern=we.callValidateCode=we.schemaProperties=we.allSchemaProperties=we.noPropertyInData=we.propertyInData=we.isOwnProperty=we.hasPropFunc=we.reportMissingProp=we.checkMissingProp=we.checkReportMissingProp=void 0;const et=Ie,yu=se,xn=bn,zE=se;function YE(t,e){const{gen:n,data:r,it:s}=t;n.if(vu(n,r,e,s.opts.ownProperties),()=>{t.setParams({missingProperty:(0,et._)`${e}`},!0),t.error()})}we.checkReportMissingProp=YE;function ZE({gen:t,data:e,it:{opts:n}},r,s){return(0,et.or)(...r.map(o=>(0,et.and)(vu(t,e,o,n.ownProperties),(0,et._)`${s} = ${o}`)))}we.checkMissingProp=ZE;function QE(t,e){t.setParams({missingProperty:e},!0),t.error()}we.reportMissingProp=QE;function yd(t){return t.scopeValue("func",{ref:Object.prototype.hasOwnProperty,code:(0,et._)`Object.prototype.hasOwnProperty`})}we.hasPropFunc=yd;function gu(t,e,n){return(0,et._)`${yd(t)}.call(${e}, ${n})`}we.isOwnProperty=gu;function ey(t,e,n,r){const s=(0,et._)`${e}${(0,et.getProperty)(n)} !== undefined`;return r?(0,et._)`${s} && ${gu(t,e,n)}`:s}we.propertyInData=ey;function vu(t,e,n,r){const s=(0,et._)`${e}${(0,et.getProperty)(n)} === undefined`;return r?(0,et.or)(s,(0,et.not)(gu(t,e,n))):s}we.noPropertyInData=vu;function gd(t){return t?Object.keys(t).filter(e=>e!=="__proto__"):[]}we.allSchemaProperties=gd;function ty(t,e){return gd(e).filter(n=>!(0,yu.alwaysValidSchema)(t,e[n]))}we.schemaProperties=ty;function ny({schemaCode:t,data:e,it:{gen:n,topSchemaRef:r,schemaPath:s,errorPath:o},it:i},a,u,c){const l=c?(0,et._)`${t}, ${e}, ${r}${s}`:e,p=[[xn.default.instancePath,(0,et.strConcat)(xn.default.instancePath,o)],[xn.default.parentData,i.parentData],[xn.default.parentDataProperty,i.parentDataProperty],[xn.default.rootData,xn.default.rootData]];i.opts.dynamicRef&&p.push([xn.default.dynamicAnchors,xn.default.dynamicAnchors]);const d=(0,et._)`${l}, ${n.object(...p)}`;return u!==et.nil?(0,et._)`${a}.call(${u}, ${d})`:(0,et._)`${a}(${d})`}we.callValidateCode=ny;const ry=(0,et._)`new RegExp`;function sy({gen:t,it:{opts:e}},n){const r=e.unicodeRegExp?"u":"",{regExp:s}=e.code,o=s(n,r);return t.scopeValue("pattern",{key:o.toString(),ref:o,code:(0,et._)`${s.code==="new RegExp"?ry:(0,zE.useFunc)(t,s)}(${n}, ${r})`})}we.usePattern=sy;function oy(t){const{gen:e,data:n,keyword:r,it:s}=t,o=e.name("valid");if(s.allErrors){const a=e.let("valid",!0);return i(()=>e.assign(a,!1)),a}return e.var(o,!0),i(()=>e.break()),o;function i(a){const u=e.const("len",(0,et._)`${n}.length`);e.forRange("i",0,u,c=>{t.subschema({keyword:r,dataProp:c,dataPropType:yu.Type.Num},o),e.if((0,et.not)(o),a)})}}we.validateArray=oy;function iy(t){const{gen:e,schema:n,keyword:r,it:s}=t;if(!Array.isArray(n))throw new Error("ajv implementation error");if(n.some(u=>(0,yu.alwaysValidSchema)(s,u))&&!s.opts.unevaluated)return;const i=e.let("valid",!1),a=e.name("_valid");e.block(()=>n.forEach((u,c)=>{const l=t.subschema({keyword:r,schemaProp:c,compositeRule:!0},a);e.assign(i,(0,et._)`${i} || ${a}`),t.mergeValidEvaluated(l,a)||e.if((0,et.not)(i))})),t.result(i,()=>t.reset(),()=>t.error(!0))}we.validateUnion=iy;Object.defineProperty(yn,"__esModule",{value:!0});yn.validateKeywordUsage=yn.validSchemaType=yn.funcKeywordCode=yn.macroKeywordCode=void 0;const Pt=Ie,ir=bn,ay=we,uy=Gs;function cy(t,e){const{gen:n,keyword:r,schema:s,parentSchema:o,it:i}=t,a=e.macro.call(i.self,s,o,i),u=vd(n,r,a);i.opts.validateSchema!==!1&&i.self.validateSchema(a,!0);const c=n.name("valid");t.subschema({schema:a,schemaPath:Pt.nil,errSchemaPath:`${i.errSchemaPath}/${r}`,topSchemaRef:u,compositeRule:!0},c),t.pass(c,()=>t.error(!0))}yn.macroKeywordCode=cy;function ly(t,e){var n;const{gen:r,keyword:s,schema:o,parentSchema:i,$data:a,it:u}=t;dy(u,e);const c=!a&&e.compile?e.compile.call(u.self,o,i,u):e.validate,l=vd(r,s,c),p=r.let("valid");t.block$data(p,d),t.ok((n=e.valid)!==null&&n!==void 0?n:p);function d(){if(e.errors===!1)b(),e.modifying&&sl(t),F(()=>t.error());else{const y=e.async?f():S();e.modifying&&sl(t),F(()=>py(t,y))}}function f(){const y=r.let("ruleErrs",null);return r.try(()=>b((0,Pt._)`await `),T=>r.assign(p,!1).if((0,Pt._)`${T} instanceof ${u.ValidationError}`,()=>r.assign(y,(0,Pt._)`${T}.errors`),()=>r.throw(T))),y}function S(){const y=(0,Pt._)`${l}.errors`;return r.assign(y,null),b(Pt.nil),y}function b(y=e.async?(0,Pt._)`await `:Pt.nil){const T=u.opts.passContext?ir.default.this:ir.default.self,O=!("compile"in e&&!a||e.schema===!1);r.assign(p,(0,Pt._)`${y}${(0,ay.callValidateCode)(t,l,T,O)}`,e.modifying)}function F(y){var T;r.if((0,Pt.not)((T=e.valid)!==null&&T!==void 0?T:p),y)}}yn.funcKeywordCode=ly;function sl(t){const{gen:e,data:n,it:r}=t;e.if(r.parentData,()=>e.assign(n,(0,Pt._)`${r.parentData}[${r.parentDataProperty}]`))}function py(t,e){const{gen:n}=t;n.if((0,Pt._)`Array.isArray(${e})`,()=>{n.assign(ir.default.vErrors,(0,Pt._)`${ir.default.vErrors} === null ? ${e} : ${ir.default.vErrors}.concat(${e})`).assign(ir.default.errors,(0,Pt._)`${ir.default.vErrors}.length`),(0,uy.extendErrors)(t)},()=>t.error())}function dy({schemaEnv:t},e){if(e.async&&!t.$async)throw new Error("async keyword in sync schema")}function vd(t,e,n){if(n===void 0)throw new Error(`keyword "${e}" failed to compile`);return t.scopeValue("keyword",typeof n=="function"?{ref:n}:{ref:n,code:(0,Pt.stringify)(n)})}function fy(t,e,n=!1){return!e.length||e.some(r=>r==="array"?Array.isArray(t):r==="object"?t&&typeof t=="object"&&!Array.isArray(t):typeof t==r||n&&typeof t>"u")}yn.validSchemaType=fy;function hy({schema:t,opts:e,self:n,errSchemaPath:r},s,o){if(Array.isArray(s.keyword)?!s.keyword.includes(o):s.keyword!==o)throw new Error("ajv implementation error");const i=s.dependencies;if(i!=null&&i.some(a=>!Object.prototype.hasOwnProperty.call(t,a)))throw new Error(`parent schema must have dependencies of ${o}: ${i.join(",")}`);if(s.validateSchema&&!s.validateSchema(t[o])){const u=`keyword "${o}" value is invalid at path "${r}": `+n.errorsText(s.validateSchema.errors);if(e.validateSchema==="log")n.logger.error(u);else throw new Error(u)}}yn.validateKeywordUsage=hy;var Hn={};Object.defineProperty(Hn,"__esModule",{value:!0});Hn.extendSubschemaMode=Hn.extendSubschemaData=Hn.getSubschema=void 0;const En=Ie,Ad=se;function my(t,{keyword:e,schemaProp:n,schema:r,schemaPath:s,errSchemaPath:o,topSchemaRef:i}){if(e!==void 0&&r!==void 0)throw new Error('both "keyword" and "schema" passed, only one allowed');if(e!==void 0){const a=t.schema[e];return n===void 0?{schema:a,schemaPath:(0,En._)`${t.schemaPath}${(0,En.getProperty)(e)}`,errSchemaPath:`${t.errSchemaPath}/${e}`}:{schema:a[n],schemaPath:(0,En._)`${t.schemaPath}${(0,En.getProperty)(e)}${(0,En.getProperty)(n)}`,errSchemaPath:`${t.errSchemaPath}/${e}/${(0,Ad.escapeFragment)(n)}`}}if(r!==void 0){if(s===void 0||o===void 0||i===void 0)throw new Error('"schemaPath", "errSchemaPath" and "topSchemaRef" are required with "schema"');return{schema:r,schemaPath:s,topSchemaRef:i,errSchemaPath:o}}throw new Error('either "keyword" or "schema" must be passed')}Hn.getSubschema=my;function Dy(t,e,{dataProp:n,dataPropType:r,data:s,dataTypes:o,propertyName:i}){if(s!==void 0&&n!==void 0)throw new Error('both "data" and "dataProp" passed, only one allowed');const{gen:a}=e;if(n!==void 0){const{errorPath:c,dataPathArr:l,opts:p}=e,d=a.let("data",(0,En._)`${e.data}${(0,En.getProperty)(n)}`,!0);u(d),t.errorPath=(0,En.str)`${c}${(0,Ad.getErrorPath)(n,r,p.jsPropertySyntax)}`,t.parentDataProperty=(0,En._)`${n}`,t.dataPathArr=[...l,t.parentDataProperty]}if(s!==void 0){const c=s instanceof En.Name?s:a.let("data",s,!0);u(c),i!==void 0&&(t.propertyName=i)}o&&(t.dataTypes=o);function u(c){t.data=c,t.dataLevel=e.dataLevel+1,t.dataTypes=[],e.definedProperties=new Set,t.parentData=e.data,t.dataNames=[...e.dataNames,c]}}Hn.extendSubschemaData=Dy;function Sy(t,{jtdDiscriminator:e,jtdMetadata:n,compositeRule:r,createErrors:s,allErrors:o}){r!==void 0&&(t.compositeRule=r),s!==void 0&&(t.createErrors=s),o!==void 0&&(t.allErrors=o),t.jtdDiscriminator=e,t.jtdMetadata=n}Hn.extendSubschemaMode=Sy;var wt={},bd=function t(e,n){if(e===n)return!0;if(e&&n&&typeof e=="object"&&typeof n=="object"){if(e.constructor!==n.constructor)return!1;var r,s,o;if(Array.isArray(e)){if(r=e.length,r!=n.length)return!1;for(s=r;s--!==0;)if(!t(e[s],n[s]))return!1;return!0}if(e.constructor===RegExp)return e.source===n.source&&e.flags===n.flags;if(e.valueOf!==Object.prototype.valueOf)return e.valueOf()===n.valueOf();if(e.toString!==Object.prototype.toString)return e.toString()===n.toString();if(o=Object.keys(e),r=o.length,r!==Object.keys(n).length)return!1;for(s=r;s--!==0;)if(!Object.prototype.hasOwnProperty.call(n,o[s]))return!1;for(s=r;s--!==0;){var i=o[s];if(!t(e[i],n[i]))return!1}return!0}return e!==e&&n!==n},Cd={exports:{}},Vn=Cd.exports=function(t,e,n){typeof e=="function"&&(n=e,e={}),n=e.cb||n;var r=typeof n=="function"?n:n.pre||function(){},s=n.post||function(){};yo(e,r,s,t,"",t)};Vn.keywords={additionalItems:!0,items:!0,contains:!0,additionalProperties:!0,propertyNames:!0,not:!0,if:!0,then:!0,else:!0};Vn.arrayKeywords={items:!0,allOf:!0,anyOf:!0,oneOf:!0};Vn.propsKeywords={$defs:!0,definitions:!0,properties:!0,patternProperties:!0,dependencies:!0};Vn.skipKeywords={default:!0,enum:!0,const:!0,required:!0,maximum:!0,minimum:!0,exclusiveMaximum:!0,exclusiveMinimum:!0,multipleOf:!0,maxLength:!0,minLength:!0,pattern:!0,format:!0,maxItems:!0,minItems:!0,uniqueItems:!0,maxProperties:!0,minProperties:!0};function yo(t,e,n,r,s,o,i,a,u,c){if(r&&typeof r=="object"&&!Array.isArray(r)){e(r,s,o,i,a,u,c);for(var l in r){var p=r[l];if(Array.isArray(p)){if(l in Vn.arrayKeywords)for(var d=0;d<p.length;d++)yo(t,e,n,p[d],s+"/"+l+"/"+d,o,s,l,r,d)}else if(l in Vn.propsKeywords){if(p&&typeof p=="object")for(var f in p)yo(t,e,n,p[f],s+"/"+l+"/"+Ey(f),o,s,l,r,f)}else(l in Vn.keywords||t.allKeys&&!(l in Vn.skipKeywords))&&yo(t,e,n,p,s+"/"+l,o,s,l,r)}n(r,s,o,i,a,u,c)}}function Ey(t){return t.replace(/~/g,"~0").replace(/\//g,"~1")}var yy=Cd.exports;Object.defineProperty(wt,"__esModule",{value:!0});wt.getSchemaRefs=wt.resolveUrl=wt.normalizeId=wt._getFullPath=wt.getFullPath=wt.inlineRef=void 0;const gy=se,vy=bd,Ay=yy,by=new Set(["type","format","pattern","maxLength","minLength","maxProperties","minProperties","maxItems","minItems","maximum","minimum","uniqueItems","multipleOf","required","enum","const"]);function Cy(t,e=!0){return typeof t=="boolean"?!0:e===!0?!ba(t):e?Td(t)<=e:!1}wt.inlineRef=Cy;const Ty=new Set(["$ref","$recursiveRef","$recursiveAnchor","$dynamicRef","$dynamicAnchor"]);function ba(t){for(const e in t){if(Ty.has(e))return!0;const n=t[e];if(Array.isArray(n)&&n.some(ba)||typeof n=="object"&&ba(n))return!0}return!1}function Td(t){let e=0;for(const n in t){if(n==="$ref")return 1/0;if(e++,!by.has(n)&&(typeof t[n]=="object"&&(0,gy.eachItem)(t[n],r=>e+=Td(r)),e===1/0))return 1/0}return e}function wd(t,e="",n){n!==!1&&(e=Kr(e));const r=t.parse(e);return Fd(t,r)}wt.getFullPath=wd;function Fd(t,e){return t.serialize(e).split("#")[0]+"#"}wt._getFullPath=Fd;const wy=/#\/?$/;function Kr(t){return t?t.replace(wy,""):""}wt.normalizeId=Kr;function Fy(t,e,n){return n=Kr(n),t.resolve(e,n)}wt.resolveUrl=Fy;const Iy=/^[a-z_][-a-z0-9._]*$/i;function ky(t,e){if(typeof t=="boolean")return{};const{schemaId:n,uriResolver:r}=this.opts,s=Kr(t[n]||e),o={"":s},i=wd(r,s,!1),a={},u=new Set;return Ay(t,{allKeys:!0},(p,d,f,S)=>{if(S===void 0)return;const b=i+d;let F=o[S];typeof p[n]=="string"&&(F=y.call(this,p[n])),T.call(this,p.$anchor),T.call(this,p.$dynamicAnchor),o[d]=F;function y(O){const j=this.opts.uriResolver.resolve;if(O=Kr(F?j(F,O):O),u.has(O))throw l(O);u.add(O);let M=this.refs[O];return typeof M=="string"&&(M=this.refs[M]),typeof M=="object"?c(p,M.schema,O):O!==Kr(b)&&(O[0]==="#"?(c(p,a[O],O),a[O]=p):this.refs[O]=b),O}function T(O){if(typeof O=="string"){if(!Iy.test(O))throw new Error(`invalid anchor "${O}"`);y.call(this,`#${O}`)}}}),a;function c(p,d,f){if(d!==void 0&&!vy(p,d))throw l(f)}function l(p){return new Error(`reference "${p}" resolves to more than one schema`)}}wt.getSchemaRefs=ky;Object.defineProperty(cn,"__esModule",{value:!0});cn.getData=cn.KeywordCxt=cn.validateFunctionCode=void 0;const Id=Yr,ol=yt,Au=kn,Vo=yt,Py=li,ys=yn,Pi=Hn,ae=Ie,De=bn,Ny=wt,Pn=se,is=Gs;function _y(t){if(Nd(t)&&(_d(t),Pd(t))){By(t);return}kd(t,()=>(0,Id.topBoolOrEmptySchema)(t))}cn.validateFunctionCode=_y;function kd({gen:t,validateName:e,schema:n,schemaEnv:r,opts:s},o){s.code.es5?t.func(e,(0,ae._)`${De.default.data}, ${De.default.valCxt}`,r.$async,()=>{t.code((0,ae._)`"use strict"; ${il(n,s)}`),$y(t,s),t.code(o)}):t.func(e,(0,ae._)`${De.default.data}, ${Oy(s)}`,r.$async,()=>t.code(il(n,s)).code(o))}function Oy(t){return(0,ae._)`{${De.default.instancePath}="", ${De.default.parentData}, ${De.default.parentDataProperty}, ${De.default.rootData}=${De.default.data}${t.dynamicRef?(0,ae._)`, ${De.default.dynamicAnchors}={}`:ae.nil}}={}`}function $y(t,e){t.if(De.default.valCxt,()=>{t.var(De.default.instancePath,(0,ae._)`${De.default.valCxt}.${De.default.instancePath}`),t.var(De.default.parentData,(0,ae._)`${De.default.valCxt}.${De.default.parentData}`),t.var(De.default.parentDataProperty,(0,ae._)`${De.default.valCxt}.${De.default.parentDataProperty}`),t.var(De.default.rootData,(0,ae._)`${De.default.valCxt}.${De.default.rootData}`),e.dynamicRef&&t.var(De.default.dynamicAnchors,(0,ae._)`${De.default.valCxt}.${De.default.dynamicAnchors}`)},()=>{t.var(De.default.instancePath,(0,ae._)`""`),t.var(De.default.parentData,(0,ae._)`undefined`),t.var(De.default.parentDataProperty,(0,ae._)`undefined`),t.var(De.default.rootData,De.default.data),e.dynamicRef&&t.var(De.default.dynamicAnchors,(0,ae._)`{}`)})}function By(t){const{schema:e,opts:n,gen:r}=t;kd(t,()=>{n.$comment&&e.$comment&&$d(t),Ly(t),r.let(De.default.vErrors,null),r.let(De.default.errors,0),n.unevaluated&&Ry(t),Od(t),Uy(t)})}function Ry(t){const{gen:e,validateName:n}=t;t.evaluated=e.const("evaluated",(0,ae._)`${n}.evaluated`),e.if((0,ae._)`${t.evaluated}.dynamicProps`,()=>e.assign((0,ae._)`${t.evaluated}.props`,(0,ae._)`undefined`)),e.if((0,ae._)`${t.evaluated}.dynamicItems`,()=>e.assign((0,ae._)`${t.evaluated}.items`,(0,ae._)`undefined`))}function il(t,e){const n=typeof t=="object"&&t[e.schemaId];return n&&(e.code.source||e.code.process)?(0,ae._)`/*# sourceURL=${n} */`:ae.nil}function xy(t,e){if(Nd(t)&&(_d(t),Pd(t))){qy(t,e);return}(0,Id.boolOrEmptySchema)(t,e)}function Pd({schema:t,self:e}){if(typeof t=="boolean")return!t;for(const n in t)if(e.RULES.all[n])return!0;return!1}function Nd(t){return typeof t.schema!="boolean"}function qy(t,e){const{schema:n,gen:r,opts:s}=t;s.$comment&&n.$comment&&$d(t),jy(t),Gy(t);const o=r.const("_errs",De.default.errors);Od(t,o),r.var(e,(0,ae._)`${o} === ${De.default.errors}`)}function _d(t){(0,Pn.checkUnknownRules)(t),My(t)}function Od(t,e){if(t.opts.jtd)return al(t,[],!1,e);const n=(0,ol.getSchemaTypes)(t.schema),r=(0,ol.coerceAndCheckDataType)(t,n);al(t,n,!r,e)}function My(t){const{schema:e,errSchemaPath:n,opts:r,self:s}=t;e.$ref&&r.ignoreKeywordsWithRef&&(0,Pn.schemaHasRulesButRef)(e,s.RULES)&&s.logger.warn(`$ref: keywords ignored in schema at path "${n}"`)}function Ly(t){const{schema:e,opts:n}=t;e.default!==void 0&&n.useDefaults&&n.strictSchema&&(0,Pn.checkStrictMode)(t,"default is ignored in the schema root")}function jy(t){const e=t.schema[t.opts.schemaId];e&&(t.baseId=(0,Ny.resolveUrl)(t.opts.uriResolver,t.baseId,e))}function Gy(t){if(t.schema.$async&&!t.schemaEnv.$async)throw new Error("async schema in sync schema")}function $d({gen:t,schemaEnv:e,schema:n,errSchemaPath:r,opts:s}){const o=n.$comment;if(s.$comment===!0)t.code((0,ae._)`${De.default.self}.logger.log(${o})`);else if(typeof s.$comment=="function"){const i=(0,ae.str)`${r}/$comment`,a=t.scopeValue("root",{ref:e.root});t.code((0,ae._)`${De.default.self}.opts.$comment(${o}, ${i}, ${a}.schema)`)}}function Uy(t){const{gen:e,schemaEnv:n,validateName:r,ValidationError:s,opts:o}=t;n.$async?e.if((0,ae._)`${De.default.errors} === 0`,()=>e.return(De.default.data),()=>e.throw((0,ae._)`new ${s}(${De.default.vErrors})`)):(e.assign((0,ae._)`${r}.errors`,De.default.vErrors),o.unevaluated&&Vy(t),e.return((0,ae._)`${De.default.errors} === 0`))}function Vy({gen:t,evaluated:e,props:n,items:r}){n instanceof ae.Name&&t.assign((0,ae._)`${e}.props`,n),r instanceof ae.Name&&t.assign((0,ae._)`${e}.items`,r)}function al(t,e,n,r){const{gen:s,schema:o,data:i,allErrors:a,opts:u,self:c}=t,{RULES:l}=c;if(o.$ref&&(u.ignoreKeywordsWithRef||!(0,Pn.schemaHasRulesButRef)(o,l))){s.block(()=>xd(t,"$ref",l.all.$ref.definition));return}u.jtd||Jy(t,e),s.block(()=>{for(const d of l.rules)p(d);p(l.post)});function p(d){(0,Au.shouldUseGroup)(o,d)&&(d.type?(s.if((0,Vo.checkDataType)(d.type,i,u.strictNumbers)),ul(t,d),e.length===1&&e[0]===d.type&&n&&(s.else(),(0,Vo.reportTypeError)(t)),s.endIf()):ul(t,d),a||s.if((0,ae._)`${De.default.errors} === ${r||0}`))}}function ul(t,e){const{gen:n,schema:r,opts:{useDefaults:s}}=t;s&&(0,Py.assignDefaults)(t,e.type),n.block(()=>{for(const o of e.rules)(0,Au.shouldUseRule)(r,o)&&xd(t,o.keyword,o.definition,e.type)})}function Jy(t,e){t.schemaEnv.meta||!t.opts.strictTypes||(Hy(t,e),t.opts.allowUnionTypes||Wy(t,e),Ky(t,t.dataTypes))}function Hy(t,e){if(e.length){if(!t.dataTypes.length){t.dataTypes=e;return}e.forEach(n=>{Bd(t.dataTypes,n)||bu(t,`type "${n}" not allowed by context "${t.dataTypes.join(",")}"`)}),zy(t,e)}}function Wy(t,e){e.length>1&&!(e.length===2&&e.includes("null"))&&bu(t,"use allowUnionTypes to allow union type keyword")}function Ky(t,e){const n=t.self.RULES.all;for(const r in n){const s=n[r];if(typeof s=="object"&&(0,Au.shouldUseRule)(t.schema,s)){const{type:o}=s.definition;o.length&&!o.some(i=>Xy(e,i))&&bu(t,`missing type "${o.join(",")}" for keyword "${r}"`)}}}function Xy(t,e){return t.includes(e)||e==="number"&&t.includes("integer")}function Bd(t,e){return t.includes(e)||e==="integer"&&t.includes("number")}function zy(t,e){const n=[];for(const r of t.dataTypes)Bd(e,r)?n.push(r):e.includes("integer")&&r==="number"&&n.push("integer");t.dataTypes=n}function bu(t,e){const n=t.schemaEnv.baseId+t.errSchemaPath;e+=` at "${n}" (strictTypes)`,(0,Pn.checkStrictMode)(t,e,t.opts.strictTypes)}class Rd{constructor(e,n,r){if((0,ys.validateKeywordUsage)(e,n,r),this.gen=e.gen,this.allErrors=e.allErrors,this.keyword=r,this.data=e.data,this.schema=e.schema[r],this.$data=n.$data&&e.opts.$data&&this.schema&&this.schema.$data,this.schemaValue=(0,Pn.schemaRefOrVal)(e,this.schema,r,this.$data),this.schemaType=n.schemaType,this.parentSchema=e.schema,this.params={},this.it=e,this.def=n,this.$data)this.schemaCode=e.gen.const("vSchema",qd(this.$data,e));else if(this.schemaCode=this.schemaValue,!(0,ys.validSchemaType)(this.schema,n.schemaType,n.allowUndefined))throw new Error(`${r} value must be ${JSON.stringify(n.schemaType)}`);("code"in n?n.trackErrors:n.errors!==!1)&&(this.errsCount=e.gen.const("_errs",De.default.errors))}result(e,n,r){this.failResult((0,ae.not)(e),n,r)}failResult(e,n,r){this.gen.if(e),r?r():this.error(),n?(this.gen.else(),n(),this.allErrors&&this.gen.endIf()):this.allErrors?this.gen.endIf():this.gen.else()}pass(e,n){this.failResult((0,ae.not)(e),void 0,n)}fail(e){if(e===void 0){this.error(),this.allErrors||this.gen.if(!1);return}this.gen.if(e),this.error(),this.allErrors?this.gen.endIf():this.gen.else()}fail$data(e){if(!this.$data)return this.fail(e);const{schemaCode:n}=this;this.fail((0,ae._)`${n} !== undefined && (${(0,ae.or)(this.invalid$data(),e)})`)}error(e,n,r){if(n){this.setParams(n),this._error(e,r),this.setParams({});return}this._error(e,r)}_error(e,n){(e?is.reportExtraError:is.reportError)(this,this.def.error,n)}$dataError(){(0,is.reportError)(this,this.def.$dataError||is.keyword$DataError)}reset(){if(this.errsCount===void 0)throw new Error('add "trackErrors" to keyword definition');(0,is.resetErrorsCount)(this.gen,this.errsCount)}ok(e){this.allErrors||this.gen.if(e)}setParams(e,n){n?Object.assign(this.params,e):this.params=e}block$data(e,n,r=ae.nil){this.gen.block(()=>{this.check$data(e,r),n()})}check$data(e=ae.nil,n=ae.nil){if(!this.$data)return;const{gen:r,schemaCode:s,schemaType:o,def:i}=this;r.if((0,ae.or)((0,ae._)`${s} === undefined`,n)),e!==ae.nil&&r.assign(e,!0),(o.length||i.validateSchema)&&(r.elseIf(this.invalid$data()),this.$dataError(),e!==ae.nil&&r.assign(e,!1)),r.else()}invalid$data(){const{gen:e,schemaCode:n,schemaType:r,def:s,it:o}=this;return(0,ae.or)(i(),a());function i(){if(r.length){if(!(n instanceof ae.Name))throw new Error("ajv implementation error");const u=Array.isArray(r)?r:[r];return(0,ae._)`${(0,Vo.checkDataTypes)(u,n,o.opts.strictNumbers,Vo.DataType.Wrong)}`}return ae.nil}function a(){if(s.validateSchema){const u=e.scopeValue("validate$data",{ref:s.validateSchema});return(0,ae._)`!${u}(${n})`}return ae.nil}}subschema(e,n){const r=(0,Pi.getSubschema)(this.it,e);(0,Pi.extendSubschemaData)(r,this.it,e),(0,Pi.extendSubschemaMode)(r,e);const s={...this.it,...r,items:void 0,props:void 0};return xy(s,n),s}mergeEvaluated(e,n){const{it:r,gen:s}=this;r.opts.unevaluated&&(r.props!==!0&&e.props!==void 0&&(r.props=Pn.mergeEvaluated.props(s,e.props,r.props,n)),r.items!==!0&&e.items!==void 0&&(r.items=Pn.mergeEvaluated.items(s,e.items,r.items,n)))}mergeValidEvaluated(e,n){const{it:r,gen:s}=this;if(r.opts.unevaluated&&(r.props!==!0||r.items!==!0))return s.if(n,()=>this.mergeEvaluated(e,ae.Name)),!0}}cn.KeywordCxt=Rd;function xd(t,e,n,r){const s=new Rd(t,n,e);"code"in n?n.code(s,r):s.$data&&n.validate?(0,ys.funcKeywordCode)(s,n):"macro"in n?(0,ys.macroKeywordCode)(s,n):(n.compile||n.validate)&&(0,ys.funcKeywordCode)(s,n)}const Yy=/^\/(?:[^~]|~0|~1)*$/,Zy=/^([0-9]+)(#|\/(?:[^~]|~0|~1)*)?$/;function qd(t,{dataLevel:e,dataNames:n,dataPathArr:r}){let s,o;if(t==="")return De.default.rootData;if(t[0]==="/"){if(!Yy.test(t))throw new Error(`Invalid JSON-pointer: ${t}`);s=t,o=De.default.rootData}else{const c=Zy.exec(t);if(!c)throw new Error(`Invalid JSON-pointer: ${t}`);const l=+c[1];if(s=c[2],s==="#"){if(l>=e)throw new Error(u("property/index",l));return r[e-l]}if(l>e)throw new Error(u("data",l));if(o=n[e-l],!s)return o}let i=o;const a=s.split("/");for(const c of a)c&&(o=(0,ae._)`${o}${(0,ae.getProperty)((0,Pn.unescapeJsonPointer)(c))}`,i=(0,ae._)`${i} && ${o}`);return i;function u(c,l){return`Cannot access ${c} ${l} levels up, current level is ${e}`}}cn.getData=qd;var Us={};Object.defineProperty(Us,"__esModule",{value:!0});class Qy extends Error{constructor(e){super("validation failed"),this.errors=e,this.ajv=this.validation=!0}}Us.default=Qy;var Vs={};Object.defineProperty(Vs,"__esModule",{value:!0});const Ni=wt;class e4 extends Error{constructor(e,n,r,s){super(s||`can't resolve reference ${r} from id ${n}`),this.missingRef=(0,Ni.resolveUrl)(e,n,r),this.missingSchema=(0,Ni.normalizeId)((0,Ni.getFullPath)(e,this.missingRef))}}Vs.default=e4;var xt={};Object.defineProperty(xt,"__esModule",{value:!0});xt.resolveSchema=xt.getCompilingSchema=xt.resolveRef=xt.compileSchema=xt.SchemaEnv=void 0;const tn=Ie,t4=Us,rr=bn,an=wt,cl=se,n4=cn;class pi{constructor(e){var n;this.refs={},this.dynamicAnchors={};let r;typeof e.schema=="object"&&(r=e.schema),this.schema=e.schema,this.schemaId=e.schemaId,this.root=e.root||this,this.baseId=(n=e.baseId)!==null&&n!==void 0?n:(0,an.normalizeId)(r==null?void 0:r[e.schemaId||"$id"]),this.schemaPath=e.schemaPath,this.localRefs=e.localRefs,this.meta=e.meta,this.$async=r==null?void 0:r.$async,this.refs={}}}xt.SchemaEnv=pi;function Cu(t){const e=Md.call(this,t);if(e)return e;const n=(0,an.getFullPath)(this.opts.uriResolver,t.root.baseId),{es5:r,lines:s}=this.opts.code,{ownProperties:o}=this.opts,i=new tn.CodeGen(this.scope,{es5:r,lines:s,ownProperties:o});let a;t.$async&&(a=i.scopeValue("Error",{ref:t4.default,code:(0,tn._)`require("ajv/dist/runtime/validation_error").default`}));const u=i.scopeName("validate");t.validateName=u;const c={gen:i,allErrors:this.opts.allErrors,data:rr.default.data,parentData:rr.default.parentData,parentDataProperty:rr.default.parentDataProperty,dataNames:[rr.default.data],dataPathArr:[tn.nil],dataLevel:0,dataTypes:[],definedProperties:new Set,topSchemaRef:i.scopeValue("schema",this.opts.code.source===!0?{ref:t.schema,code:(0,tn.stringify)(t.schema)}:{ref:t.schema}),validateName:u,ValidationError:a,schema:t.schema,schemaEnv:t,rootId:n,baseId:t.baseId||n,schemaPath:tn.nil,errSchemaPath:t.schemaPath||(this.opts.jtd?"":"#"),errorPath:(0,tn._)`""`,opts:this.opts,self:this};let l;try{this._compilations.add(t),(0,n4.validateFunctionCode)(c),i.optimize(this.opts.code.optimize);const p=i.toString();l=`${i.scopeRefs(rr.default.scope)}return ${p}`,this.opts.code.process&&(l=this.opts.code.process(l,t));const f=new Function(`${rr.default.self}`,`${rr.default.scope}`,l)(this,this.scope.get());if(this.scope.value(u,{ref:f}),f.errors=null,f.schema=t.schema,f.schemaEnv=t,t.$async&&(f.$async=!0),this.opts.code.source===!0&&(f.source={validateName:u,validateCode:p,scopeValues:i._values}),this.opts.unevaluated){const{props:S,items:b}=c;f.evaluated={props:S instanceof tn.Name?void 0:S,items:b instanceof tn.Name?void 0:b,dynamicProps:S instanceof tn.Name,dynamicItems:b instanceof tn.Name},f.source&&(f.source.evaluated=(0,tn.stringify)(f.evaluated))}return t.validate=f,t}catch(p){throw delete t.validate,delete t.validateName,l&&this.logger.error("Error compiling schema, function code:",l),p}finally{this._compilations.delete(t)}}xt.compileSchema=Cu;function r4(t,e,n){var r;n=(0,an.resolveUrl)(this.opts.uriResolver,e,n);const s=t.refs[n];if(s)return s;let o=i4.call(this,t,n);if(o===void 0){const i=(r=t.localRefs)===null||r===void 0?void 0:r[n],{schemaId:a}=this.opts;i&&(o=new pi({schema:i,schemaId:a,root:t,baseId:e}))}if(o!==void 0)return t.refs[n]=s4.call(this,o)}xt.resolveRef=r4;function s4(t){return(0,an.inlineRef)(t.schema,this.opts.inlineRefs)?t.schema:t.validate?t:Cu.call(this,t)}function Md(t){for(const e of this._compilations)if(o4(e,t))return e}xt.getCompilingSchema=Md;function o4(t,e){return t.schema===e.schema&&t.root===e.root&&t.baseId===e.baseId}function i4(t,e){let n;for(;typeof(n=this.refs[e])=="string";)e=n;return n||this.schemas[e]||di.call(this,t,e)}function di(t,e){const n=this.opts.uriResolver.parse(e),r=(0,an._getFullPath)(this.opts.uriResolver,n);let s=(0,an.getFullPath)(this.opts.uriResolver,t.baseId,void 0);if(Object.keys(t.schema).length>0&&r===s)return _i.call(this,n,t);const o=(0,an.normalizeId)(r),i=this.refs[o]||this.schemas[o];if(typeof i=="string"){const a=di.call(this,t,i);return typeof(a==null?void 0:a.schema)!="object"?void 0:_i.call(this,n,a)}if(typeof(i==null?void 0:i.schema)=="object"){if(i.validate||Cu.call(this,i),o===(0,an.normalizeId)(e)){const{schema:a}=i,{schemaId:u}=this.opts,c=a[u];return c&&(s=(0,an.resolveUrl)(this.opts.uriResolver,s,c)),new pi({schema:a,schemaId:u,root:t,baseId:s})}return _i.call(this,n,i)}}xt.resolveSchema=di;const a4=new Set(["properties","patternProperties","enum","dependencies","definitions"]);function _i(t,{baseId:e,schema:n,root:r}){var s;if(((s=t.fragment)===null||s===void 0?void 0:s[0])!=="/")return;for(const a of t.fragment.slice(1).split("/")){if(typeof n=="boolean")return;const u=n[(0,cl.unescapeFragment)(a)];if(u===void 0)return;n=u;const c=typeof n=="object"&&n[this.opts.schemaId];!a4.has(a)&&c&&(e=(0,an.resolveUrl)(this.opts.uriResolver,e,c))}let o;if(typeof n!="boolean"&&n.$ref&&!(0,cl.schemaHasRulesButRef)(n,this.RULES)){const a=(0,an.resolveUrl)(this.opts.uriResolver,e,n.$ref);o=di.call(this,r,a)}const{schemaId:i}=this.opts;if(o=o||new pi({schema:n,schemaId:i,root:r,baseId:e}),o.schema!==o.root.schema)return o}const u4="https://raw.githubusercontent.com/ajv-validator/ajv/master/lib/refs/data.json#",c4="Meta-schema for $data reference (JSON AnySchema extension proposal)",l4="object",p4=["$data"],d4={$data:{type:"string",anyOf:[{format:"relative-json-pointer"},{format:"json-pointer"}]}},f4=!1,h4={$id:u4,description:c4,type:l4,required:p4,properties:d4,additionalProperties:f4};var Tu={},Ca={exports:{}};/** @license URI.js v4.4.1 (c) 2011 Gary Court. License: http://github.com/garycourt/uri-js */(function(t,e){(function(n,r){r(e)})(pr,function(n){function r(){for(var R=arguments.length,_=Array(R),q=0;q<R;q++)_[q]=arguments[q];if(_.length>1){_[0]=_[0].slice(0,-1);for(var W=_.length-1,H=1;H<W;++H)_[H]=_[H].slice(1,-1);return _[W]=_[W].slice(1),_.join("")}else return _[0]}function s(R){return"(?:"+R+")"}function o(R){return R===void 0?"undefined":R===null?"null":Object.prototype.toString.call(R).split(" ").pop().split("]").shift().toLowerCase()}function i(R){return R.toUpperCase()}function a(R){return R!=null?R instanceof Array?R:typeof R.length!="number"||R.split||R.setInterval||R.call?[R]:Array.prototype.slice.call(R):[]}function u(R,_){var q=R;if(_)for(var W in _)q[W]=_[W];return q}function c(R){var _="[A-Za-z]",q="[0-9]",W=r(q,"[A-Fa-f]"),H=s(s("%[EFef]"+W+"%"+W+W+"%"+W+W)+"|"+s("%[89A-Fa-f]"+W+"%"+W+W)+"|"+s("%"+W+W)),ue="[\\:\\/\\?\\#\\[\\]\\@]",le="[\\!\\$\\&\\'\\(\\)\\*\\+\\,\\;\\=]",xe=r(ue,le),Qe=R?"[\\xA0-\\u200D\\u2010-\\u2029\\u202F-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF]":"[]",pt=R?"[\\uE000-\\uF8FF]":"[]",_e=r(_,q,"[\\-\\.\\_\\~]",Qe);s(_+r(_,q,"[\\+\\-\\.]")+"*"),s(s(H+"|"+r(_e,le,"[\\:]"))+"*");var ze=s(s("25[0-5]")+"|"+s("2[0-4]"+q)+"|"+s("1"+q+q)+"|"+s("0?[1-9]"+q)+"|0?0?"+q),dt=s(ze+"\\."+ze+"\\."+ze+"\\."+ze),Ee=s(W+"{1,4}"),ot=s(s(Ee+"\\:"+Ee)+"|"+dt),Dt=s(s(Ee+"\\:")+"{6}"+ot),it=s("\\:\\:"+s(Ee+"\\:")+"{5}"+ot),Bn=s(s(Ee)+"?\\:\\:"+s(Ee+"\\:")+"{4}"+ot),fn=s(s(s(Ee+"\\:")+"{0,1}"+Ee)+"?\\:\\:"+s(Ee+"\\:")+"{3}"+ot),hn=s(s(s(Ee+"\\:")+"{0,2}"+Ee)+"?\\:\\:"+s(Ee+"\\:")+"{2}"+ot),br=s(s(s(Ee+"\\:")+"{0,3}"+Ee)+"?\\:\\:"+Ee+"\\:"+ot),er=s(s(s(Ee+"\\:")+"{0,4}"+Ee)+"?\\:\\:"+ot),Jt=s(s(s(Ee+"\\:")+"{0,5}"+Ee)+"?\\:\\:"+Ee),mn=s(s(s(Ee+"\\:")+"{0,6}"+Ee)+"?\\:\\:"),tr=s([Dt,it,Bn,fn,hn,br,er,Jt,mn].join("|")),Tn=s(s(_e+"|"+H)+"+");s("[vV]"+W+"+\\."+r(_e,le,"[\\:]")+"+"),s(s(H+"|"+r(_e,le))+"*");var ss=s(H+"|"+r(_e,le,"[\\:\\@]"));return s(s(H+"|"+r(_e,le,"[\\@]"))+"+"),s(s(ss+"|"+r("[\\/\\?]",pt))+"*"),{NOT_SCHEME:new RegExp(r("[^]",_,q,"[\\+\\-\\.]"),"g"),NOT_USERINFO:new RegExp(r("[^\\%\\:]",_e,le),"g"),NOT_HOST:new RegExp(r("[^\\%\\[\\]\\:]",_e,le),"g"),NOT_PATH:new RegExp(r("[^\\%\\/\\:\\@]",_e,le),"g"),NOT_PATH_NOSCHEME:new RegExp(r("[^\\%\\/\\@]",_e,le),"g"),NOT_QUERY:new RegExp(r("[^\\%]",_e,le,"[\\:\\@\\/\\?]",pt),"g"),NOT_FRAGMENT:new RegExp(r("[^\\%]",_e,le,"[\\:\\@\\/\\?]"),"g"),ESCAPE:new RegExp(r("[^]",_e,le),"g"),UNRESERVED:new RegExp(_e,"g"),OTHER_CHARS:new RegExp(r("[^\\%]",_e,xe),"g"),PCT_ENCODED:new RegExp(H,"g"),IPV4ADDRESS:new RegExp("^("+dt+")$"),IPV6ADDRESS:new RegExp("^\\[?("+tr+")"+s(s("\\%25|\\%(?!"+W+"{2})")+"("+Tn+")")+"?\\]?$")}}var l=c(!1),p=c(!0),d=function(){function R(_,q){var W=[],H=!0,ue=!1,le=void 0;try{for(var xe=_[Symbol.iterator](),Qe;!(H=(Qe=xe.next()).done)&&(W.push(Qe.value),!(q&&W.length===q));H=!0);}catch(pt){ue=!0,le=pt}finally{try{!H&&xe.return&&xe.return()}finally{if(ue)throw le}}return W}return function(_,q){if(Array.isArray(_))return _;if(Symbol.iterator in Object(_))return R(_,q);throw new TypeError("Invalid attempt to destructure non-iterable instance")}}(),f=function(R){if(Array.isArray(R)){for(var _=0,q=Array(R.length);_<R.length;_++)q[_]=R[_];return q}else return Array.from(R)},S=2147483647,b=36,F=1,y=26,T=38,O=700,j=72,M=128,ee="-",ne=/^xn--/,Ne=/[^\0-\x7E]/,L=/[\x2E\u3002\uFF0E\uFF61]/g,pe={overflow:"Overflow: input needs wider integers to process","not-basic":"Illegal input >= 0x80 (not a basic code point)","invalid-input":"Invalid input"},de=b-F,re=Math.floor,he=String.fromCharCode;function Te(R){throw new RangeError(pe[R])}function Ge(R,_){for(var q=[],W=R.length;W--;)q[W]=_(R[W]);return q}function qe(R,_){var q=R.split("@"),W="";q.length>1&&(W=q[0]+"@",R=q[1]),R=R.replace(L,".");var H=R.split("."),ue=Ge(H,_).join(".");return W+ue}function ce(R){for(var _=[],q=0,W=R.length;q<W;){var H=R.charCodeAt(q++);if(H>=55296&&H<=56319&&q<W){var ue=R.charCodeAt(q++);(ue&64512)==56320?_.push(((H&1023)<<10)+(ue&1023)+65536):(_.push(H),q--)}else _.push(H)}return _}var Ze=function(_){return String.fromCodePoint.apply(String,f(_))},ke=function(_){return _-48<10?_-22:_-65<26?_-65:_-97<26?_-97:b},Z=function(_,q){return _+22+75*(_<26)-((q!=0)<<5)},x=function(_,q,W){var H=0;for(_=W?re(_/O):_>>1,_+=re(_/q);_>de*y>>1;H+=b)_=re(_/de);return re(H+(de+1)*_/(_+T))},v=function(_){var q=[],W=_.length,H=0,ue=M,le=j,xe=_.lastIndexOf(ee);xe<0&&(xe=0);for(var Qe=0;Qe<xe;++Qe)_.charCodeAt(Qe)>=128&&Te("not-basic"),q.push(_.charCodeAt(Qe));for(var pt=xe>0?xe+1:0;pt<W;){for(var _e=H,ze=1,dt=b;;dt+=b){pt>=W&&Te("invalid-input");var Ee=ke(_.charCodeAt(pt++));(Ee>=b||Ee>re((S-H)/ze))&&Te("overflow"),H+=Ee*ze;var ot=dt<=le?F:dt>=le+y?y:dt-le;if(Ee<ot)break;var Dt=b-ot;ze>re(S/Dt)&&Te("overflow"),ze*=Dt}var it=q.length+1;le=x(H-_e,it,_e==0),re(H/it)>S-ue&&Te("overflow"),ue+=re(H/it),H%=it,q.splice(H++,0,ue)}return String.fromCodePoint.apply(String,q)},C=function(_){var q=[];_=ce(_);var W=_.length,H=M,ue=0,le=j,xe=!0,Qe=!1,pt=void 0;try{for(var _e=_[Symbol.iterator](),ze;!(xe=(ze=_e.next()).done);xe=!0){var dt=ze.value;dt<128&&q.push(he(dt))}}catch(os){Qe=!0,pt=os}finally{try{!xe&&_e.return&&_e.return()}finally{if(Qe)throw pt}}var Ee=q.length,ot=Ee;for(Ee&&q.push(ee);ot<W;){var Dt=S,it=!0,Bn=!1,fn=void 0;try{for(var hn=_[Symbol.iterator](),br;!(it=(br=hn.next()).done);it=!0){var er=br.value;er>=H&&er<Dt&&(Dt=er)}}catch(os){Bn=!0,fn=os}finally{try{!it&&hn.return&&hn.return()}finally{if(Bn)throw fn}}var Jt=ot+1;Dt-H>re((S-ue)/Jt)&&Te("overflow"),ue+=(Dt-H)*Jt,H=Dt;var mn=!0,tr=!1,Tn=void 0;try{for(var ss=_[Symbol.iterator](),lc;!(mn=(lc=ss.next()).done);mn=!0){var pc=lc.value;if(pc<H&&++ue>S&&Te("overflow"),pc==H){for(var zs=ue,Ys=b;;Ys+=b){var Zs=Ys<=le?F:Ys>=le+y?y:Ys-le;if(zs<Zs)break;var dc=zs-Zs,fc=b-Zs;q.push(he(Z(Zs+dc%fc,0))),zs=re(dc/fc)}q.push(he(Z(zs,0))),le=x(ue,Jt,ot==Ee),ue=0,++ot}}}catch(os){tr=!0,Tn=os}finally{try{!mn&&ss.return&&ss.return()}finally{if(tr)throw Tn}}++ue,++H}return q.join("")},m=function(_){return qe(_,function(q){return ne.test(q)?v(q.slice(4).toLowerCase()):q})},A=function(_){return qe(_,function(q){return Ne.test(q)?"xn--"+C(q):q})},$={version:"2.1.0",ucs2:{decode:ce,encode:Ze},decode:v,encode:C,toASCII:A,toUnicode:m},g={};function E(R){var _=R.charCodeAt(0),q=void 0;return _<16?q="%0"+_.toString(16).toUpperCase():_<128?q="%"+_.toString(16).toUpperCase():_<2048?q="%"+(_>>6|192).toString(16).toUpperCase()+"%"+(_&63|128).toString(16).toUpperCase():q="%"+(_>>12|224).toString(16).toUpperCase()+"%"+(_>>6&63|128).toString(16).toUpperCase()+"%"+(_&63|128).toString(16).toUpperCase(),q}function N(R){for(var _="",q=0,W=R.length;q<W;){var H=parseInt(R.substr(q+1,2),16);if(H<128)_+=String.fromCharCode(H),q+=3;else if(H>=194&&H<224){if(W-q>=6){var ue=parseInt(R.substr(q+4,2),16);_+=String.fromCharCode((H&31)<<6|ue&63)}else _+=R.substr(q,6);q+=6}else if(H>=224){if(W-q>=9){var le=parseInt(R.substr(q+4,2),16),xe=parseInt(R.substr(q+7,2),16);_+=String.fromCharCode((H&15)<<12|(le&63)<<6|xe&63)}else _+=R.substr(q,9);q+=9}else _+=R.substr(q,3),q+=3}return _}function k(R,_){function q(W){var H=N(W);return H.match(_.UNRESERVED)?H:W}return R.scheme&&(R.scheme=String(R.scheme).replace(_.PCT_ENCODED,q).toLowerCase().replace(_.NOT_SCHEME,"")),R.userinfo!==void 0&&(R.userinfo=String(R.userinfo).replace(_.PCT_ENCODED,q).replace(_.NOT_USERINFO,E).replace(_.PCT_ENCODED,i)),R.host!==void 0&&(R.host=String(R.host).replace(_.PCT_ENCODED,q).toLowerCase().replace(_.NOT_HOST,E).replace(_.PCT_ENCODED,i)),R.path!==void 0&&(R.path=String(R.path).replace(_.PCT_ENCODED,q).replace(R.scheme?_.NOT_PATH:_.NOT_PATH_NOSCHEME,E).replace(_.PCT_ENCODED,i)),R.query!==void 0&&(R.query=String(R.query).replace(_.PCT_ENCODED,q).replace(_.NOT_QUERY,E).replace(_.PCT_ENCODED,i)),R.fragment!==void 0&&(R.fragment=String(R.fragment).replace(_.PCT_ENCODED,q).replace(_.NOT_FRAGMENT,E).replace(_.PCT_ENCODED,i)),R}function U(R){return R.replace(/^0*(.*)/,"$1")||"0"}function V(R,_){var q=R.match(_.IPV4ADDRESS)||[],W=d(q,2),H=W[1];return H?H.split(".").map(U).join("."):R}function Y(R,_){var q=R.match(_.IPV6ADDRESS)||[],W=d(q,3),H=W[1],ue=W[2];if(H){for(var le=H.toLowerCase().split("::").reverse(),xe=d(le,2),Qe=xe[0],pt=xe[1],_e=pt?pt.split(":").map(U):[],ze=Qe.split(":").map(U),dt=_.IPV4ADDRESS.test(ze[ze.length-1]),Ee=dt?7:8,ot=ze.length-Ee,Dt=Array(Ee),it=0;it<Ee;++it)Dt[it]=_e[it]||ze[ot+it]||"";dt&&(Dt[Ee-1]=V(Dt[Ee-1],_));var Bn=Dt.reduce(function(Jt,mn,tr){if(!mn||mn==="0"){var Tn=Jt[Jt.length-1];Tn&&Tn.index+Tn.length===tr?Tn.length++:Jt.push({index:tr,length:1})}return Jt},[]),fn=Bn.sort(function(Jt,mn){return mn.length-Jt.length})[0],hn=void 0;if(fn&&fn.length>1){var br=Dt.slice(0,fn.index),er=Dt.slice(fn.index+fn.length);hn=br.join(":")+"::"+er.join(":")}else hn=Dt.join(":");return ue&&(hn+="%"+ue),hn}else return R}var Le=/^(?:([^:\/?#]+):)?(?:\/\/((?:([^\/?#@]*)@)?(\[[^\/?#\]]+\]|[^\/?#:]*)(?:\:(\d*))?))?([^?#]*)(?:\?([^#]*))?(?:#((?:.|\n|\r)*))?/i,rt="".match(/(){0}/)[1]===void 0;function Xe(R){var _=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{},q={},W=_.iri!==!1?p:l;_.reference==="suffix"&&(R=(_.scheme?_.scheme+":":"")+"//"+R);var H=R.match(Le);if(H){rt?(q.scheme=H[1],q.userinfo=H[3],q.host=H[4],q.port=parseInt(H[5],10),q.path=H[6]||"",q.query=H[7],q.fragment=H[8],isNaN(q.port)&&(q.port=H[5])):(q.scheme=H[1]||void 0,q.userinfo=R.indexOf("@")!==-1?H[3]:void 0,q.host=R.indexOf("//")!==-1?H[4]:void 0,q.port=parseInt(H[5],10),q.path=H[6]||"",q.query=R.indexOf("?")!==-1?H[7]:void 0,q.fragment=R.indexOf("#")!==-1?H[8]:void 0,isNaN(q.port)&&(q.port=R.match(/\/\/(?:.|\n)*\:(?:\/|\?|\#|$)/)?H[4]:void 0)),q.host&&(q.host=Y(V(q.host,W),W)),q.scheme===void 0&&q.userinfo===void 0&&q.host===void 0&&q.port===void 0&&!q.path&&q.query===void 0?q.reference="same-document":q.scheme===void 0?q.reference="relative":q.fragment===void 0?q.reference="absolute":q.reference="uri",_.reference&&_.reference!=="suffix"&&_.reference!==q.reference&&(q.error=q.error||"URI is not a "+_.reference+" reference.");var ue=g[(_.scheme||q.scheme||"").toLowerCase()];if(!_.unicodeSupport&&(!ue||!ue.unicodeSupport)){if(q.host&&(_.domainHost||ue&&ue.domainHost))try{q.host=$.toASCII(q.host.replace(W.PCT_ENCODED,N).toLowerCase())}catch(le){q.error=q.error||"Host's domain name can not be converted to ASCII via punycode: "+le}k(q,l)}else k(q,W);ue&&ue.parse&&ue.parse(q,_)}else q.error=q.error||"URI can not be parsed.";return q}function Ue(R,_){var q=_.iri!==!1?p:l,W=[];return R.userinfo!==void 0&&(W.push(R.userinfo),W.push("@")),R.host!==void 0&&W.push(Y(V(String(R.host),q),q).replace(q.IPV6ADDRESS,function(H,ue,le){return"["+ue+(le?"%25"+le:"")+"]"})),(typeof R.port=="number"||typeof R.port=="string")&&(W.push(":"),W.push(String(R.port))),W.length?W.join(""):void 0}var ye=/^\.\.?\//,He=/^\/\.(\/|$)/,Ve=/^\/\.\.(\/|$)/,je=/^\/?(?:.|\n)*?(?=\/|$)/;function Ae(R){for(var _=[];R.length;)if(R.match(ye))R=R.replace(ye,"");else if(R.match(He))R=R.replace(He,"/");else if(R.match(Ve))R=R.replace(Ve,"/"),_.pop();else if(R==="."||R==="..")R="";else{var q=R.match(je);if(q){var W=q[0];R=R.slice(W.length),_.push(W)}else throw new Error("Unexpected dot segment condition")}return _.join("")}function Re(R){var _=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{},q=_.iri?p:l,W=[],H=g[(_.scheme||R.scheme||"").toLowerCase()];if(H&&H.serialize&&H.serialize(R,_),R.host&&!q.IPV6ADDRESS.test(R.host)){if(_.domainHost||H&&H.domainHost)try{R.host=_.iri?$.toUnicode(R.host):$.toASCII(R.host.replace(q.PCT_ENCODED,N).toLowerCase())}catch(xe){R.error=R.error||"Host's domain name can not be converted to "+(_.iri?"Unicode":"ASCII")+" via punycode: "+xe}}k(R,q),_.reference!=="suffix"&&R.scheme&&(W.push(R.scheme),W.push(":"));var ue=Ue(R,_);if(ue!==void 0&&(_.reference!=="suffix"&&W.push("//"),W.push(ue),R.path&&R.path.charAt(0)!=="/"&&W.push("/")),R.path!==void 0){var le=R.path;!_.absolutePath&&(!H||!H.absolutePath)&&(le=Ae(le)),ue===void 0&&(le=le.replace(/^\/\//,"/%2F")),W.push(le)}return R.query!==void 0&&(W.push("?"),W.push(R.query)),R.fragment!==void 0&&(W.push("#"),W.push(R.fragment)),W.join("")}function It(R,_){var q=arguments.length>2&&arguments[2]!==void 0?arguments[2]:{},W=arguments[3],H={};return W||(R=Xe(Re(R,q),q),_=Xe(Re(_,q),q)),q=q||{},!q.tolerant&&_.scheme?(H.scheme=_.scheme,H.userinfo=_.userinfo,H.host=_.host,H.port=_.port,H.path=Ae(_.path||""),H.query=_.query):(_.userinfo!==void 0||_.host!==void 0||_.port!==void 0?(H.userinfo=_.userinfo,H.host=_.host,H.port=_.port,H.path=Ae(_.path||""),H.query=_.query):(_.path?(_.path.charAt(0)==="/"?H.path=Ae(_.path):((R.userinfo!==void 0||R.host!==void 0||R.port!==void 0)&&!R.path?H.path="/"+_.path:R.path?H.path=R.path.slice(0,R.path.lastIndexOf("/")+1)+_.path:H.path=_.path,H.path=Ae(H.path)),H.query=_.query):(H.path=R.path,_.query!==void 0?H.query=_.query:H.query=R.query),H.userinfo=R.userinfo,H.host=R.host,H.port=R.port),H.scheme=R.scheme),H.fragment=_.fragment,H}function Nt(R,_,q){var W=u({scheme:"null"},q);return Re(It(Xe(R,W),Xe(_,W),W,!0),W)}function Cn(R,_){return typeof R=="string"?R=Re(Xe(R,_),_):o(R)==="object"&&(R=Xe(Re(R,_),_)),R}function w(R,_,q){return typeof R=="string"?R=Re(Xe(R,q),q):o(R)==="object"&&(R=Re(R,q)),typeof _=="string"?_=Re(Xe(_,q),q):o(_)==="object"&&(_=Re(_,q)),R===_}function h(R,_){return R&&R.toString().replace(!_||!_.iri?l.ESCAPE:p.ESCAPE,E)}function D(R,_){return R&&R.toString().replace(!_||!_.iri?l.PCT_ENCODED:p.PCT_ENCODED,N)}var P={scheme:"http",domainHost:!0,parse:function(_,q){return _.host||(_.error=_.error||"HTTP URIs must have a host."),_},serialize:function(_,q){var W=String(_.scheme).toLowerCase()==="https";return(_.port===(W?443:80)||_.port==="")&&(_.port=void 0),_.path||(_.path="/"),_}},G={scheme:"https",domainHost:P.domainHost,parse:P.parse,serialize:P.serialize};function J(R){return typeof R.secure=="boolean"?R.secure:String(R.scheme).toLowerCase()==="wss"}var K={scheme:"ws",domainHost:!0,parse:function(_,q){var W=_;return W.secure=J(W),W.resourceName=(W.path||"/")+(W.query?"?"+W.query:""),W.path=void 0,W.query=void 0,W},serialize:function(_,q){if((_.port===(J(_)?443:80)||_.port==="")&&(_.port=void 0),typeof _.secure=="boolean"&&(_.scheme=_.secure?"wss":"ws",_.secure=void 0),_.resourceName){var W=_.resourceName.split("?"),H=d(W,2),ue=H[0],le=H[1];_.path=ue&&ue!=="/"?ue:void 0,_.query=le,_.resourceName=void 0}return _.fragment=void 0,_}},be={scheme:"wss",domainHost:K.domainHost,parse:K.parse,serialize:K.serialize},st={},We="[A-Za-z0-9\\-\\.\\_\\~\\xA0-\\u200D\\u2010-\\u2029\\u202F-\\uD7FF\\uF900-\\uFDCF\\uFDF0-\\uFFEF]",Me="[0-9A-Fa-f]",Je=s(s("%[EFef]"+Me+"%"+Me+Me+"%"+Me+Me)+"|"+s("%[89A-Fa-f]"+Me+"%"+Me+Me)+"|"+s("%"+Me+Me)),$f="[A-Za-z0-9\\!\\$\\%\\'\\*\\+\\-\\^\\_\\`\\{\\|\\}\\~]",Bf="[\\!\\$\\%\\'\\(\\)\\*\\+\\,\\-\\.0-9\\<\\>A-Z\\x5E-\\x7E]",Rf=r(Bf,'[\\"\\\\]'),xf="[\\!\\$\\'\\(\\)\\*\\+\\,\\;\\:\\@]",qf=new RegExp(We,"g"),Ar=new RegExp(Je,"g"),Mf=new RegExp(r("[^]",$f,"[\\.]",'[\\"]',Rf),"g"),ic=new RegExp(r("[^]",We,xf),"g"),Lf=ic;function Ei(R){var _=N(R);return _.match(qf)?_:R}var ac={scheme:"mailto",parse:function(_,q){var W=_,H=W.to=W.path?W.path.split(","):[];if(W.path=void 0,W.query){for(var ue=!1,le={},xe=W.query.split("&"),Qe=0,pt=xe.length;Qe<pt;++Qe){var _e=xe[Qe].split("=");switch(_e[0]){case"to":for(var ze=_e[1].split(","),dt=0,Ee=ze.length;dt<Ee;++dt)H.push(ze[dt]);break;case"subject":W.subject=D(_e[1],q);break;case"body":W.body=D(_e[1],q);break;default:ue=!0,le[D(_e[0],q)]=D(_e[1],q);break}}ue&&(W.headers=le)}W.query=void 0;for(var ot=0,Dt=H.length;ot<Dt;++ot){var it=H[ot].split("@");if(it[0]=D(it[0]),q.unicodeSupport)it[1]=D(it[1],q).toLowerCase();else try{it[1]=$.toASCII(D(it[1],q).toLowerCase())}catch(Bn){W.error=W.error||"Email address's domain name can not be converted to ASCII via punycode: "+Bn}H[ot]=it.join("@")}return W},serialize:function(_,q){var W=_,H=a(_.to);if(H){for(var ue=0,le=H.length;ue<le;++ue){var xe=String(H[ue]),Qe=xe.lastIndexOf("@"),pt=xe.slice(0,Qe).replace(Ar,Ei).replace(Ar,i).replace(Mf,E),_e=xe.slice(Qe+1);try{_e=q.iri?$.toUnicode(_e):$.toASCII(D(_e,q).toLowerCase())}catch(ot){W.error=W.error||"Email address's domain name can not be converted to "+(q.iri?"Unicode":"ASCII")+" via punycode: "+ot}H[ue]=pt+"@"+_e}W.path=H.join(",")}var ze=_.headers=_.headers||{};_.subject&&(ze.subject=_.subject),_.body&&(ze.body=_.body);var dt=[];for(var Ee in ze)ze[Ee]!==st[Ee]&&dt.push(Ee.replace(Ar,Ei).replace(Ar,i).replace(ic,E)+"="+ze[Ee].replace(Ar,Ei).replace(Ar,i).replace(Lf,E));return dt.length&&(W.query=dt.join("&")),W}},jf=/^([^\:]+)\:(.*)/,uc={scheme:"urn",parse:function(_,q){var W=_.path&&_.path.match(jf),H=_;if(W){var ue=q.scheme||H.scheme||"urn",le=W[1].toLowerCase(),xe=W[2],Qe=ue+":"+(q.nid||le),pt=g[Qe];H.nid=le,H.nss=xe,H.path=void 0,pt&&(H=pt.parse(H,q))}else H.error=H.error||"URN can not be parsed.";return H},serialize:function(_,q){var W=q.scheme||_.scheme||"urn",H=_.nid,ue=W+":"+(q.nid||H),le=g[ue];le&&(_=le.serialize(_,q));var xe=_,Qe=_.nss;return xe.path=(H||q.nid)+":"+Qe,xe}},Gf=/^[0-9A-Fa-f]{8}(?:\-[0-9A-Fa-f]{4}){3}\-[0-9A-Fa-f]{12}$/,cc={scheme:"urn:uuid",parse:function(_,q){var W=_;return W.uuid=W.nss,W.nss=void 0,!q.tolerant&&(!W.uuid||!W.uuid.match(Gf))&&(W.error=W.error||"UUID is not valid."),W},serialize:function(_,q){var W=_;return W.nss=(_.uuid||"").toLowerCase(),W}};g[P.scheme]=P,g[G.scheme]=G,g[K.scheme]=K,g[be.scheme]=be,g[ac.scheme]=ac,g[uc.scheme]=uc,g[cc.scheme]=cc,n.SCHEMES=g,n.pctEncChar=E,n.pctDecChars=N,n.parse=Xe,n.removeDotSegments=Ae,n.serialize=Re,n.resolveComponents=It,n.resolve=Nt,n.normalize=Cn,n.equal=w,n.escapeComponent=h,n.unescapeComponent=D,Object.defineProperty(n,"__esModule",{value:!0})})})(Ca,Ca.exports);var m4=Ca.exports;Object.defineProperty(Tu,"__esModule",{value:!0});const Ld=m4;Ld.code='require("ajv/dist/runtime/uri").default';Tu.default=Ld;(function(t){Object.defineProperty(t,"__esModule",{value:!0}),t.CodeGen=t.Name=t.nil=t.stringify=t.str=t._=t.KeywordCxt=void 0;var e=cn;Object.defineProperty(t,"KeywordCxt",{enumerable:!0,get:function(){return e.KeywordCxt}});var n=Ie;Object.defineProperty(t,"_",{enumerable:!0,get:function(){return n._}}),Object.defineProperty(t,"str",{enumerable:!0,get:function(){return n.str}}),Object.defineProperty(t,"stringify",{enumerable:!0,get:function(){return n.stringify}}),Object.defineProperty(t,"nil",{enumerable:!0,get:function(){return n.nil}}),Object.defineProperty(t,"Name",{enumerable:!0,get:function(){return n.Name}}),Object.defineProperty(t,"CodeGen",{enumerable:!0,get:function(){return n.CodeGen}});const r=Us,s=Vs,o=Er,i=xt,a=Ie,u=wt,c=yt,l=se,p=h4,d=Tu,f=(Z,x)=>new RegExp(Z,x);f.code="new RegExp";const S=["removeAdditional","useDefaults","coerceTypes"],b=new Set(["validate","serialize","parse","wrapper","root","schema","keyword","pattern","formats","validate$data","func","obj","Error"]),F={errorDataPath:"",format:"`validateFormats: false` can be used instead.",nullable:'"nullable" keyword is supported by default.',jsonPointers:"Deprecated jsPropertySyntax can be used instead.",extendRefs:"Deprecated ignoreKeywordsWithRef can be used instead.",missingRefs:"Pass empty schema with $id that should be ignored to ajv.addSchema.",processCode:"Use option `code: {process: (code, schemaEnv: object) => string}`",sourceCode:"Use option `code: {source: true}`",strictDefaults:"It is default now, see option `strict`.",strictKeywords:"It is default now, see option `strict`.",uniqueItems:'"uniqueItems" keyword is always validated.',unknownFormats:"Disable strict mode or pass `true` to `ajv.addFormat` (or `formats` option).",cache:"Map is used as cache, schema object as key.",serialize:"Map is used as cache, schema object as key.",ajvErrors:"It is default now."},y={ignoreKeywordsWithRef:"",jsPropertySyntax:"",unicode:'"minLength"/"maxLength" account for unicode characters by default.'},T=200;function O(Z){var x,v,C,m,A,$,g,E,N,k,U,V,Y,Le,rt,Xe,Ue,ye,He,Ve,je,Ae,Re,It,Nt;const Cn=Z.strict,w=(x=Z.code)===null||x===void 0?void 0:x.optimize,h=w===!0||w===void 0?1:w||0,D=(C=(v=Z.code)===null||v===void 0?void 0:v.regExp)!==null&&C!==void 0?C:f,P=(m=Z.uriResolver)!==null&&m!==void 0?m:d.default;return{strictSchema:($=(A=Z.strictSchema)!==null&&A!==void 0?A:Cn)!==null&&$!==void 0?$:!0,strictNumbers:(E=(g=Z.strictNumbers)!==null&&g!==void 0?g:Cn)!==null&&E!==void 0?E:!0,strictTypes:(k=(N=Z.strictTypes)!==null&&N!==void 0?N:Cn)!==null&&k!==void 0?k:"log",strictTuples:(V=(U=Z.strictTuples)!==null&&U!==void 0?U:Cn)!==null&&V!==void 0?V:"log",strictRequired:(Le=(Y=Z.strictRequired)!==null&&Y!==void 0?Y:Cn)!==null&&Le!==void 0?Le:!1,code:Z.code?{...Z.code,optimize:h,regExp:D}:{optimize:h,regExp:D},loopRequired:(rt=Z.loopRequired)!==null&&rt!==void 0?rt:T,loopEnum:(Xe=Z.loopEnum)!==null&&Xe!==void 0?Xe:T,meta:(Ue=Z.meta)!==null&&Ue!==void 0?Ue:!0,messages:(ye=Z.messages)!==null&&ye!==void 0?ye:!0,inlineRefs:(He=Z.inlineRefs)!==null&&He!==void 0?He:!0,schemaId:(Ve=Z.schemaId)!==null&&Ve!==void 0?Ve:"$id",addUsedSchema:(je=Z.addUsedSchema)!==null&&je!==void 0?je:!0,validateSchema:(Ae=Z.validateSchema)!==null&&Ae!==void 0?Ae:!0,validateFormats:(Re=Z.validateFormats)!==null&&Re!==void 0?Re:!0,unicodeRegExp:(It=Z.unicodeRegExp)!==null&&It!==void 0?It:!0,int32range:(Nt=Z.int32range)!==null&&Nt!==void 0?Nt:!0,uriResolver:P}}class j{constructor(x={}){this.schemas={},this.refs={},this.formats={},this._compilations=new Set,this._loading={},this._cache=new Map,x=this.opts={...x,...O(x)};const{es5:v,lines:C}=this.opts.code;this.scope=new a.ValueScope({scope:{},prefixes:b,es5:v,lines:C}),this.logger=re(x.logger);const m=x.validateFormats;x.validateFormats=!1,this.RULES=(0,o.getRules)(),M.call(this,F,x,"NOT SUPPORTED"),M.call(this,y,x,"DEPRECATED","warn"),this._metaOpts=pe.call(this),x.formats&&Ne.call(this),this._addVocabularies(),this._addDefaultMetaSchema(),x.keywords&&L.call(this,x.keywords),typeof x.meta=="object"&&this.addMetaSchema(x.meta),ne.call(this),x.validateFormats=m}_addVocabularies(){this.addKeyword("$async")}_addDefaultMetaSchema(){const{$data:x,meta:v,schemaId:C}=this.opts;let m=p;C==="id"&&(m={...p},m.id=m.$id,delete m.$id),v&&x&&this.addMetaSchema(m,m[C],!1)}defaultMeta(){const{meta:x,schemaId:v}=this.opts;return this.opts.defaultMeta=typeof x=="object"?x[v]||x:void 0}validate(x,v){let C;if(typeof x=="string"){if(C=this.getSchema(x),!C)throw new Error(`no schema with key or ref "${x}"`)}else C=this.compile(x);const m=C(v);return"$async"in C||(this.errors=C.errors),m}compile(x,v){const C=this._addSchema(x,v);return C.validate||this._compileSchemaEnv(C)}compileAsync(x,v){if(typeof this.opts.loadSchema!="function")throw new Error("options.loadSchema should be a function");const{loadSchema:C}=this.opts;return m.call(this,x,v);async function m(k,U){await A.call(this,k.$schema);const V=this._addSchema(k,U);return V.validate||$.call(this,V)}async function A(k){k&&!this.getSchema(k)&&await m.call(this,{$ref:k},!0)}async function $(k){try{return this._compileSchemaEnv(k)}catch(U){if(!(U instanceof s.default))throw U;return g.call(this,U),await E.call(this,U.missingSchema),$.call(this,k)}}function g({missingSchema:k,missingRef:U}){if(this.refs[k])throw new Error(`AnySchema ${k} is loaded but ${U} cannot be resolved`)}async function E(k){const U=await N.call(this,k);this.refs[k]||await A.call(this,U.$schema),this.refs[k]||this.addSchema(U,k,v)}async function N(k){const U=this._loading[k];if(U)return U;try{return await(this._loading[k]=C(k))}finally{delete this._loading[k]}}}addSchema(x,v,C,m=this.opts.validateSchema){if(Array.isArray(x)){for(const $ of x)this.addSchema($,void 0,C,m);return this}let A;if(typeof x=="object"){const{schemaId:$}=this.opts;if(A=x[$],A!==void 0&&typeof A!="string")throw new Error(`schema ${$} must be string`)}return v=(0,u.normalizeId)(v||A),this._checkUnique(v),this.schemas[v]=this._addSchema(x,C,v,m,!0),this}addMetaSchema(x,v,C=this.opts.validateSchema){return this.addSchema(x,v,!0,C),this}validateSchema(x,v){if(typeof x=="boolean")return!0;let C;if(C=x.$schema,C!==void 0&&typeof C!="string")throw new Error("$schema must be a string");if(C=C||this.opts.defaultMeta||this.defaultMeta(),!C)return this.logger.warn("meta-schema not available"),this.errors=null,!0;const m=this.validate(C,x);if(!m&&v){const A="schema is invalid: "+this.errorsText();if(this.opts.validateSchema==="log")this.logger.error(A);else throw new Error(A)}return m}getSchema(x){let v;for(;typeof(v=ee.call(this,x))=="string";)x=v;if(v===void 0){const{schemaId:C}=this.opts,m=new i.SchemaEnv({schema:{},schemaId:C});if(v=i.resolveSchema.call(this,m,x),!v)return;this.refs[x]=v}return v.validate||this._compileSchemaEnv(v)}removeSchema(x){if(x instanceof RegExp)return this._removeAllSchemas(this.schemas,x),this._removeAllSchemas(this.refs,x),this;switch(typeof x){case"undefined":return this._removeAllSchemas(this.schemas),this._removeAllSchemas(this.refs),this._cache.clear(),this;case"string":{const v=ee.call(this,x);return typeof v=="object"&&this._cache.delete(v.schema),delete this.schemas[x],delete this.refs[x],this}case"object":{const v=x;this._cache.delete(v);let C=x[this.opts.schemaId];return C&&(C=(0,u.normalizeId)(C),delete this.schemas[C],delete this.refs[C]),this}default:throw new Error("ajv.removeSchema: invalid parameter")}}addVocabulary(x){for(const v of x)this.addKeyword(v);return this}addKeyword(x,v){let C;if(typeof x=="string")C=x,typeof v=="object"&&(this.logger.warn("these parameters are deprecated, see docs for addKeyword"),v.keyword=C);else if(typeof x=="object"&&v===void 0){if(v=x,C=v.keyword,Array.isArray(C)&&!C.length)throw new Error("addKeywords: keyword must be string or non-empty array")}else throw new Error("invalid addKeywords parameters");if(Te.call(this,C,v),!v)return(0,l.eachItem)(C,A=>Ge.call(this,A)),this;ce.call(this,v);const m={...v,type:(0,c.getJSONTypes)(v.type),schemaType:(0,c.getJSONTypes)(v.schemaType)};return(0,l.eachItem)(C,m.type.length===0?A=>Ge.call(this,A,m):A=>m.type.forEach($=>Ge.call(this,A,m,$))),this}getKeyword(x){const v=this.RULES.all[x];return typeof v=="object"?v.definition:!!v}removeKeyword(x){const{RULES:v}=this;delete v.keywords[x],delete v.all[x];for(const C of v.rules){const m=C.rules.findIndex(A=>A.keyword===x);m>=0&&C.rules.splice(m,1)}return this}addFormat(x,v){return typeof v=="string"&&(v=new RegExp(v)),this.formats[x]=v,this}errorsText(x=this.errors,{separator:v=", ",dataVar:C="data"}={}){return!x||x.length===0?"No errors":x.map(m=>`${C}${m.instancePath} ${m.message}`).reduce((m,A)=>m+v+A)}$dataMetaSchema(x,v){const C=this.RULES.all;x=JSON.parse(JSON.stringify(x));for(const m of v){const A=m.split("/").slice(1);let $=x;for(const g of A)$=$[g];for(const g in C){const E=C[g];if(typeof E!="object")continue;const{$data:N}=E.definition,k=$[g];N&&k&&($[g]=ke(k))}}return x}_removeAllSchemas(x,v){for(const C in x){const m=x[C];(!v||v.test(C))&&(typeof m=="string"?delete x[C]:m&&!m.meta&&(this._cache.delete(m.schema),delete x[C]))}}_addSchema(x,v,C,m=this.opts.validateSchema,A=this.opts.addUsedSchema){let $;const{schemaId:g}=this.opts;if(typeof x=="object")$=x[g];else{if(this.opts.jtd)throw new Error("schema must be object");if(typeof x!="boolean")throw new Error("schema must be object or boolean")}let E=this._cache.get(x);if(E!==void 0)return E;C=(0,u.normalizeId)($||C);const N=u.getSchemaRefs.call(this,x,C);return E=new i.SchemaEnv({schema:x,schemaId:g,meta:v,baseId:C,localRefs:N}),this._cache.set(E.schema,E),A&&!C.startsWith("#")&&(C&&this._checkUnique(C),this.refs[C]=E),m&&this.validateSchema(x,!0),E}_checkUnique(x){if(this.schemas[x]||this.refs[x])throw new Error(`schema with key or id "${x}" already exists`)}_compileSchemaEnv(x){if(x.meta?this._compileMetaSchema(x):i.compileSchema.call(this,x),!x.validate)throw new Error("ajv implementation error");return x.validate}_compileMetaSchema(x){const v=this.opts;this.opts=this._metaOpts;try{i.compileSchema.call(this,x)}finally{this.opts=v}}}j.ValidationError=r.default,j.MissingRefError=s.default,t.default=j;function M(Z,x,v,C="error"){for(const m in Z){const A=m;A in x&&this.logger[C](`${v}: option ${m}. ${Z[A]}`)}}function ee(Z){return Z=(0,u.normalizeId)(Z),this.schemas[Z]||this.refs[Z]}function ne(){const Z=this.opts.schemas;if(Z)if(Array.isArray(Z))this.addSchema(Z);else for(const x in Z)this.addSchema(Z[x],x)}function Ne(){for(const Z in this.opts.formats){const x=this.opts.formats[Z];x&&this.addFormat(Z,x)}}function L(Z){if(Array.isArray(Z)){this.addVocabulary(Z);return}this.logger.warn("keywords option as map is deprecated, pass array");for(const x in Z){const v=Z[x];v.keyword||(v.keyword=x),this.addKeyword(v)}}function pe(){const Z={...this.opts};for(const x of S)delete Z[x];return Z}const de={log(){},warn(){},error(){}};function re(Z){if(Z===!1)return de;if(Z===void 0)return console;if(Z.log&&Z.warn&&Z.error)return Z;throw new Error("logger must implement log, warn and error methods")}const he=/^[a-z_$][a-z0-9_$:-]*$/i;function Te(Z,x){const{RULES:v}=this;if((0,l.eachItem)(Z,C=>{if(v.keywords[C])throw new Error(`Keyword ${C} is already defined`);if(!he.test(C))throw new Error(`Keyword ${C} has invalid name`)}),!!x&&x.$data&&!("code"in x||"validate"in x))throw new Error('$data keyword must have "code" or "validate" function')}function Ge(Z,x,v){var C;const m=x==null?void 0:x.post;if(v&&m)throw new Error('keyword with "post" flag cannot have "type"');const{RULES:A}=this;let $=m?A.post:A.rules.find(({type:E})=>E===v);if($||($={type:v,rules:[]},A.rules.push($)),A.keywords[Z]=!0,!x)return;const g={keyword:Z,definition:{...x,type:(0,c.getJSONTypes)(x.type),schemaType:(0,c.getJSONTypes)(x.schemaType)}};x.before?qe.call(this,$,g,x.before):$.rules.push(g),A.all[Z]=g,(C=x.implements)===null||C===void 0||C.forEach(E=>this.addKeyword(E))}function qe(Z,x,v){const C=Z.rules.findIndex(m=>m.keyword===v);C>=0?Z.rules.splice(C,0,x):(Z.rules.push(x),this.logger.warn(`rule ${v} is not defined`))}function ce(Z){let{metaSchema:x}=Z;x!==void 0&&(Z.$data&&this.opts.$data&&(x=ke(x)),Z.validateSchema=this.compile(x,!0))}const Ze={$ref:"https://raw.githubusercontent.com/ajv-validator/ajv/master/lib/refs/data.json#"};function ke(Z){return{anyOf:[Z,Ze]}}})(ad);var wu={},Fu={},Iu={};Object.defineProperty(Iu,"__esModule",{value:!0});const D4={keyword:"id",code(){throw new Error('NOT SUPPORTED: keyword "id", use "$id" for schema ID')}};Iu.default=D4;var yr={};Object.defineProperty(yr,"__esModule",{value:!0});yr.callRef=yr.getValidate=void 0;const S4=Vs,ll=we,Bt=Ie,kr=bn,pl=xt,oo=se,E4={keyword:"$ref",schemaType:"string",code(t){const{gen:e,schema:n,it:r}=t,{baseId:s,schemaEnv:o,validateName:i,opts:a,self:u}=r,{root:c}=o;if((n==="#"||n==="#/")&&s===c.baseId)return p();const l=pl.resolveRef.call(u,c,s,n);if(l===void 0)throw new S4.default(r.opts.uriResolver,s,n);if(l instanceof pl.SchemaEnv)return d(l);return f(l);function p(){if(o===c)return go(t,i,o,o.$async);const S=e.scopeValue("root",{ref:c});return go(t,(0,Bt._)`${S}.validate`,c,c.$async)}function d(S){const b=jd(t,S);go(t,b,S,S.$async)}function f(S){const b=e.scopeValue("schema",a.code.source===!0?{ref:S,code:(0,Bt.stringify)(S)}:{ref:S}),F=e.name("valid"),y=t.subschema({schema:S,dataTypes:[],schemaPath:Bt.nil,topSchemaRef:b,errSchemaPath:n},F);t.mergeEvaluated(y),t.ok(F)}}};function jd(t,e){const{gen:n}=t;return e.validate?n.scopeValue("validate",{ref:e.validate}):(0,Bt._)`${n.scopeValue("wrapper",{ref:e})}.validate`}yr.getValidate=jd;function go(t,e,n,r){const{gen:s,it:o}=t,{allErrors:i,schemaEnv:a,opts:u}=o,c=u.passContext?kr.default.this:Bt.nil;r?l():p();function l(){if(!a.$async)throw new Error("async schema referenced by sync schema");const S=s.let("valid");s.try(()=>{s.code((0,Bt._)`await ${(0,ll.callValidateCode)(t,e,c)}`),f(e),i||s.assign(S,!0)},b=>{s.if((0,Bt._)`!(${b} instanceof ${o.ValidationError})`,()=>s.throw(b)),d(b),i||s.assign(S,!1)}),t.ok(S)}function p(){t.result((0,ll.callValidateCode)(t,e,c),()=>f(e),()=>d(e))}function d(S){const b=(0,Bt._)`${S}.errors`;s.assign(kr.default.vErrors,(0,Bt._)`${kr.default.vErrors} === null ? ${b} : ${kr.default.vErrors}.concat(${b})`),s.assign(kr.default.errors,(0,Bt._)`${kr.default.vErrors}.length`)}function f(S){var b;if(!o.opts.unevaluated)return;const F=(b=n==null?void 0:n.validate)===null||b===void 0?void 0:b.evaluated;if(o.props!==!0)if(F&&!F.dynamicProps)F.props!==void 0&&(o.props=oo.mergeEvaluated.props(s,F.props,o.props));else{const y=s.var("props",(0,Bt._)`${S}.evaluated.props`);o.props=oo.mergeEvaluated.props(s,y,o.props,Bt.Name)}if(o.items!==!0)if(F&&!F.dynamicItems)F.items!==void 0&&(o.items=oo.mergeEvaluated.items(s,F.items,o.items));else{const y=s.var("items",(0,Bt._)`${S}.evaluated.items`);o.items=oo.mergeEvaluated.items(s,y,o.items,Bt.Name)}}}yr.callRef=go;yr.default=E4;Object.defineProperty(Fu,"__esModule",{value:!0});const y4=Iu,g4=yr,v4=["$schema","$id","$defs","$vocabulary",{keyword:"$comment"},"definitions",y4.default,g4.default];Fu.default=v4;var ku={},Pu={};Object.defineProperty(Pu,"__esModule",{value:!0});const Jo=Ie,qn=Jo.operators,Ho={maximum:{okStr:"<=",ok:qn.LTE,fail:qn.GT},minimum:{okStr:">=",ok:qn.GTE,fail:qn.LT},exclusiveMaximum:{okStr:"<",ok:qn.LT,fail:qn.GTE},exclusiveMinimum:{okStr:">",ok:qn.GT,fail:qn.LTE}},A4={message:({keyword:t,schemaCode:e})=>(0,Jo.str)`must be ${Ho[t].okStr} ${e}`,params:({keyword:t,schemaCode:e})=>(0,Jo._)`{comparison: ${Ho[t].okStr}, limit: ${e}}`},b4={keyword:Object.keys(Ho),type:"number",schemaType:"number",$data:!0,error:A4,code(t){const{keyword:e,data:n,schemaCode:r}=t;t.fail$data((0,Jo._)`${n} ${Ho[e].fail} ${r} || isNaN(${n})`)}};Pu.default=b4;var Nu={};Object.defineProperty(Nu,"__esModule",{value:!0});const gs=Ie,C4={message:({schemaCode:t})=>(0,gs.str)`must be multiple of ${t}`,params:({schemaCode:t})=>(0,gs._)`{multipleOf: ${t}}`},T4={keyword:"multipleOf",type:"number",schemaType:"number",$data:!0,error:C4,code(t){const{gen:e,data:n,schemaCode:r,it:s}=t,o=s.opts.multipleOfPrecision,i=e.let("res"),a=o?(0,gs._)`Math.abs(Math.round(${i}) - ${i}) > 1e-${o}`:(0,gs._)`${i} !== parseInt(${i})`;t.fail$data((0,gs._)`(${r} === 0 || (${i} = ${n}/${r}, ${a}))`)}};Nu.default=T4;var _u={},Ou={};Object.defineProperty(Ou,"__esModule",{value:!0});function Gd(t){const e=t.length;let n=0,r=0,s;for(;r<e;)n++,s=t.charCodeAt(r++),s>=55296&&s<=56319&&r<e&&(s=t.charCodeAt(r),(s&64512)===56320&&r++);return n}Ou.default=Gd;Gd.code='require("ajv/dist/runtime/ucs2length").default';Object.defineProperty(_u,"__esModule",{value:!0});const ar=Ie,w4=se,F4=Ou,I4={message({keyword:t,schemaCode:e}){const n=t==="maxLength"?"more":"fewer";return(0,ar.str)`must NOT have ${n} than ${e} characters`},params:({schemaCode:t})=>(0,ar._)`{limit: ${t}}`},k4={keyword:["maxLength","minLength"],type:"string",schemaType:"number",$data:!0,error:I4,code(t){const{keyword:e,data:n,schemaCode:r,it:s}=t,o=e==="maxLength"?ar.operators.GT:ar.operators.LT,i=s.opts.unicode===!1?(0,ar._)`${n}.length`:(0,ar._)`${(0,w4.useFunc)(t.gen,F4.default)}(${n})`;t.fail$data((0,ar._)`${i} ${o} ${r}`)}};_u.default=k4;var $u={};Object.defineProperty($u,"__esModule",{value:!0});const P4=we,Wo=Ie,N4={message:({schemaCode:t})=>(0,Wo.str)`must match pattern "${t}"`,params:({schemaCode:t})=>(0,Wo._)`{pattern: ${t}}`},_4={keyword:"pattern",type:"string",schemaType:"string",$data:!0,error:N4,code(t){const{data:e,$data:n,schema:r,schemaCode:s,it:o}=t,i=o.opts.unicodeRegExp?"u":"",a=n?(0,Wo._)`(new RegExp(${s}, ${i}))`:(0,P4.usePattern)(t,r);t.fail$data((0,Wo._)`!${a}.test(${e})`)}};$u.default=_4;var Bu={};Object.defineProperty(Bu,"__esModule",{value:!0});const vs=Ie,O4={message({keyword:t,schemaCode:e}){const n=t==="maxProperties"?"more":"fewer";return(0,vs.str)`must NOT have ${n} than ${e} properties`},params:({schemaCode:t})=>(0,vs._)`{limit: ${t}}`},$4={keyword:["maxProperties","minProperties"],type:"object",schemaType:"number",$data:!0,error:O4,code(t){const{keyword:e,data:n,schemaCode:r}=t,s=e==="maxProperties"?vs.operators.GT:vs.operators.LT;t.fail$data((0,vs._)`Object.keys(${n}).length ${s} ${r}`)}};Bu.default=$4;var Ru={};Object.defineProperty(Ru,"__esModule",{value:!0});const as=we,As=Ie,B4=se,R4={message:({params:{missingProperty:t}})=>(0,As.str)`must have required property '${t}'`,params:({params:{missingProperty:t}})=>(0,As._)`{missingProperty: ${t}}`},x4={keyword:"required",type:"object",schemaType:"array",$data:!0,error:R4,code(t){const{gen:e,schema:n,schemaCode:r,data:s,$data:o,it:i}=t,{opts:a}=i;if(!o&&n.length===0)return;const u=n.length>=a.loopRequired;if(i.allErrors?c():l(),a.strictRequired){const f=t.parentSchema.properties,{definedProperties:S}=t.it;for(const b of n)if((f==null?void 0:f[b])===void 0&&!S.has(b)){const F=i.schemaEnv.baseId+i.errSchemaPath,y=`required property "${b}" is not defined at "${F}" (strictRequired)`;(0,B4.checkStrictMode)(i,y,i.opts.strictRequired)}}function c(){if(u||o)t.block$data(As.nil,p);else for(const f of n)(0,as.checkReportMissingProp)(t,f)}function l(){const f=e.let("missing");if(u||o){const S=e.let("valid",!0);t.block$data(S,()=>d(f,S)),t.ok(S)}else e.if((0,as.checkMissingProp)(t,n,f)),(0,as.reportMissingProp)(t,f),e.else()}function p(){e.forOf("prop",r,f=>{t.setParams({missingProperty:f}),e.if((0,as.noPropertyInData)(e,s,f,a.ownProperties),()=>t.error())})}function d(f,S){t.setParams({missingProperty:f}),e.forOf(f,r,()=>{e.assign(S,(0,as.propertyInData)(e,s,f,a.ownProperties)),e.if((0,As.not)(S),()=>{t.error(),e.break()})},As.nil)}}};Ru.default=x4;var xu={};Object.defineProperty(xu,"__esModule",{value:!0});const bs=Ie,q4={message({keyword:t,schemaCode:e}){const n=t==="maxItems"?"more":"fewer";return(0,bs.str)`must NOT have ${n} than ${e} items`},params:({schemaCode:t})=>(0,bs._)`{limit: ${t}}`},M4={keyword:["maxItems","minItems"],type:"array",schemaType:"number",$data:!0,error:q4,code(t){const{keyword:e,data:n,schemaCode:r}=t,s=e==="maxItems"?bs.operators.GT:bs.operators.LT;t.fail$data((0,bs._)`${n}.length ${s} ${r}`)}};xu.default=M4;var qu={},Js={};Object.defineProperty(Js,"__esModule",{value:!0});const Ud=bd;Ud.code='require("ajv/dist/runtime/equal").default';Js.default=Ud;Object.defineProperty(qu,"__esModule",{value:!0});const Oi=yt,Tt=Ie,L4=se,j4=Js,G4={message:({params:{i:t,j:e}})=>(0,Tt.str)`must NOT have duplicate items (items ## ${e} and ${t} are identical)`,params:({params:{i:t,j:e}})=>(0,Tt._)`{i: ${t}, j: ${e}}`},U4={keyword:"uniqueItems",type:"array",schemaType:"boolean",$data:!0,error:G4,code(t){const{gen:e,data:n,$data:r,schema:s,parentSchema:o,schemaCode:i,it:a}=t;if(!r&&!s)return;const u=e.let("valid"),c=o.items?(0,Oi.getSchemaTypes)(o.items):[];t.block$data(u,l,(0,Tt._)`${i} === false`),t.ok(u);function l(){const S=e.let("i",(0,Tt._)`${n}.length`),b=e.let("j");t.setParams({i:S,j:b}),e.assign(u,!0),e.if((0,Tt._)`${S} > 1`,()=>(p()?d:f)(S,b))}function p(){return c.length>0&&!c.some(S=>S==="object"||S==="array")}function d(S,b){const F=e.name("item"),y=(0,Oi.checkDataTypes)(c,F,a.opts.strictNumbers,Oi.DataType.Wrong),T=e.const("indices",(0,Tt._)`{}`);e.for((0,Tt._)`;${S}--;`,()=>{e.let(F,(0,Tt._)`${n}[${S}]`),e.if(y,(0,Tt._)`continue`),c.length>1&&e.if((0,Tt._)`typeof ${F} == "string"`,(0,Tt._)`${F} += "_"`),e.if((0,Tt._)`typeof ${T}[${F}] == "number"`,()=>{e.assign(b,(0,Tt._)`${T}[${F}]`),t.error(),e.assign(u,!1).break()}).code((0,Tt._)`${T}[${F}] = ${S}`)})}function f(S,b){const F=(0,L4.useFunc)(e,j4.default),y=e.name("outer");e.label(y).for((0,Tt._)`;${S}--;`,()=>e.for((0,Tt._)`${b} = ${S}; ${b}--;`,()=>e.if((0,Tt._)`${F}(${n}[${S}], ${n}[${b}])`,()=>{t.error(),e.assign(u,!1).break(y)})))}}};qu.default=U4;var Mu={};Object.defineProperty(Mu,"__esModule",{value:!0});const Ta=Ie,V4=se,J4=Js,H4={message:"must be equal to constant",params:({schemaCode:t})=>(0,Ta._)`{allowedValue: ${t}}`},W4={keyword:"const",$data:!0,error:H4,code(t){const{gen:e,data:n,$data:r,schemaCode:s,schema:o}=t;r||o&&typeof o=="object"?t.fail$data((0,Ta._)`!${(0,V4.useFunc)(e,J4.default)}(${n}, ${s})`):t.fail((0,Ta._)`${o} !== ${n}`)}};Mu.default=W4;var Lu={};Object.defineProperty(Lu,"__esModule",{value:!0});const fs=Ie,K4=se,X4=Js,z4={message:"must be equal to one of the allowed values",params:({schemaCode:t})=>(0,fs._)`{allowedValues: ${t}}`},Y4={keyword:"enum",schemaType:"array",$data:!0,error:z4,code(t){const{gen:e,data:n,$data:r,schema:s,schemaCode:o,it:i}=t;if(!r&&s.length===0)throw new Error("enum must have non-empty array");const a=s.length>=i.opts.loopEnum;let u;const c=()=>u??(u=(0,K4.useFunc)(e,X4.default));let l;if(a||r)l=e.let("valid"),t.block$data(l,p);else{if(!Array.isArray(s))throw new Error("ajv implementation error");const f=e.const("vSchema",o);l=(0,fs.or)(...s.map((S,b)=>d(f,b)))}t.pass(l);function p(){e.assign(l,!1),e.forOf("v",o,f=>e.if((0,fs._)`${c()}(${n}, ${f})`,()=>e.assign(l,!0).break()))}function d(f,S){const b=s[S];return typeof b=="object"&&b!==null?(0,fs._)`${c()}(${n}, ${f}[${S}])`:(0,fs._)`${n} === ${b}`}}};Lu.default=Y4;Object.defineProperty(ku,"__esModule",{value:!0});const Z4=Pu,Q4=Nu,eg=_u,tg=$u,ng=Bu,rg=Ru,sg=xu,og=qu,ig=Mu,ag=Lu,ug=[Z4.default,Q4.default,eg.default,tg.default,ng.default,rg.default,sg.default,og.default,{keyword:"type",schemaType:["string","array"]},{keyword:"nullable",schemaType:"boolean"},ig.default,ag.default];ku.default=ug;var ju={},ns={};Object.defineProperty(ns,"__esModule",{value:!0});ns.validateAdditionalItems=void 0;const ur=Ie,wa=se,cg={message:({params:{len:t}})=>(0,ur.str)`must NOT have more than ${t} items`,params:({params:{len:t}})=>(0,ur._)`{limit: ${t}}`},lg={keyword:"additionalItems",type:"array",schemaType:["boolean","object"],before:"uniqueItems",error:cg,code(t){const{parentSchema:e,it:n}=t,{items:r}=e;if(!Array.isArray(r)){(0,wa.checkStrictMode)(n,'"additionalItems" is ignored when "items" is not an array of schemas');return}Vd(t,r)}};function Vd(t,e){const{gen:n,schema:r,data:s,keyword:o,it:i}=t;i.items=!0;const a=n.const("len",(0,ur._)`${s}.length`);if(r===!1)t.setParams({len:e.length}),t.pass((0,ur._)`${a} <= ${e.length}`);else if(typeof r=="object"&&!(0,wa.alwaysValidSchema)(i,r)){const c=n.var("valid",(0,ur._)`${a} <= ${e.length}`);n.if((0,ur.not)(c),()=>u(c)),t.ok(c)}function u(c){n.forRange("i",e.length,a,l=>{t.subschema({keyword:o,dataProp:l,dataPropType:wa.Type.Num},c),i.allErrors||n.if((0,ur.not)(c),()=>n.break())})}}ns.validateAdditionalItems=Vd;ns.default=lg;var Gu={},rs={};Object.defineProperty(rs,"__esModule",{value:!0});rs.validateTuple=void 0;const dl=Ie,vo=se,pg=we,dg={keyword:"items",type:"array",schemaType:["object","array","boolean"],before:"uniqueItems",code(t){const{schema:e,it:n}=t;if(Array.isArray(e))return Jd(t,"additionalItems",e);n.items=!0,!(0,vo.alwaysValidSchema)(n,e)&&t.ok((0,pg.validateArray)(t))}};function Jd(t,e,n=t.schema){const{gen:r,parentSchema:s,data:o,keyword:i,it:a}=t;l(s),a.opts.unevaluated&&n.length&&a.items!==!0&&(a.items=vo.mergeEvaluated.items(r,n.length,a.items));const u=r.name("valid"),c=r.const("len",(0,dl._)`${o}.length`);n.forEach((p,d)=>{(0,vo.alwaysValidSchema)(a,p)||(r.if((0,dl._)`${c} > ${d}`,()=>t.subschema({keyword:i,schemaProp:d,dataProp:d},u)),t.ok(u))});function l(p){const{opts:d,errSchemaPath:f}=a,S=n.length,b=S===p.minItems&&(S===p.maxItems||p[e]===!1);if(d.strictTuples&&!b){const F=`"${i}" is ${S}-tuple, but minItems or maxItems/${e} are not specified or different at path "${f}"`;(0,vo.checkStrictMode)(a,F,d.strictTuples)}}}rs.validateTuple=Jd;rs.default=dg;Object.defineProperty(Gu,"__esModule",{value:!0});const fg=rs,hg={keyword:"prefixItems",type:"array",schemaType:["array"],before:"uniqueItems",code:t=>(0,fg.validateTuple)(t,"items")};Gu.default=hg;var Uu={};Object.defineProperty(Uu,"__esModule",{value:!0});const fl=Ie,mg=se,Dg=we,Sg=ns,Eg={message:({params:{len:t}})=>(0,fl.str)`must NOT have more than ${t} items`,params:({params:{len:t}})=>(0,fl._)`{limit: ${t}}`},yg={keyword:"items",type:"array",schemaType:["object","boolean"],before:"uniqueItems",error:Eg,code(t){const{schema:e,parentSchema:n,it:r}=t,{prefixItems:s}=n;r.items=!0,!(0,mg.alwaysValidSchema)(r,e)&&(s?(0,Sg.validateAdditionalItems)(t,s):t.ok((0,Dg.validateArray)(t)))}};Uu.default=yg;var Vu={};Object.defineProperty(Vu,"__esModule",{value:!0});const Kt=Ie,io=se,gg={message:({params:{min:t,max:e}})=>e===void 0?(0,Kt.str)`must contain at least ${t} valid item(s)`:(0,Kt.str)`must contain at least ${t} and no more than ${e} valid item(s)`,params:({params:{min:t,max:e}})=>e===void 0?(0,Kt._)`{minContains: ${t}}`:(0,Kt._)`{minContains: ${t}, maxContains: ${e}}`},vg={keyword:"contains",type:"array",schemaType:["object","boolean"],before:"uniqueItems",trackErrors:!0,error:gg,code(t){const{gen:e,schema:n,parentSchema:r,data:s,it:o}=t;let i,a;const{minContains:u,maxContains:c}=r;o.opts.next?(i=u===void 0?1:u,a=c):i=1;const l=e.const("len",(0,Kt._)`${s}.length`);if(t.setParams({min:i,max:a}),a===void 0&&i===0){(0,io.checkStrictMode)(o,'"minContains" == 0 without "maxContains": "contains" keyword ignored');return}if(a!==void 0&&i>a){(0,io.checkStrictMode)(o,'"minContains" > "maxContains" is always invalid'),t.fail();return}if((0,io.alwaysValidSchema)(o,n)){let b=(0,Kt._)`${l} >= ${i}`;a!==void 0&&(b=(0,Kt._)`${b} && ${l} <= ${a}`),t.pass(b);return}o.items=!0;const p=e.name("valid");a===void 0&&i===1?f(p,()=>e.if(p,()=>e.break())):i===0?(e.let(p,!0),a!==void 0&&e.if((0,Kt._)`${s}.length > 0`,d)):(e.let(p,!1),d()),t.result(p,()=>t.reset());function d(){const b=e.name("_valid"),F=e.let("count",0);f(b,()=>e.if(b,()=>S(F)))}function f(b,F){e.forRange("i",0,l,y=>{t.subschema({keyword:"contains",dataProp:y,dataPropType:io.Type.Num,compositeRule:!0},b),F()})}function S(b){e.code((0,Kt._)`${b}++`),a===void 0?e.if((0,Kt._)`${b} >= ${i}`,()=>e.assign(p,!0).break()):(e.if((0,Kt._)`${b} > ${a}`,()=>e.assign(p,!1).break()),i===1?e.assign(p,!0):e.if((0,Kt._)`${b} >= ${i}`,()=>e.assign(p,!0)))}}};Vu.default=vg;var Hd={};(function(t){Object.defineProperty(t,"__esModule",{value:!0}),t.validateSchemaDeps=t.validatePropertyDeps=t.error=void 0;const e=Ie,n=se,r=we;t.error={message:({params:{property:u,depsCount:c,deps:l}})=>{const p=c===1?"property":"properties";return(0,e.str)`must have ${p} ${l} when property ${u} is present`},params:({params:{property:u,depsCount:c,deps:l,missingProperty:p}})=>(0,e._)`{property: ${u},
    missingProperty: ${p},
    depsCount: ${c},
    deps: ${l}}`};const s={keyword:"dependencies",type:"object",schemaType:"object",error:t.error,code(u){const[c,l]=o(u);i(u,c),a(u,l)}};function o({schema:u}){const c={},l={};for(const p in u){if(p==="__proto__")continue;const d=Array.isArray(u[p])?c:l;d[p]=u[p]}return[c,l]}function i(u,c=u.schema){const{gen:l,data:p,it:d}=u;if(Object.keys(c).length===0)return;const f=l.let("missing");for(const S in c){const b=c[S];if(b.length===0)continue;const F=(0,r.propertyInData)(l,p,S,d.opts.ownProperties);u.setParams({property:S,depsCount:b.length,deps:b.join(", ")}),d.allErrors?l.if(F,()=>{for(const y of b)(0,r.checkReportMissingProp)(u,y)}):(l.if((0,e._)`${F} && (${(0,r.checkMissingProp)(u,b,f)})`),(0,r.reportMissingProp)(u,f),l.else())}}t.validatePropertyDeps=i;function a(u,c=u.schema){const{gen:l,data:p,keyword:d,it:f}=u,S=l.name("valid");for(const b in c)(0,n.alwaysValidSchema)(f,c[b])||(l.if((0,r.propertyInData)(l,p,b,f.opts.ownProperties),()=>{const F=u.subschema({keyword:d,schemaProp:b},S);u.mergeValidEvaluated(F,S)},()=>l.var(S,!0)),u.ok(S))}t.validateSchemaDeps=a,t.default=s})(Hd);var Ju={};Object.defineProperty(Ju,"__esModule",{value:!0});const Wd=Ie,Ag=se,bg={message:"property name must be valid",params:({params:t})=>(0,Wd._)`{propertyName: ${t.propertyName}}`},Cg={keyword:"propertyNames",type:"object",schemaType:["object","boolean"],error:bg,code(t){const{gen:e,schema:n,data:r,it:s}=t;if((0,Ag.alwaysValidSchema)(s,n))return;const o=e.name("valid");e.forIn("key",r,i=>{t.setParams({propertyName:i}),t.subschema({keyword:"propertyNames",data:i,dataTypes:["string"],propertyName:i,compositeRule:!0},o),e.if((0,Wd.not)(o),()=>{t.error(!0),s.allErrors||e.break()})}),t.ok(o)}};Ju.default=Cg;var fi={};Object.defineProperty(fi,"__esModule",{value:!0});const ao=we,nn=Ie,Tg=bn,uo=se,wg={message:"must NOT have additional properties",params:({params:t})=>(0,nn._)`{additionalProperty: ${t.additionalProperty}}`},Fg={keyword:"additionalProperties",type:["object"],schemaType:["boolean","object"],allowUndefined:!0,trackErrors:!0,error:wg,code(t){const{gen:e,schema:n,parentSchema:r,data:s,errsCount:o,it:i}=t;if(!o)throw new Error("ajv implementation error");const{allErrors:a,opts:u}=i;if(i.props=!0,u.removeAdditional!=="all"&&(0,uo.alwaysValidSchema)(i,n))return;const c=(0,ao.allSchemaProperties)(r.properties),l=(0,ao.allSchemaProperties)(r.patternProperties);p(),t.ok((0,nn._)`${o} === ${Tg.default.errors}`);function p(){e.forIn("key",s,F=>{!c.length&&!l.length?S(F):e.if(d(F),()=>S(F))})}function d(F){let y;if(c.length>8){const T=(0,uo.schemaRefOrVal)(i,r.properties,"properties");y=(0,ao.isOwnProperty)(e,T,F)}else c.length?y=(0,nn.or)(...c.map(T=>(0,nn._)`${F} === ${T}`)):y=nn.nil;return l.length&&(y=(0,nn.or)(y,...l.map(T=>(0,nn._)`${(0,ao.usePattern)(t,T)}.test(${F})`))),(0,nn.not)(y)}function f(F){e.code((0,nn._)`delete ${s}[${F}]`)}function S(F){if(u.removeAdditional==="all"||u.removeAdditional&&n===!1){f(F);return}if(n===!1){t.setParams({additionalProperty:F}),t.error(),a||e.break();return}if(typeof n=="object"&&!(0,uo.alwaysValidSchema)(i,n)){const y=e.name("valid");u.removeAdditional==="failing"?(b(F,y,!1),e.if((0,nn.not)(y),()=>{t.reset(),f(F)})):(b(F,y),a||e.if((0,nn.not)(y),()=>e.break()))}}function b(F,y,T){const O={keyword:"additionalProperties",dataProp:F,dataPropType:uo.Type.Str};T===!1&&Object.assign(O,{compositeRule:!0,createErrors:!1,allErrors:!1}),t.subschema(O,y)}}};fi.default=Fg;var Hu={};Object.defineProperty(Hu,"__esModule",{value:!0});const Ig=cn,hl=we,$i=se,ml=fi,kg={keyword:"properties",type:"object",schemaType:"object",code(t){const{gen:e,schema:n,parentSchema:r,data:s,it:o}=t;o.opts.removeAdditional==="all"&&r.additionalProperties===void 0&&ml.default.code(new Ig.KeywordCxt(o,ml.default,"additionalProperties"));const i=(0,hl.allSchemaProperties)(n);for(const p of i)o.definedProperties.add(p);o.opts.unevaluated&&i.length&&o.props!==!0&&(o.props=$i.mergeEvaluated.props(e,(0,$i.toHash)(i),o.props));const a=i.filter(p=>!(0,$i.alwaysValidSchema)(o,n[p]));if(a.length===0)return;const u=e.name("valid");for(const p of a)c(p)?l(p):(e.if((0,hl.propertyInData)(e,s,p,o.opts.ownProperties)),l(p),o.allErrors||e.else().var(u,!0),e.endIf()),t.it.definedProperties.add(p),t.ok(u);function c(p){return o.opts.useDefaults&&!o.compositeRule&&n[p].default!==void 0}function l(p){t.subschema({keyword:"properties",schemaProp:p,dataProp:p},u)}}};Hu.default=kg;var Wu={};Object.defineProperty(Wu,"__esModule",{value:!0});const Dl=we,co=Ie,Sl=se,El=se,Pg={keyword:"patternProperties",type:"object",schemaType:"object",code(t){const{gen:e,schema:n,data:r,parentSchema:s,it:o}=t,{opts:i}=o,a=(0,Dl.allSchemaProperties)(n),u=a.filter(b=>(0,Sl.alwaysValidSchema)(o,n[b]));if(a.length===0||u.length===a.length&&(!o.opts.unevaluated||o.props===!0))return;const c=i.strictSchema&&!i.allowMatchingProperties&&s.properties,l=e.name("valid");o.props!==!0&&!(o.props instanceof co.Name)&&(o.props=(0,El.evaluatedPropsToName)(e,o.props));const{props:p}=o;d();function d(){for(const b of a)c&&f(b),o.allErrors?S(b):(e.var(l,!0),S(b),e.if(l))}function f(b){for(const F in c)new RegExp(b).test(F)&&(0,Sl.checkStrictMode)(o,`property ${F} matches pattern ${b} (use allowMatchingProperties)`)}function S(b){e.forIn("key",r,F=>{e.if((0,co._)`${(0,Dl.usePattern)(t,b)}.test(${F})`,()=>{const y=u.includes(b);y||t.subschema({keyword:"patternProperties",schemaProp:b,dataProp:F,dataPropType:El.Type.Str},l),o.opts.unevaluated&&p!==!0?e.assign((0,co._)`${p}[${F}]`,!0):!y&&!o.allErrors&&e.if((0,co.not)(l),()=>e.break())})})}}};Wu.default=Pg;var Ku={};Object.defineProperty(Ku,"__esModule",{value:!0});const Ng=se,_g={keyword:"not",schemaType:["object","boolean"],trackErrors:!0,code(t){const{gen:e,schema:n,it:r}=t;if((0,Ng.alwaysValidSchema)(r,n)){t.fail();return}const s=e.name("valid");t.subschema({keyword:"not",compositeRule:!0,createErrors:!1,allErrors:!1},s),t.failResult(s,()=>t.reset(),()=>t.error())},error:{message:"must NOT be valid"}};Ku.default=_g;var Xu={};Object.defineProperty(Xu,"__esModule",{value:!0});const Og=we,$g={keyword:"anyOf",schemaType:"array",trackErrors:!0,code:Og.validateUnion,error:{message:"must match a schema in anyOf"}};Xu.default=$g;var zu={};Object.defineProperty(zu,"__esModule",{value:!0});const Ao=Ie,Bg=se,Rg={message:"must match exactly one schema in oneOf",params:({params:t})=>(0,Ao._)`{passingSchemas: ${t.passing}}`},xg={keyword:"oneOf",schemaType:"array",trackErrors:!0,error:Rg,code(t){const{gen:e,schema:n,parentSchema:r,it:s}=t;if(!Array.isArray(n))throw new Error("ajv implementation error");if(s.opts.discriminator&&r.discriminator)return;const o=n,i=e.let("valid",!1),a=e.let("passing",null),u=e.name("_valid");t.setParams({passing:a}),e.block(c),t.result(i,()=>t.reset(),()=>t.error(!0));function c(){o.forEach((l,p)=>{let d;(0,Bg.alwaysValidSchema)(s,l)?e.var(u,!0):d=t.subschema({keyword:"oneOf",schemaProp:p,compositeRule:!0},u),p>0&&e.if((0,Ao._)`${u} && ${i}`).assign(i,!1).assign(a,(0,Ao._)`[${a}, ${p}]`).else(),e.if(u,()=>{e.assign(i,!0),e.assign(a,p),d&&t.mergeEvaluated(d,Ao.Name)})})}}};zu.default=xg;var Yu={};Object.defineProperty(Yu,"__esModule",{value:!0});const qg=se,Mg={keyword:"allOf",schemaType:"array",code(t){const{gen:e,schema:n,it:r}=t;if(!Array.isArray(n))throw new Error("ajv implementation error");const s=e.name("valid");n.forEach((o,i)=>{if((0,qg.alwaysValidSchema)(r,o))return;const a=t.subschema({keyword:"allOf",schemaProp:i},s);t.ok(s),t.mergeEvaluated(a)})}};Yu.default=Mg;var Zu={};Object.defineProperty(Zu,"__esModule",{value:!0});const Ko=Ie,Kd=se,Lg={message:({params:t})=>(0,Ko.str)`must match "${t.ifClause}" schema`,params:({params:t})=>(0,Ko._)`{failingKeyword: ${t.ifClause}}`},jg={keyword:"if",schemaType:["object","boolean"],trackErrors:!0,error:Lg,code(t){const{gen:e,parentSchema:n,it:r}=t;n.then===void 0&&n.else===void 0&&(0,Kd.checkStrictMode)(r,'"if" without "then" and "else" is ignored');const s=yl(r,"then"),o=yl(r,"else");if(!s&&!o)return;const i=e.let("valid",!0),a=e.name("_valid");if(u(),t.reset(),s&&o){const l=e.let("ifClause");t.setParams({ifClause:l}),e.if(a,c("then",l),c("else",l))}else s?e.if(a,c("then")):e.if((0,Ko.not)(a),c("else"));t.pass(i,()=>t.error(!0));function u(){const l=t.subschema({keyword:"if",compositeRule:!0,createErrors:!1,allErrors:!1},a);t.mergeEvaluated(l)}function c(l,p){return()=>{const d=t.subschema({keyword:l},a);e.assign(i,a),t.mergeValidEvaluated(d,i),p?e.assign(p,(0,Ko._)`${l}`):t.setParams({ifClause:l})}}}};function yl(t,e){const n=t.schema[e];return n!==void 0&&!(0,Kd.alwaysValidSchema)(t,n)}Zu.default=jg;var Qu={};Object.defineProperty(Qu,"__esModule",{value:!0});const Gg=se,Ug={keyword:["then","else"],schemaType:["object","boolean"],code({keyword:t,parentSchema:e,it:n}){e.if===void 0&&(0,Gg.checkStrictMode)(n,`"${t}" without "if" is ignored`)}};Qu.default=Ug;Object.defineProperty(ju,"__esModule",{value:!0});const Vg=ns,Jg=Gu,Hg=rs,Wg=Uu,Kg=Vu,Xg=Hd,zg=Ju,Yg=fi,Zg=Hu,Qg=Wu,ev=Ku,tv=Xu,nv=zu,rv=Yu,sv=Zu,ov=Qu;function iv(t=!1){const e=[ev.default,tv.default,nv.default,rv.default,sv.default,ov.default,zg.default,Yg.default,Xg.default,Zg.default,Qg.default];return t?e.push(Jg.default,Wg.default):e.push(Vg.default,Hg.default),e.push(Kg.default),e}ju.default=iv;var ec={},tc={};Object.defineProperty(tc,"__esModule",{value:!0});const ht=Ie,av={message:({schemaCode:t})=>(0,ht.str)`must match format "${t}"`,params:({schemaCode:t})=>(0,ht._)`{format: ${t}}`},uv={keyword:"format",type:["number","string"],schemaType:"string",$data:!0,error:av,code(t,e){const{gen:n,data:r,$data:s,schema:o,schemaCode:i,it:a}=t,{opts:u,errSchemaPath:c,schemaEnv:l,self:p}=a;if(!u.validateFormats)return;s?d():f();function d(){const S=n.scopeValue("formats",{ref:p.formats,code:u.code.formats}),b=n.const("fDef",(0,ht._)`${S}[${i}]`),F=n.let("fType"),y=n.let("format");n.if((0,ht._)`typeof ${b} == "object" && !(${b} instanceof RegExp)`,()=>n.assign(F,(0,ht._)`${b}.type || "string"`).assign(y,(0,ht._)`${b}.validate`),()=>n.assign(F,(0,ht._)`"string"`).assign(y,b)),t.fail$data((0,ht.or)(T(),O()));function T(){return u.strictSchema===!1?ht.nil:(0,ht._)`${i} && !${y}`}function O(){const j=l.$async?(0,ht._)`(${b}.async ? await ${y}(${r}) : ${y}(${r}))`:(0,ht._)`${y}(${r})`,M=(0,ht._)`(typeof ${y} == "function" ? ${j} : ${y}.test(${r}))`;return(0,ht._)`${y} && ${y} !== true && ${F} === ${e} && !${M}`}}function f(){const S=p.formats[o];if(!S){T();return}if(S===!0)return;const[b,F,y]=O(S);b===e&&t.pass(j());function T(){if(u.strictSchema===!1){p.logger.warn(M());return}throw new Error(M());function M(){return`unknown format "${o}" ignored in schema at path "${c}"`}}function O(M){const ee=M instanceof RegExp?(0,ht.regexpCode)(M):u.code.formats?(0,ht._)`${u.code.formats}${(0,ht.getProperty)(o)}`:void 0,ne=n.scopeValue("formats",{key:o,ref:M,code:ee});return typeof M=="object"&&!(M instanceof RegExp)?[M.type||"string",M.validate,(0,ht._)`${ne}.validate`]:["string",M,ne]}function j(){if(typeof S=="object"&&!(S instanceof RegExp)&&S.async){if(!l.$async)throw new Error("async format in sync schema");return(0,ht._)`await ${y}(${r})`}return typeof F=="function"?(0,ht._)`${y}(${r})`:(0,ht._)`${y}.test(${r})`}}}};tc.default=uv;Object.defineProperty(ec,"__esModule",{value:!0});const cv=tc,lv=[cv.default];ec.default=lv;var Zr={};Object.defineProperty(Zr,"__esModule",{value:!0});Zr.contentVocabulary=Zr.metadataVocabulary=void 0;Zr.metadataVocabulary=["title","description","default","deprecated","readOnly","writeOnly","examples"];Zr.contentVocabulary=["contentMediaType","contentEncoding","contentSchema"];Object.defineProperty(wu,"__esModule",{value:!0});const pv=Fu,dv=ku,fv=ju,hv=ec,gl=Zr,mv=[pv.default,dv.default,(0,fv.default)(),hv.default,gl.metadataVocabulary,gl.contentVocabulary];wu.default=mv;var nc={},hi={};Object.defineProperty(hi,"__esModule",{value:!0});hi.DiscrError=void 0;var vl;(function(t){t.Tag="tag",t.Mapping="mapping"})(vl||(hi.DiscrError=vl={}));Object.defineProperty(nc,"__esModule",{value:!0});const Mr=Ie,Fa=hi,Al=xt,Dv=se,Sv={message:({params:{discrError:t,tagName:e}})=>t===Fa.DiscrError.Tag?`tag "${e}" must be string`:`value of tag "${e}" must be in oneOf`,params:({params:{discrError:t,tag:e,tagName:n}})=>(0,Mr._)`{error: ${t}, tag: ${n}, tagValue: ${e}}`},Ev={keyword:"discriminator",type:"object",schemaType:"object",error:Sv,code(t){const{gen:e,data:n,schema:r,parentSchema:s,it:o}=t,{oneOf:i}=s;if(!o.opts.discriminator)throw new Error("discriminator: requires discriminator option");const a=r.propertyName;if(typeof a!="string")throw new Error("discriminator: requires propertyName");if(r.mapping)throw new Error("discriminator: mapping is not supported");if(!i)throw new Error("discriminator: requires oneOf keyword");const u=e.let("valid",!1),c=e.const("tag",(0,Mr._)`${n}${(0,Mr.getProperty)(a)}`);e.if((0,Mr._)`typeof ${c} == "string"`,()=>l(),()=>t.error(!1,{discrError:Fa.DiscrError.Tag,tag:c,tagName:a})),t.ok(u);function l(){const f=d();e.if(!1);for(const S in f)e.elseIf((0,Mr._)`${c} === ${S}`),e.assign(u,p(f[S]));e.else(),t.error(!1,{discrError:Fa.DiscrError.Mapping,tag:c,tagName:a}),e.endIf()}function p(f){const S=e.name("valid"),b=t.subschema({keyword:"oneOf",schemaProp:f},S);return t.mergeEvaluated(b,Mr.Name),S}function d(){var f;const S={},b=y(s);let F=!0;for(let j=0;j<i.length;j++){let M=i[j];M!=null&&M.$ref&&!(0,Dv.schemaHasRulesButRef)(M,o.self.RULES)&&(M=Al.resolveRef.call(o.self,o.schemaEnv.root,o.baseId,M==null?void 0:M.$ref),M instanceof Al.SchemaEnv&&(M=M.schema));const ee=(f=M==null?void 0:M.properties)===null||f===void 0?void 0:f[a];if(typeof ee!="object")throw new Error(`discriminator: oneOf subschemas (or referenced schemas) must have "properties/${a}"`);F=F&&(b||y(M)),T(ee,j)}if(!F)throw new Error(`discriminator: "${a}" must be required`);return S;function y({required:j}){return Array.isArray(j)&&j.includes(a)}function T(j,M){if(j.const)O(j.const,M);else if(j.enum)for(const ee of j.enum)O(ee,M);else throw new Error(`discriminator: "properties/${a}" must have "const" or "enum"`)}function O(j,M){if(typeof j!="string"||j in S)throw new Error(`discriminator: "${a}" values must be unique strings`);S[j]=M}}}};nc.default=Ev;const yv="http://json-schema.org/draft-07/schema#",gv="http://json-schema.org/draft-07/schema#",vv="Core schema meta-schema",Av={schemaArray:{type:"array",minItems:1,items:{$ref:"#"}},nonNegativeInteger:{type:"integer",minimum:0},nonNegativeIntegerDefault0:{allOf:[{$ref:"#/definitions/nonNegativeInteger"},{default:0}]},simpleTypes:{enum:["array","boolean","integer","null","number","object","string"]},stringArray:{type:"array",items:{type:"string"},uniqueItems:!0,default:[]}},bv=["object","boolean"],Cv={$id:{type:"string",format:"uri-reference"},$schema:{type:"string",format:"uri"},$ref:{type:"string",format:"uri-reference"},$comment:{type:"string"},title:{type:"string"},description:{type:"string"},default:!0,readOnly:{type:"boolean",default:!1},examples:{type:"array",items:!0},multipleOf:{type:"number",exclusiveMinimum:0},maximum:{type:"number"},exclusiveMaximum:{type:"number"},minimum:{type:"number"},exclusiveMinimum:{type:"number"},maxLength:{$ref:"#/definitions/nonNegativeInteger"},minLength:{$ref:"#/definitions/nonNegativeIntegerDefault0"},pattern:{type:"string",format:"regex"},additionalItems:{$ref:"#"},items:{anyOf:[{$ref:"#"},{$ref:"#/definitions/schemaArray"}],default:!0},maxItems:{$ref:"#/definitions/nonNegativeInteger"},minItems:{$ref:"#/definitions/nonNegativeIntegerDefault0"},uniqueItems:{type:"boolean",default:!1},contains:{$ref:"#"},maxProperties:{$ref:"#/definitions/nonNegativeInteger"},minProperties:{$ref:"#/definitions/nonNegativeIntegerDefault0"},required:{$ref:"#/definitions/stringArray"},additionalProperties:{$ref:"#"},definitions:{type:"object",additionalProperties:{$ref:"#"},default:{}},properties:{type:"object",additionalProperties:{$ref:"#"},default:{}},patternProperties:{type:"object",additionalProperties:{$ref:"#"},propertyNames:{format:"regex"},default:{}},dependencies:{type:"object",additionalProperties:{anyOf:[{$ref:"#"},{$ref:"#/definitions/stringArray"}]}},propertyNames:{$ref:"#"},const:!0,enum:{type:"array",items:!0,minItems:1,uniqueItems:!0},type:{anyOf:[{$ref:"#/definitions/simpleTypes"},{type:"array",items:{$ref:"#/definitions/simpleTypes"},minItems:1,uniqueItems:!0}]},format:{type:"string"},contentMediaType:{type:"string"},contentEncoding:{type:"string"},if:{$ref:"#"},then:{$ref:"#"},else:{$ref:"#"},allOf:{$ref:"#/definitions/schemaArray"},anyOf:{$ref:"#/definitions/schemaArray"},oneOf:{$ref:"#/definitions/schemaArray"},not:{$ref:"#"}},Tv={$schema:yv,$id:gv,title:vv,definitions:Av,type:bv,properties:Cv,default:!0};(function(t,e){Object.defineProperty(e,"__esModule",{value:!0}),e.MissingRefError=e.ValidationError=e.CodeGen=e.Name=e.nil=e.stringify=e.str=e._=e.KeywordCxt=e.Ajv=void 0;const n=ad,r=wu,s=nc,o=Tv,i=["/properties"],a="http://json-schema.org/draft-07/schema";class u extends n.default{_addVocabularies(){super._addVocabularies(),r.default.forEach(S=>this.addVocabulary(S)),this.opts.discriminator&&this.addKeyword(s.default)}_addDefaultMetaSchema(){if(super._addDefaultMetaSchema(),!this.opts.meta)return;const S=this.opts.$data?this.$dataMetaSchema(o,i):o;this.addMetaSchema(S,a,!1),this.refs["http://json-schema.org/schema"]=a}defaultMeta(){return this.opts.defaultMeta=super.defaultMeta()||(this.getSchema(a)?a:void 0)}}e.Ajv=u,t.exports=e=u,t.exports.Ajv=u,Object.defineProperty(e,"__esModule",{value:!0}),e.default=u;var c=cn;Object.defineProperty(e,"KeywordCxt",{enumerable:!0,get:function(){return c.KeywordCxt}});var l=Ie;Object.defineProperty(e,"_",{enumerable:!0,get:function(){return l._}}),Object.defineProperty(e,"str",{enumerable:!0,get:function(){return l.str}}),Object.defineProperty(e,"stringify",{enumerable:!0,get:function(){return l.stringify}}),Object.defineProperty(e,"nil",{enumerable:!0,get:function(){return l.nil}}),Object.defineProperty(e,"Name",{enumerable:!0,get:function(){return l.Name}}),Object.defineProperty(e,"CodeGen",{enumerable:!0,get:function(){return l.CodeGen}});var p=Us;Object.defineProperty(e,"ValidationError",{enumerable:!0,get:function(){return p.default}});var d=Vs;Object.defineProperty(e,"MissingRefError",{enumerable:!0,get:function(){return d.default}})})(ya,ya.exports);var wv=ya.exports;const Fv="Root",Iv="object",kv="Root Element",Pv={base64String:{type:"string",pattern:"^[A-Za-z0-9/+=]*$"},tagString:{type:"string",pattern:"^[a-z][a-z0-9]*(:.+)?$"}},Nv={id:{type:"string"},metadata:{type:"object",properties:{selectors:{type:"object",additionalProperties:{type:"string"}}},required:["selectors"],additionalProperties:!1},tags:{type:"array",items:{type:"string",$ref:"#/definitions/tagString"}},enums:{type:"object",properties:{ids:{$ref:"#/definitions/base64String"},wordLike:{$ref:"#/definitions/base64String"},notWordLike:{$ref:"#/definitions/base64String"},scopeBits:{$ref:"#/definitions/base64String"},graftTypes:{$ref:"#/definitions/base64String"}},required:["ids","wordLike","notWordLike","scopeBits","graftTypes"],additionalProperties:!1},docs:{type:"object",propertyNames:{type:"string"},additionalProperties:{type:"object",properties:{sequences:{type:"object",additionalProperties:{type:"object",properties:{type:{type:"string"},blocks:{type:"array",items:{type:"object",properties:{bs:{type:"string"},bg:{type:"string"},c:{type:"string"},is:{type:"string"},os:{type:"string"},nt:{type:"string"}},required:["bs","bg","c","is","os","nt"],additionalProperties:!1}},tags:{type:"array",items:{type:"string",$ref:"#/definitions/tagString"}},chapters:{type:"object",additionalProperties:{type:"string"}},chapterVerses:{type:"object",additionalProperties:{type:"string"}},tokensPresent:{type:"string"}},required:["blocks","tags"],additionalProperties:!1}},headers:{type:"object",additionalProperties:{type:"string"}},mainId:{type:"string"},tags:{type:"array",items:{type:"string",$ref:"#/definitions/tagString"}}},required:["sequences","headers","mainId","tags"],additionalProperties:!1}},additionalProperties:!1},_v=["id","enums","docs","tags"],Ov=!1,$v={title:Fv,type:Iv,description:kv,definitions:Pv,properties:Nv,required:_v,additionalProperties:Ov},Bv="version 0.1.0",Rv="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/structure/0_2_1/document_structure.json",xv="Document (Structure)",qv="A document, typically corresponding to a single USFM or USX book",Mv="object",Lv={schema:{type:"object",properties:{structure:{description:"The basic 'shape' of the content",type:"string",enum:["flat","nested"]},structure_version:{description:"the semantic version of the structure schema",type:"string"},constraints:{type:"array",items:{type:"object",properties:{name:{type:"string",enum:["perf","sofria"]},version:{description:"the semantic version of the constraint schema",type:"string"}},additionalProperties:!1,required:["name","version"]}}},required:["structure","structure_version","constraints"],additionalProperties:!1},metadata:{description:"Metadata describing the document and the translation it belongs to",type:"object",properties:{translation:{type:"object",description:"Metadata concerning the translation to which the document belongs",properties:{tags:{description:"Tags attached to the translation",type:"array",items:{type:"string"}},properties:{type:"object",description:"Key/value properties attached to the translation",additionalProperties:{type:"string"}},selectors:{type:"object",description:"Proskomma selectors for the translation that, together, provide a primary key in the translation store",additionalProperties:{type:"string"}}},additionalProperties:{type:"string"},required:["id"]},document:{type:"object",description:"Metadata concerning the document itself",properties:{tags:{type:"array",description:"Tags attached to the document",items:{type:"string"}},properties:{type:"object",description:"Key/value properties attached to the document",additionalProperties:{type:"string"}},chapters:{type:"string",pattern:"^[1-9][0-9]*(-[1-9][0-9]*)?$"}},additionalProperties:{type:"string"}}},additionalProperties:!1},sequences:{type:"object",propertyNames:{pattern:"^\\S+$"},additionalProperties:{$ref:"./sequence_structure.json"}},sequence:{$ref:"./sequence_structure.json"},main_sequence_id:{type:"string"}},jv=["schema","metadata"],Gv=!1,Uv={required:["sequences","main_sequence_id"],not:{required:["sequence"]}},Vv={$comment:Bv,$id:Rv,title:xv,description:qv,type:Mv,properties:Lv,required:jv,additionalProperties:Gv,if:{properties:{schema:{type:"object",properties:{structure:{enum:["flat"]}}}}},then:Uv,else:{required:["sequence"],allOf:[{not:{required:["sequences"]}},{not:{required:["main_sequence_id"]}}]}},Jv="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/structure/0_2_1/sequence_structure.json",Hv="Sequence (Structure)",Wv="A sequence contains a 'flow' of one or more blocks",Kv="object",Xv={type:{description:"The type of sequence",type:"string"},preview_text:{description:"An optional field to provide some kind of printable label",type:"string"},blocks:{type:"array",description:"The blocks that, together, represent the 'flow' of the sequence",items:{$ref:"./block_structure.json"}}},zv=["type"],Yv=!1,Zv={$id:Jv,title:Hv,description:Wv,type:Kv,properties:Xv,required:zv,additionalProperties:Yv},Qv="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/structure/0_2_1/block_structure.json",e5="Block (Structure)",t5="A block, which represents either a paragraph of text or a graft",n5="object",r5={type:{type:"string",description:"The type of block",enum:["paragraph","graft"]},subtype:{description:"A type-specific subtype",type:"string"},target:{description:"The id of the sequence containing graft content",type:"string"},sequence:{description:"The sequence containing graft content",$ref:"./sequence_structure.json"},preview_text:{description:"An optional field to provide some kind of printable label for a graft",type:"string"},new:{description:"If present and true, is interpreted as a request for the server to create a new graft",type:"boolean"},atts:{type:"object",description:"An object containing USFM attributes or subtype-specific additional information (such as the number of a verse or chapter). The value may be a boolean, a string or an array of strings",additionalProperties:{oneOf:[{type:"array",items:{type:"string"}},{type:"string"},{type:"boolean"}]}},content:{type:"array",description:"The content of the block",items:{oneOf:[{type:"string"},{$ref:"./contentElement_structure.json"}]}}},s5=["type"],o5=!1,i5={required:["content"],allOf:[{not:{required:["new"]}},{not:{required:["preview_text"]}},{not:{required:["target"]}}]},a5={$id:Qv,title:e5,description:t5,type:n5,properties:r5,required:s5,additionalProperties:o5,if:{properties:{type:{enum:["paragraph"]}}},then:i5,else:{if:{required:["new"],properties:{new:{enum:[!0]}}},then:{allOf:[{oneOf:[{required:["subtype"]},{required:["sequence"]}]},{not:{required:["target"]}},{not:{required:["preview_text"]}},{not:{required:["content"]}}]},else:{oneOf:[{required:["target"]},{required:["sequence"]}]}}},u5="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/structure/0_2_1/contentElement_structure.json",c5="Content Element (Structure)",l5="A content element, ie some form of (possibly nested) markup",p5="object",d5={type:{type:"string",description:"The type of element",enum:["mark","wrapper","start_milestone","end_milestone","graft"]},subtype:{description:"The subtype of the element, which is context-dependent",type:"string"},atts:{type:"object",description:"An object containing USFM attributes or subtype-specific additional information (such as the number of a verse or chapter). The value may be a boolean, a string or an array of strings",additionalProperties:{oneOf:[{type:"array",items:{type:"string"}},{type:"string"},{type:"boolean"}]}},target:{type:"string",description:"The id of the sequence containing graft content"},sequence:{description:"The sequence containing graft content",$ref:"./sequence_structure.json"},preview_text:{description:"An optional field to provide some kind of printable label for a graft",type:"string"},new:{type:"boolean",description:"If present and true, is interpreted as a request for the server to create a new graft"},content:{type:"array",description:"Nested content within the content element",items:{oneOf:[{type:"string"},{$ref:"./contentElement_structure.json"}]}},meta_content:{type:"array",description:"Non-Scripture content related to the content element, such as checking data or related resources",items:{oneOf:[{type:"string"},{$ref:"./contentElement_structure.json"}]}}},f5=["type"],h5=!1,m5={$id:u5,title:c5,description:l5,type:p5,properties:d5,required:f5,additionalProperties:h5},D5="version 0.2.0",S5="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/constraint/0_2_1/perf_document_constraint.json",E5="object",y5={sequences:{type:"object",propertyNames:{pattern:"^\\S+$"},additionalProperties:{$ref:"./perf_sequence_constraint.json"}}},g5={$comment:D5,$id:S5,type:E5,properties:y5},v5="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/constraint/0_2_1/perf_sequence_constraint.json",A5="object",b5={type:{type:"string",enum:["main","introduction","intro_title","intro_end_title","title","end_title","heading","remark","sidebar","table","tree","kv","footnote","note_caller","xref","pub_number","alt_number","esb_cat","fig","temp"]},blocks:{type:"array",items:{$ref:"./perf_block_constraint.json"}}},C5={$id:v5,type:A5,properties:b5},T5="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/constraint/0_2_1/perf_block_constraint.json",w5="object",F5={type:{type:"string",enum:["paragraph","graft"]},content:{type:"array",items:{oneOf:[{type:"string"},{$ref:"./perf_contentElement_constraint.json"}]}},meta_content:{type:"array",items:{oneOf:[{type:"string"},{$ref:"./perf_contentElement_constraint.json"}]}}},I5={properties:{subtype:{enum:["introduction","intro_title","Intro_end_title","title","end_title","heading","remark","sidebar","table","tree","kv"]}}},k5={$id:T5,type:w5,properties:F5,if:{properties:{type:{enum:["graft"]}}},then:I5,else:{properties:{subtype:{type:"string",pattern:"^usfm:"}}}},P5="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/constraint/0_2_1/perf_contentElement_constraint.json",N5="object",_5=[{properties:{content:{type:"array",items:{oneOf:[{type:"string"},{$ref:"./perf_contentElement_constraint.json"}]}},meta_content:{type:"array",items:{oneOf:[{type:"string"},{$ref:"./perf_contentElement_constraint.json"}]}}}},{if:{properties:{type:{enum:["graft"]}}},then:{properties:{subtype:{enum:["footnote","xref","note_caller"]}},allOf:[{not:{required:["content"]}},{not:{required:["meta_content"]}}],if:{required:["new"],properties:{new:{enum:[!0]}}},then:{not:{anyOf:[{required:["target"]},{required:["preview_text"]}]}},else:{required:["target"]}}},{if:{properties:{type:{enum:["mark"]}}},then:{properties:{subtype:{type:"string",oneOf:[{enum:["chapter","verses"]},{pattern:"^[A-Za-z][A-Za-z0-9]*:\\S+$"},{pattern:"^x-\\S+$"}]}},if:{properties:{subtype:{enum:["chapter","verses"]}}},then:{type:"object",required:["atts"],properties:{atts:{type:"object",required:["number"],maxProperties:1}}}}},{if:{properties:{type:{enum:["wrapper"]}}},then:{properties:{subtype:{type:"string",oneOf:[{enum:["meta_content"]},{pattern:"^[A-Za-z][A-Za-z0-9]*:\\S+$"},{pattern:"^x-\\S+$"}]}},if:{properties:{subtype:{enum:["meta_content"]}}},then:{not:{required:["atts"]}}}},{if:{properties:{type:{enum:["start_milestone"]}}},then:{properties:{subtype:{type:"string",oneOf:[{pattern:"^[A-Za-z][A-Za-z0-9]*:\\S+$"},{pattern:"^x-\\S+$"}]}}}},{if:{properties:{type:{enum:["end_milestone"]}}},then:{properties:{subtype:{type:"string",oneOf:[{pattern:"^[A-Za-z][A-Za-z0-9]*:\\S+$"},{pattern:"^x-\\S+$"}]}},not:{required:["atts"]}}}],O5={$id:P5,type:N5,allOf:_5},$5="version 0.2.0",B5="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/constraint/0_2_1/sofria_document_constraint.json",R5="object",x5={sequences:{type:"object",propertyNames:{pattern:"^\\S+$"},additionalProperties:{$ref:"./sofria_sequence_constraint.json"}}},q5={$comment:$5,$id:B5,type:R5,properties:x5},M5="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/constraint/0_2_1/sofria_sequence_constraint.json",L5="object",j5={type:{type:"string",enum:["main","introduction","intro_title","intro_end_title","title","end_title","heading","remark","sidebar","table","tree","kv","footnote","note_caller","xref","pub_number","alt_number","esb_cat","fig","temp"]},blocks:{type:"array",items:{$ref:"./sofria_block_constraint.json"}}},G5={$id:M5,type:L5,properties:j5},U5="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/constraint/0_2_1/sofria_block_constraint.json",V5="object",J5={type:{type:"string",enum:["paragraph","graft"]},content:{type:"array",items:{oneOf:[{type:"string"},{$ref:"./sofria_contentElement_constraint.json"}]}},meta_content:{type:"array",items:{oneOf:[{type:"string"},{$ref:"./sofria_contentElement_constraint.json"}]}}},H5={properties:{subtype:{enum:["introduction","intro_title","Intro_end_title","title","end_title","heading","remark","sidebar","table","tree","kv"]}}},W5={$id:U5,type:V5,properties:J5,if:{properties:{type:{enum:["graft"]}}},then:H5,else:{properties:{subtype:{type:"string",pattern:"^usfm:"}}}},K5="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/constraint/0_2_1/sofria_contentElement_constraint.json",X5="object",z5=[{properties:{content:{type:"array",items:{oneOf:[{type:"string"},{$ref:"./sofria_contentElement_constraint.json"}]}},meta_content:{type:"array",items:{oneOf:[{type:"string"},{$ref:"./sofria_contentElement_constraint.json"}]}}}},{if:{properties:{type:{enum:["graft"]}}},then:{properties:{subtype:{enum:["footnote","xref","note_caller"]}},allOf:[{not:{required:["content"]}},{not:{required:["meta_content"]}}],if:{required:["new"],properties:{new:{enum:[!0]}}},then:{not:{anyOf:[{required:["block"]},{required:["preview_text"]}]}},else:{required:["block"]}}},{if:{properties:{type:{enum:["mark"]}}},then:{properties:{subtype:{type:"string",oneOf:[{enum:["chapter_label","verses_label"]},{pattern:"^[A-Za-z][A-Za-z0-9]*:\\S+$"},{pattern:"^x-\\S+$"}]}},if:{properties:{subtype:{enum:["chapter","verses"]}}},then:{type:"object",required:["atts"],properties:{atts:{type:"object",required:["number"],maxProperties:1}}}}},{if:{properties:{type:{enum:["wrapper"]}}},then:{properties:{subtype:{type:"string",oneOf:[{enum:["meta_content","chapter","verses"]},{pattern:"^[A-Za-z][A-Za-z0-9]*:\\S+$"},{pattern:"^x-\\S+$"}]}},if:{properties:{subtype:{enum:["meta_content"]}}},then:{not:{required:["atts"]}}}},{if:{properties:{type:{enum:["start_milestone"]}}},then:{properties:{subtype:{type:"string",oneOf:[{pattern:"^[A-Za-z][A-Za-z0-9]*:\\S+$"},{pattern:"^x-\\S+$"}]}}}},{if:{properties:{type:{enum:["end_milestone"]}}},then:{properties:{subtype:{type:"string",oneOf:[{pattern:"^[A-Za-z][A-Za-z0-9]*:\\S+$"},{pattern:"^x-\\S+$"}]}},not:{required:["atts"]}}}],Y5={$id:K5,type:X5,allOf:z5},Z5="version 0.1.0",Q5="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/structure/0_3_0/document_structure.json",eA="Document (Structure)",tA="A document, typically corresponding to a single USFM or USX book",nA="object",rA={schema:{type:"object",properties:{structure:{description:"The basic 'shape' of the content",type:"string",enum:["flat","nested"]},structure_version:{description:"the semantic version of the structure schema",type:"string"},constraints:{type:"array",items:{type:"object",properties:{name:{type:"string",enum:["perf","sofria"]},version:{description:"the semantic version of the constraint schema",type:"string"}},additionalProperties:!1,required:["name","version"]}}},required:["structure","structure_version","constraints"],additionalProperties:!1},metadata:{description:"Metadata describing the document and the translation it belongs to",type:"object",properties:{translation:{type:"object",description:"Metadata concerning the translation to which the document belongs",properties:{tags:{description:"Tags attached to the translation",type:"array",items:{type:"string"}},properties:{type:"object",description:"Key/value properties attached to the translation",additionalProperties:{type:"string"}},selectors:{type:"object",description:"Proskomma selectors for the translation that, together, provide a primary key in the translation store",additionalProperties:{type:"string"}}},additionalProperties:{type:"string"},required:["id"]},document:{type:"object",description:"Metadata concerning the document itself",properties:{tags:{type:"array",description:"Tags attached to the document",items:{type:"string"}},properties:{type:"object",description:"Key/value properties attached to the document",additionalProperties:{type:"string"}},chapters:{type:"string",pattern:"^[1-9][0-9]*(-[1-9][0-9]*)?$"}},additionalProperties:{type:"string"}}},additionalProperties:!1},hooks:{type:"array",$ref:"./hook_structure.json"},sequences:{type:"object",propertyNames:{pattern:"^\\S+$"},additionalProperties:{$ref:"./sequence_structure.json"}},sequence:{$ref:"./sequence_structure.json"},main_sequence_id:{type:"string"}},sA=["schema","metadata"],oA=!1,iA={required:["sequences","main_sequence_id"],not:{required:["sequence"]}},aA={$comment:Z5,$id:Q5,title:eA,description:tA,type:nA,properties:rA,required:sA,additionalProperties:oA,if:{properties:{schema:{type:"object",properties:{structure:{enum:["flat"]}}}}},then:iA,else:{required:["sequence"],allOf:[{not:{required:["sequences"]}},{not:{required:["main_sequence_id"]}}]}},uA="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/structure/0_3_0/sequence_structure.json",cA="Sequence (Structure)",lA="A sequence contains a 'flow' of one or more blocks",pA="object",dA={type:{description:"The type of sequence",type:"string"},preview_text:{description:"An optional field to provide some kind of printable label",type:"string"},blocks:{type:"array",description:"The blocks that, together, represent the 'flow' of the sequence",items:{$ref:"./block_structure.json"}},hooks:{type:"array",$ref:"./hook_structure.json"}},fA=["type"],hA=!1,mA={$id:uA,title:cA,description:lA,type:pA,properties:dA,required:fA,additionalProperties:hA},DA="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/structure/0_3_0/block_structure.json",SA="Block (Structure)",EA="A block, which represents either a paragraph of text or a graft",yA="object",gA={type:{type:"string",description:"The type of block",enum:["paragraph","row","node","lookup","graft"]},subtype:{description:"A type-specific subtype",type:"string"},target:{description:"The id of the sequence containing graft content",type:"string"},sequence:{description:"The sequence containing graft content",$ref:"./sequence_structure.json"},preview_text:{description:"An optional field to provide some kind of printable label for a graft",type:"string"},new:{description:"If present and true, is interpreted as a request for the server to create a new graft",type:"boolean"},atts:{type:"object",description:"An object containing USFM attributes or subtype-specific additional information (such as the number of a verse or chapter). The value may be a boolean, a string or an array of strings",additionalProperties:{oneOf:[{type:"array",items:{type:"string"}},{type:"string"},{type:"boolean"}]}},content:{type:"array",description:"The content of the block",items:{oneOf:[{type:"string"},{$ref:"./contentElement_structure.json"}]}},hooks:{type:"array",$ref:"./hook_structure.json"}},vA=["type"],AA=!1,bA={required:["content"],allOf:[{not:{required:["new"]}},{not:{required:["preview_text"]}},{not:{required:["target"]}}]},CA={$id:DA,title:SA,description:EA,type:yA,properties:gA,required:vA,additionalProperties:AA,if:{properties:{type:{enum:["paragraph","row","node","lookup"]}}},then:bA,else:{if:{required:["new"],properties:{new:{enum:[!0]}}},then:{allOf:[{oneOf:[{required:["subtype"]},{required:["sequence"]}]},{not:{required:["target"]}},{not:{required:["preview_text"]}},{not:{required:["content"]}}]},else:{oneOf:[{required:["target"]},{required:["sequence"]}]}}},TA="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/structure/0_3_0/contentElement_structure.json",wA="Content Element (Structure)",FA="A content element, ie some form of (possibly nested) markup",IA="object",kA={type:{type:"string",description:"The type of element",enum:["mark","wrapper","start_milestone","end_milestone","graft"]},subtype:{description:"The subtype of the element, which is context-dependent",type:"string"},atts:{type:"object",description:"An object containing USFM attributes or subtype-specific additional information (such as the number of a verse or chapter). The value may be a boolean, a string or an array of strings",additionalProperties:{oneOf:[{type:"array",items:{type:"string"}},{type:"string"},{type:"boolean"}]}},target:{type:"string",description:"The id of the sequence containing graft content"},sequence:{description:"The sequence containing graft content",$ref:"./sequence_structure.json"},preview_text:{description:"An optional field to provide some kind of printable label for a graft",type:"string"},new:{type:"boolean",description:"If present and true, is interpreted as a request for the server to create a new graft"},content:{type:"array",description:"Nested content within the content element",items:{oneOf:[{type:"string"},{$ref:"./contentElement_structure.json"}]}},meta_content:{type:"array",description:"Non-Scripture content related to the content element, such as checking data or related resources",items:{oneOf:[{type:"string"},{$ref:"./contentElement_structure.json"}]}},hooks:{type:"array",$ref:"./hook_structure.json"}},PA=["type"],NA=!1,_A={$id:TA,title:wA,description:FA,type:IA,properties:kA,required:PA,additionalProperties:NA},OA="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/structure/0_3_0/hook_structure.json",$A="Hook (Structure)",BA="Hooks, ie typed labels that may be used to link documents",RA="array",xA={type:"array",items:[{type:"string",oneOf:[{enum:["bcv_ref","book_ref"]},{pattern:"^x-(app|publisher)-[a-z][a-z0-9]+-\\S{2,256}$"},{pattern:"^x-local-\\S{2,256}$"}]},{type:"string",oneOf:[{enum:["label"]},{pattern:"^\\w{1,255}$"}]}],minItems:2,maxItems:2},qA={$id:OA,title:$A,description:BA,type:RA,items:xA},MA="version 0.3.0",LA="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/constraint/0_3_0/perf_document_constraint.json",jA="object",GA={hooks:{type:"array"},sequences:{type:"object",propertyNames:{pattern:"^\\S+$"},additionalProperties:{$ref:"./perf_sequence_constraint.json"}}},UA={$comment:MA,$id:LA,type:jA,properties:GA},VA="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/constraint/0_3_0/perf_sequence_constraint.json",JA="object",HA={type:{type:"string",enum:["main","introduction","intro_title","intro_end_title","title","end_title","heading","remark","sidebar","table","tree","kv","footnote","note_caller","xref","pub_number","alt_number","esb_cat","fig","temp"]},blocks:{type:"array",items:{$ref:"./perf_block_constraint.json"}}},WA={$id:VA,type:JA,properties:HA},KA="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/constraint/0_3_0/perf_block_constraint.json",XA="object",zA={type:{type:"string",enum:["paragraph","graft","row","node","lookup"]},content:{type:"array",items:{oneOf:[{type:"string"},{$ref:"./perf_contentElement_constraint.json"}]}},meta_content:{type:"array",items:{oneOf:[{type:"string"},{$ref:"./perf_contentElement_constraint.json"}]}}},YA={properties:{subtype:{enum:["introduction","intro_title","Intro_end_title","title","end_title","heading","remark","sidebar","table","tree","kv"]}}},ZA={$id:KA,type:XA,properties:zA,if:{properties:{type:{enum:["graft"]}}},then:YA,else:{if:{properties:{type:{enum:["row"]}}},then:{properties:{subtype:{type:"string",oneOf:[{enum:["row:heading","row:body"]}]}}},else:{if:{properties:{type:{enum:["node"]}}},then:{properties:{subtype:{type:"string",oneOf:[{enum:["node"]},{pattern:"^x-\\S{1,256}$"}]},atts:{type:"object",properties:{id:{type:"string"},parent:{type:"string"},children:{type:"array",items:{type:"string"}}},required:["id"],additionalProperties:!1}}},else:{if:{properties:{type:{enum:["lookup"]}}},then:{properties:{subtype:{type:"string",oneOf:[{enum:["lookup"]},{pattern:"^x-\\S{1,256}$"}]},atts:{type:"object",properties:{primary:{type:"string"},secondary:{type:"array",items:{type:"string"}}},required:["primary"],additionalProperties:!1}}},else:{properties:{subtype:{type:"string",oneOf:[{pattern:"^usfm:"},{pattern:"^x-\\S{1,256}$"}]}}}}}}},QA="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/constraint/0_3_0/perf_contentElement_constraint.json",e8="object",t8=[{properties:{content:{type:"array",items:{oneOf:[{type:"string"},{$ref:"./perf_contentElement_constraint.json"}]}},meta_content:{type:"array",items:{oneOf:[{type:"string"},{$ref:"./perf_contentElement_constraint.json"}]}}}},{if:{properties:{type:{enum:["graft"]}}},then:{properties:{subtype:{enum:["footnote","xref","note_caller"]}},allOf:[{not:{required:["content"]}},{not:{required:["meta_content"]}}],if:{required:["new"],properties:{new:{enum:[!0]}}},then:{not:{anyOf:[{required:["target"]},{required:["preview_text"]}]}},else:{required:["target"]}}},{if:{properties:{type:{enum:["mark"]}}},then:{properties:{subtype:{type:"string",oneOf:[{enum:["chapter","verses","alt_chapter","alt_verse","pub_chapter","pub_verse"]},{pattern:"^[A-Za-z][A-Za-z0-9]*:\\S+$"},{pattern:"^x-\\S+$"}]}},if:{properties:{subtype:{enum:["chapter","verses"]}}},then:{type:"object",required:["atts"],properties:{atts:{type:"object",required:["number"],maxProperties:1}}}}},{if:{properties:{type:{enum:["wrapper"]}}},then:{properties:{subtype:{type:"string",oneOf:[{enum:["meta_content"]},{pattern:"^[A-Za-z][A-Za-z0-9]*:\\S+$"},{pattern:"^x-\\S+$"}]}},if:{properties:{subtype:{enum:["meta_content"]}}},then:{not:{required:["atts"]}}}},{if:{properties:{type:{enum:["start_milestone"]}}},then:{properties:{subtype:{type:"string",oneOf:[{pattern:"^[A-Za-z][A-Za-z0-9]*:\\S+$"},{pattern:"^x-\\S+$"}]}}}},{if:{properties:{type:{enum:["end_milestone"]}}},then:{properties:{subtype:{type:"string",oneOf:[{pattern:"^[A-Za-z][A-Za-z0-9]*:\\S+$"},{pattern:"^x-\\S+$"}]}},not:{required:["atts"]}}}],n8={$id:QA,type:e8,allOf:t8},r8="version 0.3.0",s8="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/constraint/0_3_0/sofria_document_constraint.json",o8="object",i8={sequence:{$ref:"./sofria_sequence_constraint.json"}},a8={$comment:r8,$id:s8,type:o8,properties:i8},u8="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/constraint/0_3_0/sofria_sequence_constraint.json",c8="object",l8={type:{type:"string",enum:["main","introduction","intro_title","intro_end_title","title","end_title","heading","remark","sidebar","table","tree","kv","footnote","note_caller","xref","pub_number","alt_number","esb_cat","fig","temp"]},blocks:{type:"array",items:{$ref:"./sofria_block_constraint.json"}}},p8={$id:u8,type:c8,properties:l8},d8="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/constraint/0_3_0/sofria_block_constraint.json",f8="object",h8={type:{type:"string",enum:["paragraph","graft"]},content:{type:"array",items:{oneOf:[{type:"string"},{$ref:"./sofria_contentElement_constraint.json"}]}},meta_content:{type:"array",items:{oneOf:[{type:"string"},{$ref:"./sofria_contentElement_constraint.json"}]}}},m8={properties:{subtype:{enum:["introduction","intro_title","Intro_end_title","title","end_title","heading","remark","sidebar","table","tree","kv"]}}},D8={$id:d8,type:f8,properties:h8,if:{properties:{type:{enum:["graft"]}}},then:m8,else:{properties:{subtype:{type:"string",pattern:"^usfm:"}}}},S8="https://github.com/Proskomma/proskomma-json-tools/tree/main/src/schema/constraint/0_3_0/sofria_contentElement_constraint.json",E8="object",y8=[{properties:{content:{type:"array",items:{oneOf:[{type:"string"},{$ref:"./sofria_contentElement_constraint.json"}]}},meta_content:{type:"array",items:{oneOf:[{type:"string"},{$ref:"./sofria_contentElement_constraint.json"}]}}}},{if:{properties:{type:{enum:["graft"]}}},then:{properties:{subtype:{enum:["footnote","xref","note_caller"]}},allOf:[{not:{required:["content"]}},{not:{required:["meta_content"]}}],if:{required:["new"],properties:{new:{enum:[!0]}}},then:{not:{anyOf:[{required:["blocks"]},{required:["preview_text"]}]}},else:{required:["sequence"]}}},{if:{properties:{type:{enum:["mark"]}}},then:{properties:{subtype:{type:"string",oneOf:[{enum:["chapter_label","verses_label","alt_chapter","alt_verse","pub_chapter","pub_verse"]},{pattern:"^[A-Za-z][A-Za-z0-9]*:\\S+$"},{pattern:"^x-\\S+$"}]}},if:{properties:{subtype:{enum:["chapter","verses"]}}},then:{type:"object",required:["atts"],properties:{atts:{type:"object",required:["number"],maxProperties:1}}}}},{if:{properties:{type:{enum:["wrapper"]}}},then:{properties:{subtype:{type:"string",oneOf:[{enum:["meta_content","chapter","verses"]},{pattern:"^[A-Za-z][A-Za-z0-9]*:\\S+$"},{pattern:"^x-\\S+$"}]}},if:{properties:{subtype:{enum:["meta_content"]}}},then:{not:{required:["atts"]}}}},{if:{properties:{type:{enum:["start_milestone"]}}},then:{properties:{subtype:{type:"string",oneOf:[{pattern:"^[A-Za-z][A-Za-z0-9]*:\\S+$"},{pattern:"^x-\\S+$"}]}}}},{if:{properties:{type:{enum:["end_milestone"]}}},then:{properties:{subtype:{type:"string",oneOf:[{pattern:"^[A-Za-z][A-Za-z0-9]*:\\S+$"},{pattern:"^x-\\S+$"}]}},not:{required:["atts"]}}}],g8={$id:S8,type:E8,allOf:y8};var ft=wv,v8=$v,Bi=Vv,Pr=Zv,Nr=a5,_r=m5,A8=g5,bl=C5,Cl=k5,Tl=O5,b8=q5,wl=G5,Fl=W5,Il=Y5,Ri=aA,Or=mA,$r=CA,Br=_A,Dn=qA,C8=UA,kl=WA,Pl=ZA,Nl=n8,T8=a8,_l=p8,Ol=D8,$l=g8;let w8=class{constructor(){this.schema={structure:{},constraint:{},proskomma:{}};for(var[e,n]of[["succinct",{"0.2.0":[{name:"Proskomma Serialized Succinct",validator:new ft().compile(v8)}]}]])this.schema.proskomma[e]=n;for(var[r,s]of[["document",{"0.2.1":[{name:"Document Structure",validator:new ft().addSchema(_r).addSchema(Nr).addSchema(Pr).compile(Bi)}],"0.3.0":[{name:"Document Structure",validator:new ft().addSchema(Dn).addSchema(Br).addSchema($r).addSchema(Or).compile(Ri)}]}],["sequence",{"0.2.1":[{name:"Sequence Structure",validator:new ft().addSchema(_r).addSchema(Nr).compile(Pr)}],"0.3.0":[{name:"Sequence Structure",validator:new ft().addSchema(Dn).addSchema(Br).addSchema($r).compile(Or)}]}]])this.schema.structure[r]=s;for(var[o,i]of[["perfDocument",{"0.2.1":[{name:"Document Structure",validator:new ft().addSchema(_r).addSchema(Nr).addSchema(Pr).compile(Bi)},{name:"PERF Document",validator:new ft().addSchema(Tl).addSchema(Cl).addSchema(bl).compile(A8)}],"0.3.0":[{name:"Document Structure",validator:new ft().addSchema(Dn).addSchema(Br).addSchema($r).addSchema(Or).compile(Ri)},{name:"PERF Document",validator:new ft().addSchema(Dn).addSchema(Nl).addSchema(Pl).addSchema(kl).compile(C8)}]}],["perfSequence",{"0.2.1":[{name:"Sequence Structure",validator:new ft().addSchema(_r).addSchema(Nr).compile(Pr)},{name:"PERF Sequence",validator:new ft().addSchema(Tl).addSchema(Cl).compile(bl)}],"0.3.0":[{name:"Sequence Structure",validator:new ft().addSchema(Dn).addSchema(Br).addSchema($r).compile(Or)},{name:"PERF Sequence",validator:new ft().addSchema(Dn).addSchema(Nl).addSchema(Pl).compile(kl)}]}],["sofriaDocument",{"0.2.1":[{name:"Document Structure",validator:new ft().addSchema(_r).addSchema(Nr).addSchema(Pr).compile(Bi)},{name:"SOFRIA Document",validator:new ft().addSchema(Il).addSchema(Fl).addSchema(wl).compile(b8)}],"0.3.0":[{name:"Document Structure",validator:new ft().addSchema(Dn).addSchema(Br).addSchema($r).addSchema(Or).compile(Ri)},{name:"SOFRIA Document",validator:new ft().addSchema(Dn).addSchema($l).addSchema(Ol).addSchema(_l).compile(T8)}]}],["sofriaSequence",{"0.2.1":[{name:"Sequence Structure",validator:new ft().addSchema(_r).addSchema(Nr).compile(Pr)},{name:"SOFRIA Sequence",validator:new ft().addSchema(Il).addSchema(Fl).compile(wl)}],"0.3.0":[{name:"Sequence Structure",validator:new ft().addSchema(Dn).addSchema(Br).addSchema($r).compile(Or)},{name:"SOFRIA Sequence",validator:new ft().addSchema(Dn).addSchema($l).addSchema(Ol).compile(_l)}]}]])this.schema.constraint[o]=i}schemaInfo(){var e={};for(var[n,r]of Object.entries(this.schema)){e[n]={};for(var[s,o]of Object.entries(r)){e[n][s]={};for(var[i,a]of Object.entries(o))e[n][s][i]=a.map(u=>u.name)}}return e}validate(e,n,r,s){if(s===void 0)throw new Error("data argument is missing. Usage: validate(schemaType, schemaKey, schemaVersion, data)");if(s===null)throw new Error("Data argument is null");var o=Object.keys(this.schema);if(!o.includes(e))throw new Error("Schema type must be one of ".concat(o.map(l=>"'".concat(l,"'")).join(", "),", not '").concat(e,"'"));if(!this.schema[e][n])throw new Error("Unknown ".concat(e," schema key ").concat(n));if(!this.schema[e][n][r])throw new Error("Unknown version ".concat(r," for ").concat(e," schema key ").concat(n));var i=this.schema[e][n][r],a;for(var{name:u,validator:c}of i)if(a={validatorName:u,isValid:c(s),errors:c.errors},!a.isValid)break;return{requested:{schemaType:e,schemaKey:n,schemaVersion:r},lastSchema:a.validatorName,isValid:a.isValid,errors:a.errors}}};var F8=w8,I8=["qs","qac","litl","lik","liv","fr","fq","fqa","fk","fl","fw","fp","fv","ft","fdc","fm","xo","xk","xq","xt","xta","xop","xot","xnt","xdc","rq","add","bk","dc","k","nd","ord","pn","png","qt","sig","sls","tl","wj","em","bd","it","bdit","no","sc","sup","ior","iqt","th","thr","tc","tcr"],k8=["ms","mr","s","sr","r","qa","sp","sd"],P8=["cd","p","m","po","pr","cls","pmo","pm","pmc","pmr","pi","mi","nb","pc","ph","b","q","qr","qc","qa","qm","qd","lh","li","lf","lim","d"],N8=["imt","is","imte"],_8=["ip","ipi","im","imi","ipq","imq","ipr","iq","ib","ili","iot","io","iex"],O8={characterTags:I8,bodyTags:P8,headingTags:k8,introHeadingTags:N8,introBodyTags:_8};const rc=xh(Wh);var Bl=$8(rc);function $8(t){return t&&t.__esModule?t:{default:t}}var B8={startDocument:[{description:"Set up storage",test:()=>!0,action:t=>{var{workspace:e,output:n}=t;e.verseContent=[],e.chapter=null,e.verses=null,n.cv={}}}],mark:[{description:"Update CV state",test:()=>!0,action:t=>{var{context:e,workspace:n,output:r}=t,{element:s}=e.sequences[0];s.subType==="chapter"?(n.chapter=s.atts.number,n.verses=0,r.cv[n.chapter]={},r.cv[n.chapter][n.verses]={}):s.subType==="verses"&&(n.verses=s.atts.number,r.cv[n.chapter][n.verses]={})}}],text:[{description:"Log occurrences",test:()=>!0,action:t=>{var{context:e,workspace:n,output:r}=t,{chapter:s,verses:o}=n,{text:i}=e.sequences[0].element,a=(0,Bl.default)("([\\p{Letter}\\p{Number}\\p{Mark}\\u2060]{1,127})"),u=Bl.default.match(i,a,"all");for(var c of u){var l,p;(p=(l=r.cv[s][o])[c])!==null&&p!==void 0||(l[c]=0),r.cv[s][o][c]+=1}}}]},Xd={verseWordsActions:B8},Rl=R8(rc);function R8(t){return t&&t.__esModule?t:{default:t}}function xl(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter(function(s){return Object.getOwnPropertyDescriptor(t,s).enumerable})),n.push.apply(n,r)}return n}function lo(t){for(var e=1;e<arguments.length;e++){var n=arguments[e]!=null?arguments[e]:{};e%2?xl(Object(n),!0).forEach(function(r){x8(t,r,n[r])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):xl(Object(n)).forEach(function(r){Object.defineProperty(t,r,Object.getOwnPropertyDescriptor(n,r))})}return t}function x8(t,e,n){return e=q8(e),e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}function q8(t){var e=M8(t,"string");return typeof e=="symbol"?e:String(e)}function M8(t,e){if(typeof t!="object"||t===null)return t;var n=t[Symbol.toPrimitive];if(n!==void 0){var r=n.call(t,e||"default");if(typeof r!="object")return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return(e==="string"?String:Number)(t)}var L8={startDocument:[{description:"Set up",test:()=>!0,action:t=>{var{workspace:e,output:n}=t;return e.chapter=null,e.verses=null,e.lastWord="",e.waitingMarkup=[],e.currentOccurrences={},e.PendingStartMilestones=[],n.stripped={},n.unalignedWords={},!0}}],startMilestone:[{description:"Ignore zaln startMilestone events",test:t=>{var{context:e}=t;return e.sequences[0].element.subType==="usfm:zaln"},action:t=>{var{context:e,workspace:n}=t,r=e.sequences[0].element;r.subtype=r.subType,delete r.subType,n.waitingMarkup.push(r),n.PendingStartMilestones.push(r)}}],endMilestone:[{description:"Ignore zaln endMilestone events",test:t=>{var{context:e}=t;return e.sequences[0].element.subType==="usfm:zaln"},action:t=>{var{context:e,workspace:n,output:r,config:s}=t,{chapter:o,verses:i,lastWord:a}=n,{verseWords:u}=s,c=["after",a,n.currentOccurrences[a],u[o][i][a]].join("--"),l=lo({},e.sequences[0].element);l.subtype=l.subType,delete l.subType;var p={chapter:o,verses:i,occurrence:n.currentOccurrences[a],occurrences:u[o][i][a],position:"after",word:a,payload:l,startMilestone:n.PendingStartMilestones.shift()};return r.stripped[n.chapter][n.verses][c]?r.stripped[n.chapter][n.verses][c].push(p):r.stripped[n.chapter][n.verses][c]=[p],!1}}],startWrapper:[{description:"Ignore w startWrapper events",test:t=>{var{context:e}=t;return e.sequences[0].element.subType==="usfm:w"},action:t=>{var{context:e,workspace:n}=t,r=lo({},e.sequences[0].element);r.subtype=r.subType,delete r.subType,n.waitingMarkup.push(r)}}],endWrapper:[{description:"Ignore w endWrapper events",test:t=>{var{context:e}=t;return e.sequences[0].element.subType==="usfm:w"},action:t=>{}}],text:[{description:"Log occurrences",test:()=>!0,action:t=>{var{context:e,workspace:n,output:r,config:s}=t;try{var o=e.sequences[0];if(o.type!=="main")return!0;var i=o.element.text,a=(0,Rl.default)("([\\p{Letter}\\p{Number}\\p{Mark}\\u2060]{1,127})"),u=Rl.default.match(i,a,"all"),{chapter:c,verses:l}=n,{verseWords:p}=s;for(var d of u){var f,S;if((S=(f=n.currentOccurrences)[d])!==null&&S!==void 0||(f[d]=0),n.currentOccurrences[d]++,!n.PendingStartMilestones.length&&n.waitingMarkup.length){var b,F,y,T;(F=(b=r.unalignedWords)[c])!==null&&F!==void 0||(b[c]={}),(T=(y=r.unalignedWords[c])[l])!==null&&T!==void 0||(y[l]=[]),r.unalignedWords[c][l].push({word:d,occurrence:n.currentOccurrences[d],totalOccurrences:p[c][l][d]})}for(;n.waitingMarkup.length;){var O=n.waitingMarkup.shift(),j=["before",d,n.currentOccurrences[d],p[c][l][d]].join("--"),M={chapter:c,verses:l,occurrence:n.currentOccurrences[d],occurrences:p[c][l][d],position:"before",word:d,payload:lo(lo({},O),O.subtype==="usfm:w"&&{content:[d]})};r.stripped[n.chapter][n.verses][j]?r.stripped[n.chapter][n.verses][j].push(M):r.stripped[n.chapter][n.verses][j]=[M]}n.lastWord=d}}catch(ee){throw console.error(ee),ee}return!0}}],mark:[{description:"Update CV state",test:()=>!0,action:t=>{var{context:e,workspace:n,output:r}=t;try{var s=e.sequences[0].element;s.subType==="chapter"?(n.chapter=s.atts.number,n.verses=0,n.lastWord="",n.currentOccurrences={},r.stripped[n.chapter]={},r.stripped[n.chapter][n.verses]={}):s.subType==="verses"&&(n.verses=s.atts.number,n.lastWord="",n.currentOccurrences={},r.stripped[n.chapter][n.verses]={})}catch(o){throw console.error(o),o}return!0}}]},zd={stripMarkupActions:L8},lr=j8(rc);function j8(t){return t&&t.__esModule?t:{default:t}}var Yd=[["printable","wordLike",(0,lr.default)("([\\p{Letter}\\p{Number}\\p{Mark}\\u2060]{1,127})")],["printable","lineSpace",(0,lr.default)("([\\p{Separator}	]{1,127})")],["printable","punctuation",(0,lr.default)("([\\p{Punctuation}\\p{Math_Symbol}\\p{Currency_Symbol}\\p{Modifier_Symbol}\\p{Other_Symbol}])")],["bad","unknown",(0,lr.default)("(.)")]],G8=lr.default.union(Yd.map(t=>t[2])),U8={type:"end_milestone",subtype:"usfm:zaln"},V8={startDocument:[{description:"setup",test:()=>!0,action:t=>{var{workspace:e,output:n}=t;return e.chapter=null,e.verses=null,e.currentOccurrences={},n.unalignedWords={},!0}}],text:[{description:"add-to-text",test:()=>!0,action:t=>{var{config:e,context:n,workspace:r,output:s}=t;try{let T=function(){for(;S.length;)r.outputContentStack[0].push(S.shift())};var o=n.sequences[0];if(o.type!=="main")return!0;var i=n.sequences[0].element.text,a=lr.default.match(i,G8,"all"),{chapter:u,verses:c}=r;if(!c)return!0;var{totalOccurrences:l,strippedAlignment:p}=e,d={opened:null},f=O=>{var{subtype:j,content:M=[],atts:ee={}}=O;return Object.keys(ee).length>0?{type:"wrapper",subtype:j,content:M,atts:ee}:{type:"wrapper",subtype:j,content:M}},S=[],b=function(j){var M,ee,ne,Ne=(M=lr.default.match(j,Yd[0][2],"all"))===null||M===void 0?void 0:M.length;if(!Ne)return S.push(j),"continue";(ne=(ee=r.currentOccurrences)[j])!==null&&ne!==void 0||(ee[j]=0),r.currentOccurrences[j]++;var L=ke=>[ke,j,r.currentOccurrences[j],l[u][c][j]].join("--"),pe=p[u][c],de=!1,re=pe[L("after")],he=pe[L("before")];if(he!=null&&he.length&&T(),re!=null&&re.length&&!d.opened&&(re.map(ke=>{var{startMilestone:Z}=ke;return r.outputContentStack[0].push(Z)}),de=!0),he==null||he.forEach(ke=>{var{payload:Z}=ke;Z.type!=="start_milestone"&&r.outputContentStack[0].push(Z),Z.type==="start_milestone"&&!de&&(r.outputContentStack[0].push(Z),d.opened=!0)}),re==null||re.forEach(ke=>{var{payload:Z}=ke;d.opened=!1,r.outputContentStack[0].push(Z)}),!(he!=null&&he.length)){var Te,Ge,qe,ce;d.opened&&(r.outputContentStack[0].push(U8),d.opened=!1),T(),(Ge=(Te=s.unalignedWords)[u])!==null&&Ge!==void 0||(Te[u]={}),(ce=(qe=s.unalignedWords[u])[c])!==null&&ce!==void 0||(qe[c]=[]),s.unalignedWords[r.chapter][r.verses].push({word:j,occurrence:r.currentOccurrences[j],totalOccurrences:l[u][c][j]});var Ze=f({subtype:"usfm:w",content:[j]});r.outputContentStack[0].push(Ze)}};for(var F of a)var y=b(F);return T(),!1}catch(T){throw console.error(T),T}}}],mark:[{description:"mark-chapters",test:t=>{var{context:e}=t;return e.sequences[0].element.subType==="chapter"},action:t=>{var{config:e,context:n,workspace:r,output:s}=t,o=n.sequences[0].element;return r.chapter=o.atts.number,r.verses=0,!0}},{description:"mark-verses",test:t=>{var{context:e}=t;return e.sequences[0].element.subType==="verses"},action:t=>{var{config:e,context:n,workspace:r,output:s}=t,o=n.sequences[0].element;return r.verses=o.atts.number,r.currentOccurrences={},!0}}]},Zd={mergeAlignmentActions:V8},{verseWordsActions:J8}=Xd,{stripMarkupActions:H8}=zd,{mergeAlignmentActions:W8}=Zd,K8={verseWordsActions:J8,stripMarkupActions:H8,mergeAlignmentActions:W8};let X8=class{constructor(e){if(!e)throw new Error("Must provide a constructor object to constructor");this.description=e.description||function(n){throw n}(new Error("Must provide a description in constructor object")),this.test=e.test||(()=>!0),this.action=e.action||(()=>null)}};var z8=X8,ql=z8;let Y8=class Qd{constructor(e){if(this.constructor===Qd)throw new Error("Abstract class ProskommaRender cannot be instantiated - make as subclass!");var n=e.actions||{};this.debugLevel=e.debugLevel||0,this.actions={};for(var r of["startDocument","endDocument","startSequence","endSequence","unresolvedBlockGraft","blockGraft","startParagraph","endParagraph","metaContent","mark","unresolvedInlineGraft","inlineGraft","startWrapper","endWrapper","startMilestone","endMilestone","text"])n[r]?this.actions[r]=n[r].map(s=>new ql(s)):this.actions[r]=[]}addRenderActionObject(e,n){if(!this.actions[e])throw new Error("Unknown event '".concat(e));this.actions[e].push(n)}addRenderAction(e,n){this.addRenderActionObject(e,new ql(n))}describeRenderActions(e){if(!this.actions[e])throw new Error("Unknown event '".concat(e));var n=["**Actions for ".concat(e,`**
`)];for(var r of this.actions[e])n.push("IF ".concat(r.test.toString(),":")),n.push("    DO ".concat(r.description));return n.join(`
`)}renderDocument(e){var{docId:n,config:r,output:s}=e,o={},i={};return this.renderDocument1({docId:n,config:r,context:o,workspace:i,output:s}),s}renderDocument1(e){throw new Error("Define renderDocument1() in subclass")}renderEvent(e,n){var r=n.context;if(this.debugLevel>1&&console.log("".concat("    ".repeat(r.sequences.length),"EVENT ").concat(e)),!this.actions[e])throw new Error("Unknown event '".concat(e));var s=!1;for(var o of this.actions[e]){var i=!1;try{i=o.test(n)}catch(c){var a="Exception from test of action '".concat(o.description,"' for event ").concat(e," in ").concat(r.sequences.length>0?r.sequences[0].type:"no"," sequence: ").concat(c);throw new Error(a)}if(i){s=!0,this.debugLevel>0&&console.log("".concat("    ".repeat(r.sequences.length),"    ").concat(e," action: ").concat(o.description));var u=!1;try{u=o.action(n)}catch(c){throw new Error("Exception from action '".concat(o.description,"' for event ").concat(e," in ").concat(r.sequences.length>0?r.sequences[0].type:"no"," sequence: ").concat(c))}if(!u)break}}if(["unresolvedBlockGraft","unresolvedInlineGraft"].includes(e)&&this.actions[e].length===0)throw new Error("No action for ".concat(e," graft event in ").concat(r.sequences.length>0?r.sequences[0].type:"no"," sequence: add an action or fix your data!"));!s&&this.debugLevel>1&&console.log("".concat("    ".repeat(r.sequences.length),"    No matching action"))}};var Hs=Y8,Z8=Hs;let Q8=class extends Z8{constructor(e){if(super(e),!e.srcJson)throw new Error("Must provide srcJson");this.srcJson=e.srcJson}renderDocument1(e){var{docId:n,config:r,context:s,workspace:o,output:i}=e,a={config:r,context:s,workspace:o,output:i};s.renderer=this,s.document={id:n,schema:this.srcJson.schema,metadata:this.srcJson.metadata,mainSequenceId:this.srcJson.main_sequence_id,nSequences:Object.keys(this.srcJson.sequences).length},s.sequences=[],this.renderEvent("startDocument",a),this.renderSequenceId(a,this.srcJson.main_sequence_id),this.renderEvent("endDocument",a)}sequenceContext(e,n){return{id:n,type:e.type,nBlocks:e.blocks.length,milestones:new Set([])}}renderSequenceId(e,n){var r=e.context,s=this.srcJson.sequences[n];if(!s)throw new Error("Sequence '".concat(n,"' not found in renderSequenceId()"));r.sequences.unshift(this.sequenceContext(s,n)),this.renderEvent("startSequence",e);for(var[o,i]of s.blocks.entries())r.sequences[0].block={type:i.type,subType:i.subtype,blockN:o,wrappers:[]},i.type==="graft"?i.target&&!this.srcJson.sequences[i.target]?(r.sequences[0].block.target=i.target,this.renderEvent("unresolvedBlockGraft",e)):(r.sequences[0].block.target=i.target,r.sequences[0].block.isNew=i.new||!1,this.renderEvent("blockGraft",e)):(this.renderEvent("startParagraph",e),this.renderContent(i.content,e),this.renderEvent("endParagraph",e)),delete r.sequences[0].block;this.renderEvent("endSequence",e),r.sequences.shift()}renderContent(e,n){for(var r of e)this.renderElement(r,n)}renderElement(e,n){var r=i=>{e.meta_content&&(i.metaContent=e.meta_content,this.renderEvent("metaContent",n))},s=n.context,o={type:e.type||"text"};if(e.subtype&&(o.subType=e.subtype),e.atts?o.atts=e.atts:o.type!=="end_milestone"&&o.type!=="meta_content"&&(o.atts={}),e.target&&(o.target=e.target),e.type==="graft"&&(o.isNew=e.new||!1),o.type==="text"&&(o.text=e),s.sequences[0].element=o,o.type==="text")this.renderEvent("text",n),r(o);else if(o.type==="mark")this.renderEvent("mark",n),r(o);else if(o.type==="start_milestone")this.renderEvent("startMilestone",n),r(o);else if(o.type==="end_milestone")this.renderEvent("endMilestone",n),r(o);else if(o.type==="graft"){if(e.target&&e.target&&!this.srcJson.sequences[e.target]){this.renderEvent("unresolvedInlineGraft",n);return}this.renderEvent("inlineGraft",n),r(o)}else if(o.type==="wrapper")s.sequences[0].block.wrappers.unshift(o.subType),this.renderEvent("startWrapper",n),this.renderContent(e.content,n),s.sequences[0].element=o,r(o),this.renderEvent("endWrapper",n),s.sequences[0].block.wrappers.shift();else throw new Error("Unexpected element type '".concat(o.type));delete s.sequences[0].element}};var Zn=Q8,eb=tb(Zn);function tb(t){return t&&t.__esModule?t:{default:t}}var{verseWordsActions:nb}=Xd,rb=function(e){var{perf:n}=e,r=new eb.default({srcJson:n,actions:nb}),s={};return r.renderDocument({docId:"",config:{},output:s}),{verseWords:s.cv}},sb={name:"verseWords",type:"Transform",description:"PERF=>JSON: Counts words occurrences",inputs:[{name:"perf",type:"json",source:""}],outputs:[{name:"verseWords",type:"json"}],code:rb},ob={verseWords:sb},ib=t=>{var e={};for(var n of t)for(var r of Object.keys(n))e[r]?e[r].push(...n[r]):e[r]=n[r];return e},mi=ib,ab={startDocument:[{description:"identity",test:()=>!0,action:t=>{var{config:e,context:n,workspace:r,output:s}=t;s.perf={},s.perf.schema=n.document.schema,s.perf.metadata=n.document.metadata,s.perf.sequences={}}}],endDocument:[{description:"identity",test:()=>!0,action:t=>{}}],startSequence:[{description:"identity",test:()=>!0,action:t=>{var{config:e,context:n,workspace:r,output:s}=t;s.perf.sequences[n.sequences[0].id]={type:n.sequences[0].type,blocks:[]},r.outputSequence=s.perf.sequences[n.sequences[0].id],n.sequences[0].type==="main"&&(s.perf.main_sequence_id=n.sequences[0].id)}}],endSequence:[{description:"identity",test:()=>!0,action:t=>{var{config:e,context:n,workspace:r,output:s}=t;n.sequences.length>1&&(r.outputSequence=s.perf.sequences[n.sequences[1].id])}}],blockGraft:[{description:"identity",test:()=>!0,action:t=>{var e=t.context.sequences[0].block,n={type:e.type,subtype:e.subType};e.target&&(n.target=e.target,t.context.renderer.renderSequenceId(t,n.target)),e.isNew&&(n.new=e.isNew),t.workspace.outputSequence.blocks.push(n)}}],startParagraph:[{description:"identity",test:()=>!0,action:t=>{var{config:e,context:n,workspace:r,output:s}=t,o=n.sequences[0].block,i={type:o.type,subtype:o.subType,content:[]};r.outputSequence.blocks.push(i),r.currentContent=i.content,r.outputBlock=r.outputSequence.blocks[r.outputSequence.blocks.length-1],r.outputContentStack=[r.outputBlock.content]}}],endParagraph:[{description:"identity",test:()=>!0,action:t=>{}}],metaContent:[{description:"identity",test:()=>!0,action:t=>{var{config:e,context:n,workspace:r,output:s}=t,o=n.sequences[0].element;r.currentContent=o.metaContent;var i=r.outputContentStack[1][r.outputContentStack[1].length-1];i.meta_content=[],r.outputContentStack.unshift(i.meta_content),n.renderer.renderContent(r.currentContent,t),r.outputContentStack.shift()}}],mark:[{description:"identity",test:()=>!0,action:t=>{var{config:e,context:n,workspace:r,output:s}=t,o=n.sequences[0].element,i={type:o.type,subtype:o.subType};o.atts&&typeof o.atts=="object"&&Object.keys(o.atts).length!==0&&(i.atts=o.atts),r.outputContentStack[0].push(i)}}],inlineGraft:[{description:"identity",test:()=>!0,action:t=>{var e=t.context.sequences[0].element,n={type:e.type,subtype:e.subType};if(e.target){n.target=e.target;var r=t.workspace.outputContentStack[0];t.context.renderer.renderSequenceId(t,e.target),t.workspace.outputContentStack[0]=r}e.isNew&&(n.new=e.isNew),t.workspace.outputContentStack[0].push(n)}}],startWrapper:[{description:"identity",test:()=>!0,action:t=>{var{config:e,context:n,workspace:r,output:s}=t,o=n.sequences[0].element,i={type:o.type,subtype:o.subType,content:[]};"atts"in o&&typeof o.atts=="object"&&Object.keys(o.atts).length!==0&&(i.atts=o.atts),r.outputContentStack[0].push(i),r.outputContentStack.unshift(i.content)}}],endWrapper:[{description:"identity",test:()=>!0,action:t=>{var{config:e,context:n,workspace:r,output:s}=t;r.outputContentStack.shift()}}],startMilestone:[{description:"identity",test:()=>!0,action:t=>{var{config:e,context:n,workspace:r,output:s}=t,o=n.sequences[0].element,i={type:o.type,subtype:o.subType};o.atts&&typeof o.atts=="object"&&Object.keys(o.atts).length!==0&&(i.atts=o.atts),r.outputContentStack[0].push(i)}}],endMilestone:[{description:"identity",test:()=>!0,action:t=>{var{config:e,context:n,workspace:r,output:s}=t,o=n.sequences[0].element,i={type:o.type,subtype:o.subType};r.outputContentStack[0].push(i)}}],text:[{description:"identity",test:()=>!0,action:t=>{var{config:e,context:n,workspace:r,output:s}=t,o=n.sequences[0].element;r.outputContentStack[0].push(o.text)}}]},Ws={identityActions:ab},ub=ef(Zn),cb=ef(mi);function ef(t){return t&&t.__esModule?t:{default:t}}var{identityActions:lb}=Ws,{stripMarkupActions:pb}=zd,db=function(e){var{perf:n,verseWords:r}=e,s=new ub.default({srcJson:n,actions:(0,cb.default)([pb,lb])}),o={};return s.renderDocument({docId:"",config:{verseWords:r},output:o}),{perf:o.perf,strippedAlignment:o.stripped,unalignedWords:o.unalignedWords}},fb={name:"stripAlignment",type:"Transform",description:"PERF=>PERF: Strips alignment markup",inputs:[{name:"perf",type:"json",source:""},{name:"verseWords",type:"json",source:""}],outputs:[{name:"perf",type:"json"},{name:"strippedAlignment",type:"json"},{name:"unalignedWords",type:"json"}],code:db},hb={stripAlignment:fb},mb=tf(Zn),Db=tf(mi);function tf(t){return t&&t.__esModule?t:{default:t}}var{identityActions:Sb}=Ws,{mergeAlignmentActions:Eb}=Zd,yb=function(e){var{perf:n,verseWords:r,strippedAlignment:s}=e,o=new mb.default({srcJson:n,actions:(0,Db.default)([Eb,Sb])}),i={};return o.renderDocument({docId:"",config:{totalOccurrences:r,strippedAlignment:s},output:i}),{perf:i.perf,unalignedWords:i.unalignedWords}},gb={name:"mergeAlignment",type:"Transform",description:"PERF=>PERF adds report to verses",inputs:[{name:"perf",type:"json",source:""},{name:"strippedAlignment",type:"json",source:""},{name:"verseWords",type:"json",source:""}],outputs:[{name:"perf",type:"json"},{name:"unalignedWords",type:"json"}],code:yb},vb={mergeAlignment:gb},{verseWords:Ab}=ob,{stripAlignment:bb}=hb,{mergeAlignment:Cb}=vb,Tb={verseWords:Ab,stripAlignment:bb,mergeAlignment:Cb},wb=K8,Fb=Tb,Ib={transforms:Fb,renderActions:wb},kb={},nf=function(e){var{usfm:n,selectors:r,proskomma:s}=e;s.importDocuments(r,"usfm",[n]);var o=s.gqlQuerySync("{documents {id docSetId perf} }").data.documents[0],i=o.id,a=o.docSetId;s.gqlQuerySync('mutation { deleteDocument(docSetId: "'.concat(a,'", documentId: "').concat(i,'") }'));var u=JSON.parse(o.perf);return{perf:u}},Pb={name:"usfmToPerf",type:"Transform",description:"USFM=>PERF: Conversion via Proskomma",inputs:[{name:"usfm",type:"text",source:""},{name:"selectors",type:"json",source:""}],outputs:[{name:"perf",type:"json"}],code:nf},Nb={usfmToPerf:Pb,usfmToPerfCode:nf},{usfmToPerf:_b,usfmToPerfCode:Ob}=Nb,$b={usfmToPerf:_b,usfmToPerfCode:Ob},Bb=kb,Rb=$b,xb={transforms:Rb,renderActions:Bb};function Ml(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter(function(s){return Object.getOwnPropertyDescriptor(t,s).enumerable})),n.push.apply(n,r)}return n}function qb(t){for(var e=1;e<arguments.length;e++){var n=arguments[e]!=null?arguments[e]:{};e%2?Ml(Object(n),!0).forEach(function(r){Mb(t,r,n[r])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):Ml(Object(n)).forEach(function(r){Object.defineProperty(t,r,Object.getOwnPropertyDescriptor(n,r))})}return t}function Mb(t,e,n){return e=Lb(e),e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}function Lb(t){var e=jb(t,"string");return typeof e=="symbol"?e:String(e)}function jb(t,e){if(typeof t!="object"||t===null)return t;var n=t[Symbol.toPrimitive];if(n!==void 0){var r=n.call(t,e||"default");if(typeof r!="object")return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return(e==="string"?String:Number)(t)}var Gb={startDocument:[{description:"identity",test:()=>!0,action:t=>{var{config:e,context:n,workspace:r,output:s}=t;s.sofria={},s.sofria.schema=n.document.schema,s.sofria.metadata=n.document.metadata,s.sofria.sequence={},r.currentSequence=s.sofria.sequence,r.chapter=null,r.verses=null,r.cachedChapter=null,r.cachedVerses=null}}],endDocument:[{description:"identity",test:()=>!0,action:t=>{}}],startSequence:[{description:"identity",test:()=>!0,action:t=>{var{context:e,workspace:n}=t;n.currentSequence.type=e.sequences[0].type,n.currentSequence.blocks=[]}}],endSequence:[{description:"identity",test:()=>!0,action:t=>{var{workspace:e}=t;e.currentSequence.type==="main"&&(e.chapter=null,e.verses=null),e.currentSequence=null}}],blockGraft:[{description:"identity",test:()=>!0,action:t=>{var e=t.context.sequences[0].block,n={type:e.type};if(e.sequence){n.sequence={};var r=t.workspace.currentSequence;t.workspace.currentSequence=n.sequence,t.context.renderer.renderSequence(t),t.workspace.currentSequence=r}t.workspace.currentSequence.blocks.push(n)}}],startParagraph:[{description:"identity",test:()=>!0,action:t=>{var{context:e,workspace:n}=t,r=e.sequences[0].block,s={type:r.type,subtype:r.subType,content:[]};if(n.currentSequence.blocks.push(s),n.currentContent=s.content,n.outputBlock=n.currentSequence.blocks[n.currentSequence.blocks.length-1],n.outputContentStack=[n.outputBlock.content],n.currentSequence.type==="main"){for(var o of["chapter","verses"])if(n[o]){var i={type:"wrapper",subtype:o,content:[],atts:{number:n[o]}};n.outputContentStack[0].push(i),n.outputContentStack.unshift(i.content)}}}}],endParagraph:[{description:"identity",test:()=>!0,action:t=>{}}],metaContent:[{description:"identity",test:()=>!0,action:t=>{var{context:e,workspace:n}=t,r=e.sequences[0].element;n.currentContent=r.metaContent;var s=n.outputContentStack[1][n.outputContentStack[1].length-1];s.meta_content=[],n.outputContentStack.unshift(s.meta_content),e.renderer.renderContent(n.currentContent,t),n.outputContentStack.shift()}}],mark:[{description:"identity",test:()=>!0,action:t=>{var{context:e,workspace:n}=t,r=e.sequences[0].element,s={type:r.type,subtype:r.subType};r.atts&&(s.atts=r.atts),n.outputContentStack[0].push(s)}}],inlineGraft:[{description:"identity",test:()=>!0,action:t=>{var e=t.context.sequences[0].element,n={type:e.type,subtype:e.subType,sequence:{}},r=t.workspace.currentSequence,s=[...t.workspace.outputContentStack];t.workspace.currentSequence=n.sequence,t.context.renderer.renderSequence(t),t.workspace.outputContentStack=s,t.workspace.currentSequence=r,t.workspace.outputContentStack[0].push(n)}}],startWrapper:[{description:"identity",test:()=>!0,action:t=>{var{context:e,workspace:n}=t,r=e.sequences[0].element;r.subType==="chapter"?(n.chapter=r.atts.number,n.cachedChapter=n.chapter):r.subType==="verses"&&(n.verses=r.atts.number,n.cachedVerses=n.verses);var s={type:r.type,subtype:r.subType,content:[]};if("atts"in r&&(s.atts=qb({},r.atts)),n.outputContentStack.length===0)throw new Error("outputContentStack is empty before pushing to its first element, near ".concat(e.document.metadata.document.bookCode," ").concat(n.cachedChapter,":").concat(n.cachedVerses));n.outputContentStack[0].push(s),n.outputContentStack.unshift(s.content)}}],endWrapper:[{description:"identity",test:()=>!0,action:t=>{var{context:e,workspace:n}=t,r=e.sequences[0].element;r.subType==="chapter"?n.chapter=null:r.subType==="verses"&&(n.verses=null),n.outputContentStack.shift()}}],startMilestone:[{description:"identity",test:()=>!0,action:t=>{var{context:e,workspace:n}=t,r=e.sequences[0].element,s={type:r.type,subtype:r.subType};r.atts&&(s.atts=r.atts),n.outputContentStack[0].push(s)}}],endMilestone:[{description:"identity",test:()=>!0,action:t=>{var{context:e,workspace:n}=t,r=e.sequences[0].element,s={type:r.type,subtype:r.subType};n.outputContentStack[0].push(s)}}],text:[{description:"identity",test:()=>!0,action:t=>{var{context:e,workspace:n}=t,r=e.sequences[0].element;n.outputContentStack[0].push(r.text)}}]},Ub={identityActions:Gb},{identityActions:Vb}=Ub,Jb={identityActions:Vb},Hb=function(e){var{perf:n}=e,r=new PerfRenderFromJson({srcJson:n,actions:identityAction}),s={};return r.renderDocument({docId:"",config:{},output:s}),{verseWords:s.cv}},Wb={name:"identity",type:"Transform",description:"identity operation",inputs:[{name:"perf",type:"json",source:""}],outputs:[{name:"perf",type:"json"}],code:Hb},Kb={identity:Wb},{identity:Xb}=Kb,zb={identity:Xb},Yb=Jb,Zb=zb,Qb={transforms:Zb,renderActions:Yb},e6={startDocument:[{description:"Set up word object",test:()=>!0,action:t=>{var{config:e,context:n,workspace:r,output:s}=t;r.words={}}}],text:[{description:"Split strings and add words to word object",test:()=>!0,action:t=>{var{config:e,context:n,workspace:r,output:s}=t;for(var o of n.sequences[0].element.text.split(/[\s:;,.]+/).filter(i=>i.length>0))o=o.toLowerCase(),o in r.words?r.words[o]+=1:r.words[o]=1}}],endDocument:[{description:"Sort words",test:()=>!0,action:t=>{var{config:e,context:n,workspace:r,output:s}=t;s.words=[...Object.entries(r.words)].sort((o,i)=>i[1]-o[1])}}]},rf={wordCountActions:e6},Ll=t=>({type:t.sequences[0].block.type,subType:t.sequences[0].block.subType,pos:t.sequences[0].block.blockN,perfChapter:null}),t6={startDocument:[{description:"Set up storage",test:()=>!0,action:t=>{var{workspace:e,output:n}=t;e.blockRecords=[],n.report={}}}],startParagraph:[{description:"Set up block record",test:()=>!0,action:t=>{var{context:e,workspace:n,output:r}=t;n.blockRecords.push(Ll(e))}}],blockGraft:[{description:"Set up block record",test:()=>!0,action:t=>{var{context:e,workspace:n,output:r}=t;n.blockRecords.push(Ll(e))}}],mark:[{description:"Add chapter number to block record",test:t=>{var{context:e}=t;return e.sequences[0].element.subType==="chapter"},action:t=>{var{config:e,context:n,workspace:r,output:s}=t;r.blockRecords[r.blockRecords.length-1].perfChapter=n.sequences[0].element.atts.number}}],endDocument:[{description:"Populate report",test:()=>!0,action:t=>{var{workspace:e,output:n}=t;for(var[r,s]of Object.entries(e.blockRecords))if(s.perfChapter){for(var o=r,i=!1;o>0&&!i;)e.blockRecords[o-1].type==="paragraph"||e.blockRecords[o-1].subType==="title"?i=!0:o--;n.report[o.toString()]=s.perfChapter}}}]},sf={calculateUsfmChapterPositionsActions:t6},Ot=t=>["toc","toca","mt","imt","s","ms","mte","sd"].includes(t)?t+"1":t,n6=function(e){var n=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};n==null&&(n={});var r="\\".concat(e,"-s |");for(var[s,o]of Object.entries(n))s==="x-morph"&&typeof o!="string"?r=r+Ot(s)+'="'+o.join(",")+'" ':r=r+Ot(s)+'="'+o+'" ';return r+"\\*"},r6=function(e){var n=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{},r=arguments.length>2&&arguments[2]!==void 0?arguments[2]:!1;n==null&&(n={});var s="|";for(var[o,i]of Object.entries(n))s=s+Ot(o)+'="'+i+'" ';return s=s+"\\",r&&(s=s+"+"),s+e+"*"},s6={startDocument:[{description:"Set up environment",test:()=>!0,action:t=>{var{context:e,workspace:n}=t;n.usfmBits=[""],n.nestedWrapper=0;for(var[r,s]of Object.entries(e.document.metadata.document).filter(o=>!["tags","properties","bookCode","cl"].includes(o[0])))n.usfmBits.push("\\".concat(Ot(r)," ").concat(s,`
`))}}],blockGraft:[{description:"Follow block grafts",test:t=>{var{context:e}=t;return["title","heading","introduction"].includes(e.sequences[0].block.subType)},action:t=>{var e=t.context.sequences[0],n=t.config.report[e.block.blockN.toString()],r=e.block.target;n&&e.type==="main"&&t.workspace.usfmBits.push(`
\\c `.concat(n,`
`)),r&&t.context.renderer.renderSequenceId(t,r)}}],inlineGraft:[{description:"Follow inline grafts",test:()=>!0,action:t=>{var e=t.context.sequences[0].element.target;e&&t.context.renderer.renderSequenceId(t,e)}}],startParagraph:[{description:"Output footnote paragraph tag (footnote)",test:t=>{var{context:e}=t;return e.sequences[0].block.subType==="usfm:f"&&e.sequences[0].type==="footnote"||e.sequences[0].block.subType==="usfm:x"&&e.sequences[0].type==="xref"},action:t=>{var{context:e,workspace:n,config:r}=t;n.nestedWrapper=0;var s=e.sequences[0];n.usfmBits.push("\\".concat(Ot(s.block.subType.split(":")[1])," "))}},{description:"Output footnote note_caller tag (footnote)",test:t=>{var{context:e}=t;return e.sequences[0].block.subType==="usfm:f"||e.sequences[0].block.subType==="usfm:x"},action:t=>{var{context:e,workspace:n,config:r}=t;n.nestedWrapper=0}},{description:"Output paragraph tag (main)",test:()=>!0,action:t=>{var{context:e,workspace:n,config:r}=t;n.nestedWrapper=0;var s=e.sequences[0],o=r.report[s.block.blockN.toString()];o&&s.type==="main"&&n.usfmBits.push(`
\\c `.concat(o,`
`)),n.usfmBits.push(`
\\`.concat(Ot(s.block.subType.split(":")[1]),`
`))}}],endParagraph:[{description:"Output footnote paragraph tag (footnote)",test:t=>{var{context:e}=t;return e.sequences[0].block.subType==="usfm:f"&&e.sequences[0].type==="footnote"||e.sequences[0].block.subType==="usfm:x"&&e.sequences[0].type==="xref"},action:t=>{var{context:e,workspace:n,config:r}=t,s=e.sequences[0];n.usfmBits.push("\\".concat(Ot(s.block.subType.split(":")[1]),"*"))}},{description:"Output footnote note_caller tag (footnote)",test:t=>{var{context:e}=t;return e.sequences[0].block.subType==="usfm:f"||e.sequences[0].block.subType==="usfm:x"},action:t=>{}},{description:"Output nl",test:()=>!0,action:t=>{var{workspace:e}=t;e.usfmBits.push(`
`)}}],startMilestone:[{description:"Output start milestone",test:()=>!0,action:t=>{var{context:e,workspace:n}=t,r=e.sequences[0].element,s=n6(Ot(r.subType.split(":")[1]),r.atts);n.usfmBits.push(s)}}],endMilestone:[{description:"Output end milestone",test:()=>!0,action:t=>{var{context:e,workspace:n}=t;n.usfmBits.push("\\".concat(Ot(e.sequences[0].element.subType.split(":")[1]),"-e\\*"))}}],text:[{description:"Output text",test:()=>!0,action:t=>{var{context:e,workspace:n}=t,r=e.sequences[0].element.text;n.usfmBits.push(r)}}],mark:[{description:"Output chapter or verses",test:()=>!0,action:t=>{var{context:e,workspace:n}=t,r=e.sequences[0].element;r.subType==="verses"&&n.usfmBits.push(`
\\v `.concat(r.atts.number,`
`))}}],endSequence:[{description:"Output \\cl",test:t=>{var{context:e}=t;return e.document.metadata.document.cl&&e.sequences[0].type==="title"},action:t=>{var{context:e,workspace:n}=t;n.usfmBits.push(`
\\cl `.concat(e.document.metadata.document.cl,`
`))}}],startWrapper:[{description:"Output start tag",test:()=>!0,action:t=>{var{workspace:e,context:n}=t,r=n.sequences[0];e.nestedWrapper>0?e.usfmBits.push("\\+".concat(Ot(r.element.subType.split(":")[1])," ")):e.usfmBits.push("\\".concat(Ot(r.element.subType.split(":")[1])," ")),e.nestedWrapper+=1}}],endWrapper:[{description:"Output end tag",test:t=>{var{context:e}=t;return!["fr","fq","fqa","fk","fl","fw","fp","ft","xo","xk","xq","xt","xta"].includes(e.sequences[0].element.subType.split(":")[1])},action:t=>{var{workspace:e,context:n}=t;e.nestedWrapper-=1;var r=n.sequences[0],s=r.element.subType.split(":")[1],o=e.nestedWrapper>0;if(s==="w"){var i=r6(Ot(s),r.element.atts,o);e.usfmBits.push(i)}else o?e.usfmBits.push("\\+".concat(Ot(r.element.subType.split(":")[1]),"*")):e.usfmBits.push("\\".concat(Ot(r.element.subType.split(":")[1]),"*"))}},{description:"Do NOT output end tag",test:()=>!0,action:t=>{var{workspace:e}=t;e.nestedWrapper-=1}}],endDocument:[{description:"Build output",test:()=>!0,action:t=>{var{workspace:e,output:n}=t;n.usfm=e.usfmBits.join("").replace(/(\s*)\n(\s*)/gm,`
`)}}]},of={perfToUsfmActions:s6},{wordCountActions:o6}=rf,{calculateUsfmChapterPositionsActions:i6}=sf,{perfToUsfmActions:a6}=of,u6={wordCountActions:o6,perfToUsfmActions:a6,calculateUsfmChapterPositionsActions:i6},c6=l6(Zn);function l6(t){return t&&t.__esModule?t:{default:t}}var{wordCountActions:p6}=rf,d6=function(e){var{perf:n}=e,r=new c6.default({srcJson:n,actions:p6}),s={};return r.renderDocument({docId:"",config:{},output:s}),{report:s.report}},f6={name:"wordCount",type:"Transform",description:"PERF=>JSON: Generates positions for inserting chapter numbers into USFM",inputs:[{name:"perf",type:"json",source:""}],outputs:[{name:"report",type:"json"}],code:d6},h6={wordCount:f6},m6=D6(Zn);function D6(t){return t&&t.__esModule?t:{default:t}}var{calculateUsfmChapterPositionsActions:S6}=sf,E6=function(e){var{perf:n}=e,r=new m6.default({srcJson:n,actions:S6}),s={};return r.renderDocument({docId:"",config:{maxLength:60},output:s}),{report:s.report}},y6={name:"calculateUsfmChapterPositions",type:"Transform",description:"PERF=>JSON: Generates positions for inserting chapter numbers into USFM",inputs:[{name:"perf",type:"json",source:""}],outputs:[{name:"report",type:"json"}],code:E6},g6={calculateUsfmChapterPositions:y6},v6=A6(Zn);function A6(t){return t&&t.__esModule?t:{default:t}}var{perfToUsfmActions:b6}=of,C6=function(e){var{perf:n,report:r}=e,s=new v6.default({srcJson:n,actions:b6}),o={};return s.renderDocument({docId:"",config:{report:r},output:o}),{usfm:o.usfm}},T6={name:"perfToUsfm",type:"Transform",description:"PERF=>USFM",inputs:[{name:"perf",type:"json",source:""},{name:"report",type:"json",source:""}],outputs:[{name:"usfm",type:"text"}],code:C6},w6={perfToUsfm:T6},{wordCount:F6}=h6,{calculateUsfmChapterPositions:I6}=g6,{perfToUsfm:k6}=w6,P6={wordCount:F6,perfToUsfm:k6,calculateUsfmChapterPositions:I6},N6=u6,_6=P6,O6={transforms:_6,renderActions:N6},$6={startMilestone:[{description:"Ignore startMilestone events",test:()=>!0,action:()=>{}}],endMilestone:[{description:"Ignore endMilestone events",test:()=>!0,action:()=>{}}],startWrapper:[{description:"Ignore startWrapper events",test:()=>!0,action:()=>{}}],endWrapper:[{description:"Ignore endWrapper events",test:()=>!0,action:()=>{}}],blockGraft:[{description:"Ignore blockGraft events, except for title (\\mt)",test:t=>t.context.sequences[0].block.subType!=="title",action:t=>{}}],inlineGraft:[{description:"Ignore inlineGraft events",test:()=>!0,action:()=>{}}],mark:[{description:"Ignore mark events, except for chapter and verses",test:t=>{var{context:e}=t;return!["chapter","verses"].includes(e.sequences[0].element.subType)},action:()=>{}}]},af={justTheBibleActions:$6},{identityActions:B6}=Ws,{justTheBibleActions:R6}=af,x6={identityActions:B6,justTheBibleActions:R6},{identityActions:q6}=Ws,M6=function(e){var{perf:n}=e,r=new PerfRenderFromJson({srcJson:n,actions:q6}),s={};return r.renderDocument({docId:"",config:{},output:s}),{verseWords:s.cv}},L6={name:"identityTransform",type:"Transform",description:"identity operation",inputs:[{name:"perf",type:"json",source:""}],outputs:[{name:"perf",type:"json"}],code:M6},j6={identity:L6},G6=uf(Zn),U6=uf(mi);function uf(t){return t&&t.__esModule?t:{default:t}}var{identityActions:V6}=Ws,{justTheBibleActions:J6}=af,H6=function(e){var{perf:n}=e,r=new G6.default({srcJson:n,actions:(0,U6.default)([J6,V6])}),s={};return r.renderDocument({docId:"",config:{},output:s}),{perf:s.perf}},W6={name:"justTheBible",type:"Transform",description:"PERF=>PERF: Strips most markup",documentation:"This transform removes milestones, wrappers and most marks. It has been used in several pipelines. It may also be stripping metaContent.",inputs:[{name:"perf",type:"json",source:""}],outputs:[{name:"perf",type:"json"}],code:H6},K6={justTheBible:W6};const bt={},cf=t=>{let e=typeof t;return e==="number"||e==="string"||e==="boolean"||e==="undefined"||e==="bigint"||e==="symbol"||t===null},Ks=t=>{if(cf(t)||!(t instanceof Object))return"primitive";const e=t.constructor&&t.constructor.name&&t.constructor.name.toLowerCase();if(typeof e=="string"&&e.length&&bt[e])return e;let n;for(const r in bt)if(n=bt[r].type,!n||t instanceof n)return r;return"unknown"},X6=(t,e,n)=>Array.prototype.push.call(t,n),z6=t=>{const e=[];return Object.setPrototypeOf(e,Object.getPrototypeOf(t)),e},Y6=t=>{const e=[...t];return Object.setPrototypeOf(e,Object.getPrototypeOf(t)),e},Z6=(t,e,n)=>{const r=t.length;for(let s=0;s<r;s++){const o=t[s],i={key:s,value:o,type:Ks(o)};n(i)}},Q6=()=>{Object.assign(bt,{array:{type:Array,mayDeepCopy:!0,addElement:X6,makeEmpty:z6,makeShallow:Y6,iterate:Z6}})},e7=()=>{Object.assign(bt,{date:{type:Date,makeShallow:t=>new Date(t.getTime())}})},t7=()=>{Object.assign(bt,{regexp:{type:RegExp,makeShallow:t=>new RegExp(t)}})},n7=()=>{Object.assign(bt,{function:{type:Function,makeShallow:t=>t}})},r7=()=>{Object.assign(bt,{error:{type:Error,makeShallow:t=>{const e=new Error(t.message);return e.stack=t.stack,e}}})},s7=t=>{let e=typeof pr<"u"&&pr[t]||typeof window<"u"&&window[t]||typeof WorkerGlobalScope<"u"&&WorkerGlobalScope[t];typeof e<"u"&&(bt[t.toLowerCase()]={type:e,makeShallow:n=>e.from(n)})},o7=()=>{["Int8Array","Uint8Array","Uint8ClampedArray","Int16Array","Uint16Array","Int32Array","Uint32Array","Float32Array","Float32Array","Float64Array","BigInt64Array","BigUint64Array"].forEach(e=>s7(e))},i7=()=>{typeof ArrayBuffer<"u"&&Object.assign(bt,{arraybuffer:{type:ArrayBuffer,makeShallow:t=>t.slice(0)}})},a7=()=>{typeof Map>"u"||Object.assign(bt,{map:{type:Map,mayDeepCopy:!0,addElement:(t,e,n)=>t.set(e,n),makeEmpty:()=>new Map,makeShallow:t=>new Map(t),iterate:(t,e,n)=>{t.forEach((r,s)=>{const o={key:s,value:r,type:Ks(r)};n(o)})}}})},u7=()=>{typeof Set>"u"||Object.assign(bt,{set:{type:Set,mayDeepCopy:!0,addElement:(t,e,n)=>t.add(n),makeEmpty:()=>new Set,makeShallow:t=>new Set(t),iterate:(t,e,n)=>{t.forEach(r=>{const s={key:null,value:r,type:Ks(r)};n(s)})}}})},c7=()=>{typeof WeakSet>"u"||Object.assign(bt,{weakset:{type:WeakSet,makeShallow:t=>t}})},l7=()=>{typeof WeakMap>"u"||Object.assign(bt,{weakmap:{type:WeakMap,makeShallow:t=>t}})},p7=()=>{typeof Buffer>"u"||Object.assign(bt,{buffer:{type:Buffer,makeShallow:t=>Buffer.from(t)}})},d7=(t,e,n,r=void 0)=>{r?Object.defineProperty(t,e,r):t[e]=n},f7=t=>{const e={};return Object.setPrototypeOf(e,Object.getPrototypeOf(t)),e},h7=t=>{const e=Object.assign({},t);return Object.setPrototypeOf(e,Object.getPrototypeOf(t)),e},m7=(t,e,n)=>{const r=e?Object.getOwnPropertyNames(t):Object.keys(t),s=r.length;for(let o=0;o<s;o++){const i=r[o],a=t[i],u={key:i,value:a,type:Ks(a)};e&&!t.propertyIsEnumerable(i)&&(u.descriptor=Object.getOwnPropertyDescriptor(t,i)),n(u)}},D7=()=>{Object.assign(bt,{object:{type:Object,mayDeepCopy:!0,addElement:d7,makeEmpty:f7,makeShallow:h7,iterate:m7}})},S7=()=>{Object.assign(bt,{unknown:{makeShallow:t=>t},primitive:{makeShallow:t=>t}})};Q6();e7();t7();n7();r7();o7();i7();a7();u7();c7();l7();p7();D7();S7();function E7(t){return bt[t]}var y7=[cf,Ks,E7];const[g7,v7,Ia]=y7,ka={goDeep:!0,includeNonEnumerable:!1,detectCircular:!0,maxDepth:20};function A7(t){Object.keys(ka).forEach(e=>{t[e]===void 0&&(t[e]=ka[e])})}class b7{constructor(){this._seenMap=new WeakMap}setAsCopied(e,n){e instanceof Object&&this._seenMap.set(e,n)}wasCopied(e){return e instanceof Object&&this._seenMap.has(e)}getCopy(e){return this._seenMap.get(e)}}function C7(t,e,n){const{options:r,watcher:s}=n;let o;return e.mayDeepCopy?(o=e.makeEmpty(t),r.detectCircular&&s.setAsCopied(t,o)):o=e.makeShallow(t),o}function T7(t,e){if(t>=e)throw`Error max depth of ${e} levels exceeded, possible circular reference`}const lf=(t,e,n)=>{const{destObject:r,srcType:s,watcher:o,options:i}=e,a=i.detectCircular;T7(++n,i.maxDepth);const u=Ia(s);if(!u.mayDeepCopy)return;const c=u.addElement;u.iterate(t,i.includeNonEnumerable,l=>{const p=l.value,d=l.type,f=Ia(d);let S,b=!1;a&&o.wasCopied(p)?(S=o.getCopy(p),b=!0):S=C7(p,f,{options:i,watcher:o}),c(r,l.key,S,l.descriptor),f.mayDeepCopy&&!b&&lf(p,{destObject:S,srcType:d,watcher:o,options:i},n)})};function w7(t,e=ka){if(A7(e),g7(t))return t;const n=v7(t),r=Ia(n);if(!e.goDeep||!r.mayDeepCopy)return r.makeShallow(t);const s=e.detectCircular?new b7:null;let o=r.makeEmpty(t);return e.detectCircular&&s.setAsCopied(t,o),lf(t,{destObject:o,srcType:n,watcher:s,options:e},0),o}var pf=w7;const F7=On(pf);var I7=k7(pf);function k7(t){return t&&t.__esModule?t:{default:t}}var Xo=t=>{var e=[];for(var n of t)typeof n=="string"?e.length>0&&typeof e[e.length-1]=="string"?e[e.length-1]+=n:e.push(n):(n.content&&(n.content=Xo(n.content)),n.metaContent&&(n.metaContent=Xo(n.content)),e.push(n));return e},P7=t=>{var e=(0,I7.default)(t);for(var n of Object.values(e.sequences))for(var r of n.blocks)r.content&&(r.content=Xo(r.content)),r.metaContent&&(r.metaContent=Xo(r.metaContent));return e},df=function(e){var{perf:n}=e;return{perf:P7(n)}},N7={name:"mergePerfText",type:"Transform",description:"PERF=>PERF: Merge consecutive text strings",inputs:[{name:"perf",type:"json",source:""}],outputs:[{name:"perf",type:"json"}],code:df},_7={mergePerfText:N7,mergePerfTextCode:df},{identity:O7}=j6,{justTheBible:$7}=K6,{mergePerfText:B7,mergePerfTextCode:R7}=_7,x7={identity:O7,justTheBible:$7,mergePerfText:B7,mergePerfTextCode:R7},q7=x6,M7=x7,L7={transforms:M7,renderActions:q7},j7=Ib,G7=xb,U7=Qb,V7=O6,J7=L7,ff={xToPerf:G7,perfToX:V7,sofriaToSofria:U7,alignment:j7,perfToPerf:J7};const H7=[{id:0,type:"Inputs",inputs:{usfm:"text",selectors:"json"}},{id:2,title:"USFM to PERF",name:"usfmToPerf",type:"Transform",inputs:[{name:"usfm",type:"text",source:"Input usfm"},{name:"selectors",type:"json",source:"Input selectors"}],outputs:[{name:"perf",type:"json"}],description:"USFM=>PERF: Conversion via Proskomma"},{id:999,type:"Outputs",outputs:[{name:"perf",type:"json",source:"Transform 2 perf"}]}],W7=[{id:0,type:"Inputs",inputs:{perf:"json",strippedAlignment:"json"}},{id:1,title:"Count stripped perf words",name:"verseWords",transformName:"verseWords",type:"Transform",inputs:[{name:"perf",type:"json",source:"Input perf"}],outputs:[{name:"verseWords",type:"json"}],description:"PERF=>JSON: Counts words occurrences"},{id:2,title:"Merge Back Into Stripped (roundtrip)",name:"mergeAlignment",transformName:"mergeAlignment",type:"Transform",inputs:[{name:"perf",type:"json",source:"Input perf"},{name:"strippedAlignment",type:"json",source:"Input strippedAlignment"},{name:"verseWords",type:"json",source:"Transform 1 verseWords"}],outputs:[{name:"perf",type:"json"},{name:"unalignedWords",type:"json"}],description:"PERF=>PERF adds report to verses"},{id:3,title:"Merge Merged PERF Text",name:"mergePerfText",transformName:"mergePerfText",type:"Transform",inputs:[{name:"perf",type:"json",source:"Transform 2 perf"}],outputs:[{name:"perf",type:"json"}],description:"PERF=>PERF: Merge consecutive text strings"},{id:999,type:"Outputs",outputs:[{name:"perf",type:"json",source:"Transform 3 perf"},{name:"unalignedWords",type:"json",source:"Transform 2 unalignedWords"}]}],K7=[{id:0,type:"Inputs",inputs:{perf:"json"}},{id:1,title:"Count stripped perf words",name:"verseWords",type:"Transform",transformName:"verseWords",inputs:[{name:"perf",type:"json",source:"Input perf"}],outputs:[{name:"verseWords",type:"json"}],description:"PERF=>JSON: Counts words occurrences"},{id:2,title:"Strip Alignment",name:"stripAlignment",type:"Transform",transformName:"stripAlignment",inputs:[{name:"perf",type:"json",source:"Input perf"},{name:"verseWords",type:"json",source:"Transform 1 verseWords"}],outputs:[{name:"perf",type:"json"},{name:"strippedAlignment",type:"json"},{name:"unalignedWords",type:"json"}],description:"PERF=>PERF: Strips alignment markup"},{id:3,title:"Merge stripped perf",name:"mergePerfText",type:"Transform",transformName:"mergePerfText",inputs:[{name:"perf",type:"json",source:"Transform 2 perf"}],outputs:[{name:"perf",type:"json"}],description:"PERF=>PERF: Merge consecutive text strings"},{id:999,type:"Outputs",outputs:[{name:"perf",type:"json",source:"Transform 3 perf"},{name:"strippedAlignment",type:"json",source:"Transform 2 strippedAlignment"},{name:"unalignedWords",type:"json",source:"Transform 2 unalignedWords"}]}],X7=[{id:0,type:"Inputs",inputs:{perf:"json"}},{id:1,title:"Generate report",name:"calculateUsfmChapterPositions",type:"Transform",inputs:[{name:"perf",type:"json",source:"Input perf"}],outputs:[{name:"report",type:"json"}],description:"Generate report from perf to calculate the position of the chapters"},{id:2,title:"PERF to USFM",name:"perfToUsfm",type:"Transform",inputs:[{name:"perf",type:"json",source:"Input perf"},{name:"report",type:"json",source:"Transform 1 report"}],outputs:[{name:"usfm",type:"text"}],description:"PERF=>USFM: Conversion via Proskomma"},{id:999,type:"Outputs",outputs:[{name:"usfm",type:"text",source:"Transform 2 usfm"}]}],z7=[{id:0,type:"Inputs",inputs:{perf:"json"}},{id:1,title:"Simplify Input PERF",name:"justTheBible",transformName:"justTheBible",type:"Transform",inputs:[{name:"perf",type:"json",source:"Input perf"}],outputs:[{name:"perf",type:"json"}]},{id:999,type:"Outputs",outputs:[{name:"perf",type:"json",source:"Transform 1 perf"}]}];var Y7=Xs(H7),Z7=Xs(W7),Q7=Xs(K7),eC=Xs(X7),tC=Xs(z7);function Xs(t){return t&&t.__esModule?t:{default:t}}var hf={usfmToPerfPipeline:Y7.default,mergeAlignmentPipeline:Z7.default,stripAlignmentPipeline:Q7.default,perfToUsfmPipeline:eC.default,justTheBiblePipeline:tC.default};function jl(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter(function(s){return Object.getOwnPropertyDescriptor(t,s).enumerable})),n.push.apply(n,r)}return n}function Gl(t){for(var e=1;e<arguments.length;e++){var n=arguments[e]!=null?arguments[e]:{};e%2?jl(Object(n),!0).forEach(function(r){nC(t,r,n[r])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):jl(Object(n)).forEach(function(r){Object.defineProperty(t,r,Object.getOwnPropertyDescriptor(n,r))})}return t}function nC(t,e,n){return e=rC(e),e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}function rC(t){var e=sC(t,"string");return typeof e=="symbol"?e:String(e)}function sC(t,e){if(typeof t!="object"||t===null)return t;var n=t[Symbol.toPrimitive];if(n!==void 0){var r=n.call(t,e||"default");if(typeof r!="object")return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return(e==="string"?String:Number)(t)}function Ul(t,e,n,r,s,o,i){try{var a=t[o](i),u=a.value}catch(c){n(c);return}a.done?e(u):Promise.resolve(u).then(r,s)}function oC(t){return function(){var e=this,n=arguments;return new Promise(function(r,s){var o=t.apply(e,n);function i(u){Ul(o,r,s,i,a,"next",u)}function a(u){Ul(o,r,s,i,a,"throw",u)}i(void 0)})}}var iC=ff,aC=hf;let uC=class{constructor(e){var{pipelines:n=null,transforms:r=null,proskomma:s=null,verbose:o=!1}=e;if(s!==null){this.proskomma=s;var i="{ id }",a=s.gqlQuerySync(i)||{};if(!a||!a.data.id)throw new Error("Provided Proskomma instance does not have any ID")}if(this.pipelines=aC,this.namespaces=iC,this.transforms={},n!=null)for(var u of Object.keys(n))this.pipelines[u]=n[u];if(r!=null)for(var c of Object.keys(r))this.transforms[c]=r[c];this.verbose=o}getProskomma(){return this.proskomma}setProskomma(e){this.proskomma=e}listPipelinesNames(){return Object.keys(this.pipelines).join(`
`)}listTransformsNames(){return Object.keys(this.transforms).join(`
`)}listNamespacesNames(){return Object.keys(this.namespaces).join(`
`)}getPipeline(e,n){if(!this.pipelines[e])throw new Error("Unknown pipeline name '".concat(e,"'"));var r=this.pipelines[e],s=r[0].inputs;if(Object.keys(s).length!==Object.keys(n).length)throw new Error("".concat(Object.keys(s).length," input(s) expected by ").concat(e," but ").concat(Object.keys(n).length," provided (").concat(Object.keys(n).join(", "),")"));for(var[o,i]of Object.entries(s)){if(!n[o])throw new Error("Input ".concat(o," not provided as input to ").concat(e));if(typeof n[o]=="string"!=(i==="text"))throw new Error("Input ".concat(o," must be ").concat(i," but ").concat(typeof n[o]=="string"?"text":"json"," was provided"))}return r}runPipeline(e,n){var r=this;return oC(function*(){var s=r.getPipeline(e,n);return r.loadTransforms(s,"perf"),yield r.evaluateSteps({specSteps:s,inputValues:n})})()}loadTransforms(e){var n=arguments.length>1&&arguments[1]!==void 0?arguments[1]:"perf",r=e.filter(b=>b.type==="Transform");if(r.length===0)throw new Error("No Transform steps found in report steps");var s=Object.keys(r).map(b=>r[b].name);if(n==="sofria"){var o=null;for(var[i,a]of Object.entries(this.namespaces))if(i==="sofriaToSofria"){a.transforms?o=Object.entries(a.transforms):o=Object.entries(a);for(var[u,c]of o)s.includes(u)&&(this.transforms[u]=c)}}else{var l=null;for(var[p,d]of Object.entries(this.namespaces))if(p!=="sofriaToSofria"){d.transforms?l=Object.entries(d.transforms):l=Object.entries(d);for(var[f,S]of l)s.includes(f)&&(this.transforms[f]=S)}}}evaluateSteps(e){var{specSteps:n,inputValues:r}=e;this.verbose&&console.log("** Evaluate **");var s=n.filter(L=>L.type==="Inputs")[0];if(!s)throw new Error("No Inputs step found in report steps");var o=n.filter(L=>L.type==="Outputs")[0];if(!o)throw new Error("No Outputs step found in report steps");var i=n.filter(L=>L.type==="Transform");if(i.length===0)throw new Error("No Transform steps found in report steps");var a={},u={};for(var c of Object.values(i)){a[c.id]={};for(var l of c.inputs)a[c.id][l.name]=null;u[c.id]={};for(var p of c.outputs)u[c.id][p]=null}for(var[d,f]of Object.entries(r))for(var S of i)for(var b of S.inputs)b.source==="Input ".concat(d)&&(this.verbose&&console.log("Copying Input ".concat(d," to Transform ").concat(S.id," ").concat(b.name," input")),a[S.id][b.name]=f);for(var F=!0;F;){F=!1;for(var y of i)if(Object.values(a[y.id]).filter(L=>!L).length===0&&Object.values(u[y.id]).filter(L=>!L).length>0){this.verbose&&console.log("Evaluating Transform ".concat(y.id));try{u[y.id]=this.transforms[y.name].code(Gl(Gl({},a[y.id]),{},{proskomma:this.getProskomma()}))}catch(L){var T="Error evaluating Transform ".concat(y.id," (name=").concat(y.name,", type=").concat(typeof y.code,"): ").concat(L);throw new Error(T)}for(var O of i)for(var j of O.inputs)for(var M of Object.keys(u[y.id]))j.source==="Transform ".concat(y.id," ").concat(M)&&(this.verbose&&console.log("Copying Transform ".concat(y.id," ").concat(M," output to Transform ").concat(O.id," ").concat(j.name," input")),a[O.id][j.name]=u[y.id][M]);F=!0}}var ee={};for(var ne of o.outputs){var Ne=ne.source.split(" ")[1];this.verbose&&console.log("Copying Transform ".concat(Ne," ").concat(ne.name," to Output ").concat(ne.name)),ee[ne.name]=u[Ne][ne.name]}return this.verbose&&console.log("****"),ee}};var cC=uC;function Vl(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter(function(s){return Object.getOwnPropertyDescriptor(t,s).enumerable})),n.push.apply(n,r)}return n}function Jl(t){for(var e=1;e<arguments.length;e++){var n=arguments[e]!=null?arguments[e]:{};e%2?Vl(Object(n),!0).forEach(function(r){lC(t,r,n[r])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):Vl(Object(n)).forEach(function(r){Object.defineProperty(t,r,Object.getOwnPropertyDescriptor(n,r))})}return t}function lC(t,e,n){return e=pC(e),e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}function pC(t){var e=dC(t,"string");return typeof e=="symbol"?e:String(e)}function dC(t,e){if(typeof t!="object"||t===null)return t;var n=t[Symbol.toPrimitive];if(n!==void 0){var r=n.call(t,e||"default");if(typeof r!="object")return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return(e==="string"?String:Number)(t)}var fC=Hs,sr=t=>{var e=[];for(var n of t.split(""))n.toUpperCase()===n&&n.toLowerCase()!==n?e.push("_".concat(n.toLowerCase())):e.push(n);return e.join("")};let hC=class extends fC{constructor(e){if(super(e),!e.proskomma)throw new Error("No Proskomma");this.pk=e.proskomma,this._tokens=[],this._container=null}renderDocument1(e){var{docId:n,config:r,context:s,workspace:o,output:i}=e,a={config:r,context:s,workspace:o,output:i};s.renderer=this;var u=this.pk.gqlQuerySync('{document(id: "'.concat(n,'") {docSetId mainSequence { id } nSequences sequences {id} headers { key value } } }')),c=u.data.document.docSetId,l=u.data.document.mainSequence.id,p=u.data.document.nSequences;u.data.document.sequences.map(y=>y.id);var d={};for(var f of u.data.document.headers)d[f.key]=f.value;var S=this.pk.gqlQuerySync('{docSet(id: "'.concat(c,'") {selectors {key value}}}')),b={};for(var F of S.data.docSet.selectors)b[F.key]=F.value;s.document={id:n,schema:{structure:"flat",structure_version:"0.2.1",constraints:[{name:"perf",version:"0.2.1"}]},metadata:{translation:{id:c,selectors:b,properties:{},tags:[]},document:Jl(Jl({},d),{},{properties:{},tags:[]})},mainSequenceId:l,nSequences:p},s.sequences=[],this.renderEvent("startDocument",a),this.renderSequenceId(a,l),this.renderEvent("endDocument",a)}sequenceContext(e,n){return{id:n,type:sr(e.type),nBlocks:e.nBlocks,milestones:new Set([])}}renderSequenceId(e,n){var r=e.context,s=this.pk.gqlQuerySync('{document(id: "'.concat(r.document.id,'") {sequence(id:"').concat(n,'") {id type nBlocks } } }')),o=s.data.document.sequence;if(!o)throw new Error("Sequence '".concat(n,"' not found in renderSequenceId()"));r.sequences.unshift(this.sequenceContext(o,n)),this.renderEvent("startSequence",e);for(var i=0,a=0;a<o.nBlocks;a++){var u=this.pk.gqlQuerySync(`{
               document(id: "`.concat(r.document.id,`") {
                 sequence(id:"`).concat(n,`") {
                   blocks(positions:`).concat(a,`) {
                     bg {subType payload}
                     bs {payload}
                     items {type subType payload}
                   }
                 }
               }
             }`)),c=u.data.document.sequence.blocks[0];for(var l of c.bg)r.sequences[0].block={type:"graft",subType:sr(l.subType),blockN:i},r.sequences[0].block.target=l.payload,r.sequences[0].block.isNew=!1,this.renderEvent("blockGraft",e),i++;r.sequences[0].block={type:"paragraph",subType:"usfm:".concat(c.bs.payload.split("/")[1]),blockN:i,wrappers:[]},this.renderEvent("startParagraph",e),this._tokens=[],this.renderContent(c.items,e),this._tokens=[],this.renderEvent("endParagraph",e),delete r.sequences[0].block,i++}this.renderEvent("endSequence",e),r.sequences.shift()}renderContent(e,n){for(var r of e)this.renderItem(r,n);this.maybeRenderText(n)}renderItem(e,n){if(e.type==="scope"&&e.payload.startsWith("attribute")){var r=e.payload.split("/");e.subType==="start"?(this._container||(this._container={direction:"start",subType:"usfm:w",type:"wrapper",atts:{}}),r[3]in this._container.atts?this._container.atts[r[3]].push(r[5]):this._container.atts[r[3]]=[r[5]]):this._container||(this._container={direction:"end",subType:"usfm:".concat(sr(r[2]))},r[1]==="milestone"?this._container.type="end_milestone":(this._container.type="wrapper",this._container.atts={}))}else if(this._container&&(this.maybeRenderText(n),this.renderContainer(n)),e.type==="token")this._tokens.push(e.payload.replace(/\s+/g," "));else if(e.type==="graft"){this.maybeRenderText(n);var s={type:"graft",subType:sr(e.subType),target:e.payload,isNew:!1};n.context.sequences[0].element=s,this.renderEvent("inlineGraft",n),delete n.context.sequences[0].element}else{this.maybeRenderText(n);var o=e.payload.split("/");if(["chapter","verses","pubChapter","pubVerse","altChapter","altVerse"].includes(o[0])){if(e.subType==="start"){var i={type:"mark",subType:sr(o[0]),atts:{number:o[1]}};n.context.sequences[0].element=i,this.renderEvent("mark",n),delete n.context.sequences[0].element}}else if(o[0]==="span"){var a={type:"wrapper",subType:"usfm:".concat(o[1]),atts:{}};n.context.sequences[0].element=a,e.subType==="start"?(n.context.sequences[0].block.wrappers.unshift(a.subType),this.renderEvent("startWrapper",n)):(this.renderEvent("endWrapper",n),n.context.sequences[0].block.wrappers.shift()),delete n.context.sequences[0].element}else if(o[0]==="spanWithAtts")e.subType==="start"&&(this._container={direction:"start",type:"wrapper",subType:"usfm:".concat(o[1]),atts:{}});else if(o[0]==="milestone"&&e.subType==="start")if(o[1]==="ts"){var u={type:"mark",subType:"usfm:".concat(sr(o[1])),atts:{}};n.context.sequences[0].element=u,this.renderEvent("mark",n),delete n.context.sequences[0].element}else this._container={type:"start_milestone",subType:"usfm:".concat(sr(o[1])),atts:{}}}}maybeRenderText(e){if(this._tokens.length!==0){var n={type:"text",text:this._tokens.join("")};e.context.sequences[0].element=n,this._tokens=[],this.renderEvent("text",e),delete e.context.sequences[0].element}}renderContainer(e){if(this._container.type==="wrapper"){var n=this._container.direction;delete this._container.direction,n==="start"?(e.context.sequences[0].element=this._container,e.context.sequences[0].block.wrappers.unshift(this._container.subType),this.renderEvent("startWrapper",e),delete e.context.sequences[0].element):(e.context.sequences[0].element=this._container,this.renderEvent("endWrapper",e),e.context.sequences[0].block.wrappers.shift(),delete e.context.sequences[0].element)}else this._container.type==="start_milestone"?(e.context.sequences[0].element=this._container,this.renderEvent("startMilestone",e),delete e.context.sequences[0].element):this._container.type==="end_milestone"&&(e.context.sequences[0].element=this._container,this.renderEvent("endMilestone",e),delete e.context.sequences[0].element);this._container=null}};var mC=hC,DC=Hs;let SC=class extends DC{constructor(e){if(super(e),!e.srcJson)throw new Error("Must provide srcJson");this.srcJson=e.srcJson,this.cachedSequences=[]}renderDocument1(e){var{docId:n,config:r,context:s,workspace:o,output:i}=e,a={config:r,context:s,workspace:o,output:i};s.renderer=this,s.document={id:n,schema:this.srcJson.schema,metadata:this.srcJson.metadata},s.sequences=[],this.renderEvent("startDocument",a),this.renderSequence(a,this.srcJson.sequence),this.renderEvent("endDocument",a)}sequenceContext(e){return{type:e.type,nBlocks:e.blocks.length,milestones:new Set([])}}renderSequence(e,n){var r;if(n)r=n;else{if(this.cachedSequences.length===0)throw new Error("No sequence provided and no sequences cached");r=this.cachedSequences[0]}var s=e.context;s.sequences.unshift(r),this.renderEvent("startSequence",e);for(var[o,i]of r.blocks.entries())s.sequences[0].block={type:i.type,blockN:o,wrappers:[]},i.type==="graft"?(s.sequences[0].block.sequence=this.sequenceContext(i.sequence),this.cachedSequences.unshift(i.sequence),this.renderEvent("blockGraft",e),this.cachedSequences.shift()):(this.renderEvent("startParagraph",e),this.renderContent(i.content,e),this.renderEvent("endParagraph",e)),delete s.sequences[0].block;this.renderEvent("endSequence",e),this.cachedSequence=null,s.sequences.shift()}renderContent(e,n){for(var r of e)this.renderElement(r,n)}renderElement(e,n){var r=i=>{e.meta_content&&(i.metaContent=e.meta_content,this.renderEvent("metaContent",n))},s=n.context,o={type:e.type||"text"};if(e.subtype&&(o.subType=e.subtype),e.atts?o.atts=e.atts:o.type!=="end_milestone"&&o.type!=="meta_content"&&(o.atts={}),e.sequence&&(o.sequence=this.sequenceContext(e.sequence)),o.type==="text"&&(o.text=e),s.sequences[0].element=o,o.type==="text")this.renderEvent("text",n),r(o);else if(o.type==="mark")this.renderEvent("mark",n),r(o);else if(o.type==="start_milestone")this.renderEvent("startMilestone",n),r(o);else if(o.type==="end_milestone")this.renderEvent("endMilestone",n),r(o);else if(o.type==="graft")this.cachedSequences.unshift(e.sequence),this.renderEvent("inlineGraft",n),this.cachedSequences.shift(),r(o);else if(o.type==="wrapper")s.sequences[0].block.wrappers.unshift(o.subType),this.renderEvent("startWrapper",n),this.renderContent(e.content,n),s.sequences[0].element=o,r(o),this.renderEvent("endWrapper",n),s.sequences[0].block.wrappers.shift();else throw new Error("Unexpected element type '".concat(o.type));delete s.sequences[0].element}};var EC=SC;function Hl(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter(function(s){return Object.getOwnPropertyDescriptor(t,s).enumerable})),n.push.apply(n,r)}return n}function Wl(t){for(var e=1;e<arguments.length;e++){var n=arguments[e]!=null?arguments[e]:{};e%2?Hl(Object(n),!0).forEach(function(r){yC(t,r,n[r])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):Hl(Object(n)).forEach(function(r){Object.defineProperty(t,r,Object.getOwnPropertyDescriptor(n,r))})}return t}function yC(t,e,n){return e=gC(e),e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}function gC(t){var e=vC(t,"string");return typeof e=="symbol"?e:String(e)}function vC(t,e){if(typeof t!="object"||t===null)return t;var n=t[Symbol.toPrimitive];if(n!==void 0){var r=n.call(t,e||"default");if(typeof r!="object")return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return(e==="string"?String:Number)(t)}var AC=Hs,Mn=t=>{var e=[];for(var n of t.split(""))n.toUpperCase()===n&&n.toLowerCase()!==n?e.push("_".concat(n.toLowerCase())):e.push(n);return e.join("")};let bC=class extends AC{constructor(e){if(super(e),!e.proskomma)throw new Error("No Proskomma");this.pk=e.proskomma,this._tokens=[],this._container=null,this.cachedSequenceIds=[],this.sequences=null,this.currentCV={chapter:null,verses:null}}renderDocument1(e){var{docId:n,config:r,context:s,workspace:o,output:i}=e,a={config:r,context:s,workspace:o,output:i};s.renderer=this;var u=this.pk.gqlQuerySync(`{
          document(id: "`.concat(n,`") {
            docSetId
            mainSequence { id }
            nSequences
            sequences {
              id
              type
              nBlocks
            }
            headers {
              key
              value
            }
          } 
        }`)),c=u.data.document.docSetId,l=u.data.document.mainSequence.id,p=u.data.document.nSequences;this.sequences={};for(var d of u.data.document.sequences)this.sequences[d.id]=d;var f={};for(var S of u.data.document.headers)f[S.key]=S.value;var b=this.pk.gqlQuerySync('{docSet(id: "'.concat(c,'") {selectors {key value}}}')),F={};for(var y of b.data.docSet.selectors)F[y.key]=y.value;s.document={id:n,schema:{structure:"nested",structure_version:"0.2.1",constraints:[{name:"sofria",version:"0.2.1"}]},metadata:{translation:{id:c,selectors:F,properties:{},tags:[]},document:Wl(Wl({},f),{},{properties:{},tags:[]})},mainSequenceId:l,nSequences:p},r.chapters&&(s.document.metadata.document.properties.chapters=r.chapters[0]),s.sequences=[],this.renderEvent("startDocument",a),this.cachedSequenceIds.unshift(l),this.renderSequence(a,l),this.cachedSequenceIds.shift(),this.renderEvent("endDocument",a)}sequenceContext(e,n){return{id:n,type:Mn(e.type),nBlocks:e.nBlocks,milestones:new Set([])}}renderSequence(e){var n=e.context,r=this.cachedSequenceIds[0],s=this.pk.gqlQuerySync('{document(id: "'.concat(n.document.id,'") {sequence(id:"').concat(r,'") {id type nBlocks blocks { os {payload} is {payload} } } } }')),o=s.data.document.sequence;if(!o)throw new Error("Sequence '".concat(r,"' not found in renderSequenceId()"));n.sequences.unshift(this.sequenceContext(o,r)),this.renderEvent("startSequence",e);for(var i=0,a=0;a<o.nBlocks;a++){if(e.config.chapters&&o.type==="main"){var u=[...o.blocks[a].os.map(T=>T.payload),...o.blocks[a].is.map(T=>T.payload)].filter(T=>["chapter"].includes(T.split("/")[0])).map(T=>T.split("/")[1]);if(u.length===0||!e.config.chapters.includes(u[0]))continue}var c=this.pk.gqlQuerySync(`{
               document(id: "`.concat(n.document.id,`") {
                 sequence(id:"`).concat(r,`") {
                   blocks(positions:`).concat(a,`) {
                     bg {subType payload}
                     bs {payload}
                     items {type subType payload}
                   }
                 }
               }
             }`)),l=c.data.document.sequence.blocks[0];for(var p of l.bg)n.sequences[0].block={type:"graft",subType:Mn(p.subType),blockN:i,sequence:this.sequences[p.payload]},this.cachedSequenceIds.unshift(p.payload),this.renderEvent("blockGraft",e),this.cachedSequenceIds.shift(),i++;var d=l.bs.payload.split("/"),f=d[1]?"usfm:".concat(d[1]):d[0];if(n.sequences[0].block={type:"paragraph",subType:f,blockN:i,wrappers:[]},this.renderEvent("startParagraph",e),this._tokens=[],o.type==="main"&&this.currentCV.chapter){var S={type:"wrapper",subType:"chapter",atts:{number:this.currentCV.chapter}};e.context.sequences[0].element=S,e.context.sequences[0].block.wrappers.unshift(S.subType),this.renderEvent("startWrapper",e)}if(o.type==="main"&&this.currentCV.verses){var b={type:"wrapper",subType:"verses",atts:{number:this.currentCV.verses}};e.context.sequences[0].element=b,e.context.sequences[0].block.wrappers.unshift(b.subType),this.renderEvent("startWrapper",e)}if(this.renderContent(l.items,e),this._tokens=[],o.type==="main"&&this.currentCV.verses){var F={type:"wrapper",subType:"verses",atts:{number:this.currentCV.verses}};e.context.sequences[0].element=F,e.context.sequences[0].block.wrappers.shift(),this.renderEvent("endWrapper",e)}if(o.type==="main"&&this.currentCV.chapter){var y={type:"wrapper",subType:"chapter",atts:{number:this.currentCV.chapter}};e.context.sequences[0].element=y,e.context.sequences[0].block.wrappers.shift(),this.renderEvent("endWrapper",e)}this.renderEvent("endParagraph",e),delete n.sequences[0].block,i++}this.renderEvent("endSequence",e),n.sequences.shift()}renderContent(e,n){for(var r of e)this.renderItem(r,n);this.maybeRenderText(n)}renderItem(e,n){if(e.type==="scope"&&e.payload.startsWith("attribute")){var r=e.payload.split("/");e.subType==="start"?(this._container||(this._container={direction:"start",subType:"usfm:w",type:"wrapper",atts:{}}),r[3]in this._container.atts?this._container.atts[r[3]].push(r[5]):this._container.atts[r[3]]=[r[5]]):this._container||(this._container={direction:"end",subType:"usfm:".concat(Mn(r[2]))},r[1]==="milestone"?this._container.type="end_milestone":(this._container.type="wrapper",this._container.atts={}))}else if(this._container&&(this.maybeRenderText(n),this.renderContainer(n)),e.type==="token")this._tokens.push(e.payload.replace(/\s+/g," "));else if(e.type==="graft"){this.maybeRenderText(n);var s={type:"graft",subType:Mn(e.subType),sequence:this.sequences[e.payload]};n.context.sequences[0].element=s,this.cachedSequenceIds.unshift(e.payload),this.renderEvent("inlineGraft",n),this.cachedSequenceIds.shift(),delete n.context.sequences[0].element}else{this.maybeRenderText(n);var o=e.payload.split("/");if(["chapter","verses"].includes(o[0])){var i={type:"wrapper",subType:Mn(o[0]),atts:{number:o[1]}};if(n.context.sequences[0].element=i,e.subType==="start"){this.currentCV[o[0]]=o[1],n.context.sequences[0].block.wrappers.unshift(i.subType),this.renderEvent("startWrapper",n);var a={type:"mark",subType:"".concat(o[0],"_label"),atts:{number:o[1]}};n.context.sequences[0].element=a,this.renderEvent("mark",n),n.context.sequences[0].element=i}else this.renderEvent("endWrapper",n),n.context.sequences[0].block.wrappers.shift(),delete n.context.sequences[0].element,this.currentCV[o[0]]=null}else if(["pubChapter","pubVerse","altChapter","altVerse"].includes(o[0])){if(e.subType==="start"){var u={type:"mark",subType:Mn(o[0]),atts:{number:o[1]}};n.context.sequences[0].element=u,this.renderEvent("mark",n),delete n.context.sequences[0].element}}else if(o[0]==="span"){var c={type:"wrapper",subType:"usfm:".concat(o[1]),atts:{}};n.context.sequences[0].element=c,e.subType==="start"?(n.context.sequences[0].block.wrappers.unshift(c.subType),this.renderEvent("startWrapper",n)):(this.renderEvent("endWrapper",n),n.context.sequences[0].block.wrappers.shift()),delete n.context.sequences[0].element}else if(o[0]==="spanWithAtts")e.subType==="start"&&(this._container={direction:"start",type:"wrapper",subType:"usfm:".concat(o[1]),atts:{}});else if(o[0]==="milestone"&&e.subType==="start")if(o[1]==="ts"){var l={type:"mark",subType:"usfm:".concat(Mn(o[1])),atts:{}};n.context.sequences[0].element=l,this.renderEvent("mark",n),delete n.context.sequences[0].element}else this._container={type:"start_milestone",subType:"usfm:".concat(Mn(o[1])),atts:{}}}}maybeRenderText(e){if(this._tokens.length!==0){var n={type:"text",text:this._tokens.join("")};e.context.sequences[0].element=n,this._tokens=[],this.renderEvent("text",e),delete e.context.sequences[0].element}}renderContainer(e){if(this._container.type==="wrapper"){var n=this._container.direction;delete this._container.direction,n==="start"?(e.context.sequences[0].element=this._container,e.context.sequences[0].block.wrappers.unshift(this._container.subType),this.renderEvent("startWrapper",e),delete e.context.sequences[0].element):(e.context.sequences[0].element=this._container,this.renderEvent("endWrapper",e),e.context.sequences[0].block.wrappers.shift(),delete e.context.sequences[0].element)}else this._container.type==="start_milestone"?(e.context.sequences[0].element=this._container,this.renderEvent("startMilestone",e),delete e.context.sequences[0].element):this._container.type==="end_milestone"&&(e.context.sequences[0].element=this._container,this.renderEvent("endMilestone",e),delete e.context.sequences[0].element);this._container=null}};var CC=bC,TC=F8,wC=O8,FC=cC,IC=Hs,kC=Zn,PC=mC,NC=EC,_C=CC,OC=mi,$C=hf,BC=ff,Fn={Validator:TC,usfmHelps:wC,ProskommaRender:IC,PerfRenderFromJson:kC,SofriaRenderFromJson:NC,SofriaRenderFromProskomma:_C,PerfRenderFromProskomma:PC,mergeActions:OC,PipelineHandler:FC,pipelines:$C,render:BC};const Qn=[["chapter","chapter",B("([\\r\\n]*\\\\c[ \\t]+(\\d+)[ \\t\\r\\n]*)")],["pubchapter","pubchapter",B("([\\r\\n]*\\\\cp[ \\t]+([^\\r\\n]+)[ \\t\\r\\n]*)")],["verses","verses",B("(\\\\v[ \\t]+([\\d\\-]+)[ \\t\\r\\n]*)")],["attribute","attribute",B('([ \\t]*\\|?[ \\t]*([A-Za-z0-9\\-]+)="([^"]*)"[ \\t]?)')],["attribute","defaultAttribute",B("([ \\t]*\\|[ \\t]*([^\\|\\\\]*))")],["milestone","emptyMilestone",B('(\\\\([a-z1-9]+)([ \\t]*\\|[ \\t]*[a-z1-9]+="[^\\|\\\\"]*")*\\\\[*])')],["milestone","startMilestoneTag",B("(\\\\([a-z1-9]+)-([se]))")],["milestone","endMilestoneMarker",B("(\\\\([*]))")],["tag","endTag",B("(\\\\([+]?[a-z\\-]+)([1-9]?(-([1-9]))?)[*])")],["tag","startTag",B("(\\\\([+]?[a-z\\-]+)([1-9]?(-([1-9]))?)[ \\t]?)")],["bad","bareSlash",B("(\\\\)")],["printable","eol",B("([ \\t]*[\\r\\n]+[ \\t]*)")],["break","softLineBreak",B("//")],["printable","wordLike",B("([\\p{Letter}\\p{Number}\\p{Mark}\\u2060~]{1,127})")],["printable","lineSpace",B("([\\p{Separator}	]{1,127})")],["printable","punctuation",B("([\\p{Punctuation}\\p{Math_Symbol}\\p{Currency_Symbol}\\p{Modifier_Symbol}\\p{Other_Symbol}])")],["bad","unknown",B("(.)")]],mf=B.union(Qn.map(t=>t[2])),xi=(t,e)=>({subclass:t,printValue:e[0].replace(/~/g," ")}),RC=(t,e)=>({subclass:t,numberString:e[2],number:parseInt(e[2]),printValue:`\\c ${e[2]}
`}),xC=(t,e)=>{const n={subclass:t,numberString:e[2],printValue:`\\v ${e[2]}
`};if(n.numberString.includes("-")){const[r,s]=n.numberString.split("-").map(o=>parseInt(o));n.numbers=Array.from(Array(s-r+1).keys()).map(o=>o+r)}else n.numbers=[parseInt(n.numberString)];return n},qC=(t,e)=>{let n;return t==="defaultAttribute"?n={subclass:t,key:"default",valueString:e[2].trim().replace(/\//g,"÷")}:n={subclass:t,key:e[2],valueString:e[3].trim().replace(/\//g,"÷")},n.values=n.valueString.split(",").map(r=>r.trim()),n.printValue=`| ${n.key}="${n.valueString}"`,n},MC=(t,e)=>({subclass:t,numberString:e[2],printValue:`\\cp ${e[2]}
`}),LC=(t,e)=>{const n={subclass:t,sOrE:null};return t==="endMilestoneMarker"?n.printValue="\\*":(n.tagName=e[2],t==="emptyMilestone"?(n.printValue=`\\${n.tagName}\\*`,n.attributes=e[1]?e[1].split("|").slice(1).map(r=>r.split("=")).map(r=>[r[0],r[1].replace(/"/g,"").replace(/[\\*]/g,"")]):[]):(n.printValue=`\\${n.tagName}`,n.sOrE=e[3])),n},jC=(t,e)=>{const n={subclass:t,tagName:e[2],isNested:!1};return n.tagName.startsWith("+")&&(n.isNested=!0,n.tagName=n.tagName.substring(1)),n.tagLevel=e[3]!==""?parseInt(e[3]):1,n.fullTagName=`${n.tagName}${e[3]==="1"?"":e[3]}`,n.printValue=t==="startTag"?`\\${n.fullTagName} `:`\\${n.fullTagName}*`,n},me={printable:xi,chapter:RC,pubchapter:MC,verses:xC,tag:jC,break:xi,milestone:LC,attribute:qC,bad:xi},Df=(t,e)=>{for(let n=0;n<e.length;n++){let[r,s,o]=e[n],i=B.exec(t,o,0,"sticky");if(i)return me[r](s,i)}throw new Error(`Could not match preToken fragment '${t}'`)},GC=(t,e)=>{const n=B.match(t,mf,"all");for(let r=0;r<n.length;r++)e.parseItem(Df(n[r],Qn))};var Sf={},qi,Kl;function UC(){if(Kl)return qi;Kl=1,qi=t;function t(n){if(n)return e(n)}function e(n){for(var r in t.prototype)n[r]=t.prototype[r];return n}return t.prototype.on=t.prototype.addEventListener=function(n,r){return this._callbacks=this._callbacks||{},(this._callbacks[n]=this._callbacks[n]||[]).push(r),this},t.prototype.once=function(n,r){var s=this;this._callbacks=this._callbacks||{};function o(){s.off(n,o),r.apply(this,arguments)}return o.fn=r,this.on(n,o),this},t.prototype.off=t.prototype.removeListener=t.prototype.removeAllListeners=t.prototype.removeEventListener=function(n,r){if(this._callbacks=this._callbacks||{},arguments.length==0)return this._callbacks={},this;var s=this._callbacks[n];if(!s)return this;if(arguments.length==1)return delete this._callbacks[n],this;for(var o,i=0;i<s.length;i++)if(o=s[i],o===r||o.fn===r){s.splice(i,1);break}return this},t.prototype.emit=function(n){this._callbacks=this._callbacks||{};var r=[].slice.call(arguments,1),s=this._callbacks[n];if(s){s=s.slice(0);for(var o=0,i=s.length;o<i;++o)s[o].apply(this,r)}return this},t.prototype.listeners=function(n){return this._callbacks=this._callbacks||{},this._callbacks[n]||[]},t.prototype.hasListeners=function(n){return!!this.listeners(n).length},qi}var Mi,Xl;function VC(){if(Xl)return Mi;Xl=1;var t=UC();function e(){t.call(this)}return e.prototype=new t,Mi=e,e.Stream=e,e.prototype.pipe=function(n,r){var s=this;function o(d){n.writable&&n.write(d)===!1&&s.pause&&s.pause()}s.on("data",o);function i(){s.readable&&s.resume&&s.resume()}n.on("drain",i),!n._isStdio&&(!r||r.end!==!1)&&(s.on("end",u),s.on("close",c));var a=!1;function u(){a||(a=!0,n.end())}function c(){a||(a=!0,typeof n.destroy=="function"&&n.destroy())}function l(d){if(p(),!this.hasListeners("error"))throw d}s.on("error",l),n.on("error",l);function p(){s.off("data",o),n.off("drain",i),s.off("end",u),s.off("close",c),s.off("error",l),n.off("error",l),s.off("end",p),s.off("close",p),n.off("end",p),n.off("close",p)}return s.on("end",p),s.on("close",p),n.on("end",p),n.on("close",p),n.emit("pipe",s),n},Mi}var Li={},po={exports:{}},ji={},fo={};/*! ieee754. BSD-3-Clause License. Feross Aboukhadijeh <https://feross.org/opensource> */var zl;function JC(){return zl||(zl=1,fo.read=function(t,e,n,r,s){var o,i,a=s*8-r-1,u=(1<<a)-1,c=u>>1,l=-7,p=n?s-1:0,d=n?-1:1,f=t[e+p];for(p+=d,o=f&(1<<-l)-1,f>>=-l,l+=a;l>0;o=o*256+t[e+p],p+=d,l-=8);for(i=o&(1<<-l)-1,o>>=-l,l+=r;l>0;i=i*256+t[e+p],p+=d,l-=8);if(o===0)o=1-c;else{if(o===u)return i?NaN:(f?-1:1)*(1/0);i=i+Math.pow(2,r),o=o-c}return(f?-1:1)*i*Math.pow(2,o-r)},fo.write=function(t,e,n,r,s,o){var i,a,u,c=o*8-s-1,l=(1<<c)-1,p=l>>1,d=s===23?Math.pow(2,-24)-Math.pow(2,-77):0,f=r?0:o-1,S=r?1:-1,b=e<0||e===0&&1/e<0?1:0;for(e=Math.abs(e),isNaN(e)||e===1/0?(a=isNaN(e)?1:0,i=l):(i=Math.floor(Math.log(e)/Math.LN2),e*(u=Math.pow(2,-i))<1&&(i--,u*=2),i+p>=1?e+=d/u:e+=d*Math.pow(2,1-p),e*u>=2&&(i++,u/=2),i+p>=l?(a=0,i=l):i+p>=1?(a=(e*u-1)*Math.pow(2,s),i=i+p):(a=e*Math.pow(2,p-1)*Math.pow(2,s),i=0));s>=8;t[n+f]=a&255,f+=S,a/=256,s-=8);for(i=i<<s|a,c+=s;c>0;t[n+f]=i&255,f+=S,i/=256,c-=8);t[n+f-S]|=b*128}),fo}/*!
 * The buffer module from node.js, for the browser.
 *
 * @author   Feross Aboukhadijeh <https://feross.org>
 * @license  MIT
 */var Yl;function HC(){return Yl||(Yl=1,function(t){const e=zr,n=JC(),r=typeof Symbol=="function"&&typeof Symbol.for=="function"?Symbol.for("nodejs.util.inspect.custom"):null;t.Buffer=a,t.SlowBuffer=T,t.INSPECT_MAX_BYTES=50;const s=2147483647;t.kMaxLength=s,a.TYPED_ARRAY_SUPPORT=o(),!a.TYPED_ARRAY_SUPPORT&&typeof console<"u"&&typeof console.error=="function"&&console.error("This browser lacks typed array (Uint8Array) support which is required by `buffer` v5.x. Use `buffer` v4.x if you require old browser support.");function o(){try{const w=new Uint8Array(1),h={foo:function(){return 42}};return Object.setPrototypeOf(h,Uint8Array.prototype),Object.setPrototypeOf(w,h),w.foo()===42}catch{return!1}}Object.defineProperty(a.prototype,"parent",{enumerable:!0,get:function(){if(a.isBuffer(this))return this.buffer}}),Object.defineProperty(a.prototype,"offset",{enumerable:!0,get:function(){if(a.isBuffer(this))return this.byteOffset}});function i(w){if(w>s)throw new RangeError('The value "'+w+'" is invalid for option "size"');const h=new Uint8Array(w);return Object.setPrototypeOf(h,a.prototype),h}function a(w,h,D){if(typeof w=="number"){if(typeof h=="string")throw new TypeError('The "string" argument must be of type string. Received type number');return p(w)}return u(w,h,D)}a.poolSize=8192;function u(w,h,D){if(typeof w=="string")return d(w,h);if(ArrayBuffer.isView(w))return S(w);if(w==null)throw new TypeError("The first argument must be one of type string, Buffer, ArrayBuffer, Array, or Array-like Object. Received type "+typeof w);if(Ae(w,ArrayBuffer)||w&&Ae(w.buffer,ArrayBuffer)||typeof SharedArrayBuffer<"u"&&(Ae(w,SharedArrayBuffer)||w&&Ae(w.buffer,SharedArrayBuffer)))return b(w,h,D);if(typeof w=="number")throw new TypeError('The "value" argument must not be of type number. Received type number');const P=w.valueOf&&w.valueOf();if(P!=null&&P!==w)return a.from(P,h,D);const G=F(w);if(G)return G;if(typeof Symbol<"u"&&Symbol.toPrimitive!=null&&typeof w[Symbol.toPrimitive]=="function")return a.from(w[Symbol.toPrimitive]("string"),h,D);throw new TypeError("The first argument must be one of type string, Buffer, ArrayBuffer, Array, or Array-like Object. Received type "+typeof w)}a.from=function(w,h,D){return u(w,h,D)},Object.setPrototypeOf(a.prototype,Uint8Array.prototype),Object.setPrototypeOf(a,Uint8Array);function c(w){if(typeof w!="number")throw new TypeError('"size" argument must be of type number');if(w<0)throw new RangeError('The value "'+w+'" is invalid for option "size"')}function l(w,h,D){return c(w),w<=0?i(w):h!==void 0?typeof D=="string"?i(w).fill(h,D):i(w).fill(h):i(w)}a.alloc=function(w,h,D){return l(w,h,D)};function p(w){return c(w),i(w<0?0:y(w)|0)}a.allocUnsafe=function(w){return p(w)},a.allocUnsafeSlow=function(w){return p(w)};function d(w,h){if((typeof h!="string"||h==="")&&(h="utf8"),!a.isEncoding(h))throw new TypeError("Unknown encoding: "+h);const D=O(w,h)|0;let P=i(D);const G=P.write(w,h);return G!==D&&(P=P.slice(0,G)),P}function f(w){const h=w.length<0?0:y(w.length)|0,D=i(h);for(let P=0;P<h;P+=1)D[P]=w[P]&255;return D}function S(w){if(Ae(w,Uint8Array)){const h=new Uint8Array(w);return b(h.buffer,h.byteOffset,h.byteLength)}return f(w)}function b(w,h,D){if(h<0||w.byteLength<h)throw new RangeError('"offset" is outside of buffer bounds');if(w.byteLength<h+(D||0))throw new RangeError('"length" is outside of buffer bounds');let P;return h===void 0&&D===void 0?P=new Uint8Array(w):D===void 0?P=new Uint8Array(w,h):P=new Uint8Array(w,h,D),Object.setPrototypeOf(P,a.prototype),P}function F(w){if(a.isBuffer(w)){const h=y(w.length)|0,D=i(h);return D.length===0||w.copy(D,0,0,h),D}if(w.length!==void 0)return typeof w.length!="number"||Re(w.length)?i(0):f(w);if(w.type==="Buffer"&&Array.isArray(w.data))return f(w.data)}function y(w){if(w>=s)throw new RangeError("Attempt to allocate Buffer larger than maximum size: 0x"+s.toString(16)+" bytes");return w|0}function T(w){return+w!=w&&(w=0),a.alloc(+w)}a.isBuffer=function(h){return h!=null&&h._isBuffer===!0&&h!==a.prototype},a.compare=function(h,D){if(Ae(h,Uint8Array)&&(h=a.from(h,h.offset,h.byteLength)),Ae(D,Uint8Array)&&(D=a.from(D,D.offset,D.byteLength)),!a.isBuffer(h)||!a.isBuffer(D))throw new TypeError('The "buf1", "buf2" arguments must be one of type Buffer or Uint8Array');if(h===D)return 0;let P=h.length,G=D.length;for(let J=0,K=Math.min(P,G);J<K;++J)if(h[J]!==D[J]){P=h[J],G=D[J];break}return P<G?-1:G<P?1:0},a.isEncoding=function(h){switch(String(h).toLowerCase()){case"hex":case"utf8":case"utf-8":case"ascii":case"latin1":case"binary":case"base64":case"ucs2":case"ucs-2":case"utf16le":case"utf-16le":return!0;default:return!1}},a.concat=function(h,D){if(!Array.isArray(h))throw new TypeError('"list" argument must be an Array of Buffers');if(h.length===0)return a.alloc(0);let P;if(D===void 0)for(D=0,P=0;P<h.length;++P)D+=h[P].length;const G=a.allocUnsafe(D);let J=0;for(P=0;P<h.length;++P){let K=h[P];if(Ae(K,Uint8Array))J+K.length>G.length?(a.isBuffer(K)||(K=a.from(K)),K.copy(G,J)):Uint8Array.prototype.set.call(G,K,J);else if(a.isBuffer(K))K.copy(G,J);else throw new TypeError('"list" argument must be an Array of Buffers');J+=K.length}return G};function O(w,h){if(a.isBuffer(w))return w.length;if(ArrayBuffer.isView(w)||Ae(w,ArrayBuffer))return w.byteLength;if(typeof w!="string")throw new TypeError('The "string" argument must be one of type string, Buffer, or ArrayBuffer. Received type '+typeof w);const D=w.length,P=arguments.length>2&&arguments[2]===!0;if(!P&&D===0)return 0;let G=!1;for(;;)switch(h){case"ascii":case"latin1":case"binary":return D;case"utf8":case"utf-8":return Ue(w).length;case"ucs2":case"ucs-2":case"utf16le":case"utf-16le":return D*2;case"hex":return D>>>1;case"base64":return Ve(w).length;default:if(G)return P?-1:Ue(w).length;h=(""+h).toLowerCase(),G=!0}}a.byteLength=O;function j(w,h,D){let P=!1;if((h===void 0||h<0)&&(h=0),h>this.length||((D===void 0||D>this.length)&&(D=this.length),D<=0)||(D>>>=0,h>>>=0,D<=h))return"";for(w||(w="utf8");;)switch(w){case"hex":return ke(this,h,D);case"utf8":case"utf-8":return Te(this,h,D);case"ascii":return ce(this,h,D);case"latin1":case"binary":return Ze(this,h,D);case"base64":return he(this,h,D);case"ucs2":case"ucs-2":case"utf16le":case"utf-16le":return Z(this,h,D);default:if(P)throw new TypeError("Unknown encoding: "+w);w=(w+"").toLowerCase(),P=!0}}a.prototype._isBuffer=!0;function M(w,h,D){const P=w[h];w[h]=w[D],w[D]=P}a.prototype.swap16=function(){const h=this.length;if(h%2!==0)throw new RangeError("Buffer size must be a multiple of 16-bits");for(let D=0;D<h;D+=2)M(this,D,D+1);return this},a.prototype.swap32=function(){const h=this.length;if(h%4!==0)throw new RangeError("Buffer size must be a multiple of 32-bits");for(let D=0;D<h;D+=4)M(this,D,D+3),M(this,D+1,D+2);return this},a.prototype.swap64=function(){const h=this.length;if(h%8!==0)throw new RangeError("Buffer size must be a multiple of 64-bits");for(let D=0;D<h;D+=8)M(this,D,D+7),M(this,D+1,D+6),M(this,D+2,D+5),M(this,D+3,D+4);return this},a.prototype.toString=function(){const h=this.length;return h===0?"":arguments.length===0?Te(this,0,h):j.apply(this,arguments)},a.prototype.toLocaleString=a.prototype.toString,a.prototype.equals=function(h){if(!a.isBuffer(h))throw new TypeError("Argument must be a Buffer");return this===h?!0:a.compare(this,h)===0},a.prototype.inspect=function(){let h="";const D=t.INSPECT_MAX_BYTES;return h=this.toString("hex",0,D).replace(/(.{2})/g,"$1 ").trim(),this.length>D&&(h+=" ... "),"<Buffer "+h+">"},r&&(a.prototype[r]=a.prototype.inspect),a.prototype.compare=function(h,D,P,G,J){if(Ae(h,Uint8Array)&&(h=a.from(h,h.offset,h.byteLength)),!a.isBuffer(h))throw new TypeError('The "target" argument must be one of type Buffer or Uint8Array. Received type '+typeof h);if(D===void 0&&(D=0),P===void 0&&(P=h?h.length:0),G===void 0&&(G=0),J===void 0&&(J=this.length),D<0||P>h.length||G<0||J>this.length)throw new RangeError("out of range index");if(G>=J&&D>=P)return 0;if(G>=J)return-1;if(D>=P)return 1;if(D>>>=0,P>>>=0,G>>>=0,J>>>=0,this===h)return 0;let K=J-G,be=P-D;const st=Math.min(K,be),We=this.slice(G,J),Me=h.slice(D,P);for(let Je=0;Je<st;++Je)if(We[Je]!==Me[Je]){K=We[Je],be=Me[Je];break}return K<be?-1:be<K?1:0};function ee(w,h,D,P,G){if(w.length===0)return-1;if(typeof D=="string"?(P=D,D=0):D>2147483647?D=2147483647:D<-2147483648&&(D=-2147483648),D=+D,Re(D)&&(D=G?0:w.length-1),D<0&&(D=w.length+D),D>=w.length){if(G)return-1;D=w.length-1}else if(D<0)if(G)D=0;else return-1;if(typeof h=="string"&&(h=a.from(h,P)),a.isBuffer(h))return h.length===0?-1:ne(w,h,D,P,G);if(typeof h=="number")return h=h&255,typeof Uint8Array.prototype.indexOf=="function"?G?Uint8Array.prototype.indexOf.call(w,h,D):Uint8Array.prototype.lastIndexOf.call(w,h,D):ne(w,[h],D,P,G);throw new TypeError("val must be string, number or Buffer")}function ne(w,h,D,P,G){let J=1,K=w.length,be=h.length;if(P!==void 0&&(P=String(P).toLowerCase(),P==="ucs2"||P==="ucs-2"||P==="utf16le"||P==="utf-16le")){if(w.length<2||h.length<2)return-1;J=2,K/=2,be/=2,D/=2}function st(Me,Je){return J===1?Me[Je]:Me.readUInt16BE(Je*J)}let We;if(G){let Me=-1;for(We=D;We<K;We++)if(st(w,We)===st(h,Me===-1?0:We-Me)){if(Me===-1&&(Me=We),We-Me+1===be)return Me*J}else Me!==-1&&(We-=We-Me),Me=-1}else for(D+be>K&&(D=K-be),We=D;We>=0;We--){let Me=!0;for(let Je=0;Je<be;Je++)if(st(w,We+Je)!==st(h,Je)){Me=!1;break}if(Me)return We}return-1}a.prototype.includes=function(h,D,P){return this.indexOf(h,D,P)!==-1},a.prototype.indexOf=function(h,D,P){return ee(this,h,D,P,!0)},a.prototype.lastIndexOf=function(h,D,P){return ee(this,h,D,P,!1)};function Ne(w,h,D,P){D=Number(D)||0;const G=w.length-D;P?(P=Number(P),P>G&&(P=G)):P=G;const J=h.length;P>J/2&&(P=J/2);let K;for(K=0;K<P;++K){const be=parseInt(h.substr(K*2,2),16);if(Re(be))return K;w[D+K]=be}return K}function L(w,h,D,P){return je(Ue(h,w.length-D),w,D,P)}function pe(w,h,D,P){return je(ye(h),w,D,P)}function de(w,h,D,P){return je(Ve(h),w,D,P)}function re(w,h,D,P){return je(He(h,w.length-D),w,D,P)}a.prototype.write=function(h,D,P,G){if(D===void 0)G="utf8",P=this.length,D=0;else if(P===void 0&&typeof D=="string")G=D,P=this.length,D=0;else if(isFinite(D))D=D>>>0,isFinite(P)?(P=P>>>0,G===void 0&&(G="utf8")):(G=P,P=void 0);else throw new Error("Buffer.write(string, encoding, offset[, length]) is no longer supported");const J=this.length-D;if((P===void 0||P>J)&&(P=J),h.length>0&&(P<0||D<0)||D>this.length)throw new RangeError("Attempt to write outside buffer bounds");G||(G="utf8");let K=!1;for(;;)switch(G){case"hex":return Ne(this,h,D,P);case"utf8":case"utf-8":return L(this,h,D,P);case"ascii":case"latin1":case"binary":return pe(this,h,D,P);case"base64":return de(this,h,D,P);case"ucs2":case"ucs-2":case"utf16le":case"utf-16le":return re(this,h,D,P);default:if(K)throw new TypeError("Unknown encoding: "+G);G=(""+G).toLowerCase(),K=!0}},a.prototype.toJSON=function(){return{type:"Buffer",data:Array.prototype.slice.call(this._arr||this,0)}};function he(w,h,D){return h===0&&D===w.length?e.fromByteArray(w):e.fromByteArray(w.slice(h,D))}function Te(w,h,D){D=Math.min(w.length,D);const P=[];let G=h;for(;G<D;){const J=w[G];let K=null,be=J>239?4:J>223?3:J>191?2:1;if(G+be<=D){let st,We,Me,Je;switch(be){case 1:J<128&&(K=J);break;case 2:st=w[G+1],(st&192)===128&&(Je=(J&31)<<6|st&63,Je>127&&(K=Je));break;case 3:st=w[G+1],We=w[G+2],(st&192)===128&&(We&192)===128&&(Je=(J&15)<<12|(st&63)<<6|We&63,Je>2047&&(Je<55296||Je>57343)&&(K=Je));break;case 4:st=w[G+1],We=w[G+2],Me=w[G+3],(st&192)===128&&(We&192)===128&&(Me&192)===128&&(Je=(J&15)<<18|(st&63)<<12|(We&63)<<6|Me&63,Je>65535&&Je<1114112&&(K=Je))}}K===null?(K=65533,be=1):K>65535&&(K-=65536,P.push(K>>>10&1023|55296),K=56320|K&1023),P.push(K),G+=be}return qe(P)}const Ge=4096;function qe(w){const h=w.length;if(h<=Ge)return String.fromCharCode.apply(String,w);let D="",P=0;for(;P<h;)D+=String.fromCharCode.apply(String,w.slice(P,P+=Ge));return D}function ce(w,h,D){let P="";D=Math.min(w.length,D);for(let G=h;G<D;++G)P+=String.fromCharCode(w[G]&127);return P}function Ze(w,h,D){let P="";D=Math.min(w.length,D);for(let G=h;G<D;++G)P+=String.fromCharCode(w[G]);return P}function ke(w,h,D){const P=w.length;(!h||h<0)&&(h=0),(!D||D<0||D>P)&&(D=P);let G="";for(let J=h;J<D;++J)G+=It[w[J]];return G}function Z(w,h,D){const P=w.slice(h,D);let G="";for(let J=0;J<P.length-1;J+=2)G+=String.fromCharCode(P[J]+P[J+1]*256);return G}a.prototype.slice=function(h,D){const P=this.length;h=~~h,D=D===void 0?P:~~D,h<0?(h+=P,h<0&&(h=0)):h>P&&(h=P),D<0?(D+=P,D<0&&(D=0)):D>P&&(D=P),D<h&&(D=h);const G=this.subarray(h,D);return Object.setPrototypeOf(G,a.prototype),G};function x(w,h,D){if(w%1!==0||w<0)throw new RangeError("offset is not uint");if(w+h>D)throw new RangeError("Trying to access beyond buffer length")}a.prototype.readUintLE=a.prototype.readUIntLE=function(h,D,P){h=h>>>0,D=D>>>0,P||x(h,D,this.length);let G=this[h],J=1,K=0;for(;++K<D&&(J*=256);)G+=this[h+K]*J;return G},a.prototype.readUintBE=a.prototype.readUIntBE=function(h,D,P){h=h>>>0,D=D>>>0,P||x(h,D,this.length);let G=this[h+--D],J=1;for(;D>0&&(J*=256);)G+=this[h+--D]*J;return G},a.prototype.readUint8=a.prototype.readUInt8=function(h,D){return h=h>>>0,D||x(h,1,this.length),this[h]},a.prototype.readUint16LE=a.prototype.readUInt16LE=function(h,D){return h=h>>>0,D||x(h,2,this.length),this[h]|this[h+1]<<8},a.prototype.readUint16BE=a.prototype.readUInt16BE=function(h,D){return h=h>>>0,D||x(h,2,this.length),this[h]<<8|this[h+1]},a.prototype.readUint32LE=a.prototype.readUInt32LE=function(h,D){return h=h>>>0,D||x(h,4,this.length),(this[h]|this[h+1]<<8|this[h+2]<<16)+this[h+3]*16777216},a.prototype.readUint32BE=a.prototype.readUInt32BE=function(h,D){return h=h>>>0,D||x(h,4,this.length),this[h]*16777216+(this[h+1]<<16|this[h+2]<<8|this[h+3])},a.prototype.readBigUInt64LE=Nt(function(h){h=h>>>0,Y(h,"offset");const D=this[h],P=this[h+7];(D===void 0||P===void 0)&&Le(h,this.length-8);const G=D+this[++h]*2**8+this[++h]*2**16+this[++h]*2**24,J=this[++h]+this[++h]*2**8+this[++h]*2**16+P*2**24;return BigInt(G)+(BigInt(J)<<BigInt(32))}),a.prototype.readBigUInt64BE=Nt(function(h){h=h>>>0,Y(h,"offset");const D=this[h],P=this[h+7];(D===void 0||P===void 0)&&Le(h,this.length-8);const G=D*2**24+this[++h]*2**16+this[++h]*2**8+this[++h],J=this[++h]*2**24+this[++h]*2**16+this[++h]*2**8+P;return(BigInt(G)<<BigInt(32))+BigInt(J)}),a.prototype.readIntLE=function(h,D,P){h=h>>>0,D=D>>>0,P||x(h,D,this.length);let G=this[h],J=1,K=0;for(;++K<D&&(J*=256);)G+=this[h+K]*J;return J*=128,G>=J&&(G-=Math.pow(2,8*D)),G},a.prototype.readIntBE=function(h,D,P){h=h>>>0,D=D>>>0,P||x(h,D,this.length);let G=D,J=1,K=this[h+--G];for(;G>0&&(J*=256);)K+=this[h+--G]*J;return J*=128,K>=J&&(K-=Math.pow(2,8*D)),K},a.prototype.readInt8=function(h,D){return h=h>>>0,D||x(h,1,this.length),this[h]&128?(255-this[h]+1)*-1:this[h]},a.prototype.readInt16LE=function(h,D){h=h>>>0,D||x(h,2,this.length);const P=this[h]|this[h+1]<<8;return P&32768?P|4294901760:P},a.prototype.readInt16BE=function(h,D){h=h>>>0,D||x(h,2,this.length);const P=this[h+1]|this[h]<<8;return P&32768?P|4294901760:P},a.prototype.readInt32LE=function(h,D){return h=h>>>0,D||x(h,4,this.length),this[h]|this[h+1]<<8|this[h+2]<<16|this[h+3]<<24},a.prototype.readInt32BE=function(h,D){return h=h>>>0,D||x(h,4,this.length),this[h]<<24|this[h+1]<<16|this[h+2]<<8|this[h+3]},a.prototype.readBigInt64LE=Nt(function(h){h=h>>>0,Y(h,"offset");const D=this[h],P=this[h+7];(D===void 0||P===void 0)&&Le(h,this.length-8);const G=this[h+4]+this[h+5]*2**8+this[h+6]*2**16+(P<<24);return(BigInt(G)<<BigInt(32))+BigInt(D+this[++h]*2**8+this[++h]*2**16+this[++h]*2**24)}),a.prototype.readBigInt64BE=Nt(function(h){h=h>>>0,Y(h,"offset");const D=this[h],P=this[h+7];(D===void 0||P===void 0)&&Le(h,this.length-8);const G=(D<<24)+this[++h]*2**16+this[++h]*2**8+this[++h];return(BigInt(G)<<BigInt(32))+BigInt(this[++h]*2**24+this[++h]*2**16+this[++h]*2**8+P)}),a.prototype.readFloatLE=function(h,D){return h=h>>>0,D||x(h,4,this.length),n.read(this,h,!0,23,4)},a.prototype.readFloatBE=function(h,D){return h=h>>>0,D||x(h,4,this.length),n.read(this,h,!1,23,4)},a.prototype.readDoubleLE=function(h,D){return h=h>>>0,D||x(h,8,this.length),n.read(this,h,!0,52,8)},a.prototype.readDoubleBE=function(h,D){return h=h>>>0,D||x(h,8,this.length),n.read(this,h,!1,52,8)};function v(w,h,D,P,G,J){if(!a.isBuffer(w))throw new TypeError('"buffer" argument must be a Buffer instance');if(h>G||h<J)throw new RangeError('"value" argument is out of bounds');if(D+P>w.length)throw new RangeError("Index out of range")}a.prototype.writeUintLE=a.prototype.writeUIntLE=function(h,D,P,G){if(h=+h,D=D>>>0,P=P>>>0,!G){const be=Math.pow(2,8*P)-1;v(this,h,D,P,be,0)}let J=1,K=0;for(this[D]=h&255;++K<P&&(J*=256);)this[D+K]=h/J&255;return D+P},a.prototype.writeUintBE=a.prototype.writeUIntBE=function(h,D,P,G){if(h=+h,D=D>>>0,P=P>>>0,!G){const be=Math.pow(2,8*P)-1;v(this,h,D,P,be,0)}let J=P-1,K=1;for(this[D+J]=h&255;--J>=0&&(K*=256);)this[D+J]=h/K&255;return D+P},a.prototype.writeUint8=a.prototype.writeUInt8=function(h,D,P){return h=+h,D=D>>>0,P||v(this,h,D,1,255,0),this[D]=h&255,D+1},a.prototype.writeUint16LE=a.prototype.writeUInt16LE=function(h,D,P){return h=+h,D=D>>>0,P||v(this,h,D,2,65535,0),this[D]=h&255,this[D+1]=h>>>8,D+2},a.prototype.writeUint16BE=a.prototype.writeUInt16BE=function(h,D,P){return h=+h,D=D>>>0,P||v(this,h,D,2,65535,0),this[D]=h>>>8,this[D+1]=h&255,D+2},a.prototype.writeUint32LE=a.prototype.writeUInt32LE=function(h,D,P){return h=+h,D=D>>>0,P||v(this,h,D,4,4294967295,0),this[D+3]=h>>>24,this[D+2]=h>>>16,this[D+1]=h>>>8,this[D]=h&255,D+4},a.prototype.writeUint32BE=a.prototype.writeUInt32BE=function(h,D,P){return h=+h,D=D>>>0,P||v(this,h,D,4,4294967295,0),this[D]=h>>>24,this[D+1]=h>>>16,this[D+2]=h>>>8,this[D+3]=h&255,D+4};function C(w,h,D,P,G){V(h,P,G,w,D,7);let J=Number(h&BigInt(4294967295));w[D++]=J,J=J>>8,w[D++]=J,J=J>>8,w[D++]=J,J=J>>8,w[D++]=J;let K=Number(h>>BigInt(32)&BigInt(4294967295));return w[D++]=K,K=K>>8,w[D++]=K,K=K>>8,w[D++]=K,K=K>>8,w[D++]=K,D}function m(w,h,D,P,G){V(h,P,G,w,D,7);let J=Number(h&BigInt(4294967295));w[D+7]=J,J=J>>8,w[D+6]=J,J=J>>8,w[D+5]=J,J=J>>8,w[D+4]=J;let K=Number(h>>BigInt(32)&BigInt(4294967295));return w[D+3]=K,K=K>>8,w[D+2]=K,K=K>>8,w[D+1]=K,K=K>>8,w[D]=K,D+8}a.prototype.writeBigUInt64LE=Nt(function(h,D=0){return C(this,h,D,BigInt(0),BigInt("0xffffffffffffffff"))}),a.prototype.writeBigUInt64BE=Nt(function(h,D=0){return m(this,h,D,BigInt(0),BigInt("0xffffffffffffffff"))}),a.prototype.writeIntLE=function(h,D,P,G){if(h=+h,D=D>>>0,!G){const st=Math.pow(2,8*P-1);v(this,h,D,P,st-1,-st)}let J=0,K=1,be=0;for(this[D]=h&255;++J<P&&(K*=256);)h<0&&be===0&&this[D+J-1]!==0&&(be=1),this[D+J]=(h/K>>0)-be&255;return D+P},a.prototype.writeIntBE=function(h,D,P,G){if(h=+h,D=D>>>0,!G){const st=Math.pow(2,8*P-1);v(this,h,D,P,st-1,-st)}let J=P-1,K=1,be=0;for(this[D+J]=h&255;--J>=0&&(K*=256);)h<0&&be===0&&this[D+J+1]!==0&&(be=1),this[D+J]=(h/K>>0)-be&255;return D+P},a.prototype.writeInt8=function(h,D,P){return h=+h,D=D>>>0,P||v(this,h,D,1,127,-128),h<0&&(h=255+h+1),this[D]=h&255,D+1},a.prototype.writeInt16LE=function(h,D,P){return h=+h,D=D>>>0,P||v(this,h,D,2,32767,-32768),this[D]=h&255,this[D+1]=h>>>8,D+2},a.prototype.writeInt16BE=function(h,D,P){return h=+h,D=D>>>0,P||v(this,h,D,2,32767,-32768),this[D]=h>>>8,this[D+1]=h&255,D+2},a.prototype.writeInt32LE=function(h,D,P){return h=+h,D=D>>>0,P||v(this,h,D,4,2147483647,-2147483648),this[D]=h&255,this[D+1]=h>>>8,this[D+2]=h>>>16,this[D+3]=h>>>24,D+4},a.prototype.writeInt32BE=function(h,D,P){return h=+h,D=D>>>0,P||v(this,h,D,4,2147483647,-2147483648),h<0&&(h=4294967295+h+1),this[D]=h>>>24,this[D+1]=h>>>16,this[D+2]=h>>>8,this[D+3]=h&255,D+4},a.prototype.writeBigInt64LE=Nt(function(h,D=0){return C(this,h,D,-BigInt("0x8000000000000000"),BigInt("0x7fffffffffffffff"))}),a.prototype.writeBigInt64BE=Nt(function(h,D=0){return m(this,h,D,-BigInt("0x8000000000000000"),BigInt("0x7fffffffffffffff"))});function A(w,h,D,P,G,J){if(D+P>w.length)throw new RangeError("Index out of range");if(D<0)throw new RangeError("Index out of range")}function $(w,h,D,P,G){return h=+h,D=D>>>0,G||A(w,h,D,4),n.write(w,h,D,P,23,4),D+4}a.prototype.writeFloatLE=function(h,D,P){return $(this,h,D,!0,P)},a.prototype.writeFloatBE=function(h,D,P){return $(this,h,D,!1,P)};function g(w,h,D,P,G){return h=+h,D=D>>>0,G||A(w,h,D,8),n.write(w,h,D,P,52,8),D+8}a.prototype.writeDoubleLE=function(h,D,P){return g(this,h,D,!0,P)},a.prototype.writeDoubleBE=function(h,D,P){return g(this,h,D,!1,P)},a.prototype.copy=function(h,D,P,G){if(!a.isBuffer(h))throw new TypeError("argument should be a Buffer");if(P||(P=0),!G&&G!==0&&(G=this.length),D>=h.length&&(D=h.length),D||(D=0),G>0&&G<P&&(G=P),G===P||h.length===0||this.length===0)return 0;if(D<0)throw new RangeError("targetStart out of bounds");if(P<0||P>=this.length)throw new RangeError("Index out of range");if(G<0)throw new RangeError("sourceEnd out of bounds");G>this.length&&(G=this.length),h.length-D<G-P&&(G=h.length-D+P);const J=G-P;return this===h&&typeof Uint8Array.prototype.copyWithin=="function"?this.copyWithin(D,P,G):Uint8Array.prototype.set.call(h,this.subarray(P,G),D),J},a.prototype.fill=function(h,D,P,G){if(typeof h=="string"){if(typeof D=="string"?(G=D,D=0,P=this.length):typeof P=="string"&&(G=P,P=this.length),G!==void 0&&typeof G!="string")throw new TypeError("encoding must be a string");if(typeof G=="string"&&!a.isEncoding(G))throw new TypeError("Unknown encoding: "+G);if(h.length===1){const K=h.charCodeAt(0);(G==="utf8"&&K<128||G==="latin1")&&(h=K)}}else typeof h=="number"?h=h&255:typeof h=="boolean"&&(h=Number(h));if(D<0||this.length<D||this.length<P)throw new RangeError("Out of range index");if(P<=D)return this;D=D>>>0,P=P===void 0?this.length:P>>>0,h||(h=0);let J;if(typeof h=="number")for(J=D;J<P;++J)this[J]=h;else{const K=a.isBuffer(h)?h:a.from(h,G),be=K.length;if(be===0)throw new TypeError('The value "'+h+'" is invalid for argument "value"');for(J=0;J<P-D;++J)this[J+D]=K[J%be]}return this};const E={};function N(w,h,D){E[w]=class extends D{constructor(){super(),Object.defineProperty(this,"message",{value:h.apply(this,arguments),writable:!0,configurable:!0}),this.name=`${this.name} [${w}]`,this.stack,delete this.name}get code(){return w}set code(G){Object.defineProperty(this,"code",{configurable:!0,enumerable:!0,value:G,writable:!0})}toString(){return`${this.name} [${w}]: ${this.message}`}}}N("ERR_BUFFER_OUT_OF_BOUNDS",function(w){return w?`${w} is outside of buffer bounds`:"Attempt to access memory outside buffer bounds"},RangeError),N("ERR_INVALID_ARG_TYPE",function(w,h){return`The "${w}" argument must be of type number. Received type ${typeof h}`},TypeError),N("ERR_OUT_OF_RANGE",function(w,h,D){let P=`The value of "${w}" is out of range.`,G=D;return Number.isInteger(D)&&Math.abs(D)>2**32?G=k(String(D)):typeof D=="bigint"&&(G=String(D),(D>BigInt(2)**BigInt(32)||D<-(BigInt(2)**BigInt(32)))&&(G=k(G)),G+="n"),P+=` It must be ${h}. Received ${G}`,P},RangeError);function k(w){let h="",D=w.length;const P=w[0]==="-"?1:0;for(;D>=P+4;D-=3)h=`_${w.slice(D-3,D)}${h}`;return`${w.slice(0,D)}${h}`}function U(w,h,D){Y(h,"offset"),(w[h]===void 0||w[h+D]===void 0)&&Le(h,w.length-(D+1))}function V(w,h,D,P,G,J){if(w>D||w<h){const K=typeof h=="bigint"?"n":"";let be;throw h===0||h===BigInt(0)?be=`>= 0${K} and < 2${K} ** ${(J+1)*8}${K}`:be=`>= -(2${K} ** ${(J+1)*8-1}${K}) and < 2 ** ${(J+1)*8-1}${K}`,new E.ERR_OUT_OF_RANGE("value",be,w)}U(P,G,J)}function Y(w,h){if(typeof w!="number")throw new E.ERR_INVALID_ARG_TYPE(h,"number",w)}function Le(w,h,D){throw Math.floor(w)!==w?(Y(w,D),new E.ERR_OUT_OF_RANGE("offset","an integer",w)):h<0?new E.ERR_BUFFER_OUT_OF_BOUNDS:new E.ERR_OUT_OF_RANGE("offset",`>= 0 and <= ${h}`,w)}const rt=/[^+/0-9A-Za-z-_]/g;function Xe(w){if(w=w.split("=")[0],w=w.trim().replace(rt,""),w.length<2)return"";for(;w.length%4!==0;)w=w+"=";return w}function Ue(w,h){h=h||1/0;let D;const P=w.length;let G=null;const J=[];for(let K=0;K<P;++K){if(D=w.charCodeAt(K),D>55295&&D<57344){if(!G){if(D>56319){(h-=3)>-1&&J.push(239,191,189);continue}else if(K+1===P){(h-=3)>-1&&J.push(239,191,189);continue}G=D;continue}if(D<56320){(h-=3)>-1&&J.push(239,191,189),G=D;continue}D=(G-55296<<10|D-56320)+65536}else G&&(h-=3)>-1&&J.push(239,191,189);if(G=null,D<128){if((h-=1)<0)break;J.push(D)}else if(D<2048){if((h-=2)<0)break;J.push(D>>6|192,D&63|128)}else if(D<65536){if((h-=3)<0)break;J.push(D>>12|224,D>>6&63|128,D&63|128)}else if(D<1114112){if((h-=4)<0)break;J.push(D>>18|240,D>>12&63|128,D>>6&63|128,D&63|128)}else throw new Error("Invalid code point")}return J}function ye(w){const h=[];for(let D=0;D<w.length;++D)h.push(w.charCodeAt(D)&255);return h}function He(w,h){let D,P,G;const J=[];for(let K=0;K<w.length&&!((h-=2)<0);++K)D=w.charCodeAt(K),P=D>>8,G=D%256,J.push(G),J.push(P);return J}function Ve(w){return e.toByteArray(Xe(w))}function je(w,h,D,P){let G;for(G=0;G<P&&!(G+D>=h.length||G>=w.length);++G)h[G+D]=w[G];return G}function Ae(w,h){return w instanceof h||w!=null&&w.constructor!=null&&w.constructor.name!=null&&w.constructor.name===h.name}function Re(w){return w!==w}const It=function(){const w="0123456789abcdef",h=new Array(256);for(let D=0;D<16;++D){const P=D*16;for(let G=0;G<16;++G)h[P+G]=w[D]+w[G]}return h}();function Nt(w){return typeof BigInt>"u"?Cn:w}function Cn(){throw new Error("BigInt not supported")}}(ji)),ji}/*! safe-buffer. MIT License. Feross Aboukhadijeh <https://feross.org/opensource> */var Zl;function WC(){return Zl||(Zl=1,function(t,e){var n=HC(),r=n.Buffer;function s(i,a){for(var u in i)a[u]=i[u]}r.from&&r.alloc&&r.allocUnsafe&&r.allocUnsafeSlow?t.exports=n:(s(n,e),e.Buffer=o);function o(i,a,u){return r(i,a,u)}o.prototype=Object.create(r.prototype),s(r,o),o.from=function(i,a,u){if(typeof i=="number")throw new TypeError("Argument must not be a number");return r(i,a,u)},o.alloc=function(i,a,u){if(typeof i!="number")throw new TypeError("Argument must be a number");var c=r(i);return a!==void 0?typeof u=="string"?c.fill(a,u):c.fill(a):c.fill(0),c},o.allocUnsafe=function(i){if(typeof i!="number")throw new TypeError("Argument must be a number");return r(i)},o.allocUnsafeSlow=function(i){if(typeof i!="number")throw new TypeError("Argument must be a number");return n.SlowBuffer(i)}}(po,po.exports)),po.exports}var Ql;function KC(){if(Ql)return Li;Ql=1;var t=WC().Buffer,e=t.isEncoding||function(y){switch(y=""+y,y&&y.toLowerCase()){case"hex":case"utf8":case"utf-8":case"ascii":case"binary":case"base64":case"ucs2":case"ucs-2":case"utf16le":case"utf-16le":case"raw":return!0;default:return!1}};function n(y){if(!y)return"utf8";for(var T;;)switch(y){case"utf8":case"utf-8":return"utf8";case"ucs2":case"ucs-2":case"utf16le":case"utf-16le":return"utf16le";case"latin1":case"binary":return"latin1";case"base64":case"ascii":case"hex":return y;default:if(T)return;y=(""+y).toLowerCase(),T=!0}}function r(y){var T=n(y);if(typeof T!="string"&&(t.isEncoding===e||!e(y)))throw new Error("Unknown encoding: "+y);return T||y}Li.StringDecoder=s;function s(y){this.encoding=r(y);var T;switch(this.encoding){case"utf16le":this.text=p,this.end=d,T=4;break;case"utf8":this.fillLast=u,T=4;break;case"base64":this.text=f,this.end=S,T=3;break;default:this.write=b,this.end=F;return}this.lastNeed=0,this.lastTotal=0,this.lastChar=t.allocUnsafe(T)}s.prototype.write=function(y){if(y.length===0)return"";var T,O;if(this.lastNeed){if(T=this.fillLast(y),T===void 0)return"";O=this.lastNeed,this.lastNeed=0}else O=0;return O<y.length?T?T+this.text(y,O):this.text(y,O):T||""},s.prototype.end=l,s.prototype.text=c,s.prototype.fillLast=function(y){if(this.lastNeed<=y.length)return y.copy(this.lastChar,this.lastTotal-this.lastNeed,0,this.lastNeed),this.lastChar.toString(this.encoding,0,this.lastTotal);y.copy(this.lastChar,this.lastTotal-this.lastNeed,0,y.length),this.lastNeed-=y.length};function o(y){return y<=127?0:y>>5===6?2:y>>4===14?3:y>>3===30?4:y>>6===2?-1:-2}function i(y,T,O){var j=T.length-1;if(j<O)return 0;var M=o(T[j]);return M>=0?(M>0&&(y.lastNeed=M-1),M):--j<O||M===-2?0:(M=o(T[j]),M>=0?(M>0&&(y.lastNeed=M-2),M):--j<O||M===-2?0:(M=o(T[j]),M>=0?(M>0&&(M===2?M=0:y.lastNeed=M-3),M):0))}function a(y,T,O){if((T[0]&192)!==128)return y.lastNeed=0,"�";if(y.lastNeed>1&&T.length>1){if((T[1]&192)!==128)return y.lastNeed=1,"�";if(y.lastNeed>2&&T.length>2&&(T[2]&192)!==128)return y.lastNeed=2,"�"}}function u(y){var T=this.lastTotal-this.lastNeed,O=a(this,y);if(O!==void 0)return O;if(this.lastNeed<=y.length)return y.copy(this.lastChar,T,0,this.lastNeed),this.lastChar.toString(this.encoding,0,this.lastTotal);y.copy(this.lastChar,T,0,y.length),this.lastNeed-=y.length}function c(y,T){var O=i(this,y,T);if(!this.lastNeed)return y.toString("utf8",T);this.lastTotal=O;var j=y.length-(O-this.lastNeed);return y.copy(this.lastChar,0,j),y.toString("utf8",T,j)}function l(y){var T=y&&y.length?this.write(y):"";return this.lastNeed?T+"�":T}function p(y,T){if((y.length-T)%2===0){var O=y.toString("utf16le",T);if(O){var j=O.charCodeAt(O.length-1);if(j>=55296&&j<=56319)return this.lastNeed=2,this.lastTotal=4,this.lastChar[0]=y[y.length-2],this.lastChar[1]=y[y.length-1],O.slice(0,-1)}return O}return this.lastNeed=1,this.lastTotal=2,this.lastChar[0]=y[y.length-1],y.toString("utf16le",T,y.length-1)}function d(y){var T=y&&y.length?this.write(y):"";if(this.lastNeed){var O=this.lastTotal-this.lastNeed;return T+this.lastChar.toString("utf16le",0,O)}return T}function f(y,T){var O=(y.length-T)%3;return O===0?y.toString("base64",T):(this.lastNeed=3-O,this.lastTotal=3,O===1?this.lastChar[0]=y[y.length-1]:(this.lastChar[0]=y[y.length-2],this.lastChar[1]=y[y.length-1]),y.toString("base64",T,y.length-O))}function S(y){var T=y&&y.length?this.write(y):"";return this.lastNeed?T+this.lastChar.toString("base64",0,3-this.lastNeed):T}function b(y){return y.toString(this.encoding)}function F(y){return y&&y.length?this.write(y):""}return Li}(function(t){(function(e){e.parser=function(g,E){return new r(g,E)},e.SAXParser=r,e.SAXStream=l,e.createStream=c,e.MAX_BUFFER_LENGTH=64*1024;var n=["comment","sgmlDecl","textNode","tagName","doctype","procInstName","procInstBody","entity","attribName","attribValue","cdata","script"];e.EVENTS=["text","processinginstruction","sgmldeclaration","doctype","comment","opentagstart","attribute","opentag","closetag","opencdata","cdata","closecdata","error","end","ready","script","opennamespace","closenamespace"];function r(g,E){if(!(this instanceof r))return new r(g,E);var N=this;o(N),N.q=N.c="",N.bufferCheckPosition=e.MAX_BUFFER_LENGTH,N.opt=E||{},N.opt.lowercase=N.opt.lowercase||N.opt.lowercasetags,N.looseCase=N.opt.lowercase?"toLowerCase":"toUpperCase",N.tags=[],N.closed=N.closedRoot=N.sawRoot=!1,N.tag=N.error=null,N.strict=!!g,N.noscript=!!(g||N.opt.noscript),N.state=L.BEGIN,N.strictEntities=N.opt.strictEntities,N.ENTITIES=N.strictEntities?Object.create(e.XML_ENTITIES):Object.create(e.ENTITIES),N.attribList=[],N.opt.xmlns&&(N.ns=Object.create(b)),N.trackPosition=N.opt.position!==!1,N.trackPosition&&(N.position=N.line=N.column=0),de(N,"onready")}Object.create||(Object.create=function(g){function E(){}E.prototype=g;var N=new E;return N}),Object.keys||(Object.keys=function(g){var E=[];for(var N in g)g.hasOwnProperty(N)&&E.push(N);return E});function s(g){for(var E=Math.max(e.MAX_BUFFER_LENGTH,10),N=0,k=0,U=n.length;k<U;k++){var V=g[n[k]].length;if(V>E)switch(n[k]){case"textNode":he(g);break;case"cdata":re(g,"oncdata",g.cdata),g.cdata="";break;case"script":re(g,"onscript",g.script),g.script="";break;default:Ge(g,"Max buffer length exceeded: "+n[k])}N=Math.max(N,V)}var Y=e.MAX_BUFFER_LENGTH-N;g.bufferCheckPosition=Y+g.position}function o(g){for(var E=0,N=n.length;E<N;E++)g[n[E]]=""}function i(g){he(g),g.cdata!==""&&(re(g,"oncdata",g.cdata),g.cdata=""),g.script!==""&&(re(g,"onscript",g.script),g.script="")}r.prototype={end:function(){qe(this)},write:$,resume:function(){return this.error=null,this},close:function(){return this.write(null)},flush:function(){i(this)}};var a;try{a=VC().Stream}catch{a=function(){}}a||(a=function(){});var u=e.EVENTS.filter(function(g){return g!=="error"&&g!=="end"});function c(g,E){return new l(g,E)}function l(g,E){if(!(this instanceof l))return new l(g,E);a.apply(this),this._parser=new r(g,E),this.writable=!0,this.readable=!0;var N=this;this._parser.onend=function(){N.emit("end")},this._parser.onerror=function(k){N.emit("error",k),N._parser.error=null},this._decoder=null,u.forEach(function(k){Object.defineProperty(N,"on"+k,{get:function(){return N._parser["on"+k]},set:function(U){if(!U)return N.removeAllListeners(k),N._parser["on"+k]=U,U;N.on(k,U)},enumerable:!0,configurable:!1})})}l.prototype=Object.create(a.prototype,{constructor:{value:l}}),l.prototype.write=function(g){if(typeof Buffer=="function"&&typeof Buffer.isBuffer=="function"&&Buffer.isBuffer(g)){if(!this._decoder){var E=KC().StringDecoder;this._decoder=new E("utf8")}g=this._decoder.write(g)}return this._parser.write(g.toString()),this.emit("data",g),!0},l.prototype.end=function(g){return g&&g.length&&this.write(g),this._parser.end(),!0},l.prototype.on=function(g,E){var N=this;return!N._parser["on"+g]&&u.indexOf(g)!==-1&&(N._parser["on"+g]=function(){var k=arguments.length===1?[arguments[0]]:Array.apply(null,arguments);k.splice(0,0,g),N.emit.apply(N,k)}),a.prototype.on.call(N,g,E)};var p="[CDATA[",d="DOCTYPE",f="http://www.w3.org/XML/1998/namespace",S="http://www.w3.org/2000/xmlns/",b={xml:f,xmlns:S},F=/[:_A-Za-z\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02FF\u0370-\u037D\u037F-\u1FFF\u200C-\u200D\u2070-\u218F\u2C00-\u2FEF\u3001-\uD7FF\uF900-\uFDCF\uFDF0-\uFFFD]/,y=/[:_A-Za-z\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02FF\u0370-\u037D\u037F-\u1FFF\u200C-\u200D\u2070-\u218F\u2C00-\u2FEF\u3001-\uD7FF\uF900-\uFDCF\uFDF0-\uFFFD\u00B7\u0300-\u036F\u203F-\u2040.\d-]/,T=/[#:_A-Za-z\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02FF\u0370-\u037D\u037F-\u1FFF\u200C-\u200D\u2070-\u218F\u2C00-\u2FEF\u3001-\uD7FF\uF900-\uFDCF\uFDF0-\uFFFD]/,O=/[#:_A-Za-z\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02FF\u0370-\u037D\u037F-\u1FFF\u200C-\u200D\u2070-\u218F\u2C00-\u2FEF\u3001-\uD7FF\uF900-\uFDCF\uFDF0-\uFFFD\u00B7\u0300-\u036F\u203F-\u2040.\d-]/;function j(g){return g===" "||g===`
`||g==="\r"||g==="	"}function M(g){return g==='"'||g==="'"}function ee(g){return g===">"||j(g)}function ne(g,E){return g.test(E)}function Ne(g,E){return!ne(g,E)}var L=0;e.STATE={BEGIN:L++,BEGIN_WHITESPACE:L++,TEXT:L++,TEXT_ENTITY:L++,OPEN_WAKA:L++,SGML_DECL:L++,SGML_DECL_QUOTED:L++,DOCTYPE:L++,DOCTYPE_QUOTED:L++,DOCTYPE_DTD:L++,DOCTYPE_DTD_QUOTED:L++,COMMENT_STARTING:L++,COMMENT:L++,COMMENT_ENDING:L++,COMMENT_ENDED:L++,CDATA:L++,CDATA_ENDING:L++,CDATA_ENDING_2:L++,PROC_INST:L++,PROC_INST_BODY:L++,PROC_INST_ENDING:L++,OPEN_TAG:L++,OPEN_TAG_SLASH:L++,ATTRIB:L++,ATTRIB_NAME:L++,ATTRIB_NAME_SAW_WHITE:L++,ATTRIB_VALUE:L++,ATTRIB_VALUE_QUOTED:L++,ATTRIB_VALUE_CLOSED:L++,ATTRIB_VALUE_UNQUOTED:L++,ATTRIB_VALUE_ENTITY_Q:L++,ATTRIB_VALUE_ENTITY_U:L++,CLOSE_TAG:L++,CLOSE_TAG_SAW_WHITE:L++,SCRIPT:L++,SCRIPT_ENDING:L++},e.XML_ENTITIES={amp:"&",gt:">",lt:"<",quot:'"',apos:"'"},e.ENTITIES={amp:"&",gt:">",lt:"<",quot:'"',apos:"'",AElig:198,Aacute:193,Acirc:194,Agrave:192,Aring:197,Atilde:195,Auml:196,Ccedil:199,ETH:208,Eacute:201,Ecirc:202,Egrave:200,Euml:203,Iacute:205,Icirc:206,Igrave:204,Iuml:207,Ntilde:209,Oacute:211,Ocirc:212,Ograve:210,Oslash:216,Otilde:213,Ouml:214,THORN:222,Uacute:218,Ucirc:219,Ugrave:217,Uuml:220,Yacute:221,aacute:225,acirc:226,aelig:230,agrave:224,aring:229,atilde:227,auml:228,ccedil:231,eacute:233,ecirc:234,egrave:232,eth:240,euml:235,iacute:237,icirc:238,igrave:236,iuml:239,ntilde:241,oacute:243,ocirc:244,ograve:242,oslash:248,otilde:245,ouml:246,szlig:223,thorn:254,uacute:250,ucirc:251,ugrave:249,uuml:252,yacute:253,yuml:255,copy:169,reg:174,nbsp:160,iexcl:161,cent:162,pound:163,curren:164,yen:165,brvbar:166,sect:167,uml:168,ordf:170,laquo:171,not:172,shy:173,macr:175,deg:176,plusmn:177,sup1:185,sup2:178,sup3:179,acute:180,micro:181,para:182,middot:183,cedil:184,ordm:186,raquo:187,frac14:188,frac12:189,frac34:190,iquest:191,times:215,divide:247,OElig:338,oelig:339,Scaron:352,scaron:353,Yuml:376,fnof:402,circ:710,tilde:732,Alpha:913,Beta:914,Gamma:915,Delta:916,Epsilon:917,Zeta:918,Eta:919,Theta:920,Iota:921,Kappa:922,Lambda:923,Mu:924,Nu:925,Xi:926,Omicron:927,Pi:928,Rho:929,Sigma:931,Tau:932,Upsilon:933,Phi:934,Chi:935,Psi:936,Omega:937,alpha:945,beta:946,gamma:947,delta:948,epsilon:949,zeta:950,eta:951,theta:952,iota:953,kappa:954,lambda:955,mu:956,nu:957,xi:958,omicron:959,pi:960,rho:961,sigmaf:962,sigma:963,tau:964,upsilon:965,phi:966,chi:967,psi:968,omega:969,thetasym:977,upsih:978,piv:982,ensp:8194,emsp:8195,thinsp:8201,zwnj:8204,zwj:8205,lrm:8206,rlm:8207,ndash:8211,mdash:8212,lsquo:8216,rsquo:8217,sbquo:8218,ldquo:8220,rdquo:8221,bdquo:8222,dagger:8224,Dagger:8225,bull:8226,hellip:8230,permil:8240,prime:8242,Prime:8243,lsaquo:8249,rsaquo:8250,oline:8254,frasl:8260,euro:8364,image:8465,weierp:8472,real:8476,trade:8482,alefsym:8501,larr:8592,uarr:8593,rarr:8594,darr:8595,harr:8596,crarr:8629,lArr:8656,uArr:8657,rArr:8658,dArr:8659,hArr:8660,forall:8704,part:8706,exist:8707,empty:8709,nabla:8711,isin:8712,notin:8713,ni:8715,prod:8719,sum:8721,minus:8722,lowast:8727,radic:8730,prop:8733,infin:8734,ang:8736,and:8743,or:8744,cap:8745,cup:8746,int:8747,there4:8756,sim:8764,cong:8773,asymp:8776,ne:8800,equiv:8801,le:8804,ge:8805,sub:8834,sup:8835,nsub:8836,sube:8838,supe:8839,oplus:8853,otimes:8855,perp:8869,sdot:8901,lceil:8968,rceil:8969,lfloor:8970,rfloor:8971,lang:9001,rang:9002,loz:9674,spades:9824,clubs:9827,hearts:9829,diams:9830},Object.keys(e.ENTITIES).forEach(function(g){var E=e.ENTITIES[g],N=typeof E=="number"?String.fromCharCode(E):E;e.ENTITIES[g]=N});for(var pe in e.STATE)e.STATE[e.STATE[pe]]=pe;L=e.STATE;function de(g,E,N){g[E]&&g[E](N)}function re(g,E,N){g.textNode&&he(g),de(g,E,N)}function he(g){g.textNode=Te(g.opt,g.textNode),g.textNode&&de(g,"ontext",g.textNode),g.textNode=""}function Te(g,E){return g.trim&&(E=E.trim()),g.normalize&&(E=E.replace(/\s+/g," ")),E}function Ge(g,E){return he(g),g.trackPosition&&(E+=`
Line: `+g.line+`
Column: `+g.column+`
Char: `+g.c),E=new Error(E),g.error=E,de(g,"onerror",E),g}function qe(g){return g.sawRoot&&!g.closedRoot&&ce(g,"Unclosed root tag"),g.state!==L.BEGIN&&g.state!==L.BEGIN_WHITESPACE&&g.state!==L.TEXT&&Ge(g,"Unexpected end"),he(g),g.c="",g.closed=!0,de(g,"onend"),r.call(g,g.strict,g.opt),g}function ce(g,E){if(typeof g!="object"||!(g instanceof r))throw new Error("bad call to strictFail");g.strict&&Ge(g,E)}function Ze(g){g.strict||(g.tagName=g.tagName[g.looseCase]());var E=g.tags[g.tags.length-1]||g,N=g.tag={name:g.tagName,attributes:{}};g.opt.xmlns&&(N.ns=E.ns),g.attribList.length=0,re(g,"onopentagstart",N)}function ke(g,E){var N=g.indexOf(":"),k=N<0?["",g]:g.split(":"),U=k[0],V=k[1];return E&&g==="xmlns"&&(U="xmlns",V=""),{prefix:U,local:V}}function Z(g){if(g.strict||(g.attribName=g.attribName[g.looseCase]()),g.attribList.indexOf(g.attribName)!==-1||g.tag.attributes.hasOwnProperty(g.attribName)){g.attribName=g.attribValue="";return}if(g.opt.xmlns){var E=ke(g.attribName,!0),N=E.prefix,k=E.local;if(N==="xmlns")if(k==="xml"&&g.attribValue!==f)ce(g,"xml: prefix must be bound to "+f+`
Actual: `+g.attribValue);else if(k==="xmlns"&&g.attribValue!==S)ce(g,"xmlns: prefix must be bound to "+S+`
Actual: `+g.attribValue);else{var U=g.tag,V=g.tags[g.tags.length-1]||g;U.ns===V.ns&&(U.ns=Object.create(V.ns)),U.ns[k]=g.attribValue}g.attribList.push([g.attribName,g.attribValue])}else g.tag.attributes[g.attribName]=g.attribValue,re(g,"onattribute",{name:g.attribName,value:g.attribValue});g.attribName=g.attribValue=""}function x(g,E){if(g.opt.xmlns){var N=g.tag,k=ke(g.tagName);N.prefix=k.prefix,N.local=k.local,N.uri=N.ns[k.prefix]||"",N.prefix&&!N.uri&&(ce(g,"Unbound namespace prefix: "+JSON.stringify(g.tagName)),N.uri=k.prefix);var U=g.tags[g.tags.length-1]||g;N.ns&&U.ns!==N.ns&&Object.keys(N.ns).forEach(function(Ae){re(g,"onopennamespace",{prefix:Ae,uri:N.ns[Ae]})});for(var V=0,Y=g.attribList.length;V<Y;V++){var Le=g.attribList[V],rt=Le[0],Xe=Le[1],Ue=ke(rt,!0),ye=Ue.prefix,He=Ue.local,Ve=ye===""?"":N.ns[ye]||"",je={name:rt,value:Xe,prefix:ye,local:He,uri:Ve};ye&&ye!=="xmlns"&&!Ve&&(ce(g,"Unbound namespace prefix: "+JSON.stringify(ye)),je.uri=ye),g.tag.attributes[rt]=je,re(g,"onattribute",je)}g.attribList.length=0}g.tag.isSelfClosing=!!E,g.sawRoot=!0,g.tags.push(g.tag),re(g,"onopentag",g.tag),E||(!g.noscript&&g.tagName.toLowerCase()==="script"?g.state=L.SCRIPT:g.state=L.TEXT,g.tag=null,g.tagName=""),g.attribName=g.attribValue="",g.attribList.length=0}function v(g){if(!g.tagName){ce(g,"Weird empty close tag."),g.textNode+="</>",g.state=L.TEXT;return}if(g.script){if(g.tagName!=="script"){g.script+="</"+g.tagName+">",g.tagName="",g.state=L.SCRIPT;return}re(g,"onscript",g.script),g.script=""}var E=g.tags.length,N=g.tagName;g.strict||(N=N[g.looseCase]());for(var k=N;E--;){var U=g.tags[E];if(U.name!==k)ce(g,"Unexpected close tag");else break}if(E<0){ce(g,"Unmatched closing tag: "+g.tagName),g.textNode+="</"+g.tagName+">",g.state=L.TEXT;return}g.tagName=N;for(var V=g.tags.length;V-- >E;){var Y=g.tag=g.tags.pop();g.tagName=g.tag.name,re(g,"onclosetag",g.tagName);var Le={};for(var rt in Y.ns)Le[rt]=Y.ns[rt];var Xe=g.tags[g.tags.length-1]||g;g.opt.xmlns&&Y.ns!==Xe.ns&&Object.keys(Y.ns).forEach(function(Ue){var ye=Y.ns[Ue];re(g,"onclosenamespace",{prefix:Ue,uri:ye})})}E===0&&(g.closedRoot=!0),g.tagName=g.attribValue=g.attribName="",g.attribList.length=0,g.state=L.TEXT}function C(g){var E=g.entity,N=E.toLowerCase(),k,U="";return g.ENTITIES[E]?g.ENTITIES[E]:g.ENTITIES[N]?g.ENTITIES[N]:(E=N,E.charAt(0)==="#"&&(E.charAt(1)==="x"?(E=E.slice(2),k=parseInt(E,16),U=k.toString(16)):(E=E.slice(1),k=parseInt(E,10),U=k.toString(10))),E=E.replace(/^0+/,""),isNaN(k)||U.toLowerCase()!==E?(ce(g,"Invalid character entity"),"&"+g.entity+";"):String.fromCodePoint(k))}function m(g,E){E==="<"?(g.state=L.OPEN_WAKA,g.startTagPosition=g.position):j(E)||(ce(g,"Non-whitespace before first tag."),g.textNode=E,g.state=L.TEXT)}function A(g,E){var N="";return E<g.length&&(N=g.charAt(E)),N}function $(g){var E=this;if(this.error)throw this.error;if(E.closed)return Ge(E,"Cannot write after close. Assign an onready handler.");if(g===null)return qe(E);typeof g=="object"&&(g=g.toString());for(var N=0,k="";k=A(g,N++),E.c=k,!!k;)switch(E.trackPosition&&(E.position++,k===`
`?(E.line++,E.column=0):E.column++),E.state){case L.BEGIN:if(E.state=L.BEGIN_WHITESPACE,k==="\uFEFF")continue;m(E,k);continue;case L.BEGIN_WHITESPACE:m(E,k);continue;case L.TEXT:if(E.sawRoot&&!E.closedRoot){for(var U=N-1;k&&k!=="<"&&k!=="&";)k=A(g,N++),k&&E.trackPosition&&(E.position++,k===`
`?(E.line++,E.column=0):E.column++);E.textNode+=g.substring(U,N-1)}k==="<"&&!(E.sawRoot&&E.closedRoot&&!E.strict)?(E.state=L.OPEN_WAKA,E.startTagPosition=E.position):(!j(k)&&(!E.sawRoot||E.closedRoot)&&ce(E,"Text data outside of root node."),k==="&"?E.state=L.TEXT_ENTITY:E.textNode+=k);continue;case L.SCRIPT:k==="<"?E.state=L.SCRIPT_ENDING:E.script+=k;continue;case L.SCRIPT_ENDING:k==="/"?E.state=L.CLOSE_TAG:(E.script+="<"+k,E.state=L.SCRIPT);continue;case L.OPEN_WAKA:if(k==="!")E.state=L.SGML_DECL,E.sgmlDecl="";else if(!j(k))if(ne(F,k))E.state=L.OPEN_TAG,E.tagName=k;else if(k==="/")E.state=L.CLOSE_TAG,E.tagName="";else if(k==="?")E.state=L.PROC_INST,E.procInstName=E.procInstBody="";else{if(ce(E,"Unencoded <"),E.startTagPosition+1<E.position){var V=E.position-E.startTagPosition;k=new Array(V).join(" ")+k}E.textNode+="<"+k,E.state=L.TEXT}continue;case L.SGML_DECL:(E.sgmlDecl+k).toUpperCase()===p?(re(E,"onopencdata"),E.state=L.CDATA,E.sgmlDecl="",E.cdata=""):E.sgmlDecl+k==="--"?(E.state=L.COMMENT,E.comment="",E.sgmlDecl=""):(E.sgmlDecl+k).toUpperCase()===d?(E.state=L.DOCTYPE,(E.doctype||E.sawRoot)&&ce(E,"Inappropriately located doctype declaration"),E.doctype="",E.sgmlDecl=""):k===">"?(re(E,"onsgmldeclaration",E.sgmlDecl),E.sgmlDecl="",E.state=L.TEXT):(M(k)&&(E.state=L.SGML_DECL_QUOTED),E.sgmlDecl+=k);continue;case L.SGML_DECL_QUOTED:k===E.q&&(E.state=L.SGML_DECL,E.q=""),E.sgmlDecl+=k;continue;case L.DOCTYPE:k===">"?(E.state=L.TEXT,re(E,"ondoctype",E.doctype),E.doctype=!0):(E.doctype+=k,k==="["?E.state=L.DOCTYPE_DTD:M(k)&&(E.state=L.DOCTYPE_QUOTED,E.q=k));continue;case L.DOCTYPE_QUOTED:E.doctype+=k,k===E.q&&(E.q="",E.state=L.DOCTYPE);continue;case L.DOCTYPE_DTD:E.doctype+=k,k==="]"?E.state=L.DOCTYPE:M(k)&&(E.state=L.DOCTYPE_DTD_QUOTED,E.q=k);continue;case L.DOCTYPE_DTD_QUOTED:E.doctype+=k,k===E.q&&(E.state=L.DOCTYPE_DTD,E.q="");continue;case L.COMMENT:k==="-"?E.state=L.COMMENT_ENDING:E.comment+=k;continue;case L.COMMENT_ENDING:k==="-"?(E.state=L.COMMENT_ENDED,E.comment=Te(E.opt,E.comment),E.comment&&re(E,"oncomment",E.comment),E.comment=""):(E.comment+="-"+k,E.state=L.COMMENT);continue;case L.COMMENT_ENDED:k!==">"?(ce(E,"Malformed comment"),E.comment+="--"+k,E.state=L.COMMENT):E.state=L.TEXT;continue;case L.CDATA:k==="]"?E.state=L.CDATA_ENDING:E.cdata+=k;continue;case L.CDATA_ENDING:k==="]"?E.state=L.CDATA_ENDING_2:(E.cdata+="]"+k,E.state=L.CDATA);continue;case L.CDATA_ENDING_2:k===">"?(E.cdata&&re(E,"oncdata",E.cdata),re(E,"onclosecdata"),E.cdata="",E.state=L.TEXT):k==="]"?E.cdata+="]":(E.cdata+="]]"+k,E.state=L.CDATA);continue;case L.PROC_INST:k==="?"?E.state=L.PROC_INST_ENDING:j(k)?E.state=L.PROC_INST_BODY:E.procInstName+=k;continue;case L.PROC_INST_BODY:if(!E.procInstBody&&j(k))continue;k==="?"?E.state=L.PROC_INST_ENDING:E.procInstBody+=k;continue;case L.PROC_INST_ENDING:k===">"?(re(E,"onprocessinginstruction",{name:E.procInstName,body:E.procInstBody}),E.procInstName=E.procInstBody="",E.state=L.TEXT):(E.procInstBody+="?"+k,E.state=L.PROC_INST_BODY);continue;case L.OPEN_TAG:ne(y,k)?E.tagName+=k:(Ze(E),k===">"?x(E):k==="/"?E.state=L.OPEN_TAG_SLASH:(j(k)||ce(E,"Invalid character in tag name"),E.state=L.ATTRIB));continue;case L.OPEN_TAG_SLASH:k===">"?(x(E,!0),v(E)):(ce(E,"Forward-slash in opening tag not followed by >"),E.state=L.ATTRIB);continue;case L.ATTRIB:if(j(k))continue;k===">"?x(E):k==="/"?E.state=L.OPEN_TAG_SLASH:ne(F,k)?(E.attribName=k,E.attribValue="",E.state=L.ATTRIB_NAME):ce(E,"Invalid attribute name");continue;case L.ATTRIB_NAME:k==="="?E.state=L.ATTRIB_VALUE:k===">"?(ce(E,"Attribute without value"),E.attribValue=E.attribName,Z(E),x(E)):j(k)?E.state=L.ATTRIB_NAME_SAW_WHITE:ne(y,k)?E.attribName+=k:ce(E,"Invalid attribute name");continue;case L.ATTRIB_NAME_SAW_WHITE:if(k==="=")E.state=L.ATTRIB_VALUE;else{if(j(k))continue;ce(E,"Attribute without value"),E.tag.attributes[E.attribName]="",E.attribValue="",re(E,"onattribute",{name:E.attribName,value:""}),E.attribName="",k===">"?x(E):ne(F,k)?(E.attribName=k,E.state=L.ATTRIB_NAME):(ce(E,"Invalid attribute name"),E.state=L.ATTRIB)}continue;case L.ATTRIB_VALUE:if(j(k))continue;M(k)?(E.q=k,E.state=L.ATTRIB_VALUE_QUOTED):(ce(E,"Unquoted attribute value"),E.state=L.ATTRIB_VALUE_UNQUOTED,E.attribValue=k);continue;case L.ATTRIB_VALUE_QUOTED:if(k!==E.q){k==="&"?E.state=L.ATTRIB_VALUE_ENTITY_Q:E.attribValue+=k;continue}Z(E),E.q="",E.state=L.ATTRIB_VALUE_CLOSED;continue;case L.ATTRIB_VALUE_CLOSED:j(k)?E.state=L.ATTRIB:k===">"?x(E):k==="/"?E.state=L.OPEN_TAG_SLASH:ne(F,k)?(ce(E,"No whitespace between attributes"),E.attribName=k,E.attribValue="",E.state=L.ATTRIB_NAME):ce(E,"Invalid attribute name");continue;case L.ATTRIB_VALUE_UNQUOTED:if(!ee(k)){k==="&"?E.state=L.ATTRIB_VALUE_ENTITY_U:E.attribValue+=k;continue}Z(E),k===">"?x(E):E.state=L.ATTRIB;continue;case L.CLOSE_TAG:if(E.tagName)k===">"?v(E):ne(y,k)?E.tagName+=k:E.script?(E.script+="</"+E.tagName,E.tagName="",E.state=L.SCRIPT):(j(k)||ce(E,"Invalid tagname in closing tag"),E.state=L.CLOSE_TAG_SAW_WHITE);else{if(j(k))continue;Ne(F,k)?E.script?(E.script+="</"+k,E.state=L.SCRIPT):ce(E,"Invalid tagname in closing tag."):E.tagName=k}continue;case L.CLOSE_TAG_SAW_WHITE:if(j(k))continue;k===">"?v(E):ce(E,"Invalid characters in closing tag");continue;case L.TEXT_ENTITY:case L.ATTRIB_VALUE_ENTITY_Q:case L.ATTRIB_VALUE_ENTITY_U:var Y,Le;switch(E.state){case L.TEXT_ENTITY:Y=L.TEXT,Le="textNode";break;case L.ATTRIB_VALUE_ENTITY_Q:Y=L.ATTRIB_VALUE_QUOTED,Le="attribValue";break;case L.ATTRIB_VALUE_ENTITY_U:Y=L.ATTRIB_VALUE_UNQUOTED,Le="attribValue";break}if(k===";")if(E.opt.unparsedEntities){var rt=C(E);E.entity="",E.state=Y,E.write(rt)}else E[Le]+=C(E),E.entity="",E.state=Y;else ne(E.entity.length?O:T,k)?E.entity+=k:(ce(E,"Invalid character in entity name"),E[Le]+="&"+E.entity+k,E.entity="",E.state=Y);continue;default:throw new Error(E,"Unknown state: "+E.state)}return E.position>=E.bufferCheckPosition&&s(E),E}/*! http://mths.be/fromcodepoint v0.1.0 by @mathias */String.fromCodePoint||function(){var g=String.fromCharCode,E=Math.floor,N=function(){var k=16384,U=[],V,Y,Le=-1,rt=arguments.length;if(!rt)return"";for(var Xe="";++Le<rt;){var Ue=Number(arguments[Le]);if(!isFinite(Ue)||Ue<0||Ue>1114111||E(Ue)!==Ue)throw RangeError("Invalid code point: "+Ue);Ue<=65535?U.push(Ue):(Ue-=65536,V=(Ue>>10)+55296,Y=Ue%1024+56320,U.push(V,Y)),(Le+1===rt||U.length>k)&&(Xe+=g.apply(null,U),U.length=0)}return Xe};Object.defineProperty?Object.defineProperty(String,"fromCodePoint",{value:N,configurable:!0,writable:!0}):String.fromCodePoint=N}()})(t)})(Sf);const XC=On(Sf);class zC{constructor(){this.sax=XC.parser(!0),this.sax.ontext=e=>this.handleSaxText(e),this.sax.onopentag=e=>this.handleSaxOpenTag(e),this.sax.onclosetag=e=>this.handleSaxCloseTag(e),this.lexed=[],this.elementStack=[],this.currentText="",this.openTagHandlers={usx:this.ignoreHandler,book:this.handleBookOpen,chapter:this.handleChapter,verse:this.handleVerses,para:this.handleParaOpen,table:this.ignoreHandler,row:this.handleRowOpen,cell:this.handleCellOpen,char:this.handleCharOpen,ms:this.handleMSOpen,note:this.handleNoteOpen,sidebar:this.handleSidebarOpen,periph:this.notHandledHandler,figure:this.handleFigureOpen,optbreak:this.handleOptBreakOpen,ref:this.ignoreHandler},this.closeTagHandlers={usx:this.ignoreHandler,book:this.handleBookClose,chapter:this.ignoreHandler,verse:this.ignoreHandler,para:this.handleParaClose,table:this.ignoreHandler,row:this.handleRowClose,cell:this.handleCellClose,char:this.handleCharClose,ms:this.handleMSClose,note:this.handleNoteClose,sidebar:this.handleSidebarClose,periph:this.notHandledHandler,figure:this.handleFigureClose,optbreak:this.handleOptBreakClose,ref:this.ignoreHandler}}lexAndParse(e,n){this.parser=n,this.lexed=[],this.elementStack=[],this.sax.write(e).close()}handleSaxText(e){this.currentText=this.replaceEntities(e),B.match(this.currentText,mf,"all").map(n=>Df(n,Qn)).forEach(n=>this.parser.parseItem(n))}replaceEntities(e){return e.replace("&lt;","<").replace("&gt;",">").replace("&apos;","'").replace("&quot;",'"').replace("&amp;","&")}handleSaxOpenTag(e){const n=e.name,r=e.attributes;if(n in this.openTagHandlers)this.openTagHandlers[n](this,"open",n,r);else throw new Error(`Unexpected open element tag '${n}' in UsxParser`)}handleSaxCloseTag(e){this.closeTagHandlers[e](this,"close",e)}notHandledHandler(e,n,r){console.error(`WARNING: ${n} element tag '${r}' is not handled by UsxParser`)}stackPush(e,n){this.elementStack.push([e,n])}stackPop(){return this.elementStack.pop()}splitTagNumber(e){const n=B.exec(e,B("([^1-9]+)(.*)")),r=n[1],s=n[2].length>0?n[2]:"1";return[r,s]}ignoreHandler(e,n,r){}handleParaOpen(e,n,r,s){e.currentText="";const[o,i]=e.splitTagNumber(s.style);["cp"].includes(o)||e.parser.parseItem(me.tag("startTag",[null,null,o,i])),e.stackPush(r,s)}handleParaClose(e){const n=e.stackPop()[1],[r,s]=e.splitTagNumber(n.style);["cp"].includes(r)?e.parser.parseItem(me.pubchapter("pubchapter",[null,null,e.currentText])):e.parser.parseItem(me.tag("endTag",[null,null,r,s])),e.currentText=""}handleCharOpen(e,n,r,s){const[o,i]=e.splitTagNumber(s.style);e.parser.parseItem(me.tag("startTag",[null,null,`+${o}`,i]));const a=["sid","eid","style","srcloc","link-href","link-title","link-id","closed"];for(const[u,c]of Object.entries(s))a.includes(u)||e.parser.parseItem(me.attribute("attribute",[null,null,u,c]));e.stackPush(r,s)}handleCharClose(e){const n=e.stackPop()[1],[r,s]=e.splitTagNumber(n.style);e.parser.parseItem(me.tag("endTag",[null,null,`+${r}`,s]))}handleRefOpen(e){e.parser.parseItem(me.tag("startTag",[null,null,"xt",""]))}handleRefClose(e){e.parser.parseItem(me.tag("endTag",[null,null,"xt",""]))}handleRowOpen(e,n,r,s){const[o,i]=e.splitTagNumber(s.style);e.parser.parseItem(me.tag("startTag",[null,null,o,i])),e.stackPush(r,s)}handleRowClose(e){const n=e.stackPop()[1],[r,s]=e.splitTagNumber(n.style);e.parser.parseItem(me.tag("endTag",[null,null,r,s]))}handleCellOpen(e,n,r,s){const[o,i]=e.splitTagNumber(s.style);e.parser.parseItem(me.tag("startTag",[null,null,o,i])),e.stackPush(r,s)}handleCellClose(e){const n=e.stackPop()[1],[r,s]=e.splitTagNumber(n.style);e.parser.parseItem(me.tag("endTag",[null,null,r,s]))}handleBookOpen(e,n,r,s){e.parser.parseItem(me.tag("startTag",[null,null,"id",""])),e.parser.parseItem(me.printable("wordLike",[s.code])),e.parser.parseItem(me.printable("lineSpace",[" "])),e.stackPush(r,s)}handleBookClose(e){e.stackPop(),e.parser.parseItem(me.tag("endTag",[null,null,"id",""]))}handleChapter(e,n,r,s){s.number&&(e.parser.parseItem(me.chapter("chapter",[null,null,s.number])),s.pubnumber&&e.parser.parseItem(me.pubchapter("pubchapter",[null,null,s.pubnumber])),s.altnumber&&(e.parser.parseItem(me.tag("startTag",[null,null,"+ca",""])),e.parser.parseItem(me.printable("wordLike",[s.altnumber])),e.parser.parseItem(me.tag("endTag",[null,null,"+ca",""]))))}handleVerses(e,n,r,s){s.number&&(e.parser.parseItem(me.verses("verses",[null,null,s.number])),s.pubnumber&&(e.parser.parseItem(me.tag("startTag",[null,null,"+vp",""])),e.parser.parseItem(me.printable("wordLike",[s.pubnumber])),e.parser.parseItem(me.tag("endTag",[null,null,"+vp",""]))),s.altnumber&&(e.parser.parseItem(me.tag("startTag",[null,null,"+va",""])),e.parser.parseItem(me.printable("wordLike",[s.altnumber])),e.parser.parseItem(me.tag("endTag",[null,null,"+va",""]))))}handleNoteOpen(e,n,r,s){e.parser.parseItem(me.tag("startTag",[null,null,s.style,""])),e.parser.parseItem(me.printable("punctuation",[s.caller])),e.stackPush(r,s)}handleNoteClose(e){const n=e.stackPop()[1];e.parser.parseItem(me.tag("endTag",[null,null,n.style,""]))}handleSidebarOpen(e,n,r,s){e.parser.parseItem(me.tag("startTag",[null,null,"esb",""])),"category"in s&&(e.parser.parseItem(me.tag("startTag",[null,null,"cat",""])),e.parser.parseItem(me.printable("wordLike",[s.category])),e.parser.parseItem(me.tag("endTag",[null,null,"cat",""]))),e.stackPush(r,s)}handleSidebarClose(e){e.stackPop(),e.parser.parseItem(me.tag("startTag",[null,null,"esbe",""]))}handleMSOpen(e,n,r,s){let o=B.exec(s.style,B("(([a-z1-9]+)-([se]))"));if(o){const i=me.milestone("startMilestoneTag",[null,null,o[2],o[3]]);e.parser.parseItem(i);const a=["sid","eid","style","srcloc","link-href","link-title","link-id"];for(const[u,c]of Object.entries(s))a.includes(u)||e.parser.parseItem(me.attribute("attribute",[null,null,u,c]));e.parser.parseItem(me.milestone("endMilestoneMarker"))}else{const i=me.milestone("emptyMilestone",[null,null,s.style,""]);e.parser.parseItem(i)}e.stackPush(r,s)}handleMSClose(e){e.stackPop()}handleFigureOpen(e,n,r,s){e.parser.parseItem(me.tag("startTag",[null,null,"+fig",""]));for(const[o,i]of Object.entries(s)){if(o==="style")continue;const a=o==="file"?"src":o;e.parser.parseItem(me.attribute("attribute",[null,null,a,i]))}e.stackPush(r,s)}handleFigureClose(e){e.stackPop()[1],e.parser.parseItem(me.tag("endTag",[null,null,"+fig",""]))}handleOptBreakOpen(e,n,r,s){e.parser.parseItem(me.printable("softLineBreak",["//"])),e.stackPush(r,s)}handleOptBreakClose(e){e.stackPop()}}const YC=(t,e)=>{new zC().lexAndParse(t,e)},Rr=Q.ByteArray,{pushSuccinctGraftBytes:ZC,pushSuccinctScopeBytes:QC,pushSuccinctTokenBytes:e9}=Q.succinct,{addTag:t9}=Q.tags,{labelForScope:Gi}=Q.scopeDefs,{itemEnum:n9}=Q.itemDefs,{scopeEnum:r9}=Q.scopeDefs,{tokenCategory:s9,tokenEnum:o9}=Q.tokenDefs,In=class{constructor(t){this.id=Q.generateId(),this.type=t,this.tags=new Set([]),this.blocks=[],this.activeScopes=[]}addTag(t){t9(this.tags,t)}plainText(){return this.blocks.map(t=>t.plainText()).join("").trim()}addItem(t){this.lastBlock().addItem(t)}addBlockGraft(t){this.newBlock("hangingGraft"),this.lastBlock().bg.push(t)}lastBlock(){return this.blocks.length===0&&this.newBlock("orphanTokens"),this.blocks[this.blocks.length-1]}newBlock(t){this.blocks.length>0&&["orphanTokens","hangingGraft"].includes(this.blocks[this.blocks.length-1].bs.payload)?this.lastBlock().bs={type:"scope",subType:"start",payload:t}:this.blocks.push(new i9(t))}trim(){this.blocks.forEach(t=>t.trim())}reorderSpanWithAtts(){this.blocks.forEach(t=>t.reorderSpanWithAtts())}makeNoteGrafts(t){this.blocks.forEach(e=>e.makeNoteGrafts(t))}close(t){for(const e of this.activeScopes.filter(()=>!0).reverse())this.closeActiveScope(t,e);this.activeScopes=[]}closeActiveScope(t,e){this.addItem({type:"scope",subType:"end",payload:e.label}),e.onEnd&&e.onEnd(t,e.label)}filterGrafts(t){return this.blocks.map(e=>e.filterGrafts(t)).reduce((e,n)=>e.concat(n),[])}filterScopes(t){this.blocks.forEach(e=>e.filterScopes(t))}text(){return this.blocks.map(t=>t.text()).join("")}addTableScopes(){let t=!1;for(const[e,n]of this.blocks.entries())!t&&n.bs.payload==="blockTag/tr"?(t=!0,this.blocks[e].items.unshift({type:"scope",subType:"start",payload:Gi("table",[])})):t&&n.bs.payload!=="blockTag/tr"&&(t=!1,this.blocks[e-1].items.push({type:"scope",subType:"end",payload:Gi("table",[])}));t&&this.lastBlock().items.push({type:"scope",subType:"end",payload:Gi("table",[])})}graftifyIntroductionHeadings(t){let e=[...this.blocks.entries()];e.reverse();const n=["iot","is"].concat(t.customTags.introHeading);for(const[r,s]of e){const o=s.bs.payload.split("/")[1].replace(/[0-9]/g,"");if(n.includes(o)){const i=new In("heading");t.sequences.heading.push(i),i.blocks.push(s);const a={type:"graft",subType:"heading",payload:i.id};this.blocks.length<r+2&&this.newBlock("blockTag/hangingGraft"),this.blocks[r+1].bg.unshift(a),this.blocks.splice(r,1)}else if(o.startsWith("imt")){const i=o.startsWith("imte")?"introEndTitle":"introTitle";let a;if(t.sequences[i])a=t.sequences[i];else{const u=o.startsWith("imte")?"endTitle":"title";a=new In(u),t.sequences[i]=a;const c={type:"graft",subType:u,payload:a.id};this.blocks.length<r+2&&this.newBlock("blockTag/hangingGraft"),this.blocks[r+1].bg.unshift(c)}this.blocks.splice(r,1),a.blocks.unshift(s)}}}moveOrphanScopes(){this.blocks.length>1&&(this.moveOrphanStartScopes(),this.moveOrphanEndScopes())}moveOrphanStartScopes(){for(const[t,e]of this.blocks.entries())if(!(t>=this.blocks.length-1))for(const n of[...e.items].reverse()){if(n.subType!=="start"||n.payload.startsWith("altChapter"))break;this.blocks[t+1].items.unshift(this.blocks[t].items.pop())}}moveOrphanStartScopes2(){for(const[t,e]of this.blocks.entries())if(!(t>=this.blocks.length-1))for(const n of[...e.items].reverse()){if(n.subType!=="start")break;this.blocks[t+1].items.unshift(this.blocks[t].items.pop())}}moveOrphanEndScopes(){for(const[t,e]of this.blocks.entries())if(t!==0)for(const n of[...e.items]){if(n.subType!=="end")break;this.blocks[t-1].items.push(this.blocks[t].items.shift())}}removeEmptyBlocks(t){const e=["blockTag/b","blockTag/ib"].concat(t),n=[];let r=!1;const s=o=>{const i=o.filter(u=>u.type==="scope"&&u.payload.startsWith("milestone")),a=new Set([]);for(const u of i)if(u.subType==="start")a.add(u.payload);else if(a.has(u.payload))return!0;return!1};for(const o of this.blocks.entries())o[1].tokens().length===0&&!s(o[1].items)&&!e.includes(o[1].bs.payload)&&n.push(o);for(const[o,i]of n.reverse())if(o<this.blocks.length-1){for(const a of[...i.bg].reverse())this.blocks[o+1].bg.unshift(a);for(const a of i.items.reverse())this.blocks[o+1].items.unshift(a);this.blocks.splice(o,1),r=!0}else i.bg.length===0&&i.items.length===0&&(this.blocks.splice(o,1),r=!0);r&&this.removeEmptyBlocks(t)}removeGraftsToEmptySequences(t){this.blocks.forEach(e=>e.removeGraftsToEmptySequences(t))}succinctifyBlocks(t){const e=[];let n=[];const r=o=>{o.subType==="start"?n.filter(a=>a.payload===o.payload).length===0&&n.push(o):n=n.filter(i=>i.payload!==o.payload)};let s=0;for(const o of this.blocks){const i=new Rr(o.length),a=new Rr(1),u=new Rr(1),c=new Rr(1),l=new Rr(1);l.pushNByte(s);for(const f of o.bg)this.pushSuccinctGraft(a,t,f);for(const f of n)this.pushSuccinctScope(u,t,f);const p=[];for(const f of o.items)switch(f.type){case"token":this.pushSuccinctToken(i,t,f),f.subType==="wordLike"&&s++;break;case"graft":this.pushSuccinctGraft(i,t,f);break;case"scope":this.pushSuccinctScope(i,t,f),r(f),f.subType==="start"&&p.push(f);break;default:throw new Error(`Item type ${f.type} is not handled in succinctifyBlocks`)}const d=new Rr(10);this.pushSuccinctScope(d,t,o.bs);for(const f of p)this.pushSuccinctScope(c,t,f);i.trim(),a.trim(),d.trim(),u.trim(),c.trim(),e.push({c:i,bs:d,bg:a,os:u,is:c,nt:l})}return e}pushSuccinctToken(t,e,n){const r=e.enumForCategoryValue(s9[n.subType],n.payload);e9(t,o9[n.subType],r)}pushSuccinctGraft(t,e,n){const r=e.enumForCategoryValue("graftTypes",n.subType),s=e.enumForCategoryValue("ids",n.payload);ZC(t,r,s)}pushSuccinctScope(t,e,n){const r=n.payload.split("/"),s=r9[r[0]],o=r.slice(1).map(i=>e.enumForCategoryValue("scopeBits",i));QC(t,n9[`${n.subType}Scope`],s,o)}},i9=class{constructor(t){this.id=Q.generateId(),this.items=[],this.bg=[],this.bs={type:"scope",subType:"start",payload:t},this.os=[]}addItem(t){this.items.push(t)}plainText(){return this.items.filter(t=>t.type==="token").map(t=>t.payload).join("")}trim(){this.items=this.trimEnd(this.trimStart(this.items))}reorderSpanWithAtts(){const t=[];for(const[e,n]of this.items.entries())n.subType==="start"&&n.payload.startsWith("spanWithAtts")&&t.push(e+1);for(const e of t){let n=e,r=[],s=[];for(;!(n>=this.items.length);){const o=this.items[n];if(o.type==="token")r.push(o);else if(o.subType==="start"&&o.payload.startsWith("attribute/spanWithAtts"))s.push(o);else break;n++}if(r.length!==0&&s.length!==0){let o=e;for(const i of s)this.items[o]=i,o++;for(const i of r)this.items[o]=i,o++}}}inlineToEnd(){let t=null;for(const[e,n]of this.items.entries())if(n.subType==="end"&&["inline/f","inline/fe","inline/x"].includes(n.payload)){t=n,this.items.splice(e,1);break}t&&this.addItem(t)}makeNoteGrafts(t){const e=[];for(const[n,r]of this.items.entries())r.subType==="start"&&(r.payload.startsWith("inline/f")||r.payload.startsWith("inline/x"))&&e.push(n);for(const n of e){const r=this.items[n].payload,s=this.items[n+1];if(s.type==="token"&&s.payload.length===1){const o=new In("noteCaller");o.newBlock(r),o.addItem(s),t.sequences.noteCaller.push(o),this.items[n+1]={type:"graft",subType:"noteCaller",payload:o.id}}}}trimStart(t){if(t.length===0)return t;const e=t[0];return["lineSpace","eol"].includes(e.subType)?this.trimStart(t.slice(1)):e.type==="token"?t:[e,...this.trimStart(t.slice(1))]}trimEnd(t){if(t.length===0)return t;const e=t[t.length-1];return["lineSpace","eol"].includes(e.subType)?this.trimEnd(t.slice(0,t.length-1)):e.type==="token"?t:[...this.trimEnd(t.slice(0,t.length-1)),e]}filterGrafts(t){const e=[];let n=[];for(const[r,s]of this.grafts())this.graftPassesOptions(s,t)?e.push(s.payload):n.push(r);for(const[r,s]of Array.from(n.entries()))this.items.splice(s-r,1);n=[];for(const[r,s]of this.bg.entries())this.graftPassesOptions(s,t)?e.push(s.payload):n.push(r);for(const[r,s]of Array.from(n.entries()))this.bg.splice(s-r,1);return e}filterScopes(t){const e=[];for(const[n,r]of this.scopes())this.scopePassesOptions(r,t)||e.push(n);for(const[n,r]of Array.from(e.entries()))this.items.splice(r-n,1)}graftPassesOptions(t,e){return(!("includeGrafts"in e)||e.includeGrafts.includes(t.subType))&&(!("excludeGrafts"in e)||!e.excludeGrafts.includes(t.subType))}scopePassesOptions(t,e){return(!("includeScopes"in e)||this.scopeMatchesOptionArray(t.payload,e.includeScopes))&&(!("excludeScopes"in e)||!this.scopeMatchesOptionArray(t.payload,e.excludeScopes))}scopeMatchesOptionArray(t,e){for(const n of e)if(t.startsWith(n))return!0;return!1}removeGraftsToEmptySequences(t){const e=[];let n=[];for(const[r,s]of this.grafts())t.includes(s.payload)&&n.push(r);for(const[r,s]of Array.from(n.entries()))this.items.splice(s-r,1);n=[];for(const[r,s]of this.bg.entries())t.includes(s.payload)&&n.push(r);for(const[r,s]of Array.from(n.entries()))this.bg.splice(s-r,1);return e}grafts(){return Array.from(this.items.entries()).filter(t=>t[1].type==="graft")}scopes(){return Array.from(this.items.entries()).filter(t=>t[1].type==="scope")}tokens(){return Array.from(this.items.entries()).filter(t=>!["scope","graft"].includes(t[1].type))}text(){return this.tokens().map(t=>t[1].payload).join("")}},hs={},Ef=[];for(const t of Qn)["wordLike","eol","lineSpace","punctuation","unknown"].includes(t[1])&&(hs[t[1]]=B(`^${t[2].xregexp.source}$`),Ef.push(t[2]));const yf=t=>{const e=B.union(Ef),n=[];for(const r of B.match(t,e,"all")){let s;B.test(r,hs.wordLike)?s="wordLike":B.test(r,hs.punctuation)?s="punctuation":B.test(r,hs.lineSpace)?s="lineSpace":B.test(r,hs.eol)?s="eol":s="unknown",n.push([r,s])}return n},{labelForScope:a9}=Q.scopeDefs,u9=(t,e,n)=>{const{rows:r}=JSON.parse(t);e.headers.id=n,e.headers.bookCode=n;const s=new In("table");for(const[o,i]of r.entries())for(const[a,u]of i.entries()){s.newBlock(a9("tTableRow",[`${o}`]));const c=s.lastBlock();c.addItem({type:"scope",subType:"start",payload:`tTableCol/${a}`});for(const[l,p]of yf(u))c.addItem({type:"token",subType:p,payload:l});c.addItem({type:"scope",subType:"end",payload:`tTableCol/${a}`})}e.sequences.table.push(s),e.sequences.main.addBlockGraft({type:"graft",subType:"table",payload:s.id})},{labelForScope:ho}=Q.scopeDefs;let Ui=0;const gf=(t,e)=>{typeof e!="number"&&(Ui=0);const n={...t,id:Ui,parentId:typeof e=="number"?e:"none"};return Ui++,t.children&&(n.children=t.children.map(r=>gf(r,n.id))),n},vf=t=>{const e=[{}];if(e[0].id=t.id,e[0].parentId=t.parentId,t.content&&(e[0].content=t.content),t.children){e[0].children=[];for(const n of t.children)e[0].children.push(n.id),vf(n).forEach(r=>e.push(r))}return e},c9=(t,e,n)=>{e.headers.id=n,e.headers.bookCode=n;const r=new In("tree");for(const s of vf(gf(JSON.parse(t)))){r.newBlock(ho("tTreeNode",[`${s.id}`]));const o=ho("tTreeParent",[`${s.parentId}`]);if(r.lastBlock().items.push({type:"scope",subType:"start",payload:o}),s.content)for(const[i,a]of Object.entries(s.content)){const u=r.lastBlock().items.length,c=yf(a),l=ho("tTreeContent",[i,s.id,`${u}`,`${c.length}`]);r.lastBlock().items.push({type:"scope",subType:"start",payload:l});for(const[p,d]of c)r.lastBlock().items.push({type:"token",subType:d,payload:p});r.lastBlock().items.push({type:"scope",subType:"end",payload:l})}if(s.children)for(const[i,a]of s.children.entries()){const u=ho("tTreeChild",[i,a]);r.lastBlock().items.push({type:"scope",subType:"start",payload:u}),r.lastBlock().items.push({type:"scope",subType:"end",payload:u})}r.lastBlock().items.push({type:"scope",subType:"end",payload:o})}e.sequences.tree.push(r),e.sequences.main.addBlockGraft({type:"graft",subType:"tree",payload:r.id})},{labelForScope:at}=Q.scopeDefs,l9=new RegExp(/^[A-Z0-9_]+$/),p9=t=>{const e={};for(const n of t)for(const r of n.contexts){r[0]in e||(e[r[0]]={});const s=r[1];if(!s)e[r[0]]._noAccessor=n.parser;else{s in e[r[0]]||(e[r[0]][s]={});for(const o of r[2])e[r[0]][s][o]=n.parser}}return e},d9=t=>[{contexts:[["startTag","tagName",["id","usfm","ide","sts","h","toc","toca","cl"]]],parser:{baseSequenceType:"header",forceNewSequence:!0,newBlock:!0,useTempSequence:!0,newScopes:[{label:e=>e.fullTagName,endedBy:["baseSequenceChange"],onEnd:(e,n)=>{if(e.headers[n]=e.current.sequence.plainText(),n==="id"){const r=e.headers[n].split(" ",2);r[0].length>=2&&r[0].length<=32&&l9.test(r[0])&&(e.headers.bookCode=r[0])}}}]}},{contexts:[["startTag","tagName",["ms","mr","s","sr","r","qa","sp","sd"].concat(t.customTags.heading)]],parser:{baseSequenceType:"heading",forceNewSequence:!0,newBlock:!0,newScopes:[]}},{contexts:[["startTag","tagName",["mt"]]],parser:{baseSequenceType:"title",newBlock:!0,newScopes:[]}},{contexts:[["startTag","tagName",["mte"]]],parser:{baseSequenceType:"endTitle",newBlock:!0,newScopes:[]}},{contexts:[["startTag","tagName",["imt","is","ip","ipi","im","imi","ipq","imq","ipr","iq","ib","ili","iot","io","iex","imte"].concat(t.customTags.intro)]],parser:{baseSequenceType:"introduction",newBlock:!0,newScopes:[]}},{contexts:[["startTag","tagName",["esb"]]],parser:{baseSequenceType:"sidebar",newBlock:!0,newScopes:[],after:e=>{e.mainLike=e.current.sequence}}},{contexts:[["startTag","tagName",["esbe"]]],parser:{baseSequenceType:"main",newBlock:!0,newScopes:[],after:e=>{e.mainLike=e.sequences.main}}},{contexts:[["startTag","tagName",["cat"]]],parser:{inlineSequenceType:"esbCat",forceNewSequence:!0,newScopes:[{label:e=>at("inline",[e.fullTagName]),endedBy:["endTag/cat","endBlock","implicitEnd"],onEnd:e=>e.returnToBaseSequence()}],during:(e,n)=>{const r=Q.generateId(),s={label:()=>at("esbCat",[r]),endedBy:["startTag/esbe"]};e.openNewScope(n,s,!0,e.mainLike)}}},{contexts:[["startTag","tagName",["rem"]]],parser:{baseSequenceType:"remark",forceNewSequence:!0,newScopes:[]}},{contexts:[["startTag","tagName",["cd","p","m","po","pr","cls","pmo","pm","pmc","pmr","pi","mi","nb","pc","ph","b","q","qr","qc","qa","qm","qd","lh","li","lf","lim","d"].concat(t.customTags.paragraph)]],parser:{baseSequenceType:"mainLike",newBlock:!0,newScopes:[]}},{contexts:[["startTag","tagName",["tr"]]],parser:{newBlock:!0,newScopes:[]}},{contexts:[["startTag","tagName",["f","fe"]]],parser:{inlineSequenceType:"footnote",forceNewSequence:!0,newScopes:[{label:e=>at("inline",[e.fullTagName]),endedBy:["endTag/f","endTag/fe","endBlock"],onEnd:e=>e.returnToBaseSequence()}]}},{contexts:[["startTag","tagName",["x"]]],parser:{inlineSequenceType:"xref",forceNewSequence:!0,newScopes:[{label:e=>at("inline",[e.fullTagName]),endedBy:["endTag/x","endBlock"],onEnd:e=>e.returnToBaseSequence()}]}},{contexts:[["startTag","tagName",["fig"]]],parser:{inlineSequenceType:"fig",forceNewSequence:!0,newScopes:[{label:e=>at("spanWithAtts",[e.tagName]),endedBy:["endBlock","endTag/$tagName$"],onEnd:e=>e.clearAttributeContext()}],during:(e,n)=>{e.setAttributeContext(at("spanWithAtts",[n.tagName]))}}},{contexts:[["chapter"]],parser:{mainSequence:!0,newScopes:[{label:e=>at("chapter",[e.number]),endedBy:["chapter"]}]}},{contexts:[["pubchapter"]],parser:{mainSequence:!0,newScopes:[{label:e=>at("pubChapter",[e.numberString]),endedBy:["pubchapter","chapter"]}]}},{contexts:[["startTag","tagName",["ca"]]],parser:{inlineSequenceType:"altNumber",forceNewSequence:!0,newScopes:[{label:e=>at("inline",[e.fullTagName]),endedBy:["endTag/ca","endBlock","implicitEnd"],onEnd:e=>e.returnToBaseSequence()}],during:(e,n)=>{const r=Q.generateId(),s={label:()=>at("altChapter",[r]),endedBy:["startTag/ca","chapter"]};e.openNewScope(n,s,!0,e.sequences.main)}}},{contexts:[["verses"]],parser:{mainSequence:!0,newScopes:[{label:e=>at("verses",[e.numberString]),endedBy:["verses","chapter","pubchapter"]}],during:(e,n)=>{n.numbers.forEach(r=>{const s={label:()=>at("verse",[r]),endedBy:["verses","chapter","pubchapter"]};e.openNewScope(n,s,!0,e.sequences.main)})}}},{contexts:[["startTag","tagName",["vp"]]],parser:{inlineSequenceType:"pubNumber",forceNewSequence:!0,newScopes:[{label:e=>at("inline",[e.fullTagName]),endedBy:["endTag/vp","endBlock","implicitEnd"],onEnd:e=>e.returnToBaseSequence()}],during:(e,n)=>{const r=Q.generateId(),s={label:()=>at("pubVerse",[r]),endedBy:["startTag/vp","verses","chapter","pubchapter"]};e.openNewScope(n,s,!0,e.sequences.main)}}},{contexts:[["startTag","tagName",["va"]]],parser:{inlineSequenceType:"altNumber",forceNewSequence:!0,newScopes:[{label:e=>at("inline",[e.fullTagName]),endedBy:["endTag/va","endBlock","implicitEnd"],onEnd:e=>e.returnToBaseSequence()}],during:(e,n)=>{const r=Q.generateId(),s={label:()=>at("altVerse",[r]),endedBy:["startTag/va","verses","chapter","pubchapter"]};e.openNewScope(n,s,!0,e.sequences.main)}}},{contexts:[["startTag","tagName",["qs","qac","litl","lik","liv","fr","fq","fqa","fk","fl","fw","fp","fv","ft","fdc","fm","xo","xk","xq","xt","xta","xop","xot","xnt","xdc","rq","add","bk","dc","k","nd","ord","pn","png","qt","sig","sls","tl","wj","em","bd","it","bdit","no","sc","sup","ior","iqt"].concat(t.customTags.char)]],parser:{newScopes:[{label:e=>at("span",[e.fullTagName]),endedBy:["endBlock","endTag/$fullTagName$","implicitEnd"]}]}},{contexts:[["startTag","tagName",["th","thr","tc","tcr"]]],parser:{newScopes:[{label:e=>at("cell",[e.fullTagName]),endedBy:["startTag/th","startTag/thr","startTag/tc","startTag/tcr","startTag/th2","startTag/thr2","startTag/tc2","startTag/tcr2","startTag/th3","startTag/thr3","startTag/tc3","startTag/tcr3","endBlock","endTag/$fullTagName$"]}]}},{contexts:[["emptyMilestone"]],parser:{during:(e,n)=>{e.addEmptyMilestone(at("milestone",[n.tagName]))}}},{contexts:[["startMilestoneTag","sOrE","s"]],parser:{newScopes:[{label:e=>at("milestone",[e.tagName]),endedBy:["endMilestone/$tagName$"]}],during:(e,n)=>{e.setAttributeContext(at("milestone",[n.tagName]))}}},{contexts:[["endMilestoneMarker"]],parser:{during:e=>e.clearAttributeContext()}},{contexts:[["attribute"],["defaultAttribute"]],parser:{during:(e,n)=>{const r={w:"lemma",rb:"gloss",xt:"link-href"};if(e.current.attributeContext){const s=e.current.attributeContext.split("/");n.key==="default"&&s.length===2&&(n.key=r[s[1]]||`unknownDefault_${s[1]}`,n.printValue=n.printValue.replace(/default/,n.key)),[...n.values.entries()].forEach(o=>{const i={label:a=>at("attribute",[e.current.attributeContext,a.key,o[0],o[1]]),endedBy:["$attributeContext$"]};e.openNewScope(n,i)})}else e.addToken(me.printable("unknown",[n.printValue]))}}},{contexts:[["startTag","tagName",["w","rb"].concat(t.customTags.word)]],parser:{newScopes:[{label:e=>at("spanWithAtts",[e.tagName]),endedBy:["endBlock","endTag/$tagName$"],onEnd:e=>e.clearAttributeContext()}],during:(e,n)=>{e.setAttributeContext(at("spanWithAtts",[n.tagName]))}}},{contexts:[["wordLike"],["lineSpace"],["punctuation"],["eol"]],parser:{during:(e,n)=>e.addToken(n)}},{contexts:[["noBreakSpace"]],parser:{during:e=>{e.addToken(me.printable("lineSpace",[" "]))}}},{contexts:[["softLineBreak"]],parser:{during:e=>{e.addToken(me.printable("softLineBreak",["//"]))}}},{contexts:[["bareSlash"]],parser:{during:e=>{e.addToken(me.printable("bareSlash",["\\"]))}}},{contexts:[["unknown"]],parser:{during:(e,n)=>{e.addToken(me.printable("unknown",[n.printValue]))}}}],{labelForScope:Vi}=Q.scopeDefs,e1=Q.parserConstants,f9=class{constructor(t,e,n){this.filterOptions=t,this.customTags=e,this.emptyBlocks=n,this.specs=d9(this),this.specLookup=p9(this.specs),this.headers={},this.baseSequenceTypes=e1.usfm.baseSequenceTypes,this.inlineSequenceTypes=e1.usfm.inlineSequenceTypes,this.setSequences(),this.setCurrent()}setSequences(){this.sequences={};for(const[t,e]of Object.entries({...this.baseSequenceTypes,...this.inlineSequenceTypes}))switch(e){case"1":this.sequences[t]=new In(t);break;case"?":this.sequences[t]=null;break;case"*":this.sequences[t]=[];break;default:throw new Error(`Unexpected sequence arity '${e}' for '${t}'`)}this.mainLike=this.sequences.main}setCurrent(){this.current={sequence:this.sequences.main,parentSequence:null,baseSequenceType:"main",inlineSequenceType:null,attributeContext:null}}parseItem(t){let e=!1;["startTag"].includes(t.subclass)&&(this.closeActiveScopes(`startTag/${t.fullTagName}`),t.isNested||this.closeActiveScopes("implicitEnd")),["endTag"].includes(t.subclass)&&this.closeActiveScopes(`endTag/${t.fullTagName}`),["startMilestoneTag"].includes(t.subclass)&&t.sOrE==="e"&&this.closeActiveScopes(`endMilestone/${t.tagName}`),["chapter","pubchapter","verses"].includes(t.subclass)&&this.closeActiveScopes(t.subclass,this.sequences.main);const n=this.specForItem(t);n&&("before"in n.parser&&n.parser.before(this,t),e=!1,n.parser.baseSequenceType&&(e=(n.parser.baseSequenceType==="mainLike"?this.mainLike.type:n.parser.baseSequenceType)!==this.current.baseSequenceType||n.parser.forceNewSequence),e?(this.closeActiveScopes("baseSequenceChange"),this.changeBaseSequence(n.parser),"newBlock"in n.parser&&n.parser.newBlock&&(this.closeActiveScopes("endBlock"),this.current.sequence.newBlock(Vi("blockTag",[t.fullTagName])))):n.parser.inlineSequenceType?(this.current.inlineSequenceType=n.parser.inlineSequenceType,this.current.parentSequence=this.current.sequence,this.current.parentSequence.type==="header"&&(this.current.parentSequence=this.sequences.main),this.current.sequence=new In(this.current.inlineSequenceType),this.current.sequence.newBlock(Vi("inline",n.parser.inlineSequenceType)),this.sequences[this.current.inlineSequenceType].push(this.current.sequence),this.current.parentSequence.addItem({type:"graft",subType:this.current.inlineSequenceType,payload:this.current.sequence.id})):"newBlock"in n.parser&&n.parser.newBlock&&this.current.sequence.newBlock(Vi("blockTag",[t.fullTagName])),"during"in n.parser&&n.parser.during(this,t),this.openNewScopes(n.parser,t),"after"in n.parser&&n.parser.after(this,t))}tidy(){for(const n of this.sequences.introduction)n.graftifyIntroductionHeadings(this);const t=this.allSequences();for(const n of t)n.trim(),n.reorderSpanWithAtts(),n.makeNoteGrafts(this),n.moveOrphanScopes(),n.removeEmptyBlocks(this.emptyBlocks);const e=this.emptySequences(t);for(const n of t)e&&n.removeGraftsToEmptySequences(e),n.addTableScopes(),n.close(this),this.substitutePubNumberScopes(n),n.moveOrphanStartScopes2(),n.type==="sidebar"&&this.substituteEsbCatScopes(n),["footnote","xref"].includes(n.type)&&n.lastBlock().inlineToEnd()}emptySequences(t){return t.filter(e=>e.blocks.length===0).map(e=>e.id)}substitutePubNumberScopes(t){const e={},n=this.sequenceById();for(const r of t.blocks){let s=0;const o=[...r.items];for(const[i,a]of o.entries())if(a.type==="graft"&&["pubNumber","altNumber"].includes(a.subType)){const u=n[a.payload].text().trim(),c=o[i+1].payload.split("/")[1];e[c]=u,r.items.splice(i-s,1),s++}}if(Object.keys(e).length>0)for(const r of t.blocks)for(const s of r.items.filter(o=>o.type==="scope")){const o=s.payload.split("/");["altChapter","pubVerse","altVerse"].includes(o[0])&&(s.payload=`${o[0]}/${e[o[1]]}`)}}substituteEsbCatScopes(t){const e={},n=this.sequenceById();for(const r of t.blocks){let s=0;const o=[...r.items];for(const[i,a]of o.entries())if(a.type==="graft"&&a.subType==="esbCat"){const u=n[a.payload].text().trim(),c=o[1].payload.split("/")[1];e[c]=u,r.items.splice(i-s,1),s++}}if(Object.keys(e).length>0)for(const r of t.blocks)for(const s of r.items.filter(o=>o.type==="scope")){const o=s.payload.split("/");o[0]==="esbCat"&&(s.payload=`${o[0]}/${e[o[1]]}`)}}allSequences(){const t=[];for(const[e,n]of Object.entries({...this.baseSequenceTypes,...this.inlineSequenceTypes}))switch(n){case"1":case"?":this.sequences[e]&&t.push(this.sequences[e]);break;case"*":this.sequences[e].forEach(r=>{t.push(r)});break;default:throw new Error(`Unexpected sequence arity '${n}' for '${e}'`)}return t}sequenceById(){const t={};return this.allSequences().forEach(e=>{t[e.id]=e}),t}filter(){const t=[],e=this.sequenceById();this.filterGrafts(this.sequences.main.id,e,t,this.filterOptions),this.removeUnusedSequences(t),this.filterScopes(Object.values(e),this.filterOptions)}filterGrafts(t,e,n,r){n.push(t);const s=e[t].filterGrafts(r);for(const o of s){if(e[o].type==="main")throw new Error("MAIN is child!",JSON.stringify(e[t],null,2));this.filterGrafts(o,e,n,r)}}removeUnusedSequences(t){for(const e of this.allSequences())if(!t.includes(e.id)){const n={...this.baseSequenceTypes,...this.inlineSequenceTypes}[e.type];switch(n){case"1":throw new Error("Attempting to remove sequence with arity of 1");case"?":this.sequences[e.type]=null;break;case"*":this.sequences[e.type]=this.sequences[e.type].filter(r=>r.id!==e.id);break;default:throw new Error(`Unexpected sequence arity '${n}' for '${e.type}'`)}}}filterScopes(t,e){t.forEach(n=>n.filterScopes(e))}specForItem(t){const e=t.subclass;if(!(e in this.specLookup))return null;for(const n of["tagName","sOrE"])if(n in t&&n in this.specLookup[e]&&t[n]in this.specLookup[e][n])return{parser:this.specLookup[e][n][t[n]]};return"_noAccessor"in this.specLookup[e]?{parser:this.specLookup[e]._noAccessor}:null}closeActiveScopes(t,e){e===void 0&&(e=this.current.sequence);const n=e.activeScopes.filter(r=>r.endedBy.includes(t)).reverse();e.activeScopes=e.activeScopes.filter(r=>!r.endedBy.includes(t)),n.forEach(r=>this.closeActiveScope(r,e))}closeActiveScope(t,e){this.addScope("end",t.label,e),t.onEnd&&t.onEnd(this,t.label)}changeBaseSequence(t){const e=t.baseSequenceType;if(e==="mainLike"){this.current.sequence=this.mainLike;return}this.current.baseSequenceType=e;const n=this.baseSequenceTypes[e];switch(n){case"1":this.current.sequence=this.sequences[e];break;case"?":this.sequences[e]||(this.sequences[e]=new In(e)),this.current.sequence=this.sequences[e];break;case"*":this.current.sequence=new In(e),t.useTempSequence||this.sequences[e].push(this.current.sequence);break;default:throw new Error(`Unexpected base sequence arity '${n}' for '${e}'`)}!t.useTempSequence&&this.current.sequence.type!=="main"&&this.mainLike.addBlockGraft({type:"graft",subType:this.current.baseSequenceType,payload:this.current.sequence.id})}returnToBaseSequence(){this.current.inlineSequenceType=null,this.current.sequence=this.current.parentSequence,this.current.parentSequence=null}openNewScopes(t,e){if(t.newScopes){let n=this.current.sequence;"mainSequence"in t&&t.mainSequence&&(n=this.sequences.main),t.newScopes.forEach(r=>this.openNewScope(e,r,!0,n))}}openNewScope(t,e,n,r){n===void 0&&(n=!0),r===void 0&&(r=this.current.sequence),n&&r.addItem({type:"scope",subType:"start",payload:e.label(t)});const s={label:e.label(t),endedBy:this.substituteEndedBys(e.endedBy,t)};"onEnd"in e&&(s.onEnd=e.onEnd),r.activeScopes.push(s)}substituteEndedBys(t,e){return t.map(n=>{let r=n.replace("$fullTagName$",e.fullTagName).replace("$tagName$",e.tagName);return this.current.attributeContext&&(r=r.replace("$attributeContext$",this.current.attributeContext.replace("milestone","endMilestone").replace("spanWithAtts","endTag"))),r})}addToken(t){this.current.sequence.addItem({type:"token",subType:t.subclass,payload:t.printValue})}addScope(t,e,n){n===void 0&&(n=this.current.sequence),n.addItem({type:"scope",subType:t,payload:e})}addEmptyMilestone(t){this.mainLike.addItem({type:"scope",subType:"start",payload:t}),this.mainLike.addItem({type:"scope",subType:"end",payload:t})}setAttributeContext(t){this.current.attributeContext=t}clearAttributeContext(){this.current.attributeContext=null}},h9=[{id:0,type:"Inputs",inputs:{perf:"json"}},{id:1,title:"Generate report",name:"calculateUsfmChapterPositions",type:"Transform",inputs:[{name:"perf",type:"json",source:"Input perf"}],outputs:[{name:"report",type:"json"}],description:"Generate report from perf to calculate the position of the chapters"},{id:2,title:"PERF to USFM",name:"perf2usfm",type:"Transform",inputs:[{name:"perf",type:"json",source:"Input perf"},{name:"report",type:"json",source:"Transform 1 report"}],outputs:[{name:"usfm",type:"text"}],description:"PERF=>USFM: Conversion via Proskomma"},{id:999,type:"Outputs",outputs:[{name:"usfm",type:"text",source:"Transform 2 usfm"}]}],m9=[{id:0,type:"Inputs",inputs:{perf:"json"}},{id:1,title:"PERF to PkJSON",name:"perf2PkJson",type:"Transform",inputs:[{name:"perf",type:"json",source:"Input perf"}],outputs:[{name:"pkJson",type:"json"}],documentation:"",description:"PERF=>JSON: Converts PERF to current Proskomma input format"},{id:999,type:"Outputs",outputs:[{name:"pkJson",type:"json",source:"Transform 1 pkJson"}]}],Af={perf2usfmPipeline:h9,perf2PkJsonPipeline:m9},t1=t=>({type:t.sequences[0].block.type,subType:t.sequences[0].block.subType,pos:t.sequences[0].block.blockN,perfChapter:null}),D9={startDocument:[{description:"Set up storage",test:()=>!0,action:({workspace:t,output:e})=>{t.blockRecords=[],e.report={}}}],startParagraph:[{description:"Set up block record",test:()=>!0,action:({context:t,workspace:e})=>{e.blockRecords.push(t1(t))}}],blockGraft:[{description:"Set up block record",test:()=>!0,action:({context:t,workspace:e})=>{e.blockRecords.push(t1(t))}}],mark:[{description:"Add chapter number to block record",test:({context:t})=>t.sequences[0].element.subType==="chapter",action:({context:t,workspace:e})=>{e.blockRecords[e.blockRecords.length-1].perfChapter=t.sequences[0].element.atts.number}}],endDocument:[{description:"Populate report",test:()=>!0,action:({workspace:t,output:e})=>{for(const[n,r]of Object.entries(t.blockRecords)){if(!r.perfChapter)continue;let s=n,o=!1;for(;s>0&&!o;)t.blockRecords[s-1].type==="paragraph"||t.blockRecords[s-1].subType==="title"?o=!0:s--;e.report[s.toString()]=r.perfChapter}}}]},S9=function({perf:t}){const e=new Fn.PerfRenderFromJson({srcJson:t,actions:D9}),n={};return e.renderDocument({docId:"",config:{maxLength:60},output:n}),{report:n.report}},E9={name:"calculateUsfmChapterPositions",type:"Transform",description:"PERF=>JSON: Generates positions for inserting chapter numbers into USFM",inputs:[{name:"perf",type:"json",source:""}],outputs:[{name:"report",type:"json"}],code:S9},$t=t=>["toc","toca","mt","imt","s","ms","mte","sd"].includes(t)?t+"1":t,y9=(t,e)=>{let n=`\\${e}-s |`;for(let[r,s]of Object.entries(t))r==="x-morph"?n=n+$t(r)+'="'+s.join(",")+'" ':n=n+$t(r)+'="'+s+'" ';return n+"\\*"},g9=(t,e,n=!1)=>{let r="|";for(let[s,o]of Object.entries(t))r=r+$t(s)+'="'+o+'" ';return r=r+"\\",n&&(r=r+"+"),r+e+"*"},v9={startDocument:[{description:"Set up environment",test:()=>!0,action:({context:t,workspace:e})=>{e.usfmBits=[""],e.nestedWrapper=0;for(let[n,r]of Object.entries(t.document.metadata.document).filter(s=>!["tags","properties","bookCode","cl"].includes(s[0])))e.usfmBits.push(`\\${$t(n)} ${r}
`)}}],blockGraft:[{description:"Follow block grafts",test:({context:t})=>["title","heading","introduction"].includes(t.sequences[0].block.subType),action:t=>{let e=t.context.sequences[0],n=t.config.report[e.block.blockN.toString()];const r=e.block.target;n&&e.type==="main"&&t.workspace.usfmBits.push(`
\\c ${n}
`),r&&t.context.renderer.renderSequenceId(t,r)}}],inlineGraft:[{description:"Follow inline grafts",test:()=>!0,action:t=>{const e=t.context.sequences[0].element.target;e&&t.context.renderer.renderSequenceId(t,e)}}],startParagraph:[{description:"Output footnote paragraph tag (footnote)",test:({context:t})=>t.sequences[0].block.subType==="usfm:f"&&t.sequences[0].type==="footnote"||t.sequences[0].block.subType==="usfm:x"&&t.sequences[0].type==="xref",action:({context:t,workspace:e})=>{e.nestedWrapper=0;let n=t.sequences[0];e.usfmBits.push(`\\${$t(n.block.subType.split(":")[1])} `)}},{description:"Output footnote note_caller tag (footnote)",test:({context:t})=>t.sequences[0].block.subType==="usfm:f"||t.sequences[0].block.subType==="usfm:x",action:({workspace:t})=>{t.nestedWrapper=0}},{description:"Output paragraph tag (main)",test:()=>!0,action:({context:t,workspace:e,config:n})=>{e.nestedWrapper=0;let r=t.sequences[0],s=n.report[r.block.blockN.toString()];s&&r.type==="main"&&e.usfmBits.push(`
\\c ${s}
`),e.usfmBits.push(`
\\${$t(r.block.subType.split(":")[1])}
`)}}],endParagraph:[{description:"Output footnote paragraph tag (footnote)",test:({context:t})=>t.sequences[0].block.subType==="usfm:f"&&t.sequences[0].type==="footnote"||t.sequences[0].block.subType==="usfm:x"&&t.sequences[0].type==="xref",action:({context:t,workspace:e})=>{let n=t.sequences[0];e.usfmBits.push(`\\${$t(n.block.subType.split(":")[1])}*`)}},{description:"Output footnote note_caller tag (footnote)",test:({context:t})=>t.sequences[0].block.subType==="usfm:f"||t.sequences[0].block.subType==="usfm:x",action:()=>{}},{description:"Output nl",test:()=>!0,action:({workspace:t})=>{t.usfmBits.push(`
`)}}],startMilestone:[{description:"Output start milestone",test:()=>!0,action:({context:t,workspace:e})=>{let n=t.sequences[0].element,r=y9(n.atts,$t(n.subType.split(":")[1]));e.usfmBits.push(r)}}],endMilestone:[{description:"Output end milestone",test:()=>!0,action:({context:t,workspace:e})=>{e.usfmBits.push(`\\${$t(t.sequences[0].element.subType.split(":")[1])}-e\\*`)}}],text:[{description:"Output text",test:()=>!0,action:({context:t,workspace:e})=>{const n=t.sequences[0].element.text;e.usfmBits.push(n)}}],mark:[{description:"Output chapter or verses",test:()=>!0,action:({context:t,workspace:e})=>{const n=t.sequences[0].element;n.subType==="verses"&&e.usfmBits.push(`
\\v ${n.atts.number}
`)}}],endSequence:[{description:"Output \\cl",test:({context:t})=>t.document.metadata.document.cl&&t.sequences[0].type==="title",action:({context:t,workspace:e})=>{e.usfmBits.push(`
\\cl ${t.document.metadata.document.cl}
`)}}],startWrapper:[{description:"Output start tag",test:()=>!0,action:({workspace:t,context:e})=>{let n=e.sequences[0];t.nestedWrapper>0?t.usfmBits.push(`\\+${$t(n.element.subType.split(":")[1])} `):t.usfmBits.push(`\\${$t(n.element.subType.split(":")[1])} `),t.nestedWrapper+=1}}],endWrapper:[{description:"Output end tag",test:({context:t})=>!["fr","fq","fqa","fk","fl","fw","fp","ft","xo","xk","xq","xt","xta"].includes(t.sequences[0].element.subType.split(":")[1]),action:({workspace:t,context:e})=>{t.nestedWrapper-=1;let n=e.sequences[0],r=n.element.subType.split(":")[1],s=t.nestedWrapper>0;if(r==="w"){let o=g9(n.element.atts,$t(r),s);t.usfmBits.push(o)}else s?t.usfmBits.push(`\\+${$t(n.element.subType.split(":")[1])}*`):t.usfmBits.push(`\\${$t(n.element.subType.split(":")[1])}*`)}},{description:"Do NOT output end tag",test:()=>!0,action:({workspace:t})=>{t.nestedWrapper-=1}}],endDocument:[{description:"Build output",test:()=>!0,action:({workspace:t,output:e})=>{e.usfm=t.usfmBits.join("").replace(/(\s*)\n(\s*)/gm,`
`)}}]},A9=function({perf:t,report:e}){const n=new Fn.PerfRenderFromJson({srcJson:t,actions:v9}),r={};return n.renderDocument({docId:"",config:{report:e},output:r}),{usfm:r.usfm}},b9={name:"perf2usfm",type:"Transform",description:"PERF=>USFM",inputs:[{name:"perf",type:"json",source:""},{name:"report",type:"json",source:""}],outputs:[{name:"usfm",type:"text"}],code:A9},C9=Qn.filter(t=>t[1]==="wordLike")[0][2],T9=Qn.filter(t=>t[1]==="lineSpace")[0][2],w9=Qn.filter(t=>t[1]==="punctuation")[0][2],F9=t=>{[...t.os].reverse().forEach(e=>{t.block.items.push({type:"scope",subType:"end",payload:e})}),t.os=[]},I9=t=>{[...t.os.filter(e=>["span"].includes(e.split("/")[1]))].reverse().forEach(e=>{t.block.items.push({type:"scope",subType:"end",payload:e}),t.os=[...t.os.filter(n=>n!==e)]})},n1=t=>{[...t.os.filter(e=>["verse","verses"].includes(e.split("/")[0]))].reverse().forEach(e=>{t.block.items.push({type:"scope",subType:"end",payload:e}),t.os=[...t.os.filter(n=>n!==e)]})},k9=t=>{[...t.os.filter(e=>["chapter"].includes(e.split("/")[0]))].reverse().forEach(e=>{t.block.items.push({type:"scope",subType:"end",payload:e}),t.os=[...t.os.filter(n=>n!==e)]})},P9={startDocument:[{description:"Set up word object",test:()=>!0,action:({workspace:t,output:e})=>{e.pkJson={},t.sequenceId=null,t.block=null,t.os=[],t.waitingBlockGrafts=[]}}],startSequence:[{description:"Add sequence array to output",test:()=>!0,action:t=>{t.output.pkJson[t.context.sequences[0].id]=[],t.workspace.sequenceId=t.context.sequences[0].id}}],endSequence:[{description:"Reset sequenceId pointer",test:()=>!0,action:t=>{var e;F9(t.workspace),t.workspace.sequenceId=(e=t.context.sequences[1])==null?void 0:e.id}}],unresolvedBlockGraft:[{description:"Stash for next para",test:()=>!0,action:({context:t,workspace:e})=>{t.sequences[0].block.target&&e.waitingBlockGrafts.push({type:"graft",subType:t.sequences[0].block.subType,payload:t.sequences[0].block.target})}}],unresolvedInlineGraft:[{description:"Follow inline grafts",test:()=>!0,action:({context:t,workspace:e})=>{t.sequences[0].element.target&&e.block.items.push({type:"graft",subType:t.sequences[0].element.subType,payload:t.sequences[0].element.target})}}],startParagraph:[{description:"Add object for paragraph block",test:()=>!0,action:({context:t,workspace:e,output:n})=>{e.block={os:[...e.os],is:[],bs:{type:"scope",subType:"start",payload:`blockTag/${t.sequences[0].block.subType.split(":")[1]}`},bg:[...e.waitingBlockGrafts],items:[]},n.pkJson[e.sequenceId].push(e.block)}}],endParagraph:[{description:"Close open scopes",test:()=>!0,action:({workspace:t})=>{I9(t),t.waitingBlockGrafts=[]}}],mark:[{description:"ts mark as milestone",test:({context:t})=>["usfm:ts"].includes(t.sequences[0].element.subType),action:({workspace:t})=>{const e="milestone/ts";t.block.is.includes(e)||t.block.is.push(e),t.os.push(e),t.block.items.push({type:"scope",subType:"start",payload:e}),t.block.items.push({type:"scope",subType:"end",payload:e})}},{description:"Chapter",test:({context:t})=>["chapter"].includes(t.sequences[0].element.subType),action:({context:t,workspace:e})=>{n1(e),k9(e);const r=`chapter/${t.sequences[0].element.atts.number}`;e.block.is.includes(r)||e.block.is.push(r),e.os.push(r),e.block.items.push({type:"scope",subType:"start",payload:r})}},{description:"Verses",test:({context:t})=>["verses"].includes(t.sequences[0].element.subType),action:({context:t,workspace:e})=>{n1(e);const n=t.sequences[0].element,r=n.atts.number;let s=[parseInt(r)];if(r.includes("-")){let[i,a]=r.split("-").map(u=>parseInt(u));for(s=[i];i<=a;)i++,s.push(i)}for(const i of s){const a=`verse/${i}`;e.os.push(a),e.block.is.includes(a)||e.block.is.push(a),e.block.items.push({type:"scope",subType:"start",payload:a})}const o=`verses/${n.atts.number}`;e.block.is.includes(o)||e.block.is.push(o),e.os.push(o),e.block.items.push({type:"scope",subType:"start",payload:o})}}],startMilestone:[{description:"Add scope and update state",test:()=>!0,action:({context:t,workspace:e})=>{const n=t.sequences[0].element,r=`milestone/${n.subType.split(":")[1]}`;e.block.is.includes(r)||e.block.is.push(r),e.os.push(r),e.block.items.push({type:"scope",subType:"start",payload:r});for(const[s,o]of Object.entries(n.atts||{})){const i=o.toString().split(",");for(const[a,u]of i.entries()){const c=`attribute/milestone/${n.subType.split(":")[1]}/${s}/${a}/${u}`;e.block.is.includes(c)||e.block.is.push(c),e.os.push(c),e.block.items.push({type:"scope",subType:"start",payload:c})}}}}],endMilestone:[{description:"Remove scope and update state",test:()=>!0,action:({context:t,workspace:e})=>{const n=t.sequences[0].element,r=`attribute/milestone/${n.subType.split(":")[1]}`;for(const o of[...e.os.filter(i=>i.startsWith(r))].reverse())e.os=e.os.filter(i=>i!==o),e.block.items.push({type:"scope",subType:"end",payload:o});const s=`milestone/${n.subType.split(":")[1]}`;e.os=e.os.filter(o=>o!==s),e.block.items.push({type:"scope",subType:"end",payload:s})}}],startWrapper:[{description:"Add scope and update state",test:()=>!0,action:({context:t,workspace:e})=>{const n=t.sequences[0].element,r=`${n.subType==="usfm:w"?"spanWithAtts":"span"}/${n.subType.split(":")[1]}`;e.block.is.includes(r)||e.block.is.push(r),e.os.push(r),e.block.items.push({type:"scope",subType:"start",payload:r});for(const[s,o]of Object.entries(n.atts||{})){const i=o.toString().split(",");for(const[a,u]of i.entries()){const c=`attribute/spanWithAtts/w/${s}/${a}/${u}`;e.block.is.includes(c)||e.block.is.push(c),e.os.push(c),e.block.items.push({type:"scope",subType:"start",payload:c})}}}}],endWrapper:[{description:"Remove scope and update state",test:()=>!0,action:({context:t,workspace:e})=>{const n=t.sequences[0].element;for(const[s,o]of[...Object.entries(n.atts||{})].reverse()){const i=o.toString().split(",");for(const[a,u]of[...i.entries()].reverse()){const c=`attribute/spanWithAtts/w/${s}/${a}/${u}`;e.os=e.os.filter(l=>l!==c),e.block.items.push({type:"scope",subType:"end",payload:c})}}const r=`${n.subType==="usfm:w"?"spanWithAtts":"span"}/${n.subType.split(":")[1]}`;e.os=e.os.filter(s=>s!==r),e.block.items.push({type:"scope",subType:"end",payload:r})}}],text:[{description:"Log occurrences",test:()=>!0,action:({context:t,workspace:e})=>{const n=t.sequences[0].element.text,r=B.union(Qn.map(o=>o[2])),s=B.match(n,r,"all");for(const o of s){let i;B.test(o,C9)?i="wordLike":B.test(o,T9)?i="lineSpace":B.test(o,w9)&&(i="punctuation"),e.block.items.push({type:"token",subType:i,payload:o})}}}],endDocument:[{description:"Rework hanging end cv scopes",test:()=>!0,action:({output:t})=>{const e=Object.values(t.pkJson)[0];for(let n=1;n<e.length;n++){let r=e[n].items;const s=e[n-1].items;let o=0;for(;o<r.length;){const i=r[o];if(i.type!=="scope"||i.subType!=="end")break;o++}for(;o>0;){const i=r.shift();s.push(i),e[n].os=e[n].os.filter(a=>a!==i.payload),o--}}}}]},N9=function({perf:t}){const e=new Fn.PerfRenderFromJson({srcJson:t,ignoreMissingSequences:!0,actions:P9}),n={};return e.renderDocument({docId:"",config:{},output:n}),{pkJson:n.pkJson}},_9={name:"perf2PkJson",type:"Transform",description:"PERF=>JSON: Converts PERF to current Proskomma input format",documentation:"",inputs:[{name:"perf",type:"json",source:""}],outputs:[{name:"pkJson",type:"json"}],code:N9},bf={calculateUsfmChapterPositions:E9,perf2usfm:b9,perf2PkJson:_9},r1=Q.ByteArray,{itemEnum:Ji}=Q.itemDefs,{tokenEnum:O9}=Q.tokenDefs,$9=0,Gr=2,zo=3,mo=t=>{const e=t.sequences[t.mainId],n=t.processor.docSets[t.docSetId];n.buildPreEnums(),n.buildEnumIndexes();const r={},s={};let o="0",i="0",a="1",u=0;if(e.chapterVerses={},n.enums.wordLike.length===0)throw new Error("No wordLike content in docSet - probably a USFM issue, maybe missing \\mt?");e.tokensPresent=new Jp(new Array(n.enums.wordLike.length).fill(0).map(c=>c.toString()).join(""));for(const[c,l]of e.blocks.entries()){let p=0,d=l.c,f=-1;for(;p<d.length;){f++;const[S,b,F]=Q.succinct.headerBytes(d,p);if(b===Ji.startScope){let y=n.succinctScopeLabel(d,F,p);y.startsWith("chapter/")?(o=y.split("/")[1],r[o]={},s[o]={startBlock:c,startItem:f,nextToken:u}):y.startsWith("verse/")?(i=y.split("/")[1],i==="1"&&!("0"in r[o])&&s[o].nextToken<u&&(r[o][0]=[{startBlock:s[o].startBlock,startItem:s[o].startItem,endBlock:c,endItem:Math.max(f-1,0),nextToken:s[o].nextToken,verses:"0"}]),i in r[o]||(r[o][i]=[]),r[o][i].push({startBlock:c,startItem:f,nextToken:u})):y.startsWith("verses/")&&(a=y.split("/")[1])}else if(b===Ji.endScope){let y=n.succinctScopeLabel(d,F,p);if(y.startsWith("chapter/")){o=y.split("/")[1];let T=s[o];T&&(T.endBlock=c,T.endItem=f)}else if(y.startsWith("verse/")&&(i=y.split("/")[1],r[o][i])){const O=r[o][i][r[o][i].length-1];O.endBlock=c,O.endItem=f,O.verses=a}}else b===Ji.token&&F===O9.wordLike&&(e.tokensPresent.set(d.nByte(p+2),1),u++);p+=S}}for(const[c,l]of Object.entries(r)){const p=new r1;e.chapterVerses[c]=p;const d=Object.keys(l).map(F=>parseInt(F)).sort((F,y)=>F-y);if(d.length===0)continue;const f=d[d.length-1],S=Array.from(Array(f+1).keys());let b=0;for(const F of S){const y=`${F}`;if(y in l){const T=l[y],O=T.length;for(const[j,M]of T.entries()){if(!M.verses){console.log(`** VerseElement without verses for ${F} in buildChapterVerseIndex`);continue}const ee=n.enumForCategoryValue("scopeBits",M.verses),ne=M.startBlock===M.endBlock?Gr:zo;p.pushByte(0),ne===Gr?p.pushNBytes([M.startBlock,M.startItem,M.endItem,M.nextToken,ee]):p.pushNBytes([M.startBlock,M.endBlock,M.startItem,M.endItem,M.nextToken,ee]),p.setByte(b,Hi(ne,j===O-1,p.length-b)),b=p.length}}else p.pushByte(Hi($9,!0,1)),b++}p.trim()}e.chapters={};for(const[c,l]of Object.entries(s)){if(!("startBlock"in l)||!("endBlock"in l))continue;const p=new r1;e.chapters[c]=p;const d=l.startBlock===l.endBlock?Gr:zo;p.pushByte(0),d===Gr?p.pushNBytes([l.startBlock,l.startItem,l.endItem,l.nextToken]):p.pushNBytes([l.startBlock,l.endBlock,l.startItem,l.endItem,l.nextToken]),p.setByte(0,Hi(d,!0,p.length)),p.trim()}},s1=(t,e)=>{const n=t.processor.docSets[t.docSetId];n.buildEnumIndexes();const r=[],s=t.sequences[t.mainId].chapterVerses[e];if(s){let o=0,i=[];for(;o<s.length;){const[a,u,c]=Cf(s,o);if(a===Gr){const l=s.nBytes(o+1,5);i.push({startBlock:l[0],endBlock:l[0],startItem:l[1],endItem:l[2],nextToken:l[3],verses:n.enums.scopeBits.countedString(n.enumIndexes.scopeBits[l[4]])})}else if(a===zo){const l=s.nBytes(o+1,6);i.push({startBlock:l[0],endBlock:l[1],startItem:l[2],endItem:l[3],nextToken:l[4],verses:n.enums.scopeBits.countedString(n.enumIndexes.scopeBits[l[5]])})}u&&(r.push(i),i=[]),o+=c}}return r},o1=(t,e)=>{const n=t.sequences[t.mainId].chapters[e];if(n){const r=Cf(n,0)[0];if(r===Gr){const s=n.nBytes(1,4);return{startBlock:s[0],endBlock:s[0],startItem:s[1],endItem:s[2],nextToken:s[3]}}else if(r===zo){const s=n.nBytes(1,5);return{startBlock:s[0],endBlock:s[1],startItem:s[2],endItem:s[3],nextToken:s[4]}}}},Hi=(t,e,n)=>n+(e?32:0)+t*64,Cf=(t,e)=>{const n=t.byte(e);return[n>>6,(n>>5)%2===1,n%32]},B9=t=>{const e=new Set,n=t.processor.docSets[t.docSetId];n.maybeBuildEnumIndexes();const r=(o,i,a)=>{a.add(i.id);for(const u of i.blocks){for(const c of n.unsuccinctifyGrafts(u.bg))a.has(c[2])||r(o,o.sequences[c[2]],a);for(const c of n.unsuccinctifyItems(u.c,{grafts:!0},0))a.has(c[2])||r(o,o.sequences[c[2]],a)}};r(t,t.sequences[t.mainId],e);let s=!1;for(const o of Object.keys(t.sequences))e.has(o)||(delete t.sequences[o],s=!0);return s},R9=(t,e,n)=>{const r=Q.generateId();return t.sequences[r]={id:r,type:e,tags:new Set(n||[]),isBaseType:e in t.baseSequenceTypes,blocks:[]},r},x9=(t,e)=>{if(!(e in t.sequences))return!1;if(t.sequences[e].type==="main")throw new Error("Cannot delete main sequence");return t.sequences[e].type in t.baseSequenceTypes?i1(t,"block",e):i1(t,"inline",e),delete t.sequences[e],t.buildChapterVerseIndex(globalThis),t.gcSequences(),!0},i1=(t,e,n)=>{const r=t.processor.docSets[t.docSetId];for(const s of Object.values(t.sequences))for(const o of s.blocks){const i=e==="block"?o.bg:o.c;let a=0;for(;a<i.length;){const[u,c]=Q.succinct.headerBytes(i,a);c!==Q.itemDefs.itemEnum.graft?a+=u:Q.succinct.succinctGraftSeqId(r.enums,r.enumIndexes,i,a)===n?i.deleteItem(a):a+=u}}},q9=(t,e,n,r,s,o,i)=>{t.processor.docSets[t.docSetId].maybeBuildEnumIndexes(),n=n||(l=>l);const u=t.sequences[e],c=n({id:e,type:u.type,tags:u.tags,isBaseType:u.isBaseType,verseMapping:u.verseMapping});return M9(u,c,r,s,o,i),t.sequences[e]=c,c.type==="main"&&t.buildChapterVerseIndex(),c},M9=(t,e,n,r,s,o)=>{n=n||((i,a,u)=>!!u),r=r||((i,a,u,c,l,p,d)=>!!u||d),s=s||((i,a,u)=>u),o=o||((i,a,u,c,l,p,d,f,S)=>{for(let b=0;b<p;b++)c.c.pushByte(u.c.byte(S+b))}),e.blocks=[];for(const[i,a]of t.blocks.entries())if(n(t,i,a)){const u=s(t,i,F7(a));u.c.clear(),L9(t,i,a,u,r,o),e.blocks.push(u)}},L9=(t,e,n,r,s,o)=>{let i=0,a=-1;for(;i<n.c.length;){a++;const[u,c,l]=Q.succinct.headerBytes(n.c,i);s(t,e,n,a,c,l,i)&&o(t,e,n,r,a,u,c,l,i),i+=u}},or=Q.ByteArray,{pushSuccinctGraftBytes:j9,pushSuccinctScopeBytes:Tf,pushSuccinctTokenBytes:a1}=Q.succinct,{itemEnum:Pa}=Q.itemDefs,{scopeEnum:G9,scopeEnumLabels:U9,nComponentsForScope:wf}=Q.scopeDefs,{tokenCategory:YF,tokenEnum:V9}=Q.tokenDefs,{headerBytes:J9}=Q.succinct,H9=(t,e,n,r)=>{if(r!==!1&&(r=!0),!(e in t.sequences))return!1;const s=t.sequences[e];return n<0||n>=s.blocks.length?!1:(s.blocks.splice(n,1),r&&t.buildChapterVerseIndex(globalThis),!0)},W9=(t,e,n,r,s,o)=>{if(o!==!1&&(o=!0),!(e in t.sequences))return!1;const i=t.sequences[e];if(n<0||n>i.blocks.length)return!1;const a=t.processor.docSets[t.docSetId];a.maybeBuildPreEnums();const u={bs:new or(0),bg:new or(0),c:new or(0),os:new or(0),is:new or(0),nt:new or(0)},c=r.split("/"),l=G9[c[0]],p=wf(c[0]);if(c.length!==p)throw new Error(`Scope ${r} has ${c.length} component(s) (expected ${p}`);const d=c.slice(1).map(f=>a.enumForCategoryValue("scopeBits",f,!0));return Tf(u.bs,Pa.startScope,l,d),u.bs.trim(),s&&id(a,t.id,e,n,s),i.blocks.splice(n,0,u),o&&t.buildChapterVerseIndex(),!0},K9=(t,e)=>{for(const n of["bs","bg","c","is","os"]){const r=t[n],s=new or(r.length);let o=0;for(;o<r.length;){const[i,a,u]=J9(r,o);if(a===Pa.token)u===V9.wordLike?a1(s,u,e.wordLike[r.nByte(o+2)]):a1(s,u,e.notWordLike[r.nByte(o+2)]);else if(a===Pa.graft)j9(s,e.graftTypes[u],e.ids[r.nByte(o+2)]);else{let c=wf(U9[u]);const l=[];let p=2;for(;c>1;){const d=e.scopeBits[r.nByte(o+p)];l.push(d),p+=r.nByteLength(d),c--}Tf(s,a,u,l)}o+=i}s.trim(),t[n]=s}},X9=Q.ByteArray,{itemEnum:Wi}=Q.itemDefs,z9=(t,e)=>{if(!e||Object.keys(e).length===0)return;const n=t.processor.docSets[t.docSetId],r=(o,i,a,u,c,l,p)=>{if(c===Wi.token)return!0;if(c===Wi.startScope||c===Wi.endScope){if(!e.includeScopes&&!e.excludeScopes)return!0;{const d=n.unsuccinctifyScope(a.c,c,l,p);return(!e.includeScopes||e.includeScopes.filter(f=>d[2].startsWith(f)).length>0)&&(!e.excludeScopes||e.excludeScopes.filter(f=>d[2].startsWith(f)).length===0)}}else{if(!e.includeGrafts&&!e.excludeGrafts)return!0;const d=n.unsuccinctifyGraft(a.c,l,p);return(!e.includeGrafts||e.includeGrafts.filter(f=>d[1].startsWith(f)).length>0)&&(!e.excludeGrafts||e.excludeGrafts.filter(f=>d[1].startsWith(f)).length===0)}},s=(o,i,a)=>{const u=new X9(a.bg.length);let c=0;for(;c<a.bg.length;){const[l,p,d]=Q.succinct.headerBytes(a.bg,c),f=n.unsuccinctifyGraft(a.bg,d,c);if((!e.includeGrafts||e.includeGrafts.filter(S=>f[1].startsWith(S)).length>0)&&(!e.excludeGrafts||e.excludeGrafts.filter(S=>f[1].startsWith(S)).length===0))for(let S=0;S<l;S++)u.pushByte(a.bg.byte(c+S));c+=l}return u.trim(),a.bg=u,a};Object.keys(t.sequences).forEach(o=>{t.modifySequence(o,null,null,r,s,null)}),Object.values(t.sequences).forEach(o=>n.updateBlockIndexesAfterFilter(o)),t.gcSequences()},Y9=t=>{const e={sequences:{}};e.headers=t.headers,e.mainId=t.mainId,e.tags=Array.from(t.tags);for(const[n,r]of Object.entries(t.sequences))e.sequences[n]=Z9(r);return e},Z9=t=>{const e={type:t.type,blocks:t.blocks.map(n=>Q9(n)),tags:Array.from(t.tags)};if(t.type==="main"){e.chapters={};for(const[n,r]of Object.entries(t.chapters||{}))r.trim(),e.chapters[n]=r.base64();e.chapterVerses={};for(const[n,r]of Object.entries(t.chapterVerses||{}))r.trim(),e.chapterVerses[n]=r.base64();"tokensPresent"in t&&(e.tokensPresent="0x"+t.tokensPresent.toString(16))}return e},Q9=t=>{for(const e of["bs","bg","c","is","os","nt"])t[e].trim();return{bs:t.bs.base64(),bg:t.bg.base64(),c:t.c.base64(),is:t.is.base64(),os:t.os.base64(),nt:t.nt.base64()}},eT=(t,e)=>{t.recordPreEnum("scopeBits","0");for(const[n,r]of e.blocks.entries())for(const[s,o]of[...r.items,r.bs,...r.bg].entries())if(o.subType==="wordLike")t.recordPreEnum("wordLike",o.payload);else if(["lineSpace","eol","punctuation","softLineBreak","bareSlash","unknown"].includes(o.subType))t.recordPreEnum("notWordLike",o.payload);else if(o.type==="graft")t.recordPreEnum("graftTypes",o.subType);else if(o.subType==="start"){const i=o.payload.split("/");if(i.length!==Q.scopeDefs.nComponentsForScope(i[0]))throw new Error(`Scope ${o.payload} has unexpected number of components`);for(const a of i.slice(1))t.recordPreEnum("scopeBits",a)}},tT=(t,e)=>{t.recordPreEnum("scopeBits","0"),t.recordPreEnum("ids",e.id);for(const n of e.blocks)for(const r of["bs","bg","c","is","os"])nT(t,n[r])},nT=(t,e)=>{for(const n of t.unsuccinctifyItems(e,{},0))if(n[0]==="token")n[1]==="wordLike"?t.recordPreEnum("wordLike",n[2]):t.recordPreEnum("notWordLike",n[2]);else if(n[0]==="graft")t.recordPreEnum("graftTypes",n[1]);else if(n[0]==="scope"&&n[1]==="start"){const r=n[2].split("/");if(r.length!==Q.scopeDefs.nComponentsForScope(r[0]))throw new Error(`Scope ${n[2]} has unexpected number of components`);for(const s of r.slice(1))t.recordPreEnum("scopeBits",s)}},{addTag:rT,removeTag:sT,validateTags:oT}=Q.tags,iT=Q.parserConstants;class u1{constructor(e,n,r,s,o,i,a,u){if(this.processor=e,this.docSetId=n,this.baseSequenceTypes=iT.usfm.baseSequenceTypes,r)switch(this.id=Q.generateId(),this.filterOptions=o,this.customTags=i,this.emptyBlocks=a,this.tags=new Set(u||[]),oT(this.tags),this.headers={},this.mainId=null,this.sequences={},r.toLowerCase()){case"usfm":case"sfm":this.processUsfm(s);break;case"usx":this.processUsx(s);break;case"tsv":this.processTSV(s);break;case"nodes":this.processNodes(s);break;default:throw new Error(`Unknown document contentType '${r}'`)}}addTag(e){rT(this.tags,e)}removeTag(e){sT(this.tags,e)}makeParser(){return new f9(this.filterOptions,this.customTags,this.emptyBlocks)}processUsfm(e){const n=this.makeParser();GC(e,n),this.postParseScripture(n)}processUsx(e){const n=this.makeParser();YC(e,n),this.postParseScripture(n)}processTSV(e){const n=this.makeParser(),r=`T${this.processor.nextTable>9?this.processor.nextTable:"0"+this.processor.nextTable}`;this.processor.nextTable++,u9(e,n,r),this.headers=n.headers,this.succinctPass1(n),this.succinctPass2(n),mo(this);const s=Object.values(this.sequences).filter(o=>o.type==="table")[0];for(const[o,i]of JSON.parse(e).headings.entries())s.tags.add(`col${o}:${i}`)}processNodes(e){const n=this.makeParser(),r=`N${this.processor.nextNodes>9?this.processor.nextNodes:"0"+this.processor.nextNodes}`;this.processor.nextNodes++,c9(e,n,r),this.headers=n.headers,this.succinctPass1(n),this.succinctPass2(n),mo(this)}postParseScripture(e){e.tidy();const n=e.filterOptions;this.headers=e.headers,this.succinctPass1(e),this.succinctPass2(e),this.succinctFilter(n),mo(this)}succinctFilter(e){z9(this,e)}succinctPass1(e){const n=this.processor.docSets[this.docSetId];for(const r of e.allSequences())n.recordPreEnum("ids",r.id),this.recordPreEnums(n,r);n.enums.wordLike.length===0&&n.sortPreEnums(),n.buildEnums()}recordPreEnums(e,n){eT(e,n)}rerecordPreEnums(e,n){tT(e,n)}succinctPass2(e){const n=this.processor.docSets[this.docSetId];this.mainId=e.sequences.main.id;for(const r of e.allSequences())this.sequences[r.id]={id:r.id,type:r.type,tags:new Set(r.tags),isBaseType:r.type in e.baseSequenceTypes,blocks:r.succinctifyBlocks(n)};this.sequences[this.mainId].verseMapping={}}modifySequence(e,n,r,s,o,i){q9(this,e,n,r,s,o,i)}buildChapterVerseIndex(){mo(this)}chapterVerseIndexes(){const e={};for(const n of Object.keys(this.sequences[this.mainId].chapterVerses))e[n]=s1(this,n);return e}chapterVerseIndex(e){return s1(this,e)}chapterIndexes(){const e={};for(const n of Object.keys(this.sequences[this.mainId].chapters))e[n]=o1(this,n);return e}chapterIndex(e){return o1(this,e)}rewriteSequenceBlocks(e,n){const r=this.sequences[e];for(const s of r.blocks)this.rewriteSequenceBlock(s,n)}rewriteSequenceBlock(e,n){K9(e,n)}serializeSuccinct(){return Y9(this)}gcSequences(){return B9(this)}newSequence(e,n){return R9(this,e,n)}deleteSequence(e){return x9(this,e)}deleteBlock(e,n,r){return H9(this,e,n,r)}newBlock(e,n,r,s,o){return W9(this,e,n,r,s,o)}perf(e){const n=new Fn.PerfRenderFromProskomma({proskomma:this.processor,actions:Fn.render.perfToPerf.renderActions.identityActions}),r={};return n.renderDocument({docId:this.id,config:{},output:r}),e?JSON.stringify(r.perf,null,e):JSON.stringify(r.perf)}async usfm(){const e=JSON.parse(this.perf());try{return(await new Fn.PipelineHandler({pipelines:Af,transforms:bf,proskomma:this.processor}).runPipeline("perf2usfmPipeline",{perf:e})).usfm}catch(n){console.error(`pipelineHandler Error :
`,n)}}sofria(e,n){const r=new Fn.SofriaRenderFromProskomma({proskomma:this.processor,actions:Fn.render.sofriaToSofria.renderActions.identityActions}),s={},o={};n&&(o.chapters=[`${n}`]);try{r.renderDocument({docId:this.id,config:o,output:s})}catch(i){throw console.log(i),i}return e?JSON.stringify(s.sofria,null,e):JSON.stringify(s.sofria)}}const aT=`
"""Key/Value tuple"""
type KeyValue {
    """The key"""
    key: String!
    """The value"""
    value: String!
}`,uT={key:t=>t[0],value:t=>t[1]},cT=`
"""Key/Count tuple"""
type KeyCount {
    """The key"""
    key: String!
    """The number of occurrences"""
    count: Int!
}`,lT={key:t=>t[0],count:t=>t[1]},pT=`
"""Key/Count/Category tuple"""
type KeyCountCategory {
    """The key"""
    key: String!
    """The number of occurrences"""
    count: Int!
    """The category"""
    category: String!
}`,dT={key:t=>t[0],count:t=>t[1],category:t=>t[2]},fT=`
"""A chapter-verse reference"""
type cv {
  """The chapter number"""
  chapter: Int
  """The verse number"""
  verse: Int
}
`,hT={chapter:t=>t[0],verse:t=>t[1]},mT=`
"""Type-dependent parts of the ID header"""
type idParts {
  """The type of the ID"""
  type: String
  """An array of parts of the ID"""
  parts: [String]
  """A part of the ID, by index"""
  part(
    """The numeric index of the part"""
    index: Int!
  ): String
}
`,DT={type:t=>t[0],parts:t=>t[1],part:(t,e)=>!t[1]||e.index<0||e.index>=t[1].length?null:t[1][e.index]},ST=`
"""Attribute Specification"""
input AttSpec {
"""The type of attribute, ie what type of thing it's connected to"""
attType: String!
"""The name of the USFM tag to which the attribute is connected"""
tagName: String!
"""The attribute key (ie the bit to the left of the equals sign in USX)"""
attKey: String!
"""The position of the value (which is 0 except for attributes with multiple values)"""
valueN: Int!
}`,ET=`
"""Key/Regex tuple"""
input KeyMatches {
  """The key"""
  key: String!
  """The regex to match"""
  matches: String!
}
`,yT=`
"""Input Key/Value Object"""
input InputKeyValue {
    """The key"""
    key: String!
    """The value"""
    value: String!
}
`,gT=`
"""Input Key/Values Object"""
input KeyValues {
    """The key"""
    key: String!
    """The values"""
    values: [String!]!
}
`,vT=`
"""Item for arguments"""
input InputItemObject {
    """The basic item type (token, scope or graft)'"""
    type: String!
    """The type-dependent subtype of the item"""
    subType: String!
    """The content of the item (the text for tokens, the label for scopes and the sequence id for grafts)"""
    payload: String!
}`,AT=(t,e)=>{if(t.length===0)return!0;for(const n of t)if(e.startsWith(n))return!0;return!1},bT=`
"""Item"""
type Item {
  """The basic item type (token, scope or graft)"""
  type: String!
  """The type-dependent subtype of the item"""
  subType: String!
  """The content of the item (the text for tokens, the label for scopes and the sequence id for grafts)"""
  payload(
    """If true, turn all whitespace into a normal space"""
    normalizeSpace: Boolean
    """A whitelist of characters to include"""
    includeChars: [String!]
    """A blacklist of characters to exclude"""
    excludeChars: [String!],
  ): String!
  """If 'includeContext' was selected, and for tokens, the index of the token from the start of the sequence"""
  position(
    """Only include scopes that begin with this value"""
    startsWith: [String!]
  ): Int
  """If 'includeContext' was selected, a list of scopes that are open around the item"""
  scopes(
    """Only include scopes that begin with this value"""
    startsWith: [String!]
  ): [String!]
}
`,CT={type:t=>t[0],subType:t=>t[1],payload:(t,e)=>{let n=t[2];if(t[0]==="token"&&(e.normalizeSpace&&(n=t[2].replace(/[ \t\n\r]+/g," ")),e.includeChars||e.excludeChars)){let r=n.split("");r=r.filter(s=>!e.includeChars||e.includeChars.includes(s)),r=r.filter(s=>!e.excludeChars||!e.excludeChars.includes(s)),n=r.join("")}return n},position:t=>t[3],scopes:(t,e)=>t[4]?t[4].filter(n=>!e.startsWith||AT(e.startsWith,n)):[]},TT=t=>{let e;switch(t[0]){case"token":return`|${t[2]}`;case"scope":return e=t[1]==="start"?"+":"-",`${e}${t[2]}${e}`;case"graft":return`>${t[1]}<`}},Di=t=>t.map(e=>TT(e)).join(""),wT=t=>{const e=["ItemGroup:"];return e.push(`   Open Scopes ${t[0].join(", ")}`),e.push(`   ${Di(t[1])}`),e.join(`
`)},FT=t=>{const e=["Block:"];return t.bg.length>0&&t.bg.forEach(n=>e.push(`   ${n[1]} graft to ${n[2]}`)),e.push(`   Scope ${t.bs[2]}`),e.push(`   ${Di(t.c)}`),e.join(`
`)},IT=(t,e)=>{if(t.length===0)return!0;for(const n of t)if(e.startsWith(n))return!0;return!1},kT=`
"""A collection of items, with scope context"""
type ItemGroup {
  """Items for this itemGroup"""
  items: [Item!]!
  """Tokens for this itemGroup"""
  tokens(
    """Return tokens whose payload is an exact match to one of the specified strings"""
    withChars: [String!]
    """Return tokens with one of the specified subTypes"""
    withSubTypes: [String!]
  ): [Item!]!
  """The text of the itemGroup as a single string"""
  text(
    """If true, converts each whitespace character to a single space"""
    normalizeSpace: Boolean
  ): String!
  """The labels of scopes that were open at the beginning of the itemGroup"""
  scopeLabels(
    """Only include scopes that begin with this value"""
    startsWith: [String!]
  ): [String!]!
  """The itemGroup content as a string in a compact eyeballable format"""
  dump: String!
  """A list of scopes from the items of the itemGroup"""
  includedScopes: [String!]!
} 
`,PT={items:t=>t[1],tokens:(t,e)=>t[1].filter(n=>n[0]==="token"&&(!e.withChars||e.withChars.includes(n[2]))&&(!e.withSubTypes||e.withSubTypes.includes(n[1]))),text:(t,e)=>{const n=t[1].filter(r=>r[0]==="token").map(r=>r[2]).join("");return e.normalizeSpace?n.replace(/[ \t\n\r]+/g," "):n},scopeLabels:(t,e)=>t[0].filter(n=>!e.startsWith||IT(e.startsWith,n)),dump:t=>wT(t),includedScopes:t=>Array.from(new Set(t[1].filter(e=>e[0]==="scope"&&e[1]==="start").map(e=>e[2])))},NT=`
"""Key/Items tuple"""
type kvEntry {
    """The key"""
    key: String!
    """The secondary keys"""
    secondaryKeys: [KeyValue!]
    """The fields as itemGroups"""
    itemGroups: [ItemGroup]!
}`,_T={key:t=>t[0],secondaryKeys:t=>t[1],itemGroups:t=>t[2]},OT=`
"""Information about a regex match on an enum"""
type regexIndex {
    """The index in the enum"""
    index: String!
    """The string in the enum that matched"""
    matched: String!
}`,$T={index:t=>t[0],matched:t=>t[1]},BT=`
"""Row Equals Specification"""
input rowEqualsSpec {
  """The position of the column in which to search a match"""
  colN: Int!
  """The values to match"""
  values: [String!]!
}
`,RT=`
"""Row Match Specification"""
input rowMatchSpec {
  """The position of the column in which to search a match"""
  colN: Int!
  """The regex to match"""
  matching: String!
}
`,xT=`
"""Information about a verse range (which may only cover one verse)"""
type verseRange {
  """The range, as it would be printed in a Bible"""
  range: String!
  """A list of verse numbers for this range"""
  numbers: [Int!]!
}
`,qT=`
"""Mapped verse information"""
type orig {
  """The book code"""
  book: String
  """A list of chapter-verse references"""
  cvs: [cv!]!
}
`,MT=`
"""Information about a verse number (which may be part of a verse range)"""
type verseNumber {
  """The verse number"""
  number: Int!
  """The verse range to which the verse number belongs"""
  range: String!
  """The reference for this verse when mapped to 'original' versification"""
  orig: orig!
}
`,LT={orig:(t,e,n)=>{const r=n.doc.headers.bookCode,s=n.cvIndex[0],o=t.number,i=n.doc.sequences[n.doc.mainId];if(i.verseMapping&&"forward"in i.verseMapping&&`${s}`in i.verseMapping.forward){const a=Q.versification.mapVerse(i.verseMapping.forward[`${s}`],r,s,o);return{book:a[0],cvs:a[1]}}else return{book:r,cvs:[[s,o]]}}},jT=`
"""A table cell"""
type cell {
  """The row numbers"""
  rows: [Int!]!
  """The column numbers"""
  columns: [Int!]!
  """A list of items from the c (content) field of the cell"""
  items: [Item!]!
  """A list of tokens from the c (content) field of the cell"""
  tokens: [Item!]!
  """The text of the cell as a single string"""
  text(
    """If true, converts each whitespace character to a single space"""
    normalizeSpace: Boolean
  ): String!
}
`,GT={rows:t=>t[0],columns:t=>t[1],items:t=>t[2],tokens:t=>t[2].filter(e=>e[0]==="token"),text:(t,e)=>{let n=t[2].filter(r=>r[0]==="token").map(r=>r[2]).join("").trim();return e.normalizeSpace&&(n=n.replace(/[ \t\n\r]+/g," ")),n}},UT=`
"""A chapter index entry"""
type cIndex {
  """The chapter number"""
  chapter: Int!
  """The zero-indexed number of the block where the chapter starts"""
  startBlock: Int
  """The zero-indexed number of the block where the chapter ends"""
  endBlock: Int
  """The zero-indexed position of the item where the chapter starts"""
  startItem: Int
  """The zero-indexed position of the item where the chapter ends"""
  endItem: Int
  """The value of nextToken at the beginning of the chapter"""
  nextToken: Int
  """A list of items for this chapter"""
  items(
    """If true, adds scope and nextToken information to each token"""
    includeContext: Boolean
  ): [Item]!
  """The items as a string in a compact eyeballable format"""
  dumpItems: String
  """A list of tokens for this chapter"""
  tokens(
    """If true, adds scope and nextToken information to each token"""
    includeContext: Boolean
    """Return tokens whose payload is an exact match to one of the specified strings"""
    withChars: [String!]
    """Return tokens with one of the specified subTypes"""
    withSubTypes: [String!]
  ): [Item]!
  """The text of the chapter as a single string"""
  text(
    """If true, converts each whitespace character to a single space"""
    normalizeSpace: Boolean
  ): String!
}
`,VT={chapter:t=>t[0],startBlock:t=>t[1].startBlock,endBlock:t=>t[1].endBlock,startItem:t=>t[1].startItem,endItem:t=>t[1].endItem,nextToken:t=>t[1].nextToken,items:(t,e,n)=>n.docSet.itemsByIndex(n.doc.sequences[n.doc.mainId],t[1],e.includeContext).reduce((r,s)=>r.concat([["token","lineSpace"," "]].concat(s)),[]),dumpItems:(t,e,n)=>{const r=n.docSet.itemsByIndex(n.doc.sequences[n.doc.mainId],t[1],!1);return r.length>0?Di(r.reduce((s,o)=>s.concat([["token","lineSpace"," ",null]].concat(o)))):""},tokens:(t,e,n)=>n.docSet.itemsByIndex(n.doc.sequences[n.doc.mainId],t[1],e.includeContext).reduce((r,s)=>r.concat([["token","lineSpace"," "]].concat(s)),[]).filter(r=>r[0]==="token"&&(!e.withChars||e.withChars.includes(r[2]))&&(!e.withSubTypes||e.withSubTypes.includes(r[1]))),text:(t,e,n)=>{let r=n.docSet.itemsByIndex(n.doc.sequences[n.doc.mainId],t[1]).reduce((s,o)=>s.concat([["token","lineSpace"," "]].concat(o)),[]).filter(s=>s[0]==="token").map(s=>s[1]==="lineSpace"?" ":s[2]).join("").trim();return e.normalizeSpace&&(r=r.replace(/[ \t\n\r]+/g," ")),r}},JT=`
""""""
type cvVerseElement {
  """The zero-indexed number of the block where the verse starts"""
  startBlock: Int
  """The zero-indexed number of the block where the verse ends"""
  endBlock: Int
  """The zero-indexed position of the item where the verse starts"""
  startItem: Int
  """The zero-indexed position of the item where the verse ends"""
  endItem: Int
  """The value of nextToken at the beginning of the verse"""
  nextToken: Int
  """The verse range for this verse as it would be printed in a Bible"""
  verseRange: String
  """A list of items for this verse"""
  items(
    """If true, adds scope and nextToken information to each token"""
    includeContext: Boolean
  ): [Item]!
  """The items as a string in a compact eyeballable format"""
  dumpItems: String
  """A list of tokens for this verse"""
  tokens(
    """If true, adds scope and nextToken information to each token"""
    includeContext: Boolean
    """Return tokens whose payload is an exact match to one of the specified strings"""
    withChars: [String!]
    """Return tokens with one of the specified subTypes"""
    withSubTypes: [String!]
  ): [Item]!
  """The text of the verse as a single string"""
  text(
    """If true, converts each whitespace character to a single space"""
    normalizeSpace: Boolean
  ): String!
}
`,HT={startBlock:t=>t.startBlock,endBlock:t=>t.endBlock,startItem:t=>t.startItem,endItem:t=>t.endItem,nextToken:t=>t.nextToken,verseRange:t=>t.verses,items:(t,e,n)=>n.docSet.itemsByIndex(n.doc.sequences[n.doc.mainId],t,e.includeContext).reduce((r,s)=>r.concat([["token","lineSpace"," ",null]].concat(s))),dumpItems:(t,e,n)=>Di(n.docSet.itemsByIndex(n.doc.sequences[n.doc.mainId],t,e.includeContext).reduce((r,s)=>r.concat([["token","lineSpace"," ",null]].concat(s)))),tokens:(t,e,n)=>n.docSet.itemsByIndex(n.doc.sequences[n.doc.mainId],t,e.includeContext).reduce((r,s)=>r.concat([["token","lineSpace"," ",null]].concat(s))).filter(r=>r[0]==="token"&&(!e.withChars||e.withChars.includes(r[2]))&&(!e.withSubTypes||e.withSubTypes.includes(r[1]))),text:(t,e,n)=>{let r=n.docSet.itemsByIndex(n.doc.sequences[n.doc.mainId],t).reduce((s,o)=>s.concat([["token","lineSpace"," ",null]].concat(o))).filter(s=>s[0]==="token").map(s=>s[1]==="lineSpace"?" ":s[2]).join("").trim();return e.normalizeSpace&&(r=r.replace(/[ \t\n\r]+/g," ")),r}},WT=`
"""Information about a verse in the chapter, which may be split into several pieces"""
type cvVerses {
  """The pieces of verse"""
  verse: [cvVerseElement]
}
`,KT={verse:t=>t},XT=`
"""A chapterVerse index entry"""
type cvIndex {
  """The chapter number"""
  chapter: Int!
  """Information about the verses in the chapter"""
  verses: [cvVerses]
  """A list of verse number and range information, organized by verse number"""
  verseNumbers: [verseNumber!]
  """A list of verse number and range information, organized by verse range"""
  verseRanges: [verseRange!]
}
`,zT={chapter:t=>t[0],verses:t=>t[1],verseNumbers:(t,e,n)=>(n.cvIndex=t,[...t[1].entries()].filter(r=>r[1].length>0).map(r=>({number:r[0],range:r[1][r[1].length-1].verses}))),verseRanges:t=>{const e=[];for(const[n,r]of[...t[1].entries()].filter(s=>s[1].length>0))e.length===0||e[e.length-1].range!==r[r.length-1].verses?e.push({range:r[r.length-1].verses,numbers:[n]}):e[e.length-1].numbers.push(n);return e}},c1=(t,e)=>{const n=parseInt(t[0]),r=parseInt(t[1]);if(t[3].length<=r||t[3][r].length===0)return null;let s=null,o=n,i=r,a=t[3],u=a[r][0].verses,c=!1;for(;!s;)if(i+=1,i>=a.length){if(c||!t[4])break;i=-1,o+=1,a=t[4],c=!0}else a[i].length>0&&(!e||c||a[i][0].verses!==u)&&(s=[o,i]);return s},l1=(t,e)=>{const n=parseInt(t[0]),r=parseInt(t[1]);if(t[3].length<=r||t[3][r].length===0)return null;let s=null,o=n,i=r,a=t[3],u=a[r][0].verses,c=!1;for(;!s;)if(i-=1,i<0){if(c||!t[2])break;i=t[2].length,o-=1,a=t[2],c=!0}else a[i].length>0&&(!e||c||a[i][0].verses!==u)&&(s=[o,i]);return s},YT=`
"""Various answers to 'previous' and 'next' with respect to a verse"""
type cvNavigation {
  """The verse number for the next verse"""
  nextVerse: cv
  """The verse number for the previous verse"""
  previousVerse: cv
  """The verse number for the next verse range"""
  nextVerseRangeVerse: cv
  """The verse number for the previous verse range"""
  previousVerseRangeVerse: cv
  """The next chapter number (as a string)"""
  nextChapter: String
  """The previous chapter number (as a string)"""
  previousChapter: String
}
`,ZT={nextVerse:t=>c1(t,!1),previousVerse:t=>l1(t,!1),nextVerseRangeVerse:t=>c1(t,!0),previousVerseRangeVerse:t=>l1(t,!0),nextChapter:t=>t[3].length>0&&t[4].length>0?(parseInt(t[0])+1).toString():null,previousChapter:t=>t[2].length>0&&t[3].length>0?(parseInt(t[0])-1).toString():null},QT=`
"""A specification to create or update a block"""
input inputBlockSpec {
  """The block scope as an item"""
  bs: InputItemObject!
  """The block grafts as items"""
  bg: [InputItemObject!]!
  """The open scopes as items"""
  os: [InputItemObject!]!
  """The included scopes as items"""
  is: [InputItemObject!]!
  """The items"""
  items: [InputItemObject!]!
}
`,ew=`
"""A tree node"""
type node {
  """The node id"""
  id: String!
  """The node parent id"""
  parentId: String
  """The keys for content"""
  keys: [String!]!
  """The content as itemGroups"""
  itemGroups(
    """If true, adds scope and nextToken information to each token"""
    includeContext: Boolean
  ): [ItemGroup!]!
  """The node children ids"""
  childIds: [String!]!
}
`,tw={id:(t,e,n)=>{const[r,s,o]=Q.succinct.headerBytes(t.bs,0);return n.docSet.unsuccinctifyScope(t.bs,s,o,0)[2].split("/")[1]},parentId:(t,e,n)=>{const r=n.docSet.unsuccinctifyScopes(t.is).filter(s=>s[2].startsWith("tTreeParent"))[0][2].split("/")[1];return r==="none"?null:r},keys:(t,e,n)=>n.docSet.unsuccinctifyScopes(t.is).filter(r=>r[2].startsWith("tTreeContent")).map(r=>r[2].split("/")[1]),itemGroups:(t,e,n)=>n.docSet.sequenceItemsByScopes([t],["tTreeContent/"],e.includeContext||!1),childIds:(t,e,n)=>n.docSet.unsuccinctifyScopes(t.is).filter(r=>r[2].startsWith("tTreeChild")).map(r=>r[2].split("/")[2])},nw=`
"""A contiguous flow of content for key-values"""
type kvSequence {
  """The id of the sequence"""
  id: String!
  """The number of entries in the key-value sequence"""
  nEntries: Int!
  """The entries in the key-value sequence"""
  entries(
    """Only return entries whose key matches the specification"""
    keyMatches: String
    """Only return entries whose key equals one of the values in the specification"""
    keyEquals: [String!]
    """Only return entries whose secondary keys match the specification"""
    secondaryMatches: [KeyMatches!]
    """Only return entries whose secondary keys equal one of the values in the specification"""
    secondaryEquals: [KeyValues!]
    """Only return entries whose content matches the specification"""
    contentMatches: [KeyMatches!]
    """Only return entries whose content equals one of the values in the specification"""
    contentEquals: [KeyValues!]
  ): [kvEntry!]
  """A list of the tags of this sequence"""
  tags: [String!]!
  """A list of the tags of this sequence as key/value tuples"""
  tagsKv: [KeyValue!]!
  """Whether or not the sequence has the specified tag"""
  hasTag(
    """The tag name"""
    tagName: String
  ): Boolean!
}
`,rw={nEntries:t=>t.blocks.length,entries:(t,e,n)=>{let r=t.blocks.map(s=>[n.docSet.unsuccinctifyScopes(s.bs).map(o=>o[2].split("/")[1])[0],n.docSet.unsuccinctifyScopes(s.is).filter(o=>o[2].startsWith("kvSecondary/")).map(o=>[o[2].split("/")[1],o[2].split("/")[2]]),n.docSet.sequenceItemsByScopes([s],["kvField/"],!1)]);if(e.keyMatches&&(r=r.filter(s=>B.test(s[0],B(e.keyMatches)))),e.keyEquals&&(r=r.filter(s=>e.keyEquals.includes(s[0]))),e.secondaryMatches){const s={};e.secondaryMatches.forEach(o=>s[o.key]=o.matches),r=r.filter(o=>{const i={};o[1].forEach(a=>i[a[0]]=a[1]);for(const a of Object.entries(s)){const u=i[a[0]];if(!u||!B.test(u,B(a[1])))return!1}return!0})}if(e.secondaryEquals){const s={};e.secondaryEquals.forEach(o=>s[o.key]=o.values),r=r.filter(o=>{const i={};o[1].forEach(a=>i[a[0]]=a[1]);for(const a of Object.entries(s)){const u=i[a[0]];if(!u||!a[1].includes(u))return!1}return!0})}if(e.contentMatches){const s={};e.contentMatches.forEach(o=>s[o.key]=o.matches),r=r.filter(o=>{const i={};o[2].forEach(a=>i[a[0].filter(u=>u.startsWith("kvField"))[0].split("/")[1]]=a[1].filter(u=>u[0]==="token").map(u=>u[2]).join(""));for(const a of Object.entries(s)){const u=i[a[0]];if(!u||!B.test(u,B(a[1])))return!1}return!0})}if(e.contentEquals){const s={};e.contentEquals.forEach(o=>s[o.key]=o.values),r=r.filter(o=>{const i={};o[2].forEach(a=>i[a[0].filter(u=>u.startsWith("kvField"))[0].split("/")[1]]=a[1].filter(u=>u[0]==="token").map(u=>u[2]).join(""));for(const a of Object.entries(s)){const u=i[a[0]];if(!u||!u.includes(a[1]))return!1}return!0})}return r},tags:t=>Array.from(t.tags),tagsKv:t=>Array.from(t.tags).map(e=>e.includes(":")?[e.substring(0,e.indexOf(":")),e.substring(e.indexOf(":")+1)]:[e,""]),hasTag:(t,e)=>t.tags.has(e.tagName)},sw=`
"""A contiguous flow of content for a table"""
type tableSequence {
  """The id of the sequence"""
  id: String!
  """The number of cells in the table sequence"""
  nCells: Int!
  """The number of rows in the table sequence"""
  nRows: Int!
  """The number of columns in the table sequence"""
  nColumns: Int!
  """The cells in the table sequence"""
  cells: [cell!]!
  """The rows in the table sequence"""
  rows(
    """Only return rows whose zero-indexed position is in the list"""
    positions: [Int!]
    """Only return columns whose zero-indexed position is in the list"""
    columns: [Int!]
    """Only return rows whose cells match the specification"""
    matches: [rowMatchSpec!]
    """'Only return rows whose cells contain one of the values in the specification"""
    equals: [rowEqualsSpec!]
  ): [[cell!]!]!
  """A list of the tags of this sequence"""
  tags: [String!]!
  """A list of the tags of this sequence as key/value tuples"""
  tagsKv: [KeyValue!]!
  """Whether or not the sequence has the specified tag"""
  hasTag(
    """The tag name"""
    tagName: String
  ): Boolean!
  """A list of column headings for this tableSequence, derived from the sequence tags"""
  headings: [String!]!
}
`,ow={nCells:t=>t.blocks.length,nRows:(t,e,n)=>{const r=new Set([]);for(const s of t.blocks){const[o,i,a]=Q.succinct.headerBytes(s.bs,0),u=n.docSet.unsuccinctifyScope(s.bs,i,a,0)[2];r.add(u.split("/")[1])}return r.size},nColumns:(t,e,n)=>{const r=new Set([]);for(const s of t.blocks)for(const o of n.docSet.unsuccinctifyScopes(s.is).map(i=>i[2]))o.startsWith("tTableCol")&&r.add(o.split("/")[1]);return r.size},cells:(t,e,n)=>{const r=[];for(const s of t.blocks)r.push([n.docSet.unsuccinctifyScopes(s.bs).map(o=>parseInt(o[2].split("/")[1])),Array.from(new Set(n.docSet.unsuccinctifyScopes(s.is).filter(o=>o[2].startsWith("tTableCol")).map(o=>parseInt(o[2].split("/")[1])))),n.docSet.unsuccinctifyItems(s.c,{},0)]);return r},rows:(t,e,n)=>{const r=(c,l)=>{if(c[l.colN]===void 0)return!1;const p=c[l.colN][2].filter(d=>d[0]==="token").map(d=>d[2]).join("");return B.test(p,B(l.matching))},s=(c,l)=>l.length===0?!0:r(c,l[0])?s(c,l.slice(1)):!1,o=(c,l)=>{if(c[l.colN]===void 0)return!1;const p=c[l.colN][2].filter(d=>d[0]==="token").map(d=>d[2]).join("");return l.values.includes(p)},i=(c,l)=>l.length===0?!0:o(c,l[0])?i(c,l.slice(1)):!1;let a=[],u=-1;for(const c of t.blocks){const l=n.docSet.unsuccinctifyScopes(c.bs).map(p=>parseInt(p[2].split("/")[1]));e.positions&&!e.positions.includes(l[0])||(l[0]!==u&&(a.push([]),u=l[0]),a[a.length-1].push([l,Array.from(new Set(n.docSet.unsuccinctifyScopes(c.is).filter(p=>p[2].startsWith("tTableCol")).map(p=>parseInt(p[2].split("/")[1])))),n.docSet.unsuccinctifyItems(c.c,{},0)]))}return e.matches&&(a=a.filter(c=>s(c,e.matches))),e.equals&&(a=a.filter(c=>i(c,e.equals))),e.columns&&(a=a.map(c=>[...c.entries()].filter(l=>e.columns.includes(l[0])).map(l=>l[1]))),a},tags:t=>Array.from(t.tags),tagsKv:t=>Array.from(t.tags).map(e=>e.includes(":")?[e.substring(0,e.indexOf(":")),e.substring(e.indexOf(":")+1)]:[e,""]),hasTag:(t,e)=>t.tags.has(e.tagName),headings:t=>Array.from(t.tags).filter(e=>e.startsWith("col")).sort((e,n)=>parseInt(e.split(":")[0].substring(3))-parseInt(n.split(":")[0].substring(3))).map(e=>e.split(":")[1])},iw={equals:(t,e,n,r)=>n===r,notEqual:(t,e,n,r)=>n!==r,and:(t,e,...n)=>n.filter(r=>!r).length===0,or:(t,e,...n)=>n.filter(r=>r).length>0,not:(t,e,n)=>!n,idRef:(t,e)=>t.unsuccinctifyScopes(e.bs)[0][2].split("/")[1],parentIdRef:(t,e)=>t.unsuccinctifyScopes(e.is).filter(n=>n[2].startsWith("tTreeParent"))[0][2].split("/")[1],nChildren:(t,e)=>t.unsuccinctifyScopes(e.is).filter(n=>n[2].startsWith("tTreeChild")).length,contentRef:(t,e,n)=>{const r=t.sequenceItemsByScopes([e],["tTreeContent/"],!1).filter(s=>s[0].filter(i=>i.startsWith("tTreeContent"))[0].split("/")[1]===n);return r[0]?r[0][1].filter(s=>s[0]==="token").map(s=>s[2]).join(""):""},hasContent:(t,e,n)=>t.sequenceItemsByScopes([e],["tTreeContent/"],!1).filter(s=>s[0].filter(i=>i.startsWith("tTreeContent"))[0].split("/")[1]===n).length>0,concat:(t,e,...n)=>n.join(""),startsWith:(t,e,n,r)=>n.startsWith(r),endsWith:(t,e,n,r)=>n.endsWith(r),contains:(t,e,n,r)=>n.includes(r),matches:(t,e,n,r)=>B.test(n,B(r)),int:(t,e,n)=>parseInt(n),string:(t,e,n)=>`${n}`,left:(t,e,n,r)=>n.substring(0,r),right:(t,e,n,r)=>n.substring(n.length-r),length:(t,e,n)=>n.length,indexOf:(t,e,n,r)=>n.indexOf(r),add:(t,e,...n)=>n.reduce((r,s)=>r+s),mul:(t,e,...n)=>n.reduce((r,s)=>r*s),sub:(t,e,n,r)=>n-r,div:(t,e,n,r)=>Math.floor(n/r),mod:(t,e,n,r)=>n%r,gt:(t,e,n,r)=>n>r,lt:(t,e,n,r)=>n<r,ge:(t,e,n,r)=>n>=r,le:(t,e,n,r)=>n<=r},aw={quotedString:t=>t.substring(1,t.length-1),int:t=>parseInt(t),true:()=>!0,false:()=>!1},uw=t=>{const e=[[]];let n=0,r=0,s=!1;for(;t&&n<t.length;){switch(t[n]){case"\\":e[e.length-1].push(t[n]),t[n+1]==="'"&&(e[e.length-1].push(t[n+1]),n++);break;case"'":e[e.length-1].push(t[n]),s=!s;break;case"(":s?e[e.length-1].push(t[n]):(e[e.length-1].push(t[n]),r++);break;case")":s?e[e.length-1].push(t[n]):(e[e.length-1].push(t[n]),r--);break;case",":if(!s&&r===0)for(e.push([]);t[n+1]===" ";)n++;else e[e.length-1].push(t[n]);break;default:e[e.length-1].push(t[n])}n++}return e.map(o=>o.join(""))},sc={expression:{oneOf:["stringExpression","intExpression","booleanExpression"]},booleanExpression:{oneOf:["booleanPrimitive","equals","notEqual","and","or","not","contains","startsWith","endsWith","matches","gt","lt","ge","le","hasContent"]},stringExpression:{oneOf:["concat","left","right","string","idRef","parentIdRef","contentRef","stringPrimitive"]},intExpression:{oneOf:["length","indexOf","int","nChildren","intPrimitive","add","sub","mul","div","mod"]},equals:{regex:B("^==\\((.+)\\)$"),doc:{operator:"==",args:["expression","expression"],result:"boolean",description:"Are the arguments strictly equal?"},argStructure:[["expression",[2,2]]]},notEqual:{regex:B("^!=\\((.+)\\)$"),doc:{operator:"!=",args:["expression","expression"],result:"boolean",description:"Are the arguments not strictly equal?"},argStructure:[["expression",[2,2]]]},and:{regex:B("^and\\((.+)\\)$"),doc:{operator:"and",args:["boolean","boolean","..."],result:"boolean",description:"Are all the arguments true?"},breakOn:!1,argStructure:[["booleanExpression",[2,null]]]},or:{regex:B("^or\\((.+)\\)$"),doc:{operator:"or",args:["boolean","boolean"],result:"boolean",description:"Are any arguments true?"},breakOn:!0,argStructure:[["booleanExpression",[2,null]]]},concat:{regex:B("^concat\\((.+)\\)$"),doc:{operator:"concat",args:["string","string","..."],result:"string",description:"Concatenates string arguments"},argStructure:[["stringExpression",[2,null]]]},contentRef:{regex:B("^content\\((.+)\\)$"),doc:{operator:"content",args:["string"],result:"string",description:"String value of the specified content for the node"},argStructure:[["stringExpression",[1,1]]]},hasContent:{regex:B("^hasContent\\((.+)\\)$"),doc:{operator:"hasContent",args:["string"],result:"boolean",description:"Does the node have this content?"},argStructure:[["stringExpression",[1,1]]]},contains:{regex:B("^contains\\((.+)\\)$"),doc:{operator:"contains",args:["string","string"],result:"boolean",description:"Does the first string contain the second string?"},argStructure:[["stringExpression",[2,2]]]},startsWith:{regex:B("^startsWith\\((.+)\\)$"),doc:{operator:"startsWith",args:["string","string"],result:"boolean",description:"Does the first string start with the second string?"},argStructure:[["stringExpression",[2,2]]]},endsWith:{regex:B("^endsWith\\((.+)\\)$"),doc:{operator:"endsWith",args:["string","string"],result:"boolean",description:"Does the first string end with the second string?"},argStructure:[["stringExpression",[2,2]]]},matches:{regex:B("^matches\\((.+)\\)$"),doc:{operator:"matches",args:["string","regex"],result:"boolean",description:"Does the first string match the regex in the second string?"},argStructure:[["stringExpression",[2,2]]]},left:{regex:B("^left\\((.+)\\)$"),doc:{operator:"left",args:["string","integer"],result:"string",description:"The first n characters of the string"},argStructure:[["stringExpression",[1,1]],["intExpression",[1,1]]]},right:{regex:B("^right\\((.+)\\)$"),doc:{operator:"right",args:["string","integer"],result:"string",description:"The last n characters of the string"},argStructure:[["stringExpression",[1,1]],["intExpression",[1,1]]]},length:{regex:B("^length\\((.+)\\)$"),doc:{operator:"length",args:["string"],result:"integer",description:"The number of characters in the string"},argStructure:[["stringExpression",[1,1]]]},indexOf:{regex:B("^indexOf\\((.+)\\)$"),doc:{operator:"indexOf",args:["string","string"],result:"number",description:"The integer position at which the second string starts in the first string"},argStructure:[["stringExpression",[2,2]]]},not:{regex:B("^not\\((.+)\\)$"),doc:{operator:"not",args:["boolean"],result:"boolean",description:"The inverse boolean value of the argument"},argStructure:[["booleanExpression",[1,1]]]},int:{regex:B("^int\\((.+)\\)$"),doc:{operator:"int",args:["string"],result:"integer",description:"The integer value of the string"},argStructure:[["stringExpression",[1,1]]]},string:{regex:B("^string\\((.+)\\)$"),doc:{operator:"string",args:["integer"],result:"string",description:"The string value of the integer"},argStructure:[["intExpression",[1,1]]]},idRef:{regex:B("^id$"),doc:{operator:"id",args:[],result:"string",description:"The node ID"},argStructure:[]},parentIdRef:{regex:B("^parentId$"),doc:{operator:"parentId",args:[],result:"string",description:"The node's parent ID"},argStructure:[]},nChildren:{regex:B("^nChildren$"),doc:{operator:"nChildren",args:[],result:"int",description:"The number of children of the node"},argStructure:[]},add:{regex:B("^add\\((.+)\\)$"),doc:{operator:"add",args:["integer","..."],result:"integer",description:"The numeric sum of the arguments"},argStructure:[["intExpression",[2,null]]]},mul:{regex:B("^mul\\((.+)\\)$"),doc:{operator:"mul",args:["integer","..."],result:"integer",description:"The numeric product of the arguments"},argStructure:[["intExpression",[2,null]]]},sub:{regex:B("^sub\\((.+)\\)$"),doc:{operator:"sub",args:["integer","integer"],result:"integer",description:"The first integer minus the second"},argStructure:[["intExpression",[2,2]]]},div:{regex:B("^div\\((.+)\\)$"),doc:{operator:"div",args:["integer","integer"],result:"integer",description:"The first integer divided by the second"},argStructure:[["intExpression",[2,2]]]},mod:{regex:B("^mod\\((.+)\\)$"),doc:{operator:"mod",args:["integer","integer"],result:"integer",description:"The modulus of the first integer when divided by the second"},argStructure:[["intExpression",[2,2]]]},gt:{regex:B("^>\\((.+)\\)$"),doc:{operator:">",args:["integer","integer"],result:"boolean",description:"Is the first integer numerically greater than the second?"},argStructure:[["intExpression",[2,2]]]},lt:{regex:B("^<\\((.+)\\)$"),doc:{operator:"<",args:["integer","integer"],result:"boolean",description:"Is the first integer numerically less than the second?"},argStructure:[["intExpression",[2,2]]]},ge:{regex:B("^>=\\((.+)\\)$"),doc:{operator:">=",args:["integer","integer"],result:"boolean",description:"Is the first integer numerically greater than or equal to the second?"},argStructure:[["intExpression",[2,2]]]},le:{regex:B("^<=\\((.+)\\)$"),doc:{operator:"<=",args:["integer","integer"],result:"boolean",description:"Is the first integer numerically less than or equal to the second?"},argStructure:[["intExpression",[2,2]]]},stringPrimitive:{regex:B("^('([^']|\\\\')*')$"),parseFunctions:[null,"quotedString"]},intPrimitive:{regex:B("^(-?[0-9]+)$"),parseFunctions:[null,"int"]},booleanPrimitive:{regex:B("^(true)|(false)$"),parseFunctions:[null,"true","false"]}},cw=(t,e,n,r,s)=>{const o=sc[r];if(!o)throw new Error(`Unknown expression ${r} for predicate ${n}`);const i=a=>[a.map(u=>u[1][0]).reduce((u,c)=>u+c),a.filter(u=>u[1][1]===null).length>0];if(o.parseFunctions){let a=!1;for(const[u,c]of o.parseFunctions.entries())if(!(!c||!s[u]))return a=!0,{data:aw[c](s[u])};if(!a)return{errors:`Could not parse predicate ${n}`}}else{const a=uw(s[1]),u=o.argStructure,c=[];if(u.length>0){const l=i(u);if(a.length<l[0])return{errors:`Expected at least ${l[0]} args for '${r}', found ${a.length}`};if(!l[1]&&a.length>l[0])return{errors:`Expected at most ${l[0]} args for '${r}', found ${a.length}`};let p=0,d=0,f=0;for(;p<a.length;){const S=a[p],b=oc(t,e,S,u[d][0]);if("breakOn"in o&&!S.errors&&b.data===o.breakOn)return b;c.push(b),p++,f++,u[d][1][1]&&f>=u[d][1][1]&&(d++,f=0)}}if(c.filter(l=>l.errors).length===0){const l=c.map(d=>d.data);return{data:iw[r](t,e,...l)}}return{errors:`Could not parse arguments to ${r}: ${a.filter(l=>l.errors).map(l=>l.errors).join("; ")}`}}},oc=(t,e,n,r)=>{const s=sc[r];if(!s)throw new Error(`Unknown expression ${r} for predicate ${n}`);if(s.oneOf){let o=null;for(const i of s.oneOf){const a=oc(t,e,n,i);if(a.errors)(!o||a.errors.length<o.length)&&(o=a.errors);else return a}return{errors:o}}else{const o=B.exec(n,s.regex);return o?cw(t,e,n,r,o):{errors:`Could not match ${n}`}}},lw=(t,e,n)=>({data:e.data.filter(r=>{const s=oc(t,r,n,"booleanExpression");if(s.errors)throw new Error(`Predicate - ${s.errors}`);return s.data})}),Ht="(\\[(([^\\]']|'([^']|\\\\')*')+)\\])*",pw=(t,e,n,r,s,o)=>{const i=o[1].split(",").map(a=>a.trim());return{data:Array.from(i).map(a=>e[n.get(a)])}},dw=(t,e)=>({data:[e[0]]}),fw=(t,e)=>({data:e}),hw=(t,e,n,r,s,o)=>{const i=o[2],a=new Set([]);for(const u of r.data){const c=t.unsuccinctifyScopes(u.is).map(l=>l[2].split("/")).filter(l=>l[0]==="tTreeChild").filter(l=>!i||l[1]===i).map(l=>l[2]);for(const l of c)a.add(l)}return{data:Array.from(a).map(u=>e[n.get(u)])}},mw=(t,e,n,r)=>{const s=new Set([]);for(const o of r.data){const i=t.unsuccinctifyScopes(o.is).filter(a=>a[2].startsWith("tTreeParent")).map(a=>a[2].split("/")[1])[0];s.add(i)}return{data:Array.from(s).map(o=>e[n.get(o)])}},Dw=(t,e,n,r,s,o)=>{let i=parseInt(o[2]);if(i<1)return{errors:`Expected a positive integer argument for ancestor, found ${s}`};let a=r.data;for(;i>0;){const u=new Set([]);for(const c of a){const l=t.unsuccinctifyScopes(c.is).filter(p=>p[2].startsWith("tTreeParent")).map(p=>p[2].split("/")[1])[0];u.add(l)}a=Array.from(u).map(c=>e[n.get(c)]),i--}return{data:a}},Sw=(t,e,n,r,s,o)=>{const i=new Set([]),a=(l,p)=>{const d=t.unsuccinctifyScopes(l.is).filter(f=>f[2].startsWith("tTreeChild")).map(f=>f[2].split("/")[2]);(p<=1||p===null)&&d.forEach(f=>i.add(f)),(p===null||p>1)&&d.map(f=>e[n.get(f)]).forEach(f=>a(f,p-1))};let u=null;o[3]&&(u=parseInt(o[3]));let c=-1;o[5]&&(c=parseInt(o[5]));for(const l of r.data)a(l,u);return{data:[...Array.from(i).entries()].filter(l=>c<0||l[0]===c).map(l=>l[1]).map(l=>e[n.get(l)])}},Ew=(t,e,n,r)=>{const s=new Set([]),o=i=>{const a=t.unsuccinctifyScopes(i.is).filter(u=>u[2].startsWith("tTreeChild")).map(u=>u[2].split("/")[2]);a.length===0?s.add(t.unsuccinctifyScopes(i.bs)[0][2].split("/")[1]):a.map(u=>e[n.get(u)]).forEach(u=>o(u))};for(const i of r.data)o(i);return{data:Array.from(s).map(i=>e[n.get(i)])}},yw=(t,e,n,r)=>{const s=new Set([]);for(const a of r.data){const u=t.unsuccinctifyScopes(a.is).filter(c=>c[2].startsWith("tTreeParent")).map(c=>c[2].split("/")[1])[0];s.add(u)}const o=e.filter(a=>s.has(t.unsuccinctifyScopes(a.bs)[0][2].split("/")[1])),i=new Set([]);for(const a of o){const u=t.unsuccinctifyScopes(a.is).filter(c=>c[2].startsWith("tTreeChild")).map(c=>c[2].split("/")[2]);for(const c of u)i.add(c)}return{data:Array.from(i).map(a=>e[n.get(a)])}},Si=(t,e,n,r,s,o)=>{const i={};(s.size===0||s.has("id"))&&(i.id=t.unsuccinctifyScopes(e.bs)[0][2].split("/")[1]),(s.size===0||s.has("parentId"))&&(i.parentId=t.unsuccinctifyScopes(e.is).filter(c=>c[2].startsWith("tTreeParent")).map(c=>c[2].split("/")[1])[0]);const a={};for(const[c,l]of t.sequenceItemsByScopes([e],["tTreeContent/"],!1)){const p=c.filter(d=>d.startsWith("tTreeContent"))[0].split("/")[1];(s.size===0||s.has("content")||s.has(`@${p}`))&&(a[p]=l.filter(d=>d[0]==="token").map(d=>d[2]).join(""))}Object.keys(a).length>0&&(i.content=a);const u=[];if(s.has("children"))for(const c of t.unsuccinctifyScopes(e.is).filter(l=>l[2].startsWith("tTreeChild")).map(l=>l[2].split("/")[2]))u.push(c);return u.length>0&&(o?i.children=u.map(c=>n[r.get(c)]).map(c=>Si(t,c,n,r,s,!0)):i.children=u),i},gw=(t,e,n,r,s,o)=>{const i=[];let a=new Set([]);o[2]&&(a=new Set(o[2].split(",").map(u=>u.trim())));for(const u of r.data)i.push(Si(t,u,e,n,a,!0));return{data:i}},vw=(t,e,n,r,s,o)=>{const i=[];let a=new Set([]);o[2]&&(a=new Set(o[2].split(",").map(c=>c.trim()).filter(c=>c.startsWith("@"))));for(const c of r.data)i.push(Si(t,c,e,n,a,!0));const u={};for(const c of Array.from(a).map(l=>l.substring(1)))u[c]=Array.from(new Set(i.filter(l=>l.content).map(l=>l.content).filter(l=>c in l).map(l=>l[c]).sort()));return{data:u}},Aw=(t,e,n,r,s,o)=>{const i=[];let a=new Set([]);o[2]&&(a=new Set(o[2].split(",").map(u=>u.trim())));for(const u of r.data)i.push(Si(t,u,e,n,a,!1));return{data:i}},p1=[{regex:B(`^#\\{([^}]+)\\}${Ht}$`),doc:{title:"Nodes by Id",syntax:"#(id, id, ...)",description:"Returns nodes whose id is listed"},predicateCapture:3,inputType:null,outputType:"nodes",function:pw},{regex:B(`^root${Ht}$`),doc:{title:"Root Node",syntax:"root",description:"Returns the root node"},predicateCapture:2,inputType:null,outputType:"nodes",function:dw},{regex:B(`^nodes${Ht}$`),doc:{title:"Nodes",syntax:"nodes",description:"Returns all the nodes"},predicateCapture:2,function:fw,inputType:null,outputType:"nodes"},{regex:B(`^children(\\((\\d+)\\))?${Ht}$`),doc:{title:"Children",syntax:"children; children(pos)",description:"Returns the children of the current node(s), optionally filtered by position within the parent node"},predicateCapture:4,inputType:"nodes",outputType:"nodes",function:hw},{regex:B(`^descendants((\\((\\d+)(,\\s*(\\d+))?\\))?)${Ht}$`),doc:{title:"Descendants",syntax:"descendants; descendants(depth); descendants(depth, pos)",description:"Returns the descendants of the current node(s), optionally at the specified level, optionally filtered by position"},predicateCapture:7,inputType:"nodes",outputType:"nodes",function:Sw},{regex:B(`^leaves${Ht}$`),doc:{title:"Leaves",syntax:"leaves",description:"Returns the leaves (ie the nodes with no children) below the current node"},predicateCapture:2,inputType:"nodes",outputType:"nodes",function:Ew},{regex:B(`^parent${Ht}$`),doc:{title:"Parent",syntax:"parent",description:"Returns the parent of the current node"},predicateCapture:2,inputType:"nodes",outputType:"nodes",function:mw},{regex:B(`^ancestor(\\((\\d+)\\))${Ht}$`),doc:{title:"Ancestor",syntax:"ancestor(depth)",description:"Returns the nth ancestor of the node"},predicateCapture:5,inputType:"nodes",outputType:"nodes",function:Dw},{regex:B(`^siblings${Ht}$`),doc:{title:"Siblings",syntax:"siblings",description:"Returns the children of the parent of the current node"},predicateCapture:2,inputType:"nodes",outputType:"nodes",function:yw},{regex:B(`^node(\\{([^}]+)\\})?${Ht}$`),doc:{title:"Node Details",syntax:"node; node{ id, parentId, content, children, @foo }",description:"Returns an object containing the specified content"},predicateCapture:4,inputType:"nodes",outputType:"node",function:Aw},{regex:B(`^branch(\\{([^}]+)\\})?${Ht}$`),doc:{title:"Branch",syntax:"branch; branch{ id, parentId, content, children, @foo }",description:"Returns nested objects containing the specified content"},predicateCapture:4,inputType:"nodes",outputType:"node",function:gw},{regex:B(`^values(\\{([^}]+)\\})?${Ht}$`),doc:{title:"Values",syntax:"values{ @foo ... }",description:"Returns all values across nodes for the specified fields"},predicateCapture:4,inputType:"nodes",outputType:"values",function:vw}];class Ki{constructor(){this.currentStepType=null}doStep(e,n,r,s,o){for(const i of p1){const a=B.exec(o,i.regex);if(a&&i.inputType===this.currentStepType){let u=i.function(e,n,r,s,o,a);return a[i.predicateCapture]&&(u=lw(e,u,a[i.predicateCapture])),this.currentStepType=i.outputType,u}}return{errors:`Unable to match step ${o}`}}parse1(e,n,r,s,o){if(o.length>0){const i=this.doStep(e,n,r,s,o[0]);return i.errors||i.data.length===0?i:this.parse1(e,n,r,i,o.slice(1))}else return s}queryArray(e){const n=[];for(const r of e.split("/"))n.push(r);return n}indexNodes(e,n){const r=new Map;for(const[s,o]of n.entries()){const i=e.unsuccinctifyScopes(o.bs)[0][2].split("/")[1];r.set(i,s)}return r}doc(){return`** Steps **

`+p1.map(e=>e.doc).map(e=>`* ${e.title} *
${e.syntax}
${e.description}`).join(`

`)+`** Predicate Operators **

`+Object.values(sc).filter(e=>e.doc).map(e=>`${e.doc.operator}(${e.doc.args.map(n=>"<"+n+">").join(", ")}) => ${e.doc.result}
${e.doc.description}`).join(`

`)}parse(e,n,r){const s=this.parse1(e,n,this.indexNodes(e,n),{data:n},this.queryArray(r));if(s.data)switch(this.currentStepType){case"nodes":s.data=s.data.map(i=>({id:e.unsuccinctifyScopes(i.bs)[0][2].split("/")[1]}))}return JSON.stringify(s,null,2)}}const bw=`
"""The nodes of a tree"""
type treeSequence {
  """The id of the sequence"""
  id: String!
  """The number of nodes in the tree sequence"""
  nNodes: Int!
  """The nodes in the tree sequence"""
  nodes: [node!]!
  """The JSON result for a Tribos query, as a string"""
  tribos(
    """The Tribos query string"""
    query: String!
  ): String!
  """The JSON results for the Tribos queries, as an array of strings"""
  triboi(
    """The Tribos query strings"""
    queries: [String!]!
  ): [String!]!
  """Tribos documentation"""
  tribosDoc: String!
  """A list of the tags of this sequence"""
  tags: [String!]!
  """A list of the tags of this sequence as key/value tuples"""
  tagsKv: [KeyValue!]!
  """Whether or not the sequence has the specified tag"""
  hasTag(
    """The tag name"""
    tagName: String
  ): Boolean!
}
`,Cw={nNodes:t=>t.blocks.length,nodes:t=>t.blocks,tribos:(t,e,n)=>new Ki().parse(n.docSet,t.blocks,e.query),triboi:(t,e,n)=>e.queries.map(r=>new Ki().parse(n.docSet,t.blocks,r)),tribosDoc:()=>new Ki().doc(),tags:t=>Array.from(t.tags),tagsKv:t=>Array.from(t.tags).map(e=>e.includes(":")?[e.substring(0,e.indexOf(":")),e.substring(e.indexOf(":")+1)]:[e,""]),hasTag:(t,e)=>t.tags.has(e.tagName)},Tw=(t,e)=>{if(t.length===0)return!0;for(const n of t)if(e.startsWith(n))return!0;return!1},ww=`
"""Part of a sequence, roughly equivalent to a USFM paragraph"""
type Block {
  """The length in bytes of the succinct representation of c (block items)"""
  cBL: Int!
  """The length in bytes of the succinct representation of bg (block grafts)"""
  bgBL: Int!
  """The length in bytes of the succinct representation of os (open scopes)"""
  osBL: Int!
  """The length in bytes of the succinct representation of is (included scopes)"""
  isBL: Int!
  """The length in bytes of the succinct representation of nt (nextToken at the start of the block)"""
  ntBL: Int!
  """The number of items in the succinct representation of c (block items)"""
  cL: Int!
  """The number of items in the succinct representation of bg (block grafts)"""
  bgL: Int!
  """The number of items in the succinct representation of os (open scopes)"""
  osL: Int!
  """The number of items in the succinct representation of is (included scopes)"""
  isL: Int!
  """A list of included scopes for this block"""
  is: [Item!]!
  """A list of open scopes for this block"""
  os: [Item!]!
  """The block scope for this block"""
  bs: Item!
  """A list of block grafts for this block"""
  bg: [Item!]!
  """The value of nextToken at the start of this block"""
  nt: Int!
  """A list of items from the c (content) field of the block"""
  items(
    """Only return items that are within specific scopes"""
    withScopes: [String!]
    """If true, withScopes filtering matches items within at least one of the specified scopes"""
    anyScope: Boolean
    """Only return items that are within a chapterVerse range (ch or ch:v or ch:v-v or ch:v-ch:v)"""
    withScriptureCV: String
    """If true, adds scope and nextToken information to each token"""
    includeContext: Boolean
    """Do not return scopes types in list (eg milestone)"""
    excludeScopeTypes: [String!]
  ) : [Item!]! 
  """A list of tokens from the c (content) field of the block"""
  tokens(
    """Only return tokens that are within specific scopes"""
    withScopes: [String!]
    """If true, withScopes filtering matches tokens within at least one of the specified scopes"""
    anyScope: Boolean
    """Only return tokens that are within a chapterVerse range (ch or ch:v or ch:v-v or ch:v-ch:v)"""
    withScriptureCV: String
    """If true, adds scope and nextToken information to each token"""
    includeContext: Boolean
    """Return tokens whose payload is an exact match to one of the specified strings"""
    withChars: [String!]
    """Return tokens whose payload matches one of the specified regexes"""
    withMatchingChars: [String!]
    """Return tokens with one of the specified subTypes"""
    withSubTypes: [String!]
  ) : [Item!]!
  """The text of the block as a single string"""
  text(
    """Only return text that is within a chapterVerse range (ch or ch:v or ch:v-v or ch:v-ch:v)"""
    withScriptureCV: String
    """If true, converts each whitespace character to a single space"""
    normalizeSpace: Boolean
  ): String!
  """'Block items grouped by scopes or milestones"""
  itemGroups(
    """Produce one itemGroup for every match of the list of scopes"""
    byScopes: [String!]
    """Start a new itemGroup whenever a milestone in the list is encountered"""
    byMilestones: [String!]
  ): [ItemGroup]!
  """The block content as a string in a compact eyeballable format"""
  dump: String!
  """A list of the labels for the block\\'s bs, os and is scopes"""
  scopeLabels(
    """Only include scopes that begin with this value"""
    startsWith: [String!]
  ): [String!]!
}
`,Fw={cBL:t=>t.c.length,bgBL:t=>t.bg.length,osBL:t=>t.os.length,isBL:t=>t.is.length,ntBL:t=>t.nt.length,cL:(t,e,n)=>n.docSet.countItems(t.c),bgL:(t,e,n)=>n.docSet.countItems(t.bg),osL:(t,e,n)=>n.docSet.countItems(t.os),isL:(t,e,n)=>n.docSet.countItems(t.is),is:(t,e,n)=>n.docSet.unsuccinctifyScopes(t.is),os:(t,e,n)=>n.docSet.unsuccinctifyScopes(t.os),bs:(t,e,n)=>{const[r,s,o]=Q.succinct.headerBytes(t.bs,0);return n.docSet.unsuccinctifyScope(t.bs,s,o,0)},bg:(t,e,n)=>n.docSet.unsuccinctifyGrafts(t.bg),nt:t=>t.nt.nByte(0),items:(t,e,n)=>{if(e.withScopes&&e.withScriptureCV)throw new Error("Cannot specify both withScopes and withScriptureCV");return e.withScriptureCV?n.docSet.unsuccinctifyItemsWithScriptureCV(t,e.withScriptureCV,e.excludeScopeTypes?{tokens:!0,scopes:!0,grafts:!0,excludeScopeTypes:e.excludeScopeTypes||[],anyScope:e.anyScope||!1,includeContext:e.includeContext||!1}:{}):n.docSet.unsuccinctifyPrunedItems(t,{tokens:!0,scopes:!0,grafts:!0,excludeScopeTypes:e.excludeScopeTypes||[],requiredScopes:e.withScopes||[],anyScope:e.anyScope||!1})},tokens:(t,e,n)=>{if(Object.keys(e).filter(s=>s.includes("Chars")).length>1)throw new Error('Only one of "withChars", "withAnyCaseChars" and "withCharsMatchingRegex" may be specified');let r;return e.withScriptureCV?r=n.docSet.unsuccinctifyItemsWithScriptureCV(t,e.withScriptureCV,{tokens:!0},e.includeContext||!1):r=n.docSet.unsuccinctifyPrunedItems(t,{tokens:!0,scopes:!0,requiredScopes:e.withScopes||[],anyScope:e.anyScope||!1}),e.withSubTypes&&(r=r.filter(s=>e.withSubTypes.includes(s[1]))),e.withChars?r=r.filter(s=>e.withChars.includes(s[2])):e.withMatchingChars&&(r=r.filter(s=>{for(const o of e.withMatchingChars)if(B.test(s,B(o)))return!0;return!1})),r.filter(s=>s[0]==="token")},text:(t,e,n)=>{let s=(e.withScriptureCV?n.docSet.unsuccinctifyItemsWithScriptureCV(t,e.withScriptureCV,{tokens:!0},!1):n.docSet.unsuccinctifyItems(t.c,{tokens:!0},null)).map(o=>o[2]).join("").trim();return e.normalizeSpace&&(s=s.replace(/[ \t\n\r]+/g," ")),s},itemGroups:(t,e,n)=>{if(e.byScopes&&e.byMilestones)throw new Error("Cannot specify both byScopes and byMilestones");if(!e.byScopes&&!e.byMilestones)throw new Error("Must specify either byScopes or byMilestones");return e.byScopes?n.docSet.sequenceItemsByScopes([t],e.byScopes):n.docSet.sequenceItemsByMilestones([t],e.byMilestones)},dump:(t,e,n)=>FT(n.docSet.unsuccinctifyBlock(t,{},null)),scopeLabels:(t,e,n)=>[...n.docSet.unsuccinctifyBlockScopeLabelsSet(t)].filter(r=>!e.startsWith||Tw(e.startsWith,r))},Ff=(t,e,n)=>{let r=[e.map(s=>[Q.enums.enumStringIndex(t.enums.wordLike,s)])];return n?r=r[0]:r=r.map(s=>s.reduce((o,i)=>o.concat(i))),r},If=(t,e,n)=>{let r=[e.map(s=>Q.enums.enumRegexIndexTuples(t.enums.wordLike,s).map(o=>o[0]))];return n?r=r[0]:r=r.map(s=>s.reduce((o,i)=>o.concat(i))),r},kf=(t,e,n)=>{if(n&&e.filter(r=>r.length===0).length>0||(e=e.filter(r=>r.length>0),e.length===0))return!1;for(const r of e){let s=!1;for(const o of r)if(o>=0&&t.tokensPresent.get(o)>0){s=!0;break}if(n&&!s)return!1;if(!n&&s)return!0}return n},Na=(t,e,n,r)=>{let s=Ff(t,n,r);return kf(e,s,r)},_a=(t,e,n,r)=>{let s=If(t,n,r);return kf(e,s,r)},Iw=[[64335,[[8591,[[4991,[[2143,[[1279,[[591,[[255,[[127,"Basic Latin"],[255,"Latin-1 Supplement"]]],[591,[[383,"Latin Extended-A"],[591,"Latin Extended-B"]]]]],[1279,[[767,[[687,"IPA Extensions"],[767,"Spacing Modifier Letters"]]],[1279,[[879,"Combining Diacritical Marks"],[1279,[[1023,"Greek and Coptic"],[1279,"Cyrillic"]]]]]]]]],[2143,[[1871,[[1423,[[1327,"Cyrillic Supplement"],[1423,"Armenian"]]],[1871,[[1535,"Hebrew"],[1871,[[1791,"Arabic"],[1871,"Syriac"]]]]]]],[2143,[[1983,[[1919,"Arabic Supplement"],[1983,"Thaana"]]],[2143,[[2047,"NKo"],[2143,[[2111,"Samaritan"],[2143,"Mandaic"]]]]]]]]]]],[4991,[[3199,[[2559,[[2303,[[2159,"Syriac Supplement"],[2303,"Arabic Extended-A"]]],[2559,[[2431,"Devanagari"],[2559,"Bengali"]]]]],[3199,[[2815,[[2687,"Gurmukhi"],[2815,"Gujarati"]]],[3199,[[2943,"Oriya"],[3199,[[3071,"Tamil"],[3199,"Telugu"]]]]]]]]],[4991,[[3839,[[3455,[[3327,"Kannada"],[3455,"Malayalam"]]],[3839,[[3583,"Sinhala"],[3839,[[3711,"Thai"],[3839,"Lao"]]]]]]],[4991,[[4255,[[4095,"Tibetan"],[4255,"Myanmar"]]],[4991,[[4351,"Georgian"],[4991,[[4607,"Hangul Jamo"],[4991,"Ethiopic"]]]]]]]]]]]]],[8591,[[6911,[[6015,[[5791,[[5119,[[5023,"Ethiopic Supplement"],[5119,"Cherokee"]]],[5791,[[5759,"Unified Canadian Aboriginal Syllabics"],[5791,"Ogham"]]]]],[6015,[[5919,[[5887,"Runic"],[5919,"Tagalog"]]],[6015,[[5951,"Hanunoo"],[6015,[[5983,"Buhid"],[6015,"Tagbanwa"]]]]]]]]],[6911,[[6527,[[6319,[[6143,"Khmer"],[6319,"Mongolian"]]],[6527,[[6399,"Unified Canadian Aboriginal Syllabics Extended"],[6527,[[6479,"Limbu"],[6527,"Tai Le"]]]]]]],[6911,[[6655,[[6623,"New Tai Lue"],[6655,"Khmer Symbols"]]],[6911,[[6687,"Buginese"],[6911,[[6831,"Tai Tham"],[6911,"Combining Diacritical Marks Extended"]]]]]]]]]]],[8591,[[7551,[[7295,[[7103,[[7039,"Balinese"],[7103,"Sundanese"]]],[7295,[[7167,"Batak"],[7295,[[7247,"Lepcha"],[7295,"Ol Chiki"]]]]]]],[7551,[[7359,[[7311,"Cyrillic Extended-C"],[7359,"Georgian Extended"]]],[7551,[[7375,"Sundanese Supplement"],[7551,[[7423,"Vedic Extensions"],[7551,"Phonetic Extensions"]]]]]]]]],[8591,[[8303,[[7679,[[7615,"Phonetic Extensions Supplement"],[7679,"Combining Diacritical Marks Supplement"]]],[8303,[[7935,"Latin Extended Additional"],[8303,[[8191,"Greek Extended"],[8303,"General Punctuation"]]]]]]],[8591,[[8399,[[8351,"Superscripts and Subscripts"],[8399,"Currency Symbols"]]],[8591,[[8447,"Combining Diacritical Marks for Symbols"],[8591,[[8527,"Letterlike Symbols"],[8591,"Number Forms"]]]]]]]]]]]]]]],[64335,[[12799,[[11359,[[9727,[[9279,[[8959,[[8703,"Arrows"],[8959,"Mathematical Operators"]]],[9279,[[9215,"Miscellaneous Technical"],[9279,"Control Pictures"]]]]],[9727,[[9471,[[9311,"Optical Character Recognition"],[9471,"Enclosed Alphanumerics"]]],[9727,[[9599,"Box Drawing"],[9727,[[9631,"Block Elements"],[9727,"Geometric Shapes"]]]]]]]]],[11359,[[10495,[[10175,[[9983,"Miscellaneous Symbols"],[10175,"Dingbats"]]],[10495,[[10223,"Miscellaneous Mathematical Symbols-A"],[10495,[[10239,"Supplemental Arrows-A"],[10495,"Braille Patterns"]]]]]]],[11359,[[10751,[[10623,"Supplemental Arrows-B"],[10751,"Miscellaneous Mathematical Symbols-B"]]],[11359,[[11007,"Supplemental Mathematical Operators"],[11359,[[11263,"Miscellaneous Symbols and Arrows"],[11359,"Glagolitic"]]]]]]]]]]],[12799,[[12255,[[11647,[[11519,[[11391,"Latin Extended-C"],[11519,"Coptic"]]],[11647,[[11567,"Georgian Supplement"],[11647,"Tifinagh"]]]]],[12255,[[11775,[[11743,"Ethiopic Extended"],[11775,"Cyrillic Extended-A"]]],[12255,[[11903,"Supplemental Punctuation"],[12255,[[12031,"CJK Radicals Supplement"],[12255,"Kangxi Radicals"]]]]]]]]],[12799,[[12591,[[12351,[[12287,"Ideographic Description Characters"],[12351,"CJK Symbols and Punctuation"]]],[12591,[[12447,"Hiragana"],[12591,[[12543,"Katakana"],[12591,"Bopomofo"]]]]]]],[12799,[[12703,[[12687,"Hangul Compatibility Jamo"],[12703,"Kanbun"]]],[12799,[[12735,"Bopomofo Extended"],[12799,[[12783,"CJK Strokes"],[12799,"Katakana Phonetic Extensions"]]]]]]]]]]]]],[64335,[[43311,[[42559,[[19967,[[13311,[[13055,"Enclosed CJK Letters and Months"],[13311,"CJK Compatibility"]]],[19967,[[19903,"CJK Unified Ideographs Extension A"],[19967,"Yijing Hexagram Symbols"]]]]],[42559,[[42127,[[40959,"CJK Unified Ideographs"],[42127,"Yi Syllables"]]],[42559,[[42191,"Yi Radicals"],[42559,[[42239,"Lisu"],[42559,"Vai"]]]]]]]]],[43311,[[43055,[[42751,[[42655,"Cyrillic Extended-B"],[42751,"Bamum"]]],[43055,[[42783,"Modifier Tone Letters"],[43055,[[43007,"Latin Extended-D"],[43055,"Syloti Nagri"]]]]]]],[43311,[[43135,[[43071,"Common Indic Number Forms"],[43135,"Phags-pa"]]],[43311,[[43231,"Saurashtra"],[43311,[[43263,"Devanagari Extended"],[43311,"Kayah Li"]]]]]]]]]]],[64335,[[43887,[[43615,[[43391,[[43359,"Rejang"],[43391,"Hangul Jamo Extended-A"]]],[43615,[[43487,"Javanese"],[43615,[[43519,"Myanmar Extended-B"],[43615,"Cham"]]]]]]],[43887,[[43743,[[43647,"Myanmar Extended-A"],[43743,"Tai Viet"]]],[43887,[[43775,"Meetei Mayek Extensions"],[43887,[[43823,"Ethiopic Extended-A"],[43887,"Latin Extended-E"]]]]]]]]],[64335,[[56191,[[44031,[[43967,"Cherokee Supplement"],[44031,"Meetei Mayek"]]],[56191,[[55215,"Hangul Syllables"],[56191,[[55295,"Hangul Jamo Extended-B"],[56191,"High Surrogates"]]]]]]],[64335,[[57343,[[56319,"High Private Use Surrogates"],[57343,"Low Surrogates"]]],[64335,[[63743,"Private Use Area"],[64335,[[64255,"CJK Compatibility Ideographs"],[64335,"Alphabetic Presentation Forms"]]]]]]]]]]]]]]]]],[1114111,[[72031,[[67999,[[66351,[[65535,[[65071,[[65039,[[65023,"Arabic Presentation Forms-A"],[65039,"Variation Selectors"]]],[65071,[[65055,"Vertical Forms"],[65071,"Combining Half Marks"]]]]],[65535,[[65135,[[65103,"CJK Compatibility Forms"],[65135,"Small Form Variants"]]],[65535,[[65279,"Arabic Presentation Forms-B"],[65535,[[65519,"Halfwidth and Fullwidth Forms"],[65535,"Specials"]]]]]]]]],[66351,[[65999,[[65791,[[65663,"Linear B Syllabary"],[65791,"Linear B Ideograms"]]],[65999,[[65855,"Aegean Numbers"],[65999,[[65935,"Ancient Greek Numbers"],[65999,"Ancient Symbols"]]]]]]],[66351,[[66207,[[66047,"Phaistos Disc"],[66207,"Lycian"]]],[66351,[[66271,"Carian"],[66351,[[66303,"Coptic Epact Numbers"],[66351,"Old Italic"]]]]]]]]]]],[67999,[[66863,[[66527,[[66431,[[66383,"Gothic"],[66431,"Old Permic"]]],[66527,[[66463,"Ugaritic"],[66527,"Old Persian"]]]]],[66863,[[66687,[[66639,"Deseret"],[66687,"Shavian"]]],[66863,[[66735,"Osmanya"],[66863,[[66815,"Osage"],[66863,"Elbasan"]]]]]]]]],[67999,[[67711,[[67455,[[66927,"Caucasian Albanian"],[67455,"Linear A"]]],[67711,[[67647,"Cypriot Syllabary"],[67711,[[67679,"Imperial Aramaic"],[67711,"Palmyrene"]]]]]]],[67999,[[67839,[[67759,"Nabataean"],[67839,"Hatran"]]],[67999,[[67871,"Phoenician"],[67999,[[67903,"Lydian"],[67999,"Meroitic Hieroglyphs"]]]]]]]]]]]]],[72031,[[69759,[[68527,[[68255,[[68191,[[68095,"Meroitic Cursive"],[68191,"Kharoshthi"]]],[68255,[[68223,"Old South Arabian"],[68255,"Old North Arabian"]]]]],[68527,[[68415,[[68351,"Manichaean"],[68415,"Avestan"]]],[68527,[[68447,"Inscriptional Parthian"],[68527,[[68479,"Inscriptional Pahlavi"],[68527,"Psalter Pahlavi"]]]]]]]]],[69759,[[69311,[[68863,[[68687,"Old Turkic"],[68863,"Old Hungarian"]]],[69311,[[68927,"Hanifi Rohingya"],[69311,[[69247,"Rumi Numeral Symbols"],[69311,"Yezidi"]]]]]]],[69759,[[69487,[[69423,"Old Sogdian"],[69487,"Sogdian"]]],[69759,[[69599,"Chorasmian"],[69759,[[69631,"Elymaic"],[69759,"Brahmi"]]]]]]]]]]],[72031,[[70527,[[70111,[[69887,[[69839,"Kaithi"],[69887,"Sora Sompeng"]]],[70111,[[69967,"Chakma"],[70111,[[70015,"Mahajani"],[70111,"Sharada"]]]]]]],[70527,[[70223,[[70143,"Sinhala Archaic Numbers"],[70223,"Khojki"]]],[70527,[[70319,"Multani"],[70527,[[70399,"Khudawadi"],[70527,"Grantha"]]]]]]]]],[72031,[[71295,[[70879,[[70783,"Newa"],[70879,"Tirhuta"]]],[71295,[[71167,"Siddham"],[71295,[[71263,"Modi"],[71295,"Mongolian Supplement"]]]]]]],[72031,[[71487,[[71375,"Takri"],[71487,"Ahom"]]],[72031,[[71759,"Dogra"],[72031,[[71935,"Warang Citi"],[72031,"Dives Akuru"]]]]]]]]]]]]]]],[1114111,[[119551,[[92783,[[73471,[[72447,[[72271,[[72191,"Nandinagari"],[72271,"Zanabazar Square"]]],[72447,[[72367,"Soyombo"],[72447,"Pau Cin Hau"]]]]],[73471,[[72895,[[72815,"Bhaiksuki"],[72895,"Marchen"]]],[73471,[[73055,"Masaram Gondi"],[73471,[[73135,"Gunjala Gondi"],[73471,"Makasar"]]]]]]]]],[92783,[[75087,[[73727,[[73663,"Lisu Supplement"],[73727,"Tamil Supplement"]]],[75087,[[74751,"Cuneiform"],[75087,[[74879,"Cuneiform Numbers and Punctuation"],[75087,"Early Dynastic Cuneiform"]]]]]]],[92783,[[78911,[[78895,"Egyptian Hieroglyphs"],[78911,"Egyptian Hieroglyph Format Controls"]]],[92783,[[83583,"Anatolian Hieroglyphs"],[92783,[[92735,"Bamum Supplement"],[92783,"Mro"]]]]]]]]]]],[119551,[[101775,[[94111,[[93071,[[92927,"Bassa Vah"],[93071,"Pahawh Hmong"]]],[94111,[[93855,"Medefaidrin"],[94111,"Miao"]]]]],[101775,[[100351,[[94207,"Ideographic Symbols and Punctuation"],[100351,"Tangut"]]],[101775,[[101119,"Tangut Components"],[101775,[[101631,"Khitan Small Script"],[101775,"Tangut Supplement"]]]]]]]]],[119551,[[113823,[[110895,[[110847,"Kana Supplement"],[110895,"Kana Extended-A"]]],[113823,[[110959,"Small Kana Extension"],[113823,[[111359,"Nushu"],[113823,"Duployan"]]]]]]],[119551,[[119039,[[113839,"Shorthand Format Controls"],[119039,"Byzantine Musical Symbols"]]],[119551,[[119295,"Musical Symbols"],[119551,[[119375,"Ancient Greek Musical Notation"],[119551,"Mayan Numerals"]]]]]]]]]]]]],[1114111,[[128591,[[125279,[[121519,[[119679,[[119647,"Tai Xuan Jing Symbols"],[119679,"Counting Rod Numerals"]]],[121519,[[120831,"Mathematical Alphanumeric Symbols"],[121519,"Sutton SignWriting"]]]]],[125279,[[123215,[[122927,"Glagolitic Supplement"],[123215,"Nyiakeng Puachue Hmong"]]],[125279,[[123647,"Wancho"],[125279,[[125151,"Mende Kikakui"],[125279,"Adlam"]]]]]]]]],[128591,[[127135,[[126287,[[126143,"Indic Siyaq Numbers"],[126287,"Ottoman Siyaq Numbers"]]],[127135,[[126719,"Arabic Mathematical Alphabetic Symbols"],[127135,[[127023,"Mahjong Tiles"],[127135,"Domino Tiles"]]]]]]],[128591,[[127487,[[127231,"Playing Cards"],[127487,"Enclosed Alphanumeric Supplement"]]],[128591,[[127743,"Enclosed Ideographic Supplement"],[128591,[[128511,"Miscellaneous Symbols and Pictographs"],[128591,"Emoticons"]]]]]]]]]]],[1114111,[[173791,[[129279,[[128767,[[128639,"Ornamental Dingbats"],[128767,"Transport and Map Symbols"]]],[129279,[[128895,"Alchemical Symbols"],[129279,[[129023,"Geometric Shapes Extended"],[129279,"Supplemental Arrows-C"]]]]]]],[173791,[[129647,[[129535,"Supplemental Symbols and Pictographs"],[129647,"Chess Symbols"]]],[173791,[[129791,"Symbols and Pictographs Extended-A"],[173791,[[130047,"Symbols for Legacy Computing"],[173791,"CJK Unified Ideographs Extension B"]]]]]]]]],[1114111,[[195103,[[178207,[[177983,"CJK Unified Ideographs Extension C"],[178207,"CJK Unified Ideographs Extension D"]]],[195103,[[183983,"CJK Unified Ideographs Extension E"],[195103,[[191471,"CJK Unified Ideographs Extension F"],[195103,"CJK Compatibility Ideographs Supplement"]]]]]]],[1114111,[[917631,[[201551,"CJK Unified Ideographs Extension G"],[917631,"Tags"]]],[1114111,[[917999,"Variation Selectors Supplement"],[1114111,[[1048575,"Supplementary Private Use Area-A"],[1114111,"Supplementary Private Use Area-B"]]]]]]]]]]]]]]]]]],kw={tokens:!1,scopes:!0,grafts:!1,requiredScopes:[]},Pw=(t,e,n,r,s)=>{let o=new Set([]);for(const i of t.unsuccinctifyPrunedItems(e,kw,!1)){const[a,u,c,l,p,d]=i[2].split("/");for(const[f,S]of n.entries()){for(const b of S)if(u===b.attType&&c===b.tagName&&l===b.attKey&&parseInt(p)===b.valueN&&r[f].includes(d)){if(!s)return!0;o.add(f);break}if(o.size===n.length)return!0}}return!1},Nw=t=>{const e=t.charCodeAt(0);let n=Iw;for(;typeof n!="string";){const[r,s]=n[0];e<=r?n=s:n=n[1][1]}return n},_w=`
"""A contiguous flow of content"""
type Sequence {
  """The id of the sequence"""
  id: String!
  """The type of the sequence (main, heading...)"""
  type: String!
  """The number of blocks in the sequence"""
  nBlocks: Int!
  """The blocks in the sequence"""
  blocks(
    """Only return blocks where the list of scopes is open"""
    withScopes: [String!]
    """Only return blocks whose zero-indexed position is in the list"""
    positions: [Int!]
    """Only return blocks with the specified block scope (eg 'blockScope/p'"""
    withBlockScope: String
    """Only return blocks that contain items within the specified chapter, verse or chapterVerse range"""
    withScriptureCV: String
    """Ordered list of attribute specs whose values must match those in 'attValues'"""
    attSpecs: [[AttSpec!]!]
    """Ordered list of attribute values, used in conjunction with \\'attSpecs\\'"""
    attValues: [[String!]!]
    """If true, blocks where all attSpecs match will be included"""
    allAtts: Boolean
    """Return blocks containing a token whose payload is an exact match to one of the specified strings"""
    withChars: [String!]
    """Return blocks containing a token whose payload matches the specified regexes"""
    withMatchingChars: [String!]
    """If true, blocks where all regexes match will be included"""
    allChars: Boolean
  ): [Block!]!
  """The items for each block in the sequence"""
  blocksItems: [[Item!]!]
  """The tokens for each block in the sequence"""
  blocksTokens: [[Item!]!]
  """The text for each block in the sequence"""
  blocksText(
    """If true, converts each whitespace character to a single space"""
    normalizeSpace: Boolean
  ): [String!]
  """The text for the sequence"""
  text(
    """If true, converts each whitespace character to a single space"""
    normalizeSpace: Boolean
  ) : String!
  """Sequence content grouped by scopes or milestones"""
  itemGroups(
    """Produce one itemGroup for every different match of the list of scopes"""
    byScopes: [String!]
    """Start a new itemGroup whenever a milestone in the list is encountered"""
    byMilestones: [String!]
  ) : [ItemGroup!]!
  """A list of the tags of this sequence"""
  tags: [String!]!
  """A list of the tags of this sequence as key/value tuples"""
  tagsKv: [KeyValue!]!
  """Whether or not the sequence has the specified tag"""
  hasTag(
    """The specified tag"""
    tagName: String!
  ): Boolean!
  """A list of wordLike token strings in a main sequence"""
  wordLikes(
    """Whether to coerce the strings (toLower|toUpper|none)"""
    coerceCase: String
  ) : [String!]!
  """A list of token strings the sequence with counts"""
  uniqueTokenCounts(
      """Whether to coerce the strings (toLower|toUpper|none)"""
    coerceCase: String
) : [KeyCount!]!
    """A list of unique characters in the sequence with counts"""
  uniqueCharacterCounts: [KeyCountCategory!]!
  """Returns true if a main sequence contains the specified tokens"""
  hasChars(
    """Token strings to be matched exactly"""
    chars: [String!]
    """If true all tokens must match"""
    allChars: Boolean
  ): Boolean!
  """Returns true if a main sequence contains a match for specified regexes"""
  hasMatchingChars(
    """Regexes to be matched"""
    chars: [String!]
    """If true all regexes must match"""
    allChars: Boolean
  ): Boolean!
}
`,Ow={nBlocks:t=>t.blocks.length,blocks:(t,e,n)=>{if(n.docSet.maybeBuildEnumIndexes(),e.withScopes&&e.withScriptureCV)throw new Error("Cannot specify both withScopes and withScriptureCV");if(e.attSpecs&&!e.attValues)throw new Error("Cannot specify attSpecs without attValues");if(!e.attSpecs&&e.attValues)throw new Error("Cannot specify attValues without attSpecs");if(e.attSpecs&&e.attValues&&e.attSpecs.length!==e.attValues.length)throw new Error("attSpecs and attValues must be same length");if(e.withChars&&e.withMatchingChars)throw new Error("Cannot specify both withChars and withMatchingChars");let r=t.blocks;if(e.positions&&(r=Array.from(r.entries()).filter(s=>e.positions.includes(s[0])).map(s=>s[1])),e.withScopes&&(r=r.filter(s=>n.docSet.allScopesInBlock(s,e.withScopes))),e.withScriptureCV&&(r=n.docSet.blocksWithScriptureCV(r,e.withScriptureCV)),e.attSpecs&&(r=r.filter(s=>Pw(n.docSet,s,e.attSpecs,e.attValues,e.allAtts||!1))),e.withBlockScope&&(r=r.filter(s=>n.docSet.blockHasBlockScope(s,e.withBlockScope))),e.withChars){if(t.type==="main"&&!Na(n.docSet,t,e.withChars,e.allChars))return[];let s=Ff(n.docSet,e.withChars,e.allChars);for(const o of s)r=r.filter(i=>n.docSet.blockHasChars(i,o))}if(e.withMatchingChars){if(t.type==="main"&&!_a(n.docSet,t,e.withMatchingChars,e.allChars))return[];let s=If(n.docSet,e.withMatchingChars,e.allChars);for(const o of s)r=r.filter(i=>n.docSet.blockHasChars(i,o))}return r},blocksItems:(t,e,n)=>t.blocks.map(r=>n.docSet.unsuccinctifyItems(r.c,{},null)),blocksTokens:(t,e,n)=>t.blocks.map(r=>n.docSet.unsuccinctifyItems(r.c,{tokens:!0},null)),blocksText:(t,e,n)=>t.blocks.map(r=>{let s=n.docSet.unsuccinctifyItems(r.c,{tokens:!0},null).map(o=>o[2]).join("");return e.normalizeSpace&&(s=s.replace(/[ \t\n\r]+/g," ")),s}),text:(t,e,n)=>{let r=t.blocks.map(s=>n.docSet.unsuccinctifyItems(s.c,{tokens:!0},null).map(o=>o[2]).join("")).join(`
`);return e.normalizeSpace&&(r=r.replace(/[ \t\n\r]+/g," ")),r},itemGroups:(t,e,n)=>{if(e.byScopes&&e.byMilestones)throw new Error("Cannot specify both byScopes and byMilestones");if(!e.byScopes&&!e.byMilestones)throw new Error("Must specify either byScopes or byMilestones");return e.byScopes?n.docSet.sequenceItemsByScopes(t.blocks,e.byScopes):n.docSet.sequenceItemsByMilestones(t.blocks,e.byMilestones)},tags:t=>Array.from(t.tags),tagsKv:t=>Array.from(t.tags).map(e=>e.includes(":")?[e.substring(0,e.indexOf(":")),e.substring(e.indexOf(":")+1)]:[e,""]),hasTag:(t,e)=>t.tags.has(e.tagName),wordLikes:(t,e,n)=>{if(t.type!=="main")throw new Error(`Only available for the main sequence, not ${t.type}`);if(e.coerceCase&&!["toLower","toUpper","none"].includes(e.coerceCase))throw new Error(`coerceCase, when present, must be 'toLower', 'toUpper' or 'none', not '${e.coerceCase}'`);n.docSet.maybeBuildEnumIndexes();let r=new Set,s=0;for(const o of t.tokensPresent){if(o){const i=n.docSet.enumIndexes.wordLike[s];let a=n.docSet.enums.wordLike.countedString(i);e.coerceCase==="toLower"&&(a=a.toLowerCase()),e.coerceCase==="toUpper"&&(a=a.toUpperCase()),r.add(a)}s++}return Array.from(r).sort()},uniqueCharacterCounts:(t,e,n)=>{const r={};return t.blocks.forEach(s=>n.docSet.unsuccinctifyItems(s.c,{tokens:!0},null).forEach(o=>{const i=o[2].split("");for(const a of i)r[a]?r[a]+=1:r[a]=1})),Object.entries(r).map(s=>[s[0],s[1],Nw(s[0])]).sort((s,o)=>o[1]-s[1])},uniqueTokenCounts:(t,e,n)=>{const r={};return t.blocks.forEach(s=>n.docSet.unsuccinctifyItems(s.c,{tokens:!0},null).forEach(o=>{let i=o[2];if(e.coerceCase&&!["toLower","toUpper","none"].includes(e.coerceCase))throw new Error(`coerceCase, when present, must be 'toLower', 'toUpper' or 'none', not '${e.coerceCase}'`);e.coerceCase==="toLower"&&(i=i.toLowerCase()),e.coerceCase==="toUpper"&&(i=i.toUpperCase()),r[i]?r[i]+=1:r[i]=1})),Object.entries(r).sort((s,o)=>o[1]-s[1])},hasChars:(t,e,n)=>{if(t.type!=="main")throw new Error(`Only available for the main sequence, not ${t.type}`);return Na(n.docSet,t,e.chars,e.allChars||!1)},hasMatchingChars:(t,e,n)=>{if(t.type!=="main")throw new Error(`Only available for the main sequence, not ${t.type}`);return _a(n.docSet,t,e.chars,e.allChars)}},Pf=(t,e)=>{let n=t;for(const r of e)r[0]==="scope"&&(r[1]==="start"?n.filter(o=>o===r[2]).length===0&&n.push(r[2]):n=n.filter(s=>s!==r[2]));return n},$w=(t,e,n,r,s)=>{const o=t.chapterIndex(r);if(o){const i=n.blocks[o.startBlock];return i?[[Pf(e.docSet.unsuccinctifyScopes(i.os).map(a=>a[2]),e.docSet.unsuccinctifyItems(i.c,{},0,[]).slice(0,o.startItem+1).filter(a=>a[0]==="scope")),e.docSet.itemsByIndex(n,o,s||!1).reduce((a,u)=>a.concat([["token","lineSpace"," "]].concat(u)))]]:[]}else return[]},Bw=(t,e,n,r,s,o,i,a)=>{let u=e.docSet,c=t.headers.bookCode,l=s.map(b=>[parseInt(r),parseInt(b)]);if(i){const b=t.processor.docSets[a];if(b&&(u=b),"forward"in n.verseMapping&&r in n.verseMapping.forward){let y=[];for(const O of s)y.push(Q.versification.mapVerse(n.verseMapping.forward[r],t.headers.bookCode,r,O));const T=y[0];c=T[0],l=T[1]}const F=u.documentWithBook(c);if(F){const y=F.sequences[F.mainId];if(y.verseMapping&&"reversed"in y.verseMapping){const T=[];for(const[O,j]of l)`${O}`in y.verseMapping.reversed?T.push(Q.versification.mapVerse(y.verseMapping.reversed[`${O}`],c,O,j)):T.push([c,[[O,j]]]),c=T[0][0],l=T.map(M=>M[1]).reduce((M,ee)=>M.concat(ee))}}}const p={},d=u.documentWithBook(c);if(!d)return[];const f=d.sequences[d.mainId];for(const b of l.map(F=>F[0]))b in p||(p[b]=d.chapterVerseIndex(b));const S=[];for(const[b,F]of l)if(p[b]){let y=[],T=0,O=0;if(p[b][F]){for(const M of p[b][F])T||(T=M.startBlock,O=M.startItem),y=y.concat(u.itemsByIndex(f,M,o||null).reduce((ee,ne)=>ee.concat([["token","lineSpace"," "]].concat(ne))));const j=f.blocks[T];S.push(j?[Pf(u.unsuccinctifyScopes(j.os).map(M=>M[2]),u.unsuccinctifyItems(j.c,{},0,[]).slice(0,O+1).filter(M=>M[0]==="scope")),y]:[])}}return S},Nf=(t,e)=>e.length===0?!1:t.includes(`chapter/${e[0][0]}`)&&(!e[0][1]||t.filter(n=>n.startsWith("verse/")&&parseInt(n.split("/")[1])>=e[0][1]).length>0)&&(!e[0][2]||t.filter(n=>n.startsWith("verse/")&&parseInt(n.split("/")[1])<=e[0][2]).length>0)?!0:Nf(t,e.slice(1)),Do=(t,e,n,r,s,o)=>{const[i,a]=r.split(":").map(d=>parseInt(d)),[u,c]=s.split(":").map(d=>parseInt(d));if(u<i)throw new Error(`cv chapterVerses requires fromChapter <= toChapter, not ${i} to ${u}`);const l=[];let p=i;for(;p<=u;)l.push([p,p===i?a:null,p===u?c:null]),p++;return e.docSet.sequenceItemsByScopes(n.blocks,["chapter/","verse/"],o).filter(d=>Nf(d[0],l))},Rw=(t,e,n,r,s,o)=>{if(e.chapter&&!e.verses)return $w(t,n,r,e.chapter,e.includeContext);if(e.verses)return Bw(t,n,r,e.chapter,e.verses,e.includeContext,s,o);throw new Error("Unexpected args to do_cv_separate_args")},xw=(t,e,n,r)=>{if(B.test(e.chapterVerses,B("^[0-9]+:[0-9]+-[0-9]+:[0-9]+$"))){const[s,o]=e.chapterVerses.split("-");return Do(t,n,r,s,o,e.includeContext)}else if(B.test(e.chapterVerses,B("^[0-9]+:[0-9]+-[0-9]+$"))){const[s,o]=e.chapterVerses.split(":"),[i,a]=o.split("-");return Do(t,n,r,`${s}:${i}`,`${s}:${a}`,e.includeContext)}else if(B.test(e.chapterVerses,B("^[0-9]+:[0-9]+$"))){const[s,o]=e.chapterVerses.split(":");return Do(t,n,r,`${s}:${o}`,`${s}:${o}`,e.includeContext)}else if(B.test(e.chapterVerses,B("^[0-9]+$"))){const s=e.chapterVerses,o=t.chapterVerseIndex(s);if(!o)throw new Error(`No chapter ${s} found`);const i=o.map((a,u)=>[u,a]).filter(a=>a[1].length>0).map(a=>a[0]);return Do(t,n,r,`${s}:${Math.min(i)}`,`${s}:${Math.max(i)}`,e.includeContext)}else throw new Error(`Could not parse chapterVerses string '${e.chapterVerses}'`)},Xi=(t,e,n,r,s)=>{n.docSet=t.processor.docSets[t.docSetId];const o=t.sequences[t.mainId];if(!e.chapter&&!e.chapterVerses)throw new Error("Must specify either chapter or chapterVerses for cv");if(e.chapter&&e.chapterVerses)throw new Error("Must not specify both chapter and chapterVerses for cv");if(e.chapterVerses&&e.verses)throw new Error("Must not specify both chapterVerses and verses for cv");return e.chapter?Rw(t,e,n,o,r,s):xw(t,e,n,o)},d1=(t,e)=>e in t.headers?t.headers[e]:null,qw=`
"""A document, typically corresponding to USFM for one book"""
type Document {
  """The id of the document"""
  id: String!
  """A parsed version of the id header"""
  idParts: idParts!
  """The id of the docSet to which this document belongs"""
  docSetId: String!
  """USFM header information such as TOC"""
  headers: [KeyValue!]!
  """One USFM header"""
  header(
    """The header id, corresponding to the tag name minus any trailing '1'"""
    id: String!
  ): String
  """The main sequence"""
  mainSequence: Sequence!
  """The number of sequences"""
  nSequences: Int!
  """A list of sequences for this document"""
  sequences(
    """ids of sequences to include, if found"""
    ids: [String!]
    """types of sequences to include, if found"""
    types: [String!]
    """Only return sequences with all the specified tags"""
    withTags: [String!]
    """Only return sequences with none of the specified tags"""
    withoutTags: [String!]
  ): [Sequence!]!
  """A list of table sequences for this document"""
  tableSequences(
    """ids of sequences to include, if found"""
    ids: [String!]
    """Only return sequences with all the specified tags"""
    withTags: [String!]
    """Only return sequences with none of the specified tags"""
    withoutTags: [String!]
  ): [tableSequence!]!
  """A list of tree sequences for this document"""
  treeSequences(
    """ids of sequences to include, if found"""
    ids: [String!]
    """Only return sequences with all the specified tags"""
    withTags: [String!]
    """Only return sequences with none of the specified tags"""
    withoutTags: [String!]
  ): [treeSequence!]!
  """A list of key-value sequences for this document"""
  kvSequences(
    """ids of sequences to include, if found"""
    ids: [String!]
    """Only return sequences with all the specified tags"""
    withTags: [String!]
    """Only return sequences with none of the specified tags"""
    withoutTags: [String!]
  ): [kvSequence!]!
  """A list of text (ie non-table, non-tree, non-kv) sequences for this document"""
  textSequences(
    """ids of sequences to include, if found"""
    ids: [String!]
    """Only return sequences with all the specified tags"""
    withTags: [String!]
    """Only return sequences with none of the specified tags"""
    withoutTags: [String!]
  ): [Sequence!]!
  """The sequence with the specified id"""
  sequence(
    """id of the sequence"""
    id: String!
  ): Sequence
  """The table sequence with the specified id"""
  tableSequence(
    """id of the sequence"""
    id: String!
  ): tableSequence
  """The tree sequence with the specified id"""
  treeSequence(
    """id of the sequence"""
    id: String!
  ): treeSequence
  """The key-value sequence with the specified id"""
  kvSequence(
    """id of the sequence"""
    id: String!
  ): kvSequence
  """The blocks of the main sequence"""
  mainBlocks: [Block!]!
  """The items for each block of the main sequence"""
  mainBlocksItems: [[Item!]!]!
  """The tokens for each block of the main sequence"""
  mainBlocksTokens: [[Item!]!]!
  """The text for each block of the main sequence"""
  mainBlocksText(
    """If true, converts each whitespace character to a single space"""
    normalizeSpace: Boolean
  ): [String!]!
  """The text for the main sequence"""
  mainText(
    """If true, converts each whitespace character to a single space"""
    normalizeSpace: Boolean
  ): String!
  """A list of the tags of this document"""
  tags: [String!]!
  """A list of the tags of this document as key/value tuples"""
  tagsKv: [KeyValue!]!
  """'Whether or not the document has the specified tag"""
  hasTag(
    tagName: String!
  ): Boolean!
  """Content for a Scripture reference within this document, using local versification"""
  cv(
    """The chapter number (as a string)"""
    chapter: String
    """'A list of verse numbers (as strings)"""
    verses: [String!]
    """A chapterVerse Reference (ch:v-ch:v)"""
    chapterVerses: String
    """If true, adds scope and nextToken information to each token"""
    includeContext: Boolean
  ): [ItemGroup!]!
  """Content for a Scripture reference within this document, using the versification of the specified docSet"""
  mappedCv(
    """The chapter number (as a string)"""
    chapter: String!
    """The id of the mapped docSet"""
    mappedDocSetId: String!
    """A list of verse numbers (as strings)"""
    verses: [String!]!
    """If true, adds scope and nextToken information to each token"""
    includeContext: Boolean
  ): [ItemGroup!]!
  """Content for each verse of a chapter within this document, using the versification of the specified docSet"""
  mappedCvs(
    """The chapter number (as a string)"""
    chapter: String!
    """The id of the mapped docSet"""
    mappedDocSetId: String!
    """If true, adds scope and nextToken information to each token"""
    includeContext: Boolean
  ): [[ItemGroup!]!]!
  """What's previous and next with respect to the specified verse"""
  cvNavigation(
    """The chapter number (as a string)"""
    chapter: String!
    """A verse number (as a string)"""
    verse: String!
  ): cvNavigation
  """The content of the main sequence indexed by chapterVerse"""
  cvIndexes: [cvIndex]!
  """The content of the specified chapter indexed by chapterVerse"""
  cvIndex(
    """The chapter number"""
    chapter: Int!
  ): cvIndex!
  """The content of the main sequence indexed by chapter"""
  cIndexes: [cIndex]!
  """The content of a chapter"""
  cIndex(
    """'The chapter number"""
    chapter: Int!
  ): cIndex!
  """Verses matching the arguments"""
  cvMatching(
    """Return verses containing a token whose payload is an exact match to one of the specified strings"""
    withChars: [String!]
    """Return verses containing a token whose payload matches the specified regexes"""
    withMatchingChars: [String!]
    """Only return blocks where the list of scopes is open"""
    withScopes: [String!]
    """If true, verses where all regexes match will be included"""
    allChars: Boolean
    """If true, verses where all scopes match will be included"""
    allScopes: Boolean
  ): [ItemGroup!]!
  """A string of PERF JSON for this document"""
  perf(
    """Format JSON string with this indent"""
    indent: Int
  ): String! 
  """A string of USFM for this document"""
  usfm: String! 
  """A string of SOFRIA JSON for this document"""
  sofria(
    """Format JSON string with this indent"""
    indent: Int
    """Return SOFRIA for this chapter only"""
    chapter: Int
  ): String! 
}
`,Mw={idParts:t=>{const e=d1(t,"id");if(!e)return[null,null];const n=B.exec(e,/^(P\d\d)\s+([A-Z0-6]{3})\s+(\S+)\s+-\s+(.*)/);if(n)return["periph",n.slice(1)];const r=B.exec(e,/^([A-Z0-6]{3})\s+(.*)/);return r?["book",r.slice(1)]:[null,[e]]},headers:t=>Object.entries(t.headers),header:(t,e)=>d1(t,e.id),mainSequence:(t,e,n)=>(n.docSet=t.processor.docSets[t.docSetId],t.sequences[t.mainId]),nSequences:(t,e,n)=>(n.docSet=t.processor.docSets[t.docSetId],Object.keys(t.sequences).length),sequences:(t,e,n)=>{n.docSet=t.processor.docSets[t.docSetId];let r=Object.values(t.sequences);return e.ids&&(r=r.filter(s=>e.ids.includes(s.id))),e.types&&(r=r.filter(s=>e.types.includes(s.type))),e.withTags&&(r=r.filter(s=>e.withTags.filter(o=>s.tags.has(o)).length===e.withTags.length)),e.withoutTags&&(r=r.filter(s=>e.withoutTags.filter(o=>s.tags.has(o)).length===0)),r},tableSequences:(t,e,n)=>{n.docSet=t.processor.docSets[t.docSetId];let r=Object.values(t.sequences);return r=r.filter(s=>s.type==="table"),e.ids&&(r=r.filter(s=>e.ids.includes(s.id))),e.withTags&&(r=r.filter(s=>e.withTags.filter(o=>s.tags.has(o)).length===e.withTags.length)),e.withoutTags&&(r=r.filter(s=>e.withoutTags.filter(o=>s.tags.has(o)).length===0)),r},treeSequences:(t,e,n)=>{n.docSet=t.processor.docSets[t.docSetId];let r=Object.values(t.sequences);return r=r.filter(s=>s.type==="tree"),e.ids&&(r=r.filter(s=>e.ids.includes(s.id))),e.withTags&&(r=r.filter(s=>e.withTags.filter(o=>s.tags.has(o)).length===e.withTags.length)),e.withoutTags&&(r=r.filter(s=>e.withoutTags.filter(o=>s.tags.has(o)).length===0)),r},kvSequences:(t,e,n)=>{n.docSet=t.processor.docSets[t.docSetId];let r=Object.values(t.sequences);return r=r.filter(s=>s.type==="kv"),e.ids&&(r=r.filter(s=>e.ids.includes(s.id))),e.withTags&&(r=r.filter(s=>e.withTags.filter(o=>s.tags.has(o)).length===e.withTags.length)),e.withoutTags&&(r=r.filter(s=>e.withoutTags.filter(o=>s.tags.has(o)).length===0)),r},textSequences:(t,e,n)=>{n.docSet=t.processor.docSets[t.docSetId];let r=Object.values(t.sequences);return r=r.filter(s=>s.type!=="tree"&&s.type!=="table"&&s.type!=="kv"),e.ids&&(r=r.filter(s=>e.ids.includes(s.id))),e.withTags&&(r=r.filter(s=>e.withTags.filter(o=>s.tags.has(o)).length===e.withTags.length)),e.withoutTags&&(r=r.filter(s=>e.withoutTags.filter(o=>s.tags.has(o)).length===0)),r},sequence:(t,e,n)=>{n.docSet=t.processor.docSets[t.docSetId];let r=Object.values(t.sequences);return r=r.filter(s=>e.id.includes(s.id)),r[0]||null},tableSequence:(t,e,n)=>{n.docSet=t.processor.docSets[t.docSetId];let r=Object.values(t.sequences);if(r=r.filter(s=>e.id.includes(s.id)),r[0]&&r[0].type!=="table")throw new Error(`Expected sequence id ${r[0].id} to be of type 'table', not '${r[0].type}'`);return r[0]||null},treeSequence:(t,e,n)=>{n.docSet=t.processor.docSets[t.docSetId];let r=Object.values(t.sequences);if(r=r.filter(s=>e.id.includes(s.id)),r[0]&&r[0].type!=="tree")throw new Error(`Expected sequence id ${r[0].id} to be of type 'tree', not '${r[0].type}'`);return r[0]||null},kvSequence:(t,e,n)=>{n.docSet=t.processor.docSets[t.docSetId];let r=Object.values(t.sequences);if(r=r.filter(s=>e.id.includes(s.id)),r[0]&&r[0].type!=="vk")throw new Error(`Expected sequence id ${r[0].id} to be of type 'kv', not '${r[0].type}'`);return r[0]||null},mainBlocks:(t,e,n)=>(n.docSet=t.processor.docSets[t.docSetId],t.sequences[t.mainId].blocks),mainBlocksItems:(t,e,n)=>(n.docSet=t.processor.docSets[t.docSetId],t.sequences[t.mainId].blocks.map(r=>n.docSet.unsuccinctifyItems(r.c,{},null))),mainBlocksTokens:(t,e,n)=>(n.docSet=t.processor.docSets[t.docSetId],t.sequences[t.mainId].blocks.map(r=>n.docSet.unsuccinctifyItems(r.c,{tokens:!0},null))),mainBlocksText:(t,e,n)=>(n.docSet=t.processor.docSets[t.docSetId],t.sequences[t.mainId].blocks.map(r=>{let o=n.docSet.unsuccinctifyItems(r.c,{tokens:!0},null).map(i=>i[2]).join("").trim();return e.normalizeSpace&&(o=o.replace(/[ \t\n\r]+/g," ")),o})),mainText:(t,e,n)=>(n.docSet=t.processor.docSets[t.docSetId],t.sequences[t.mainId].blocks.map(r=>{let o=n.docSet.unsuccinctifyItems(r.c,{tokens:!0},null).map(i=>i[2]).join("").trim();return e.normalizeSpace&&(o=o.replace(/[ \t\n\r]+/g," ")),o}).join(`
`)),tags:t=>Array.from(t.tags),tagsKv:t=>Array.from(t.tags).map(e=>e.includes(":")?[e.substring(0,e.indexOf(":")),e.substring(e.indexOf(":")+1)]:[e,""]),hasTag:(t,e)=>t.tags.has(e.tagName),cv:(t,e,n)=>Xi(t,e,n,!1),mappedCv:(t,e,n)=>{if(e.verses.length!==1)throw new Error(`mappedCv expects exactly one verse, not ${e.verses.length}`);return Xi(t,e,n,!0,e.mappedDocSetId)},mappedCvs:(t,e,n)=>{const s=t.chapterVerseIndex(e.chapter).filter(i=>i.length>0).map(i=>i[0].verses);let o=[];for(const i of s)o.push(Xi(t,{...e,verses:[i]},n,!0,e.mappedDocSetId).map(a=>[[`fromChapter/${e.chapter}`,`fromVerse/${i}`,...a[0]],a[1]]));return o},cvNavigation:(t,e)=>[e.chapter,e.verse,t.chapterVerseIndex((parseInt(e.chapter)-1).toString()),t.chapterVerseIndex(e.chapter),t.chapterVerseIndex((parseInt(e.chapter)+1).toString())],cvIndexes:(t,e,n)=>(n.docSet=t.processor.docSets[t.docSetId],n.doc=t,Object.entries(t.chapterVerseIndexes())),cvIndex:(t,e,n)=>(n.docSet=t.processor.docSets[t.docSetId],n.doc=t,[e.chapter,t.chapterVerseIndex(e.chapter)||[]]),cIndexes:(t,e,n)=>(n.docSet=t.processor.docSets[t.docSetId],n.doc=t,Object.entries(t.chapterIndexes())),cIndex:(t,e,n)=>{n.docSet=t.processor.docSets[t.docSetId],n.doc=t;const r=t.chapterIndex(e.chapter);return[e.chapter,r||{}]},cvMatching:(t,e,n)=>{if(!e.withChars&&!e.withMatchingChars&&!e.withScopes)throw new Error("Must specify at least one of withChars or withMatchingChars or withScopes");if(e.withChars&&e.withMatchingChars)throw new Error("Must not specify both withChars and withMatchingChars");n.docSet=t.processor.docSets[t.docSetId];let r;e.withChars&&e.allChars?r=e.withChars.map(u=>B(`^${u}$`)):e.withChars?r=[B.union(e.withChars.map(u=>B(`^${u}$`,"i")))]:e.withMatchingChars&&e.allChars?r=e.withMatchingChars.map(u=>B(u,"i")):e.withMatchingChars&&(r=[B.union(e.withMatchingChars.map(u=>B(u,"i")))]);const s=u=>{for(const c of e.withScopes||[])if(!u.includes(c))return!1;return!0},o=u=>{const c=e.withScopes||[];for(const l of c)if(u.includes(l))return!0;return c.length===0},i=u=>{for(const c of r||[]){let l=!1;for(const p of u)if(B.test(p[2],c)){l=!0;break}if(!l)return!1}return!0};return n.docSet.sequenceItemsByScopes(t.sequences[t.mainId].blocks,["chapter/","verses/"]).filter(u=>(e.allScopes?s:o)(u[1].filter(c=>c[0]==="scope"&&c[1]==="start").map(c=>c[2]))&&i(u[1]))},perf:(t,e)=>t.perf(e.indent),usfm:t=>t.usfm(),sofria:(t,e)=>t.sofria(e.indent,e.chapter)},Lw=(t,e)=>{const n=t.headers.bookCode||"GEN",r=e.headers.bookCode||"GEN",s=Q.canons.ptBooks[n]?Q.canons.ptBooks[n].position:999,o=Q.canons.ptBooks[r]?Q.canons.ptBooks[r].position:999;return s-o},jw=(t,e)=>{const n=t.headers.bookCode||"GEN",r=e.headers.bookCode||"GEN";return n.localeCompare(r)},Gw=(t,e)=>{const n=[1,2,3,4,5,6];let r=t.headers.bookCode||"GEN";n.includes(r[0])&&(r=r.substring(1)+r[0]);let s=e.headers.bookCode||"GEN";return n.includes(s[0])&&(s=s.substring(1)+s[0]),r.localeCompare(s)},Wn={paratext:Lw,alpha:jw,alpha2:Gw},Uw=`
"""A collection of documents that share the same set of selector values"""
type DocSet {
  """The id of the docSet, which is formed by concatenating the docSet's selector values"""
  id: String!
  """The selectors of the docSet"""
  selectors: [KeyValue!]!
  """A selector for this docSet"""
  selector(
    """The id of the selector"""
    id: String!
  ): String!
  """A list of the tags of this docSet"""
  tags: [String!]!
  """A list of the tags of this docSet as key/value tuples"""
  tagsKv: [KeyValue!]!
  """Whether or not the docSet has the specified tag"""
  hasTag(
    """The tag"""
    tagName: String!
  ): Boolean!
  """The documents in the docSet"""
  documents(
    """A whitelist of ids of documents to include"""
    ids: [String!]
    """A whitelist of ids of documents to include"""
    withChars: [String!]
    """Return documents whose main sequence contains a token whose payload is an exact match to one of the specified strings"""
    withMatchingChars: [String!]
    """If true, documents where all search terms match will be included"""
    allChars: Boolean
    """Only return documents where the list of scopes is used"""
    withScopes: [String!]
    """If true, documents where all scopes are found will be included"""
    allScopes: Boolean
    """Only return documents with the specified header key/values"""
    withHeaderValues: [InputKeyValue!]
    """Only return documents with all the specified tags"""
    withTags: [String!]
    """Only return documents with none of the specified tags"""
    withoutTags: [String!]
    """Sort returned documents by the designated method (currently ${Object.keys(Wn).join(", ")})\`"""
    sortedBy: String
  ): [Document!]!
  """The number of documents in the docSet"""
  nDocuments: Int!
  """A document in the docSet, if present"""
  document(
    """The book code of the required document"""
    bookCode: String!
  ): Document
  """Whether the docSet has versification information loaded"""
  hasMapping: Boolean!
  """The internal index number corresponding to a string in a given docSet enum"""
  enumIndexForString(
    """The enum to be searched"""
    enumType: String!
    """The string to match"""
    searchString: String!
  ): Int!
  """Information about internal indexes matching the case-insensitive regex in a given docSet enum"""
  enumRegexIndexesForString(
    """The enum to be searched"""
    enumType: String!
    """The regex to match"""
    searchRegex: String!
  ): [regexIndex!]!
  """A list of wordLike token strings in the docSet"""
  wordLikes(
    """Whether to coerce the strings (toLower|toUpper|none)"""
    coerceCase: String
  ): [String!]!
  """A list of unique characters in the docSet"""
  uniqueChars: [String!]!
  """A string containing the unique characters in the docSet"""
  uniqueCharsString: String!
  }
`,Vw={selectors:t=>Object.entries(t.selectors),selector:(t,e)=>t.selectors[e.id],tags:t=>Array.from(t.tags),tagsKv:t=>Array.from(t.tags).map(e=>e.includes(":")?[e.substring(0,e.indexOf(":")),e.substring(e.indexOf(":")+1)]:[e,""]),hasTag:(t,e)=>t.tags.has(e.tagName),documents:(t,e,n)=>{const r=(o,i)=>{for(const a of i||[])if(!(a.key in o)||o[a.key]!==a.value)return!1;return!0};if(e.withChars&&e.withMatchingChars)throw new Error("Cannot specify both withChars and withMatchingChars");n.docSet=t;let s=t.documents();if(e.ids&&(s=s.filter(o=>e.ids.includes(o.id))),e.withChars&&(s=s.filter(o=>Na(t,o.sequences[o.mainId],e.withChars,e.allChars))),e.withMatchingChars&&(s=s.filter(o=>_a(t,o.sequences[o.mainId],e.withMatchingChars,e.allChars))),e.withScopes){const o=i=>new Set(i.sequences[i.mainId].blocks.map(a=>n.docSet.unsuccinctifyBlockScopeLabelsSet(a)).map(a=>Array.from(a)).reduce((a,u)=>a.concat(u)));s=s.filter(i=>{const a=o(i),u=e.allScopes?e.withScopes.length:1;return e.withScopes.filter(c=>a.has(c)).length>=u})}if(e.withHeaderValues&&(s=s.filter(o=>r(o.headers,e.withHeaderValues))),e.withTags&&(s=s.filter(o=>e.withTags.filter(i=>o.tags.has(i)).length===e.withTags.length)),e.withoutTags&&(s=s.filter(o=>e.withoutTags.filter(i=>o.tags.has(i)).length===0)),e.sortedBy){if(!(e.sortedBy in Wn))throw new Error(`sortedBy value must be one of [${Object.keys(Wn)}], not ${e.sortedBy}`);s.sort(Wn[e.sortedBy])}return s},nDocuments:(t,e,n)=>(n.docSet=t,t.documents().length),document:(t,e)=>t.documentWithBook(e.bookCode),hasMapping:t=>t.tags.has("hasMapping"),enumIndexForString:(t,e)=>Q.enums.enumStringIndex(t.enums[e.enumType],e.searchString),enumRegexIndexesForString:(t,e)=>Q.enums.enumRegexIndexTuples(t.enums[e.enumType],e.searchRegex),wordLikes:(t,e)=>{if(e.coerceCase&&!["toLower","toUpper","none"].includes(e.coerceCase))throw new Error(`coerceCase, when present, must be 'toLower', 'toUpper' or 'none', not '${e.coerceCase}'`);let n=Q.succinct.unpackEnum(t.enums.wordLike);return e.coerceCase==="toLower"&&(n=n.map(r=>r.toLowerCase())),e.coerceCase==="toUpper"&&(n=n.map(r=>r.toUpperCase())),Array.from(new Set(n))},uniqueChars:t=>{const e=new Set([]);for(const n of[...Q.succinct.unpackEnum(t.enums.wordLike),...Q.succinct.unpackEnum(t.enums.notWordLike)])for(const r of n.split(""))e.add(r);return Array.from(e).sort()},uniqueCharsString:t=>{const e=new Set([]);for(const n of[...Q.succinct.unpackEnum(t.enums.wordLike),...Q.succinct.unpackEnum(t.enums.notWordLike)])for(const r of n.split(""))e.add(r);return Array.from(e).sort().join("")}},Jw=`# Versification  "English"
# Version=2.0
#
# modifications by Reinier de Blois 13/March/2012
# modified mappings Psalms by adding verse #0 to the mappings
# many of the subscripts that are part of verses 1,2 in the original text end up as verse #0 in English translations

# modifications by Studge 26/June/2009
# book definitions are for all books printed in any English of Spanish Bible
# this includes books for Protestant, Catholic and Protestant-Catholic-EasternOrthodox Interconfessional editions
#
# This is the versification used by most English (e.g. RSV) and Spanish Bibles (e.g. RVR)
#
# List of books, chapters, verses
# One line per book.
# One entry for each chapter.
# Verse number is the maximum verse number for that chapter.
# See the lines containing ='s below for verse mappings.
#
#--------------------------------------------------
# Old Testament
GEN 1:31 2:25 3:24 4:26 5:32 6:22 7:24 8:22 9:29 10:32 11:32 12:20 13:18 14:24 15:21 16:16 17:27 18:33 19:38 20:18 21:34 22:24 23:20 24:67 25:34 26:35 27:46 28:22 29:35 30:43 31:55 32:32 33:20 34:31 35:29 36:43 37:36 38:30 39:23 40:23 41:57 42:38 43:34 44:34 45:28 46:34 47:31 48:22 49:33 50:26
EXO 1:22 2:25 3:22 4:31 5:23 6:30 7:25 8:32 9:35 10:29 11:10 12:51 13:22 14:31 15:27 16:36 17:16 18:27 19:25 20:26 21:36 22:31 23:33 24:18 25:40 26:37 27:21 28:43 29:46 30:38 31:18 32:35 33:23 34:35 35:35 36:38 37:29 38:31 39:43 40:38
LEV 1:17 2:16 3:17 4:35 5:19 6:30 7:38 8:36 9:24 10:20 11:47 12:8 13:59 14:57 15:33 16:34 17:16 18:30 19:37 20:27 21:24 22:33 23:44 24:23 25:55 26:46 27:34
NUM 1:54 2:34 3:51 4:49 5:31 6:27 7:89 8:26 9:23 10:36 11:35 12:16 13:33 14:45 15:41 16:50 17:13 18:32 19:22 20:29 21:35 22:41 23:30 24:25 25:18 26:65 27:23 28:31 29:40 30:16 31:54 32:42 33:56 34:29 35:34 36:13
DEU 1:46 2:37 3:29 4:49 5:33 6:25 7:26 8:20 9:29 10:22 11:32 12:32 13:18 14:29 15:23 16:22 17:20 18:22 19:21 20:20 21:23 22:30 23:25 24:22 25:19 26:19 27:26 28:68 29:29 30:20 31:30 32:52 33:29 34:12
JOS 1:18 2:24 3:17 4:24 5:15 6:27 7:26 8:35 9:27 10:43 11:23 12:24 13:33 14:15 15:63 16:10 17:18 18:28 19:51 20:9 21:45 22:34 23:16 24:33
JDG 1:36 2:23 3:31 4:24 5:31 6:40 7:25 8:35 9:57 10:18 11:40 12:15 13:25 14:20 15:20 16:31 17:13 18:31 19:30 20:48 21:25
RUT 1:22 2:23 3:18 4:22
1SA 1:28 2:36 3:21 4:22 5:12 6:21 7:17 8:22 9:27 10:27 11:15 12:25 13:23 14:52 15:35 16:23 17:58 18:30 19:24 20:42 21:15 22:23 23:29 24:22 25:44 26:25 27:12 28:25 29:11 30:31 31:13
2SA 1:27 2:32 3:39 4:12 5:25 6:23 7:29 8:18 9:13 10:19 11:27 12:31 13:39 14:33 15:37 16:23 17:29 18:33 19:43 20:26 21:22 22:51 23:39 24:25
1KI 1:53 2:46 3:28 4:34 5:18 6:38 7:51 8:66 9:28 10:29 11:43 12:33 13:34 14:31 15:34 16:34 17:24 18:46 19:21 20:43 21:29 22:53
2KI 1:18 2:25 3:27 4:44 5:27 6:33 7:20 8:29 9:37 10:36 11:21 12:21 13:25 14:29 15:38 16:20 17:41 18:37 19:37 20:21 21:26 22:20 23:37 24:20 25:30
1CH 1:54 2:55 3:24 4:43 5:26 6:81 7:40 8:40 9:44 10:14 11:47 12:40 13:14 14:17 15:29 16:43 17:27 18:17 19:19 20:8 21:30 22:19 23:32 24:31 25:31 26:32 27:34 28:21 29:30
2CH 1:17 2:18 3:17 4:22 5:14 6:42 7:22 8:18 9:31 10:19 11:23 12:16 13:22 14:15 15:19 16:14 17:19 18:34 19:11 20:37 21:20 22:12 23:21 24:27 25:28 26:23 27:9 28:27 29:36 30:27 31:21 32:33 33:25 34:33 35:27 36:23
EZR 1:11 2:70 3:13 4:24 5:17 6:22 7:28 8:36 9:15 10:44
NEH 1:11 2:20 3:32 4:23 5:19 6:19 7:73 8:18 9:38 10:39 11:36 12:47 13:31
EST 1:22 2:23 3:15 4:17 5:14 6:14 7:10 8:17 9:32 10:3
JOB 1:22 2:13 3:26 4:21 5:27 6:30 7:21 8:22 9:35 10:22 11:20 12:25 13:28 14:22 15:35 16:22 17:16 18:21 19:29 20:29 21:34 22:30 23:17 24:25 25:6 26:14 27:23 28:28 29:25 30:31 31:40 32:22 33:33 34:37 35:16 36:33 37:24 38:41 39:30 40:24 41:34 42:17
PSA 1:6 2:12 3:8 4:8 5:12 6:10 7:17 8:9 9:20 10:18 11:7 12:8 13:6 14:7 15:5 16:11 17:15 18:50 19:14 20:9 21:13 22:31 23:6 24:10 25:22 26:12 27:14 28:9 29:11 30:12 31:24 32:11 33:22 34:22 35:28 36:12 37:40 38:22 39:13 40:17 41:13 42:11 43:5 44:26 45:17 46:11 47:9 48:14 49:20 50:23 51:19 52:9 53:6 54:7 55:23 56:13 57:11 58:11 59:17 60:12 61:8 62:12 63:11 64:10 65:13 66:20 67:7 68:35 69:36 70:5 71:24 72:20 73:28 74:23 75:10 76:12 77:20 78:72 79:13 80:19 81:16 82:8 83:18 84:12 85:13 86:17 87:7 88:18 89:52 90:17 91:16 92:15 93:5 94:23 95:11 96:13 97:12 98:9 99:9 100:5 101:8 102:28 103:22 104:35 105:45 106:48 107:43 108:13 109:31 110:7 111:10 112:10 113:9 114:8 115:18 116:19 117:2 118:29 119:176 120:7 121:8 122:9 123:4 124:8 125:5 126:6 127:5 128:6 129:8 130:8 131:3 132:18 133:3 134:3 135:21 136:26 137:9 138:8 139:24 140:13 141:10 142:7 143:12 144:15 145:21 146:10 147:20 148:14 149:9 150:6
PRO 1:33 2:22 3:35 4:27 5:23 6:35 7:27 8:36 9:18 10:32 11:31 12:28 13:25 14:35 15:33 16:33 17:28 18:24 19:29 20:30 21:31 22:29 23:35 24:34 25:28 26:28 27:27 28:28 29:27 30:33 31:31
ECC 1:18 2:26 3:22 4:16 5:20 6:12 7:29 8:17 9:18 10:20 11:10 12:14
SNG 1:17 2:17 3:11 4:16 5:16 6:13 7:13 8:14
ISA 1:31 2:22 3:26 4:6 5:30 6:13 7:25 8:22 9:21 10:34 11:16 12:6 13:22 14:32 15:9 16:14 17:14 18:7 19:25 20:6 21:17 22:25 23:18 24:23 25:12 26:21 27:13 28:29 29:24 30:33 31:9 32:20 33:24 34:17 35:10 36:22 37:38 38:22 39:8 40:31 41:29 42:25 43:28 44:28 45:25 46:13 47:15 48:22 49:26 50:11 51:23 52:15 53:12 54:17 55:13 56:12 57:21 58:14 59:21 60:22 61:11 62:12 63:19 64:12 65:25 66:24
JER 1:19 2:37 3:25 4:31 5:31 6:30 7:34 8:22 9:26 10:25 11:23 12:17 13:27 14:22 15:21 16:21 17:27 18:23 19:15 20:18 21:14 22:30 23:40 24:10 25:38 26:24 27:22 28:17 29:32 30:24 31:40 32:44 33:26 34:22 35:19 36:32 37:21 38:28 39:18 40:16 41:18 42:22 43:13 44:30 45:5 46:28 47:7 48:47 49:39 50:46 51:64 52:34
LAM 1:22 2:22 3:66 4:22 5:22
EZK 1:28 2:10 3:27 4:17 5:17 6:14 7:27 8:18 9:11 10:22 11:25 12:28 13:23 14:23 15:8 16:63 17:24 18:32 19:14 20:49 21:32 22:31 23:49 24:27 25:17 26:21 27:36 28:26 29:21 30:26 31:18 32:32 33:33 34:31 35:15 36:38 37:28 38:23 39:29 40:49 41:26 42:20 43:27 44:31 45:25 46:24 47:23 48:35
DAN 1:21 2:49 3:30 4:37 5:31 6:28 7:28 8:27 9:27 10:21 11:45 12:13
HOS 1:11 2:23 3:5 4:19 5:15 6:11 7:16 8:14 9:17 10:15 11:12 12:14 13:16 14:9
JOL 1:20 2:32 3:21
AMO 1:15 2:16 3:15 4:13 5:27 6:14 7:17 8:14 9:15
OBA 1:21
JON 1:17 2:10 3:10 4:11
MIC 1:16 2:13 3:12 4:13 5:15 6:16 7:20
NAM 1:15 2:13 3:19
HAB 1:17 2:20 3:19
ZEP 1:18 2:15 3:20
HAG 1:15 2:23
ZEC 1:21 2:13 3:10 4:14 5:11 6:15 7:14 8:23 9:17 10:12 11:17 12:14 13:9 14:21
MAL 1:14 2:17 3:18 4:6
#-----------------------------------------------
# New Testament
MAT 1:25 2:23 3:17 4:25 5:48 6:34 7:29 8:34 9:38 10:42 11:30 12:50 13:58 14:36 15:39 16:28 17:27 18:35 19:30 20:34 21:46 22:46 23:39 24:51 25:46 26:75 27:66 28:20
MRK 1:45 2:28 3:35 4:41 5:43 6:56 7:37 8:38 9:50 10:52 11:33 12:44 13:37 14:72 15:47 16:20
LUK 1:80 2:52 3:38 4:44 5:39 6:49 7:50 8:56 9:62 10:42 11:54 12:59 13:35 14:35 15:32 16:31 17:37 18:43 19:48 20:47 21:38 22:71 23:56 24:53
JHN 1:51 2:25 3:36 4:54 5:47 6:71 7:53 8:59 9:41 10:42 11:57 12:50 13:38 14:31 15:27 16:33 17:26 18:40 19:42 20:31 21:25
ACT 1:26 2:47 3:26 4:37 5:42 6:15 7:60 8:40 9:43 10:48 11:30 12:25 13:52 14:28 15:41 16:40 17:34 18:28 19:41 20:38 21:40 22:30 23:35 24:27 25:27 26:32 27:44 28:31
ROM 1:32 2:29 3:31 4:25 5:21 6:23 7:25 8:39 9:33 10:21 11:36 12:21 13:14 14:23 15:33 16:27
1CO 1:31 2:16 3:23 4:21 5:13 6:20 7:40 8:13 9:27 10:33 11:34 12:31 13:13 14:40 15:58 16:24
#2CO 1:24 2:17 3:18 4:18 5:21 6:18 7:16 8:24 9:15 10:18 11:33 12:21 13:14
# Note sometimes 2CO 13 has 14 verses e.g. KJV. but 13 verses in modern translations
2CO 1:24 2:17 3:18 4:18 5:21 6:18 7:16 8:24 9:15 10:18 11:33 12:21 13:14
GAL 1:24 2:21 3:29 4:31 5:26 6:18
EPH 1:23 2:22 3:21 4:32 5:33 6:24
PHP 1:30 2:30 3:21 4:23
COL 1:29 2:23 3:25 4:18
1TH 1:10 2:20 3:13 4:18 5:28
2TH 1:12 2:17 3:18
1TI 1:20 2:15 3:16 4:16 5:25 6:21
2TI 1:18 2:26 3:17 4:22
TIT 1:16 2:15 3:15
PHM 1:25
HEB 1:14 2:18 3:19 4:16 5:14 6:20 7:28 8:13 9:28 10:39 11:40 12:29 13:25
JAS 1:27 2:26 3:18 4:17 5:20
1PE 1:25 2:25 3:22 4:19 5:14
2PE 1:21 2:22 3:18
1JN 1:10 2:29 3:24 4:21 5:21
2JN 1:13
3JN 1:15
JUD 1:25
REV 1:20 2:29 3:22 4:11 5:14 6:17 7:17 8:13 9:21 10:11 11:19 12:18 13:18 14:20 15:8 16:21 17:18 18:24 19:21 20:15 21:27 22:21
# sometimes called the Apocalypse
#---------------------------------------------------------
# Deuterocanonical books
TOB 1:22 2:14 3:17 4:21 5:21 6:17 7:18 8:21 9:6 10:13 11:19 12:22 13:18 14:15
JDT 1:16 2:28 3:10 4:15 5:24 6:21 7:32 8:36 9:14 10:23 11:23 12:20 13:20 14:19 15:13 16:25
#-----------------------
# This is the definition for "Additions to Daniel" as in the KJV [Studge]
# ESG 1:13 2:12 3:6 4:18 5:19 6:16 7:24
# more commonly UBS Bibles have ESG which is the full Esther Greek for modern Bibles e.g. RSV, CEV, GNB etc
ESG 1:39 2:23 3:22 4:47 5:28 6:14 7:10 8:39 9:32 10:13
#-----------------------
WIS 1:16 2:24 3:19 4:20 5:23 6:25 7:30 8:21 9:18 10:21 11:26 12:27 13:19 14:31 15:19 16:29 17:21 18:25 19:22
SIR 1:30 2:18 3:31 4:31 5:15 6:37 7:36 8:19 9:18 10:31 11:34 12:18 13:26 14:27 15:20 16:30 17:32 18:33 19:30 20:32 21:28 22:27 23:27 24:34 25:26 26:29 27:30 28:26 29:28 30:25 31:31 32:24 33:31 34:26 35:20 36:26 37:31 38:34 39:35 40:30 41:23 42:25 43:33 44:23 45:26 46:20 47:25 48:25 49:16 50:29 51:30
#
# In English Bibles Baruch sometimes has 5 chapters and sometimes 6 in Catholic Bibles [Studge]
BAR 1:21 2:35 3:37 4:37 5:9 6:73
#
LJE 1:73
S3Y 1:68
SUS 1:64
BEL 1:42
1MA 1:64 2:70 3:60 4:61 5:68 6:63 7:50 8:32 9:73 10:89 11:74 12:53 13:53 14:49 15:41 16:24
2MA 1:36 2:32 3:40 4:50 5:27 6:31 7:42 8:36 9:29 10:38 11:38 12:45 13:26 14:46 15:39
#-----------------------------------------------------
# Additional Orthodox Books in Interconfessional Bibles e.g. RSV, NRSV
3MA 1:29 2:33 3:30 4:21 5:51 6:41 7:23
4MA 1:35 2:24 3:21 4:26 5:38 6:35 7:23 8:29 9:32 10:21 11:27 12:19 13:27 14:20 15:32 16:25 17:24 18:24
1ES 1:58 2:30 3:24 4:63 5:73 6:34 7:15 8:96 9:55
2ES 1:40 2:48 3:36 4:52 5:56 6:59 7:140 8:63 9:47 10:59 11:46 12:51 13:58 14:48 15:63 16:78
MAN 1:15
PS2 1:7
#-----------------------------------------------------
# ODA and PSS are only used in LXX and SYR projects and are not needed here
# ODA 1:19 2:43 3:10 4:19 5:12 6:8 7:20 8:37 9:22 10:9 11:11 12:15 13:4 14:46
# PSS 1:8 2:37 3:12 4:25 5:19 6:6 7:10 8:34 9:11 10:8 11:9 12:6 13:12 14:10 15:13 16:15 17:46 18:12
#-----------------------------------------------------
# Obselete books used for LXX variant texts, in LXX only in PT 6, and obselete in PT 7, not used in English, Spanish or any other Bibles.  If these codes were used they were used for the wrong books and these definitions were not relevant
JSA 1:18 2:24 3:17 4:24 5:15 6:27 7:26 8:35 9:27 10:43 11:23 12:24 13:33 14:15 15:63 16:10 17:18 18:28 19:51 20:9 21:45 22:34 23:16 24:33
JDB 1:36 2:23 3:31 4:24 5:31 6:40 7:25 8:35 9:57 10:18 11:40 12:15 13:25 14:20 15:20 16:31 17:13 18:31 19:30 20:48 21:25
TBS 1:22 2:14 3:17 4:21 5:23 6:19 7:17 8:21 9:6 10:14 11:19 12:22 13:18 14:15
SST 1:64
DNT 1:21 2:49 3:97 4:37 5:30 6:29 7:28 8:27 9:27 10:21 11:45 12:13
BLT 1:42
#------------------------------------------------------
# Daniel Greek used in some English Catholic Bibles
DAG 1:21 2:49 3:97 4:37 5:31 6:28 7:28 8:27 9:27 10:21 11:45 12:13 13:64 14:42
# Letter to the Laodiceans which was in the John Wycliffe Bible
LAO 1:20
#
#-----------------------------------------------------
# Mapping
#-----------------------------------------------------
# English = BHS (see org.vrs)
#
# (Note: ranges must not span a chapter, e.g. 4:10-5:11 is illegal)
#
GEN 31:55 = GEN 32:1
GEN 32:1-32 = GEN 32:2-33
EXO 8:1-4 = EXO 7:26-29
EXO 8:5-32 = EXO 8:1-28
EXO 22:1 = EXO 21:37
EXO 22:2-31 = EXO 22:1-30
LEV 6:1-7 = LEV 5:20-26
LEV 6:8-30 = LEV 6:1-23
NUM 16:36-50 = NUM 17:1-15
NUM 17:1-13 = NUM 17:16-28
# NUM 26:1a = NUM 25:19b  # no support for splits yet
# NUM 26:1b = NUM 26:1  # no support for splits yet
NUM 29:40 = NUM 30:1
NUM 30:1-16 = NUM 30:2-17
DEU 12:32 = DEU 13:1
DEU 13:1-18 = DEU 13:2-19
DEU 22:30 = DEU 23:1
DEU 23:1-25 = DEU 23:2-26
DEU 29:1 = DEU 28:69
DEU 29:2-29 = DEU 29:1-28
#
# removed see PTSIL-113
#1SA 20:42 = 1SA 20:41
#
1SA 20:42 = 1SA 21:1
1SA 21:1-15 = 1SA 21:2-16
1SA 23:29 = 1SA 24:1
1SA 24:1-22 = 1SA 24:2-23
2SA 18:33 = 2SA 19:1
2SA 19:1-43 = 2SA 19:2-44
1KI 4:21-34 = 1KI 5:1-14
1KI 5:1-18 = 1KI 5:15-32
# 1KI 18:33a = 1KI 18:33  # no support for splits yet
# 1KI 18:33b = 1KI 18:34  # no support for splits yet
# 1KI 22:43a = 1KI 22:43b  # no support for splits yet
1KI 22:43-53 = 1KI 22:44-54
2KI 11:21 = 2KI 12:1
2KI 12:1-21 = 2KI 12:2-22
1CH 6:1-15 = 1CH 5:27-41
1CH 6:16-81 = 1CH 6:1-66
# 1CH 12:4b = 1CH 12:4  # no support for splits yet
1CH 12:4-40 = 1CH 12:5-41
2CH 2:1 = 2CH 1:18
2CH 2:2-18 = 2CH 2:1-17
2CH 14:1 = 2CH 13:23
2CH 14:2-15 = 2CH 14:1-14
NEH 4:1-6 = NEH 3:33-38
NEH 4:7-23 = NEH 4:1-17
NEH 7:69-73 = NEH 7:68-72
NEH 9:38 = NEH 10:1
NEH 10:1-39 = NEH 10:2-40
JOB 41:1-8 = JOB 40:25-32
JOB 41:9-34 = JOB 41:1-26
PSA 3:0-8 = PSA 3:1-9
PSA 4:0-8 = PSA 4:1-9
PSA 5:0-12 = PSA 5:1-13
PSA 6:0-10 = PSA 6:1-11
PSA 7:0-17 = PSA 7:1-18
PSA 8:0-9 = PSA 8:1-10
PSA 9:0-20 = PSA 9:1-21
PSA 12:0-8 = PSA 12:1-9
PSA 13:0-5 = PSA 13:1-6
PSA 18:0-50 = PSA 18:1-51
PSA 19:0-14 = PSA 19:1-15
PSA 20:0-9 = PSA 20:1-10
PSA 21:0-13 = PSA 21:1-14
PSA 22:0-31 = PSA 22:1-32
PSA 30:0-12 = PSA 30:1-13
PSA 31:0-24 = PSA 31:1-25
PSA 34:0-22 = PSA 34:1-23
PSA 36:0-12 = PSA 36:1-13
PSA 38:0-22 = PSA 38:1-23
PSA 39:0-13 = PSA 39:1-14
PSA 40:0-17 = PSA 40:1-18
PSA 41:0-13 = PSA 41:1-14
PSA 42:0-11 = PSA 42:1-12
PSA 44:0-26 = PSA 44:1-27
PSA 45:0-17 = PSA 45:1-18
PSA 46:0-11 = PSA 46:1-12
PSA 47:0-9 = PSA 47:1-10
PSA 48:0-14 = PSA 48:1-15
PSA 49:0-20 = PSA 49:1-21
PSA 51:0 = PSA 51:1
PSA 51:0 = PSA 51:2
PSA 51:1-19 = PSA 51:3-21
PSA 52:0 = PSA 52:1
PSA 52:0 = PSA 52:2
PSA 52:1-9 = PSA 52:3-11
PSA 53:0-6 = PSA 53:1-7
PSA 54:0 = PSA 54:1
PSA 54:0 = PSA 54:2
PSA 54:1-7 = PSA 54:3-9
PSA 55:0-23 = PSA 55:1-24
PSA 56:0-13 = PSA 56:1-14
PSA 57:0-11 = PSA 57:1-12
PSA 58:0-11 = PSA 58:1-12
PSA 59:0-17 = PSA 59:1-18
PSA 60:0 = PSA 60:1
PSA 60:0 = PSA 60:2
PSA 60:1-12 = PSA 60:3-14
PSA 61:0-8 = PSA 61:1-9
PSA 62:0-12 = PSA 62:1-13
PSA 63:0-11 = PSA 63:1-12
PSA 64:0-10 = PSA 64:1-11
PSA 65:0-13 = PSA 65:1-14
PSA 67:0-7 = PSA 67:1-8
PSA 68:0-35 = PSA 68:1-36
PSA 69:0-36 = PSA 69:1-37
PSA 70:0-5 = PSA 70:1-6
PSA 75:0-10 = PSA 75:1-11
PSA 76:0-12 = PSA 76:1-13
PSA 77:0-20 = PSA 77:1-21
PSA 80:0-19 = PSA 80:1-20
PSA 81:0-16 = PSA 81:1-17
PSA 83:0-18 = PSA 83:1-19
PSA 84:0-12 = PSA 84:1-13
PSA 85:0-13 = PSA 85:1-14
PSA 88:0-18 = PSA 88:1-19
PSA 89:0-52 = PSA 89:1-53
PSA 92:0-15 = PSA 92:1-16
PSA 102:0-28 = PSA 102:1-29
PSA 108:0-13 = PSA 108:1-14
PSA 140:0-13 = PSA 140:1-14
PSA 142:0-7 = PSA 142:1-8
ECC 5:1 = ECC 4:17
ECC 5:2-20 = ECC 5:1-19
SNG 6:13 = SNG 7:1
SNG 7:1-13 = SNG 7:2-14
ISA 9:1 = ISA 8:23
ISA 9:2-21 = ISA 9:1-20
ISA 64:2-12 = ISA 64:1-11
JER 9:1 = JER 8:23
JER 9:2-26 = JER 9:1-25
EZK 20:45-46 = EZK 21:1-2
EZK 20:47 = EZK 21:3
EZK 20:48-49 = EZK 21:4-5
EZK 21:1-32 = EZK 21:6-37
DAN 4:1-3 = DAN 3:31-33
DAN 4:4-37 = DAN 4:1-34
DAN 5:31 = DAN 6:1
DAN 6:1-28 = DAN 6:2-29
HOS 1:10-11 = HOS 2:1-2
HOS 2:1-23 = HOS 2:3-25
HOS 11:12 = HOS 12:1
HOS 12:1-14 = HOS 12:2-15
HOS 13:16 = HOS 14:1
HOS 14:1-9 = HOS 14:2-10
JOL 2:28-32 = JOL 3:1-5
JOL 3:1-21 = JOL 4:1-21
JON 1:17 = JON 2:1
JON 2:1-10 = JON 2:2-11
MIC 5:1 = MIC 4:14
MIC 5:2-15 = MIC 5:1-14
NAM 1:15 = NAM 2:1
NAM 2:1-13 = NAM 2:2-14
ZEC 1:18-21 = ZEC 2:1-4
ZEC 2:1-13 = ZEC 2:5-17
MAL 4:1-6 = MAL 3:19-24
# 40 + 41 -> 40 (per Peter Kirk)
#! &ACT 19:40-41 = ACT 19:40
#
#---------------------------------
# map Baruch 6 onto Letter of Jeremiah [Studge]
BAR 6:1-73 = LJE 1:1-73
#
#------------------------------
# Susanna
DAG 13:1-63 = SUS 1:1-63
# Bel and the Dragon
DAG 14:1-42 = BEL 1:1-42
#----------------------------------
# Mapping Esther Greek onto LXX Esther Greek
#
# This maps the standard verses generated by Create Book
# to the actual verse numbers and segments found in the LXX
# ESG chapter 1
ESG 1:1 = ESG 1:1a
ESG 1:2 = ESG 1:1b
ESG 1:3 = ESG 1:1c
ESG 1:4 = ESG 1:1d
ESG 1:5 = ESG 1:1e
ESG 1:6 = ESG 1:1f
ESG 1:7 = ESG 1:1g
ESG 1:8 = ESG 1:1h
ESG 1:9 = ESG 1:1i
ESG 1:10 = ESG 1:1k
ESG 1:11 = ESG 1:1l
ESG 1:12 = ESG 1:1m
ESG 1:13 = ESG 1:1n
ESG 1:14 = ESG 1:1o
ESG 1:15 = ESG 1:1p
ESG 1:16 = ESG 1:1q
ESG 1:17 = ESG 1:1r
ESG 1:18 = ESG 1:1s
ESG 1:19-39 = ESG 1:2-22
# ESG chapter 3
ESG 3:14 = ESG 3:13a
ESG 3:15 = ESG 3:13b
ESG 3:16 = ESG 3:13c
ESG 3:17 = ESG 3:13d
ESG 3:18 = ESG 3:13e
ESG 3:19 = ESG 3:13f
ESG 3:20 = ESG 3:13g
ESG 3:21 = ESG 3:14
ESG 3:22 = ESG 3:15
# ESG chapter 4
ESG 4:18 = ESG 4:17a
ESG 4:19 = ESG 4:17b
ESG 4:20 = ESG 4:17c
ESG 4:21 = ESG 4:17c
ESG 4:22 = ESG 4:17d
ESG 4:23 = ESG 4:17d
ESG 4:24 = ESG 4:17e
ESG 4:25 = ESG 4:17f
ESG 4:26 = ESG 4:17g
ESG 4:27 = ESG 4:17h
ESG 4:28 = ESG 4:17i
ESG 4:29 = ESG 4:17k
ESG 4:30 = ESG 4:17k
ESG 4:31 = ESG 4:17k
ESG 4:32 = ESG 4:17l
ESG 4:33 = ESG 4:17m
ESG 4:34 = ESG 4:17n
ESG 4:35 = ESG 4:17n
ESG 4:36 = ESG 4:17o
ESG 4:37 = ESG 4:17o
ESG 4:38 = ESG 4:17p
ESG 4:39 = ESG 4:17q
ESG 4:40 = ESG 4:17r
ESG 4:41 = ESG 4:17s
ESG 4:42 = ESG 4:17t
ESG 4:43 = ESG 4:17u
ESG 4:44 = ESG 4:17w
ESG 4:45 = ESG 4:17x
ESG 4:46 = ESG 4:17y
ESG 4:47 = ESG 4:17z
# ESG chapter 5
ESG 5:2 = ESG 5:1a
ESG 5:3 = ESG 5:1a
ESG 5:4 = ESG 5:1a
ESG 5:5 = ESG 5:1b
ESG 5:6 = ESG 5:1c
ESG 5:7 = ESG 5:1d
ESG 5:8 = ESG 5:1e
ESG 5:9 = ESG 5:1f
ESG 5:10 = ESG 5:1f
ESG 5:11 = ESG 5:2
ESG 5:12 = ESG 5:2
ESG 5:13 = ESG 5:2a
ESG 5:14 = ESG 5:2a
ESG 5:15 = ESG 5:2b
ESG 5:16 = ESG 5:2b
ESG 5:17-28 = ESG 5:3-14
# ESG chapter 8
ESG 8:13 = ESG 8:12a
ESG 8:14 = ESG 8:12b
ESG 8:15 = ESG 8:12c
ESG 8:16 = ESG 8:12d
ESG 8:17 = ESG 8:12e
ESG 8:18 = ESG 8:12f
ESG 8:19 = ESG 8:12g
ESG 8:20 = ESG 8:12h
ESG 8:21 = ESG 8:12i
ESG 8:22 = ESG 8:12k
ESG 8:23 = ESG 8:12l
ESG 8:24 = ESG 8:12m
ESG 8:25 = ESG 8:12n
ESG 8:26 = ESG 8:12o
ESG 8:27 = ESG 8:12p
ESG 8:28 = ESG 8:12q
ESG 8:29 = ESG 8:12r
ESG 8:30 = ESG 8:12s
ESG 8:31 = ESG 8:12t
ESG 8:32 = ESG 8:12u
ESG 8:33 = ESG 8:12x
ESG 8:34 = ESG 8:12y
ESG 8:35 = ESG 8:12y
ESG 8:36 = ESG 8:12y
ESG 8:37-41 = ESG 8:13-17
# ESG chapter 10
ESG 10:4 = ESG 10:3a
ESG 10:5 = ESG 10:3b
ESG 10:6 = ESG 10:3c
ESG 10:7 = ESG 10:3d
ESG 10:8 = ESG 10:3e
ESG 10:9 = ESG 10:3f
ESG 10:10 = ESG 10:3g
ESG 10:11 = ESG 10:3h
ESG 10:12 = ESG 10:3i
ESG 10:13 = ESG 10:3k
ESG 10:14 = ESG 10:3l
# S3Y is a small section of the DAG LXX pulled out and translated as a separate book.
# Map it back to the LXX.  This section allow's texts such as TOB (French) which do
# this to scroll correctly with the LXX.
# S3Y is not present in the GRK, HEB, or LXX(Ralphs) text.
# If a text has DAG present, this section must NOT be included in its versification file because
# that would cause references in other texts to DAG to be redirected to a non-existant S3Y.
S3Y 1:1-29 = DAG 3:24-52
S3Y 1:30-31 = DAG 3:52-53
S3Y 1:33 = DAG 3:54
S3Y 1:32 = DAG 3:55
S3Y 1:34-35 = DAG 3:56-57
S3Y 1:37 = DAG 3:58
S3Y 1:36 = DAG 3:59
S3Y 1:38-68 = DAG 3:60-90
`,Hw=`# Versification  "Septuagint"
# Version=1.7
# 
# modifications by Studge 26/ June/ 2009
# This should include the versifications for Bibles which follow LXX versificatio mainly Orthodox Bibles. [Studge]
#
# List of books, chapters, verses
# One line per book.
# One entry for each chapter.
# Verse number is the maximum verse number for that chapter.
# See the lines containing ='s below for verse mappings.
#
# modifications by Reinier 20/ April/ 2010
# all data that are not part of the LXX itself have been commented out with ##
#
# modifications by Michael Lothers 1/ June/ 2011
# added verse segment information in the format: *GEN 1:22,-,a,b
# which indicates GEN 1:22 has three segments, the first has no marking followed by two segments: 1a and 1b
# The lines are preceded by #! so that versions of Paratext prior to 7.3 will ignore them rather than crash.
#
# modifications by Tim Steenwyk 15/ September/ 2011
# removed mapping references to PS3 since they shouldn't be in LXX (Septuagint)
#------------------------------------------------
# Old Testament
GEN 1:31 2:25 3:24 4:26 5:32 6:22 7:24 8:22 9:29 10:32 11:32 12:20 13:18 14:24 15:21 16:16 17:27 18:33 19:38 20:18 21:34 22:24 23:20 24:67 25:34 26:35 27:46 28:22 29:35 30:43 31:54 32:33 33:20 34:31 35:29 36:43 37:36 38:30 39:23 40:23 41:57 42:38 43:34 44:34 45:28 46:34 47:31 48:22 49:33 50:26
EXO 1:22 2:25 3:22 4:31 5:23 6:30 7:29 8:28 9:35 10:29 11:10 12:51 13:22 14:31 15:27 16:36 17:16 18:27 19:25 20:26 21:37 22:30 23:33 24:18 25:40 26:37 27:21 28:43 29:46 30:38 31:18 32:35 33:23 34:35 35:35 36:38 37:21 38:27 39:23 40:38
LEV 1:17 2:16 3:17 4:35 5:26 6:23 7:38 8:36 9:24 10:20 11:47 12:8 13:59 14:57 15:33 16:34 17:16 18:30 19:37 20:27 21:24 22:33 23:44 24:23 25:55 26:46 27:34
NUM 1:54 2:34 3:51 4:49 5:31 6:26 7:89 8:26 9:23 10:36 11:35 12:16 13:33 14:45 15:41 16:35 17:28 18:32 19:22 20:29 21:35 22:41 23:30 24:25 25:18 26:65 27:23 28:31 29:39 30:17 31:54 32:42 33:56 34:29 35:34 36:13
DEU 1:46 2:37 3:29 4:49 5:33 6:25 7:26 8:20 9:29 10:22 11:32 12:31 13:19 14:29 15:23 16:22 17:20 18:22 19:21 20:20 21:23 22:29 23:26 24:22 25:19 26:19 27:26 28:69 29:28 30:20 31:30 32:52 33:29 34:12
JOS 1:18 2:24 3:17 4:24 5:15 6:27 7:26 8:29 9:27 10:42 11:23 12:24 13:32 14:15 15:63 16:10 17:18 18:28 19:51 20:9 21:45 22:34 23:16 24:33
JDG 1:36 2:23 3:31 4:24 5:31 6:40 7:25 8:35 9:57 10:18 11:40 12:15 13:25 14:20 15:20 16:31 17:13 18:31 19:30 20:48 21:25
RUT 1:22 2:23 3:18 4:22
1SA 1:28 2:36 3:21 4:22 5:12 6:21 7:17 8:22 9:27 10:27 11:15 12:25 13:23 14:52 15:35 16:23 17:54 18:29 19:24 20:42 21:16 22:23 23:28 24:23 25:44 26:25 27:12 28:25 29:11 30:31 31:13
# 1SA called 1 Kings in the Orthodox tradition
2SA 1:27 2:32 3:39 4:12 5:25 6:23 7:29 8:18 9:13 10:19 11:27 12:31 13:39 14:33 15:37 16:23 17:29 18:32 19:44 20:26 21:22 22:51 23:39 24:25
# 2SA called 2 Kings in the Orthodox tradition
1KI 1:53 2:46 3:28 4:19 5:32 6:36 7:50 8:66 9:28 10:29 11:43 12:33 13:34 14:31 15:34 16:34 17:24 18:46 19:21 20:29 21:43 22:54
# 1KI called 3 Kings in the Orthodox tradition
2KI 1:18 2:25 3:27 4:44 5:27 6:33 7:20 8:29 9:37 10:36 11:20 12:22 13:25 14:29 15:38 16:20 17:41 18:37 19:37 20:21 21:26 22:20 23:37 24:20 25:30
# 2KI called 4 Kings in the Orthodox tradition
1CH 1:54 2:55 3:24 4:43 5:41 6:66 7:40 8:40 9:44 10:14 11:47 12:41 13:14 14:17 15:29 16:43 17:27 18:17 19:19 20:8 21:30 22:19 23:32 24:31 25:31 26:32 27:34 28:21 29:30
2CH 1:18 2:17 3:17 4:22 5:14 6:42 7:22 8:18 9:31 10:19 11:23 12:16 13:23 14:14 15:19 16:14 17:19 18:34 19:11 20:37 21:20 22:12 23:21 24:27 25:28 26:23 27:9 28:27 29:36 30:27 31:21 32:33 33:25 34:33 35:27 36:23
#
# Edited by Studge
# Added EZR which is Ezra-Nehemiah, which had been put under 2ES by mistake
# Edited chapters 13 and 20 / SS 14.6.2014
EZR 1:11 2:70 3:13 4:24 5:17 6:22 7:28 8:36 9:15 10:44 11:11 12:20 13:37 14:23 15:19 16:19 17:73 18:18 19:38 20:40 21:36 22:47 23:31
#
# most projects based on LXX will use Nehemiah so we ought to add it in.
##NEH 1:11 2:20 3:32 4:23 5:19 6:19 7:73 8:18 9:38 10:39 11:36 12:47 13:31
#
# Edited by Studge
# should not have ESG here but amongst the Deuterocanonical books for PT order
# ESG 1:22 2:23 3:15 4:17 5:14 6:14 7:10 8:17 9:32 10:3
#
JOB 1:22 2:13 3:26 4:21 5:27 6:30 7:21 8:22 9:35 10:22 11:20 12:25 13:28 14:22 15:35 16:22 17:16 18:21 19:29 20:29 21:34 22:30 23:17 24:25 25:6 26:14 27:23 28:28 29:25 30:31 31:40 32:22 33:33 34:37 35:16 36:33 37:24 38:41 39:30 40:32 41:26 42:17
PSA 1:6 2:12 3:9 4:9 5:13 6:11 7:18 8:10 9:39 10:7 11:9 12:6 13:7 14:5 15:11 16:15 17:51 18:15 19:10 20:14 21:32 22:6 23:10 24:22 25:12 26:14 27:9 28:11 29:13 30:25 31:11 32:22 33:23 34:28 35:13 36:40 37:23 38:14 39:18 40:14 41:12 42:5 43:27 44:18 45:12 46:10 47:15 48:21 49:23 50:21 51:11 52:7 53:9 54:24 55:14 56:12 57:12 58:18 59:14 60:9 61:13 62:12 63:11 64:14 65:20 66:8 67:36 68:37 69:6 70:24 71:20 72:28 73:23 74:11 75:13 76:21 77:72 78:13 79:20 80:17 81:8 82:19 83:13 84:14 85:17 86:7 87:19 88:53 89:17 90:16 91:16 92:5 93:23 94:11 95:13 96:12 97:9 98:9 99:5 100:8 101:29 102:22 103:35 104:45 105:48 106:43 107:14 108:31 109:7 110:10 111:10 112:9 113:26 114:9 115:10 116:2 117:29 118:176 119:7 120:8 121:9 122:4 123:8 124:5 125:6 126:5 127:6 128:8 129:8 130:3 131:18 132:3 133:3 134:21 135:26 136:9 137:8 138:24 139:14 140:10 141:8 142:12 143:15 144:21 145:10 146:11 147:9 148:14 149:9 150:6 151:7
# Psalms has 151 psalms in the Septuagint tradition
PRO 1:33 2:22 3:35 4:27 5:23 6:35 7:27 8:36 9:18 10:32 11:31 12:28 13:25 14:35 15:33 16:33 17:28 18:22 19:29 20:30 21:31 22:29 23:35 24:34 25:28 26:28 27:27 28:28 29:27 30:33 31:31
ECC 1:18 2:26 3:22 4:17 5:19 6:12 7:29 8:17 9:18 10:20 11:10 12:14
SNG 1:17 2:17 3:11 4:16 5:16 6:12 7:14 8:14
ISA 1:31 2:21 3:26 4:6 5:30 6:13 7:25 8:23 9:20 10:34 11:16 12:6 13:22 14:32 15:9 16:14 17:14 18:7 19:25 20:6 21:17 22:25 23:18 24:23 25:12 26:21 27:13 28:29 29:24 30:33 31:9 32:20 33:24 34:17 35:10 36:22 37:38 38:22 39:8 40:31 41:29 42:25 43:28 44:28 45:25 46:13 47:15 48:22 49:26 50:11 51:23 52:15 53:12 54:17 55:13 56:11 57:21 58:14 59:21 60:22 61:11 62:12 63:19 64:11 65:25 66:24
#
# Edited by SS 25.3.2003
# Original: JER 1:19 2:37 3:25 4:31 5:31 6:30 7:34 8:23 9:25 10:25 11:23 12:17 13:27 14:22 15:21 16:21 17:27 18:23 19:15 20:18 21:14 22:30 23:40 24:10 25:38 26:24 27:22 28:17 29:32 30:24 31:40 32:44 33:26 34:22 35:19 36:32 37:21 38:28 39:18 40:16 41:18 42:22 43:13 44:30 45:5 46:28 47:7 48:47 49:39 50:46 51:64 52:34
#
JER 1:19 2:37 3:25 4:31 5:31 6:30 7:34 8:23 9:25 10:25 11:23 12:17 13:27 14:22 15:21 16:21 17:27 18:23 19:15 20:18 21:14 22:30 23:40 24:10 25:20 26:28 27:46 28:64 29:7 30:33 31:44 32:38 33:24 34:22 35:17 36:32 37:24 38:40 39:44 40:13 41:22 42:19 43:32 44:21 45:28 46:18 47:16 48:18 49:22 50:13 51:35 52:34
LAM 1:22 2:22 3:66 4:22 5:22
EZK 1:28 2:10 3:27 4:17 5:17 6:14 7:27 8:18 9:11 10:22 11:25 12:28 13:23 14:23 15:8 16:63 17:24 18:32 19:14 20:44 21:37 22:31 23:49 24:27 25:17 26:21 27:36 28:26 29:21 30:26 31:18 32:32 33:33 34:31 35:15 36:38 37:28 38:23 39:29 40:49 41:26 42:20 43:27 44:31 45:25 46:24 47:23 48:35
#
# There really should not be an entry for DAN in the LXX.vrs. All this material should be in DAG to match Ralhfs.
# However, there are no doubt many projects that incorrectly but the material in DAN so we leave this here
# for backward compatibility
# Following line commented out and DAG-DAN mapping brought up from end of file to allow DAG text to sychronize with HEB where they match
# Edited by Sarah Lind Oct 6 2015
# DAN 1:21 2:49 3:97 4:37 5:30 6:29 7:28 8:27 9:27 10:21 11:45 12:13
DAG 1:1-21 = DAN 1:1-21 
DAG 2:1-49 = DAN 2:1-49
DAG 3:1-23 = DAN 3:1-23
DAG 3:91-97 = DAN 3:24-30
DAG 4:1-3 = DAN 3:31-33
DAG 4:4-37 = DAN 4:1-34
DAG 4:1-2 = DAN 4:4-5
DAG 5:1-30 = DAN 5:1-30
DAG 6:1-29 = DAN 6:1-29
DAG 7:1-28 = DAN 7:1-28
DAG 8:1-27 = DAN 8:1-27
DAG 9:1-27 = DAN 9:1-27
DAG 10:1-21 = DAN 10:1-21
DAG 11:1-45 = DAN 11:1-45
DAG 12:1-13 = DAN 12:1-13
#
HOS 1:9 2:25 3:5 4:19 5:15 6:11 7:16 8:14 9:17 10:15 11:11 12:15 13:15 14:10
JOL 1:20 2:27 3:5 4:21
AMO 1:15 2:16 3:15 4:13 5:27 6:14 7:17 8:14 9:15
OBA 1:21
JON 1:16 2:11 3:10 4:11
MIC 1:16 2:13 3:12 4:14 5:14 6:16 7:20
NAM 1:14 2:14 3:19
HAB 1:17 2:20 3:19
ZEP 1:18 2:15 3:20
HAG 1:15 2:23
ZEC 1:17 2:17 3:10 4:14 5:11 6:15 7:14 8:23 9:17 10:12 11:17 12:14 13:9 14:21
MAL 1:14 2:17 3:24
#
#  It feels a bit odd to include NT in "Septuagint" but I think there are
#  Bibles that follow the _versification_ of OT LXX but also have a NT.
#
# ------------------------------------------------------
# New Testament books
MAT 1:25 2:23 3:17 4:25 5:48 6:34 7:29 8:34 9:38 10:42 11:30 12:50 13:58 14:36 15:39 16:28 17:27 18:35 19:30 20:34 21:46 22:46 23:39 24:51 25:46 26:75 27:66 28:20
MRK 1:45 2:28 3:35 4:41 5:43 6:56 7:37 8:38 9:50 10:52 11:33 12:44 13:37 14:72 15:47 16:20
LUK 1:80 2:52 3:38 4:44 5:39 6:49 7:50 8:56 9:62 10:42 11:54 12:59 13:35 14:35 15:32 16:31 17:37 18:43 19:48 20:47 21:38 22:71 23:56 24:53
JHN 1:51 2:25 3:36 4:54 5:47 6:71 7:53 8:59 9:41 10:42 11:57 12:50 13:38 14:31 15:27 16:33 17:26 18:40 19:42 20:31 21:25
ACT 1:26 2:47 3:26 4:37 5:42 6:15 7:60 8:40 9:43 10:48 11:30 12:25 13:52 14:28 15:41 16:40 17:34 18:28 19:40 20:38 21:40 22:30 23:35 24:27 25:27 26:32 27:44 28:31
ROM 1:32 2:29 3:31 4:25 5:21 6:23 7:25 8:39 9:33 10:21 11:36 12:21 13:14 14:23 15:33 16:27
1CO 1:31 2:16 3:23 4:21 5:13 6:20 7:40 8:13 9:27 10:33 11:34 12:31 13:13 14:40 15:58 16:24
2CO 1:24 2:17 3:18 4:18 5:21 6:18 7:16 8:24 9:15 10:18 11:33 12:21 13:13
GAL 1:24 2:21 3:29 4:31 5:26 6:18
EPH 1:23 2:22 3:21 4:32 5:33 6:24
PHP 1:30 2:30 3:21 4:23
COL 1:29 2:23 3:25 4:18
1TH 1:10 2:20 3:13 4:18 5:28
2TH 1:12 2:17 3:18
1TI 1:20 2:15 3:16 4:16 5:25 6:21
2TI 1:18 2:26 3:17 4:22
TIT 1:16 2:15 3:15
PHM 1:25
HEB 1:14 2:18 3:19 4:16 5:14 6:20 7:28 8:13 9:28 10:39 11:40 12:29 13:25
JAS 1:27 2:26 3:18 4:17 5:20
1PE 1:25 2:25 3:22 4:19 5:14
2PE 1:21 2:22 3:18
1JN 1:10 2:29 3:24 4:21 5:21
2JN 1:13
3JN 1:15
JUD 1:25
REV 1:20 2:29 3:22 4:11 5:14 6:17 7:17 8:13 9:21 10:11 11:19 12:18 13:18 14:20 15:8 16:21 17:18 18:24 19:21 20:15 21:27 22:21
#--------------------------------------------------
# Deuterocanonical Books
TOB 1:22 2:14 3:17 4:21 5:23 6:19 7:17 8:21 9:6 10:14 11:19 12:22 13:18 14:15
JDT 1:16 2:28 3:10 4:15 5:24 6:21 7:32 8:36 9:14 10:23 11:23 12:20 13:20 14:19 15:14 16:25
# added ESG definition in its right PT order
ESG 1:22 2:23 3:15 4:17 5:14 6:14 7:10 8:17 9:32 10:3
# note chapter 4 v17 is 17a-z
# note chapter 8 v12 is 12a-x
# note chapter 10 v3 is 3a-l
WIS 1:16 2:24 3:19 4:20 5:23 6:25 7:30 8:21 9:18 10:21 11:26 12:27 13:19 14:31 15:19 16:29 17:20 18:25 19:22
SIR 1:30 2:18 3:31 4:31 5:15 6:37 7:36 8:19 9:18 10:31 11:34 12:18 13:26 14:27 15:20 16:30 17:32 18:33 19:30 20:31 21:28 22:27 23:27 24:34 25:26 26:29 27:30 28:26 29:28 30:25 31:31 32:24 33:33 34:26 35:24 36:27 37:31 38:34 39:35 40:30 41:27 42:25 43:33 44:23 45:26 46:20 47:25 48:25 49:16 50:29 51:30
BAR 1:22 2:35 3:38 4:37 5:9
LJE 1:72
# Edited SUS / SS 14.6.2014
SUS 1:64
BEL 1:42
1MA 1:64 2:70 3:60 4:61 5:68 6:63 7:50 8:32 9:73 10:89 11:74 12:53 13:53 14:49 15:41 16:24
2MA 1:36 2:32 3:40 4:50 5:27 6:31 7:42 8:36 9:29 10:38 11:38 12:45 13:26 14:46 15:39
3MA 1:29 2:33 3:30 4:21 5:51 6:41 7:23
4MA 1:35 2:24 3:21 4:26 5:38 6:35 7:23 8:29 9:32 10:21 11:27 12:19 13:27 14:20 15:32 16:25 17:24 18:24
# 1ES Ezra (Greek)
1ES 1:55 2:26 3:24 4:63 5:71 6:33 7:15 8:92 9:55
#-----------------------------------------------------
# Edited by Studge - Had the wrong definition of 2ES
# 2ES 1:11 2:70 3:13 4:24 5:17 6:22 7:28 8:36 9:15 10:44 11:11 12:20 13:37 14:17 15:19 16:19 17:73 18:18 19:37 20:40 21:36 22:47 23:31
# 2ES is not a LXX book but is from the Vulgate and has 16 chapters
# edited by Studge added the correct definition of 2ES
2ES 1:40 2:48 3:36 4:52 5:56 6:59 7:140 8:63 9:47 10:59 11:46 12:51 13:58 14:48 15:63 16:78
#
# Edited by Studge
#MAN and PS2 were not defined which are in LXX
MAN 1:15
PS2 1:7
#-------------------------------------------------------
# ODA and PSS are in the PT 6 files but now missing from the LXX files in PT 7
ODA 1:19 2:43 3:10 4:19 5:12 6:8 7:20 8:37 9:22 10:9 11:11 12:15 13:4 14:46
PSS 1:8 2:37 3:12 4:25 5:19 6:6 7:10 8:34 9:11 10:8 11:9 12:6 13:12 14:10 15:13 16:15 17:46 18:12
#-------------------------------------------------------
# NR: LXX variant texts now obselete, kep for backward compatability
JSA 1:18 2:24 3:17 4:24 5:15 6:27 7:26 8:35 9:27 10:43 11:23 12:24 13:33 14:15 15:63 16:10 17:18 18:28 19:45 20:9 21:45 22:34 23:16 24:33
JDB 1:36 2:23 3:31 4:24 5:31 6:40 7:25 8:35 9:57 10:18 11:40 12:15 13:25 14:20 15:20 16:31 17:13 18:31 19:30 20:48 21:25
TBS 1:22 2:14 3:17 4:21 5:23 6:19 7:17 8:21 9:6 10:14 11:19 12:22 13:18 14:15
SST 1:64
DNT 1:21 2:49 3:97 4:37 5:30 6:29 7:28 8:27 9:27 10:21 11:45 12:13
BLT 1:42
#--------------------------------------------------------
# Greek Daniel
# Edited chapter 5 and 6 and removed chapters 13 and 14 that are not in Rahlfs / SS 14.6.2014
DAG 1:21 2:49 3:97 4:37 5:30 6:29 7:28 8:27 9:27 10:21 11:45 12:13
#--------------------------------------------------------
# Syriac books for Peshitta projects SYR and SYA
#
# Syriac Psalms 152-155
##PS3 1:17 2:20 3:6 4:6
#
# Apocalypse of Baruch
##2BA 1:5 2:2 3:9 4:7 5:7 6:10 7:2 8:5 9:1 10:19 11:7 12:5 13:12 14:19 15:8 16:1 17:4 18:2 19:8 20:6 21:26 22:8 23:7 24:4 25:4 26:1 27:15 28:7 29:8 30:5 31:5 32:9 33:3 34:1 35:5 36:10 37:1 38:4 39:8 40:4 41:6 42:8 43:3 44:15 45:2 46:7 47:2 48:50 49:3 50:4 51:16 52:8 53:12 54:22 55:8 56:16 57:3 58:2 59:12 60:2 61:8 62:8 63:11 64:10 65:2 66:8 67:9 68:8 69:5 70:10 71:3 72:6 73:7 74:4 75:8 76:5 77:26
#
# Letter of Baruch
##LBA 78:7 79:3 80:7 81:4 82:9 83:23 84:11 85:15 86:3
#--------------------------------------------------------
# Books for Ethiopian Canon
# Jubilees (Ethiopian canon)
##JUB 1:26 2:17 3:19 4:24 5:36 6:34 7:37 8:40 9:27 10:48 11:39 12:56 13:34 14:55 15:20 16:28 17:30 18:31 19:59 20:66 21:30 22:38 23:59 24:30 25:50 26:48 27:37 28:38 29:27 30:29 31:31 32:24 33:30 34:20
# Enoch (Ethiopian canon)
##ENO 1:28 2:42 3:30 4:88 5:40 6:42 7:39 8:46 9:42 10:16 11:19 12:40 13:34 14:35 15:45 16:41 17:69 18:42 19:29 20:53 21:57 22:14 23:26 24:16 25:30 26:37 27:21 28:34 29:28 30:23 31:29 32:82 33:59 34:49 35:36 36:30 37:34 38:36 39:24 40:40 41:22 42:16
# 1 Meqabyan (Ethiopian canon)
##1MQ 1:28 2:28 3:38 4:37 5:39 6:38 7:33 8:35 9:10 10:8 11:8 12:44 13:27 14:23 15:20 16:9 17:8 18:12 19:17 20:4 21:31 22:11 23:7 4:22 25:18 26:5 27:20 28:49 29:17 30:16 31:7 32:4 33:11 34:18 35:8 36:46
# 2 Meqabyan (Ethiopian canon)
##2MQ 1:13 2:11 3:29 4:32 5:18 6:24 7:9 8:24 9:27 10:28 11:25 12:15 13:14 14:36 15:21 16:15 17:12 18:14 19:15 20:14 
# 3 Meqabyan (Ethiopian canon)
##3MQ 1:24 2:23 3:11 4:36 5:16 6:16 7:5 8:12 9:36 10:29
# Reproof (Ethiopian canon)
##REP 1:28 2:28 3:27 4:28 5:27 6:22
# 4 Baruch / Rest of the Words of Baruch (Ethiopian canon)
##4BA 1:30 2:29 3:30 4:33 5:62
#---------------------------------------------------------
# Edited by SS 14.6.2014 added deliberatelly omitted verses
-GEN 31:51
-GEN 35:21

-EXO 25:6
-EXO 28:23
-EXO 28:24
-EXO 28:25
-EXO 28:26
-EXO 28:27
-EXO 28:28
-EXO 32:9
-EXO 35:8
-EXO 35:15
-EXO 35:17
-EXO 35:18
-EXO 40:7
-EXO 40:11
-EXO 40:28
-EXO 40:30
-EXO 40:31
-EXO 40:32

-JOS 6:4
-JOS 8:13
-JOS 8:26
-JOS 10:15
-JOS 20:4
-JOS 20:5
-JOS 20:6

-1SA 13:1
-1SA 17:21
-1SA 17:22
-1SA 17:23
-1SA 17:24
-1SA 17:25
-1SA 17:26
-1SA 17:27
-1SA 17:28
-1SA 17:29
-1SA 17:30
-1SA 17:31
-1SA 17:41
-1SA 17:50
-1SA 18:1
-1SA 18:2
-1SA 18:3
-1SA 18:4
-1SA 18:5
-1SA 18:10
-1SA 18:11
-1SA 18:17
-1SA 18:18
-1SA 18:19
-1SA 23:12

-1KI 3:1
-1KI 5:5
-1KI 5:6
-1KI 5:7
-1KI 5:8
-1KI 5:31
-1KI 6:11
-1KI 6:12
-1KI 6:13
-1KI 6:14
-1KI 6:18
-1KI 8:12
-1KI 8:13
-1KI 9:15
-1KI 9:16
-1KI 9:17
-1KI 9:18
-1KI 9:19
-1KI 9:20
-1KI 9:21
-1KI 9:22
-1KI 9:23
-1KI 9:24
-1KI 9:25
-1KI 11:3
-1KI 11:23
-1KI 11:24
-1KI 11:39
-1KI 12:2
-1KI 12:17
-1KI 13:27
-1KI 14:1
-1KI 14:2
-1KI 14:3
-1KI 14:4
-1KI 14:5
-1KI 14:6
-1KI 14:7
-1KI 14:8
-1KI 14:9
-1KI 14:10
-1KI 14:11
-1KI 14:12
-1KI 14:13
-1KI 14:14
-1KI 14:15
-1KI 14:16
-1KI 14:17
-1KI 14:18
-1KI 14:19
-1KI 14:20
-1KI 15:6
-1KI 15:32
-1KI 22:47
-1KI 22:48
-1KI 22:49
-1KI 22:50

-1SA 17:12
-1SA 17:13
-1SA 17:14
-1SA 17:15
-1SA 17:16
-1SA 17:17
-1SA 17:18
-1SA 17:19
-1SA 17:20

-1CH 1:11
-1CH 1:12
-1CH 1:13
-1CH 1:14
-1CH 1:15
-1CH 1:16
-1CH 1:18
-1CH 1:19
-1CH 1:20
-1CH 1:21
-1CH 1:22
-1CH 1:23
-1CH 16:24

-2CH 27:8

-EZR 13:7
-EZR 14:18
-EZR 14:19
-EZR 14:20
-EZR 14:21
-EZR 14:22
-EZR 14:23
-EZR 19:38
-EZR 21:16
-EZR 21:20
-EZR 21:21
-EZR 21:28
-EZR 21:29
-EZR 21:32
-EZR 21:33
-EZR 21:34
-EZR 21:35
-EZR 22:4
-EZR 22:5
-EZR 22:6

-JOB 23:14

-PSA 115:5

-PRO 4:7
-PRO 8:33
-PRO 11:4
-PRO 15:31
-PRO 16:1
-PRO 16:3
-PRO 16:4
-PRO 16:6
-PRO 19:1
-PRO 19:2
-PRO 20:14
-PRO 20:15
-PRO 20:16
-PRO 20:17
-PRO 20:18
-PRO 20:19
-PRO 20:20
-PRO 20:21
-PRO 20:22
-PRO 21:5
-PRO 22:6
-PRO 23:23

-JER 2:1
-JER 7:1
-JER 8:11
-JER 8:12
-JER 10:6
-JER 10:7
-JER 10:8
-JER 10:10
-JER 11:7
-JER 17:1
-JER 17:2
-JER 17:3
-JER 17:4
-JER 26:1
-JER 26:26
-JER 28:45
-JER 28:46
-JER 28:47
-JER 28:48
-JER 30:22
-JER 32:1
-JER 32:2
-JER 32:3
-JER 32:4
-JER 32:5
-JER 32:6
-JER 32:7
-JER 32:8
-JER 32:9
-JER 32:10
-JER 32:11
-JER 32:12
-JER 32:14
-JER 34:1
-JER 34:7
-JER 34:13
-JER 34:17
-JER 34:21
-JER 36:16
-JER 36:17
-JER 36:18
-JER 36:19
-JER 36:20
-JER 37:10
-JER 37:11
-JER 37:15
-JER 37:22
-JER 46:4
-JER 46:5
-JER 46:6
-JER 46:7
-JER 46:8
-JER 46:9
-JER 46:10
-JER 46:11
-JER 46:12
-JER 46:13
-JER 52:2
-JER 52:3
-JER 52:15
-JER 52:28
-JER 52:29
-JER 52:30

-LAM 3:22
-LAM 3:23
-LAM 3:24
-LAM 3:29

-EZK 1:14
-EZK 10:14
-EZK 27:31
-EZK 32:19
-EZK 33:26
-EZK 40:30

#------------- DC books ------------

-TOB 4:8
-TOB 4:9
-TOB 4:10
-TOB 4:11
-TOB 4:12
-TOB 4:13
-TOB 4:14
-TOB 4:15
-TOB 4:16
-TOB 4:17
-TOB 4:18
-TOB 13:8
-TOB 13:9
-TOB 13:10

-ESG 4:6
-ESG 9:5
-ESG 9:30

-SIR 1:5
-SIR 1:7
-SIR 1:21
-SIR 3:19
-SIR 3:25
-SIR 6:1
-SIR 10:21
-SIR 11:15
-SIR 11:16
-SIR 13:14
-SIR 16:15
-SIR 16:16
-SIR 17:5
-SIR 17:9
-SIR 17:16
-SIR 17:18
-SIR 17:21
-SIR 18:3
-SIR 19:18
-SIR 19:19
-SIR 19:21
-SIR 22:7
-SIR 22:8
-SIR 24:18
-SIR 24:24
-SIR 25:12
-SIR 26:19
-SIR 26:20
-SIR 26:21
-SIR 26:22
-SIR 26:23
-SIR 26:24
-SIR 26:25
-SIR 26:26
-SIR 26:27

-4MA 10:4
-4MA 11:7
-4MA 11:8

#---------------------------------------------------------
# Mapping
# LXX = BHS (see org.vrs)
#
# (Note: for performance reasons ranges must not span a chapter, e.g. 4:10-5:11 is illegal)
#
# 2ES = EZR and NEH
#
EXO 20:13 = EXO 20:14
EXO 20:14 = EXO 20:15
EXO 20:15 = EXO 20:13
EXO 21:16 = EXO 21:17
EXO 21:17 = EXO 21:16
EXO 36:9 = EXO 39:2
EXO 36:10 = EXO 39:3
EXO 36:11 = EXO 39:4
EXO 36:12 = EXO 39:5
EXO 36:13 = EXO 39:6
EXO 36:14 = EXO 39:7
EXO 36:15 = EXO 39:8
EXO 36:16 = EXO 39:9
EXO 36:17 = EXO 39:10
EXO 36:20 = EXO 39:13
EXO 36:21 = EXO 39:14
EXO 36:22 = EXO 39:15
EXO 36:23 = EXO 39:16
EXO 36:25 = EXO 39:17
EXO 36:26 = EXO 39:18
EXO 36:27 = EXO 39:19
EXO 36:28 = EXO 39:20
EXO 36:29 = EXO 39:21
EXO 36:30 = EXO 39:22
EXO 36:31 = EXO 39:23
EXO 36:32 = EXO 39:24
EXO 36:33 = EXO 39:25
EXO 36:34 = EXO 39:26
EXO 36:35 = EXO 39:27
EXO 36:36 = EXO 39:28
EXO 36:37 = EXO 39:29
EXO 36:38 = EXO 39:30

DEU 5:17 = DEU 5:18
DEU 5:18 = DEU 5:17

1KI 20:1-29 = 1KI 21:1-29 
1KI 21:1-43 = 1KI 20:1-43

#
# Map The Greek versioin of Esther onto the Hebrew version of Esther
# using the Hebrew version as the reference point.
# Normally DC material would not have any entries in this part of the lxx.vrs file
# because the LXX serves as the reference point for DC material.
# Material which is placed in separate books in HEB and LXX (i.e. EST and ESG)
# is however placed here and referenced to the HEB reference points.
ESG 1:1-22 = EST 1:1-22
ESG 2:1-23 = EST 2:1-23
ESG 3:1-15 = EST 3:1-15
ESG 4:1-17 = EST 4:1-17
ESG 5:1-14 = EST 5:1-14
ESG 6:1-14 = EST 6:1-14
ESG 7:1-10 = EST 7:1-10
ESG 8:1-17 = EST 8:1-17
ESG 9:1-32 = EST 9:1-32
ESG 10:1-3 = EST 10:1-3
#
# PSA 9 = 9+10
PSA 9:22 = PSA 10:0
PSA 9:22-39 = PSA 10:1-18
PSA 10:0-7 = PSA 11:0-7
PSA 11:0-9 = PSA 12:0-9
PSA 12:0-6 = PSA 13:0-6
PSA 13:0-7 = PSA 14:0-7
PSA 14:0-5 = PSA 15:0-5
PSA 15:0-11 = PSA 16:0-11
PSA 16:0-15 = PSA 17:0-15
PSA 17:0-51 = PSA 18:0-51
PSA 18:0-15 = PSA 19:0-15
PSA 19:0-10 = PSA 20:0-10
PSA 20:0-14 = PSA 21:0-14
PSA 21:0-32 = PSA 22:0-32
PSA 22:0-6 = PSA 23:0-6
PSA 23:0-10 = PSA 24:0-10
PSA 24:0-22 = PSA 25:0-22
PSA 25:0-12 = PSA 26:0-12
PSA 26:0-14 = PSA 27:0-14
PSA 27:0-9 = PSA 28:0-9
PSA 28:0-11 = PSA 29:0-11
PSA 29:0-13 = PSA 30:0-13
PSA 30:0-25 = PSA 31:0-25
PSA 31:0-11 = PSA 32:0-11
PSA 32:0-22 = PSA 33:0-22
PSA 33:0-23 = PSA 34:0-23
PSA 34:0-28 = PSA 35:0-28
PSA 35:0-13 = PSA 36:0-13
PSA 36:0-40 = PSA 37:0-40
PSA 37:0-23 = PSA 38:0-23
PSA 38:0-14 = PSA 39:0-14
PSA 39:0-18 = PSA 40:0-18
PSA 40:0-14 = PSA 41:0-14
PSA 41:0-12 = PSA 42:0-12
PSA 42:0-5 = PSA 43:0-5
PSA 43:0-27 = PSA 44:0-27
PSA 44:0-18 = PSA 45:0-18
PSA 45:0-12 = PSA 46:0-12
PSA 46:0-10 = PSA 47:0-10
PSA 47:0-15 = PSA 48:0-15
PSA 48:0-21 = PSA 49:0-21
PSA 49:0-23 = PSA 50:0-23
PSA 50:0-21 = PSA 51:0-21
PSA 51:0-11 = PSA 52:0-11
PSA 52:0-7 = PSA 53:0-7
PSA 53:0-9 = PSA 54:0-9
PSA 54:0-24 = PSA 55:0-24
PSA 55:0-14 = PSA 56:0-14
PSA 56:0-12 = PSA 57:0-12
PSA 57:0-12 = PSA 58:0-12
PSA 58:0-18 = PSA 59:0-18
PSA 59:0-14 = PSA 60:0-14
PSA 60:0-9 = PSA 61:0-9
PSA 61:0-13 = PSA 62:0-13
PSA 62:0-12 = PSA 63:0-12
PSA 63:0-11 = PSA 64:0-11
PSA 64:0-14 = PSA 65:0-14
PSA 65:0-20 = PSA 66:0-20
PSA 66:0-8 = PSA 67:0-8
PSA 67:0-36 = PSA 68:0-36
PSA 68:0-37 = PSA 69:0-37
PSA 69:0-6 = PSA 70:0-6
PSA 70:0-24 = PSA 71:0-24
PSA 71:0-20 = PSA 72:0-20
PSA 72:0-28 = PSA 73:0-28
PSA 73:0-23 = PSA 74:0-23
PSA 74:0-11 = PSA 75:0-11
PSA 75:0-13 = PSA 76:0-13
PSA 76:0-21 = PSA 77:0-21
PSA 77:0-72 = PSA 78:0-72
PSA 78:0-13 = PSA 79:0-13
PSA 79:0-20 = PSA 80:0-20
PSA 80:0-17 = PSA 81:0-17
PSA 81:0-8 = PSA 82:0-8
PSA 82:0-19 = PSA 83:0-19
PSA 83:0-13 = PSA 84:0-13
PSA 84:0-14 = PSA 85:0-14
PSA 85:0-17 = PSA 86:0-17
PSA 86:0-7 = PSA 87:0-7
PSA 87:0-19 = PSA 88:0-19
PSA 88:0-53 = PSA 89:0-53
PSA 89:0-17 = PSA 90:0-17
PSA 90:0-16 = PSA 91:0-16
PSA 91:0-16 = PSA 92:0-16
PSA 92:0-5 = PSA 93:0-5
PSA 93:0-23 = PSA 94:0-23
PSA 94:0-11 = PSA 95:0-11
PSA 95:0-13 = PSA 96:0-13
PSA 96:0-12 = PSA 97:0-12
PSA 97:0-9 = PSA 98:0-9
PSA 98:0-9 = PSA 99:0-9
PSA 99:0-5 = PSA 100:0-5
PSA 100:0-8 = PSA 101:0-8
PSA 101:0-29 = PSA 102:0-29
PSA 102:0-22 = PSA 103:0-22
PSA 103:0-35 = PSA 104:0-35
PSA 104:0-45 = PSA 105:0-45
PSA 105:0-48 = PSA 106:0-48
PSA 106:0-43 = PSA 107:0-43
PSA 107:0-14 = PSA 108:0-14
PSA 108:0-31 = PSA 109:0-31
PSA 109:0-7 = PSA 110:0-7
PSA 110:0-10 = PSA 111:0-10
PSA 111:0-10 = PSA 112:0-10
PSA 112:0-9 = PSA 113:0-9
PSA 113:0-8 = PSA 114:0-8
PSA 113:9 = PSA 115:0
PSA 113:9-26 = PSA 115:1-18
PSA 114:0-9 = PSA 116:0-9
PSA 115:0 = PSA 116:10
PSA 115:1-10 = PSA 116:10-19	
PSA 116:0-2 = PSA 117:0-2
PSA 117:0-29 = PSA 118:0-29
PSA 118:0-176 = PSA 119:0-176
PSA 119:0-7 = PSA 120:0-7
PSA 120:0-8 = PSA 121:0-8
PSA 121:0-9 = PSA 122:0-9
PSA 122:0-4 = PSA 123:0-4
PSA 123:0-8 = PSA 124:0-8
PSA 124:0-5 = PSA 125:0-5
PSA 125:0-6 = PSA 126:0-6
PSA 126:0-5 = PSA 127:0-5
PSA 127:0-6 = PSA 128:0-6
PSA 128:0-8 = PSA 129:0-8
PSA 129:0-8 = PSA 130:0-8
PSA 130:0-3 = PSA 131:0-3
PSA 131:0-18 = PSA 132:0-18
PSA 132:0-3 = PSA 133:0-3
PSA 133:0-3 = PSA 134:0-3
PSA 134:0-21 = PSA 135:0-21
PSA 135:0-26 = PSA 136:0-26
PSA 136:0-9 = PSA 137:0-9
PSA 137:0-8 = PSA 138:0-8
PSA 138:0-24 = PSA 139:0-24
PSA 139:0-14 = PSA 140:0-14
PSA 140:0-10 = PSA 141:0-10
PSA 141:0-8 = PSA 142:0-8
PSA 142:0-12 = PSA 143:0-12
PSA 143:0-15 = PSA 144:0-15
PSA 144:0-21 = PSA 145:0-21
PSA 145:0-10 = PSA 146:0-10
# 146 + 147 -> 147
PSA 146:0-11 = PSA 147:0-11
PSA 147:0 = PSA 147:12
PSA 147:1-9 = PSA 147:12-20
# PSA 151 -> PS2
PSA 151:0-7 = PS2 1:0-7
#
# Jeremiah according to Rahlfs
# Added by SS 25.3.2003
#
# JER 1-25:13 = JER 1-25:13
# JER 25:14 = part of JER 49:34
# JER 25:20 = part of JER 49:34
# JER 52 = JER 52
#
JER 25:14-19 = JER 49:34-39
JER 25:20 = JER 49:34
JER 26:1-28 = JER 46:1-28
JER 27:1-46 = JER 50:1-46
JER 28:1-64 = JER 51:1-64
JER 29:1-7 = JER 47:1-7
JER 30:1-16 = JER 49:7-22
JER 30:17-22 = JER 49:1-6
JER 30:23-28 = JER 49:28-33
JER 30:29-33 = JER 49:23-27
JER 31:1-44 = JER 48:1-44
# Verses 31:1-13 do not exist
JER 32:13 = JER 25:13
# Verse 32:14 does not exist
JER 32:15-38 = JER 25:15-38
JER 33:1-24 = JER 26:1-24
JER 34:1-22 = JER 27:1-22
JER 35:1-17 = JER 28:1-17
JER 36:1-32 = JER 29:1-32
JER 37:1-24 = JER 30:1-24
JER 38:1-40 = JER 31:1-40
JER 39:1-44 = JER 32:1-44
JER 40:1-13 = JER 33:1-13
JER 41:1-22 = JER 34:1-22
JER 42:1-19 = JER 35:1-19
JER 43:1-32 = JER 36:1-32
JER 44:1-21 = JER 37:1-21
JER 45:1-28 = JER 38:1-28
JER 46:1-3 = JER 39:1-3
# Verses 46:4-13 do not exist
JER 46:14-18 = JER 39:14-18
JER 47:1-16 = JER 40:1-16
JER 48:1-18 = JER 41:1-18
JER 49:1-22 = JER 42:1-22
JER 50:1-13 = JER 43:1-13
JER 51:1-30 = JER 44:1-30
JER 51:31-35 = JER 45:1-5
#
# Map The Greek versioin of Daniel onto the Hebrew version of Daniel
# using the Hebrew version as the reference point.
# Normally DC material would not have any entries in this part of the lxx.vrs file
# because the LXX serves as the reference point for DC material.
# Material which is placed in separate books in HEB and LXX (i.e. DAN and DAG)
# is however placed here and referenced to the HEB reference point.
#
# If you have a text in which the DAG material has been (incorrectly) placed into DAN
# you must create a versification file in which DAN appears as the first book in 
# the following section.  You cannot have both DAN = DAN and DAG = DAN entries
# in a single file.
DAG 1:1-21 = DAN 1:1-21
DAG 2:1-49 = DAN 2:1-49
DAG 3:1-23 = DAN 3:1-23
DAG 3:91-97 = DAN 3:24-30
DAG 4:1-3 = DAN 3:31-33
DAG 4:4-37 = DAN 4:1-34
DAG 5:1-31 = DAN 5:1-31
DAG 6:1-28 = DAN 6:1-28
DAG 7:1-28 = DAN 7:1-28
DAG 8:1-27 = DAN 8:1-27
DAG 9:1-27 = DAN 9:1-27
DAG 10:1-21 = DAN 10:1-21
DAG 11:1-45 = DAN 11:1-45 
DAG 12:1-13 = DAN 12:1-13
#
# No entries present for S3Y because this book would not normally be present in a text based
# on the LXX versification. The S3Y material would instead start at DAG 3:24.
#
# When Ezra-Nehemiah is one book Ezra 11-23 maps onto Nehemiah
# LXX mapping onto BHS
EZR 11:1-11 = NEH 1:1-11
EZR 12:1-20 = NEH 2:1-20
EZR 13:1-38 = NEH 3:1-38
EZR 14:1-17 = NEH 4:1-17
EZR 15:1-19 = NEH 5:1-19
EZR 16:1-19 = NEH 6:1-19
EZR 17:1-72 = NEH 7:1-72
EZR 18:1-18 = NEH 8:1-18
EZR 19:1-37 = NEH 9:1-37
EZR 20:1-40 = NEH 10:1-40
EZR 21:1-36 = NEH 11:1-36
EZR 22:1-47 = NEH 12:1-47
EZR 23:1-31 = NEH 13:1-31
#---------------------------
# Mapping 2 Esdras onto the older Apocalypse of Ezra [Studge]
2ES 3:1-36 = EZA 1:1-36
2ES 4:1-52 = EZA 2:1-52
2ES 5:1-56 = EZA 3:1-56
2ES 6:1-59 = EZA 4:1-59
2ES 7:1-35 = EZA 5:1-35
2ES 7:106-140 = EZA 5:36-70
2ES 8:1-63 = EZA 6:1-63
2ES 9:1-47 = EZA 7:1-47
2ES 10:1-60 = EZA 8:1-60
2ES 11:1-46 = EZA 9:1-46
2ES 12:1-51 = EZA 10:1-51
2ES 13:1-58 = EZA 11:1-58
2ES 14:1-48 = EZA 12:1-48
#----------------------------
# Some texts (but not LXX) contain SUS and BEL as chapters 13 and 14 of DAG.
# There should not be any entries for DAG 13 and DAG 14 in the lxx.vrs because these chapters do not 
# exist in the LXX.
# If you have a text which has DAG 13 and 14 you will need to have a .vrs file that includes the following
# two mapping.
#
# Susanna
# DAG 13:1-63 = SUS 1:1-63
# Bel and the Dragon
# DAG 14:1-42 = BEL 1:1-42
#
#----------------------------
# Verse segment information for the Septuagint.
# The verse segment information is preceded by a '#!' so that it will be ignored by versions 
# of Paratext prior to Paratext 7.3 (and thus avoid crashing it with an unexpected format). 
#! *EXO 28:29,-,a 
#! *EXO 35:12,-,a 
#! *JOS 9:2,-,a,b,c,d,e,f 
#! *JOS 15:59,-,a 
#! *JOS 19:47,-,a 
#! *JOS 19:48,-,a 
#! *JOS 21:42,-,a,b,c,d 
#! *JOS 24:31,-,a 
#! *JOS 24:33,-,a,b 
#! *1SA 30:28,-,a 
#! *2SA 5:16,-,a 
#! *1KI 2:35,-,a,b,c,d,e,f,g,h,i,k,l,m,n,o 
#! *1KI 2:46,-,a,b,c,d,e,f,g,h,i,k,l 
#! *1KI 5:14,-,a,b 
#! *1KI 6:1,-,a,b,c,d 
#! *1KI 6:36,-,a 
#! *1KI 8:53,-,a 
#! *1KI 9:9,-,a 
#! *1KI 10:22,-,a,b,c 
#! *1KI 10:26,-,a 
#! *1KI 12:24,-,a,b,c,d,e,f,g,h,i,k,l,m,n,o,p,q,r,s,t,u,x,y,z 
#! *1KI 16:28,-,a,b,c,d,e,f,g,h 
#! *2KI 1:18,-,a,b,c,d 
#! *2CH 35:19,-,a,b,c,d 
#! *2CH 36:2,-,a,b,c 
#! *2CH 36:4,-,a 
#! *2CH 36:5,-,a,b,c,d 
#! *JOB 2:9,-,a,b,c,d,e 
#! *JOB 19:4,-,a 
#! *JOB 23:15,-,a 
#! *JOB 36:28,-,a,b 
#! *JOB 42:17,-,a,b,c,d,e 
#! *PSA 144:13,-,a 
#! *PRO 3:16,-,a 
#! *PRO 3:22,-,a 
#! *PRO 4:27,-,a,b 
#! *PRO 6:8,-,a,b,c 
#! *PRO 6:11,-,a 
#! *PRO 7:1,-,a 
#! *PRO 8:21,-,a 
#! *PRO 9:10,-,a 
#! *PRO 9:12,-,a,b,c 
#! *PRO 9:18,-,a,b,c,d 
#! *PRO 10:4,-,a 
#! *PRO 12:11,-,a 
#! *PRO 12:13,-,a 
#! *PRO 13:9,-,a 
#! *PRO 13:13,-,a 
#! *PRO 15:18,-,a 
#! *PRO 15:27,-,a 
#! *PRO 15:28,-,a 
#! *PRO 15:29,-,a,b 
#! *PRO 17:6,-,a 
#! *PRO 17:16,-,a 
#! *PRO 18:22,-,a 
#! *PRO 20:9,-,a,b,c 
#! *PRO 22:8,-,a 
#! *PRO 22:9,-,a 
#! *PRO 22:14,-,a 
#! *PRO 24:22,-,a,b,c,d,e 
#! *PRO 25:10,-,a 
#! *PRO 25:20,-,a 
#! *PRO 26:11,-,a 
#! *PRO 27:20,-,a 
#! *PRO 27:21,-,a 
#! *PRO 28:17,-,a 
#! *ESG 1:1,-,b,c,d,e,f,g,h,i,k,l,m,n,o,p,q,r,s 
#! *ESG 3:13,-,a,b,c,d,e,f,g 
#! *ESG 4:17,-,a,b,c,d,e,f,g,h,i,k,l,m,n,o,p,q,r,s,t,u,w,x,y,z 
#! *ESG 5:1,-,a,b,c,d,e,f 
#! *ESG 5:2,-,a,b 
#! *ESG 8:12,-,a,b,c,d,e,f,g,h,i,k,l,m,n,o,p,q,r,s,t,u,x 
#! *ESG 10:3,-,a,b,c,d,e,f,g,h,i,k,l 
#! *SIR 1:1,-,a,b,c,d,e,f,g,h 
`,Ww=`# Versification  "Original" 
# Version=1.200
# (not a very good name but I have not heard a better suggestion)
#
# modifications by Studge 26/June/2009
#
# BHS versification for OT, UBS GNT versification for NT
# following the Masoretic order
# OT translations using Masorteic verse structures should map onto this text
# NT versifications maps onto Nestle-Aland
#
# List of books, chapters, verses
# One line per book.
# One entry for each chapter.
# Verse number is the maximum verse number for that chapter.
# See the lines containing ='s below for verse mappings.
#
#---------------------------------------------------------------
# Old Testament
GEN 1:31 2:25 3:24 4:26 5:32 6:22 7:24 8:22 9:29 10:32 11:32 12:20 13:18 14:24 15:21 16:16 17:27 18:33 19:38 20:18 21:34 22:24 23:20 24:67 25:34 26:35 27:46 28:22 29:35 30:43 31:54 32:33 33:20 34:31 35:29 36:43 37:36 38:30 39:23 40:23 41:57 42:38 43:34 44:34 45:28 46:34 47:31 48:22 49:33 50:26
EXO 1:22 2:25 3:22 4:31 5:23 6:30 7:29 8:28 9:35 10:29 11:10 12:51 13:22 14:31 15:27 16:36 17:16 18:27 19:25 20:26 21:37 22:30 23:33 24:18 25:40 26:37 27:21 28:43 29:46 30:38 31:18 32:35 33:23 34:35 35:35 36:38 37:29 38:31 39:43 40:38
LEV 1:17 2:16 3:17 4:35 5:26 6:23 7:38 8:36 9:24 10:20 11:47 12:8 13:59 14:57 15:33 16:34 17:16 18:30 19:37 20:27 21:24 22:33 23:44 24:23 25:55 26:46 27:34
NUM 1:54 2:34 3:51 4:49 5:31 6:27 7:89 8:26 9:23 10:36 11:35 12:16 13:33 14:45 15:41 16:35 17:28 18:32 19:22 20:29 21:35 22:41 23:30 24:25 25:19 26:65 27:23 28:31 29:39 30:17 31:54 32:42 33:56 34:29 35:34 36:13
DEU 1:46 2:37 3:29 4:49 5:33 6:25 7:26 8:20 9:29 10:22 11:32 12:31 13:19 14:29 15:23 16:22 17:20 18:22 19:21 20:20 21:23 22:29 23:26 24:22 25:19 26:19 27:26 28:69 29:28 30:20 31:30 32:52 33:29 34:12
JOS 1:18 2:24 3:17 4:24 5:15 6:27 7:26 8:35 9:27 10:43 11:23 12:24 13:33 14:15 15:63 16:10 17:18 18:28 19:51 20:9 21:45 22:34 23:16 24:33
JDG 1:36 2:23 3:31 4:24 5:31 6:40 7:25 8:35 9:57 10:18 11:40 12:15 13:25 14:20 15:20 16:31 17:13 18:31 19:30 20:48 21:25
RUT 1:22 2:23 3:18 4:22
1SA 1:28 2:36 3:21 4:22 5:12 6:21 7:17 8:22 9:27 10:27 11:15 12:25 13:23 14:52 15:35 16:23 17:58 18:30 19:24 20:42 21:16 22:23 23:28 24:23 25:44 26:25 27:12 28:25 29:11 30:31 31:13
2SA 1:27 2:32 3:39 4:12 5:25 6:23 7:29 8:18 9:13 10:19 11:27 12:31 13:39 14:33 15:37 16:23 17:29 18:32 19:44 20:26 21:22 22:51 23:39 24:25
1KI 1:53 2:46 3:28 4:20 5:32 6:38 7:51 8:66 9:28 10:29 11:43 12:33 13:34 14:31 15:34 16:34 17:24 18:46 19:21 20:43 21:29 22:54
2KI 1:18 2:25 3:27 4:44 5:27 6:33 7:20 8:29 9:37 10:36 11:20 12:22 13:25 14:29 15:38 16:20 17:41 18:37 19:37 20:21 21:26 22:20 23:37 24:20 25:30
1CH 1:54 2:55 3:24 4:43 5:41 6:66 7:40 8:40 9:44 10:14 11:47 12:41 13:14 14:17 15:29 16:43 17:27 18:17 19:19 20:8 21:30 22:19 23:32 24:31 25:31 26:32 27:34 28:21 29:30
2CH 1:18 2:17 3:17 4:22 5:14 6:42 7:22 8:18 9:31 10:19 11:23 12:16 13:23 14:14 15:19 16:14 17:19 18:34 19:11 20:37 21:20 22:12 23:21 24:27 25:28 26:23 27:9 28:27 29:36 30:27 31:21 32:33 33:25 34:33 35:27 36:23
EZR 1:11 2:70 3:13 4:24 5:17 6:22 7:28 8:36 9:15 10:44
NEH 1:11 2:20 3:38 4:17 5:19 6:19 7:72 8:18 9:37 10:40 11:36 12:47 13:31
EST 1:22 2:23 3:15 4:17 5:14 6:14 7:10 8:17 9:32 10:3
JOB 1:22 2:13 3:26 4:21 5:27 6:30 7:21 8:22 9:35 10:22 11:20 12:25 13:28 14:22 15:35 16:22 17:16 18:21 19:29 20:29 21:34 22:30 23:17 24:25 25:6 26:14 27:23 28:28 29:25 30:31 31:40 32:22 33:33 34:37 35:16 36:33 37:24 38:41 39:30 40:32 41:26 42:17
PSA 1:6 2:12 3:9 4:9 5:13 6:11 7:18 8:10 9:21 10:18 11:7 12:9 13:6 14:7 15:5 16:11 17:15 18:51 19:15 20:10 21:14 22:32 23:6 24:10 25:22 26:12 27:14 28:9 29:11 30:13 31:25 32:11 33:22 34:23 35:28 36:13 37:40 38:23 39:14 40:18 41:14 42:12 43:5 44:27 45:18 46:12 47:10 48:15 49:21 50:23 51:21 52:11 53:7 54:9 55:24 56:14 57:12 58:12 59:18 60:14 61:9 62:13 63:12 64:11 65:14 66:20 67:8 68:36 69:37 70:6 71:24 72:20 73:28 74:23 75:11 76:13 77:21 78:72 79:13 80:20 81:17 82:8 83:19 84:13 85:14 86:17 87:7 88:19 89:53 90:17 91:16 92:16 93:5 94:23 95:11 96:13 97:12 98:9 99:9 100:5 101:8 102:29 103:22 104:35 105:45 106:48 107:43 108:14 109:31 110:7 111:10 112:10 113:9 114:8 115:18 116:19 117:2 118:29 119:176 120:7 121:8 122:9 123:4 124:8 125:5 126:6 127:5 128:6 129:8 130:8 131:3 132:18 133:3 134:3 135:21 136:26 137:9 138:8 139:24 140:14 141:10 142:8 143:12 144:15 145:21 146:10 147:20 148:14 149:9 150:6
PRO 1:33 2:22 3:35 4:27 5:23 6:35 7:27 8:36 9:18 10:32 11:31 12:28 13:25 14:35 15:33 16:33 17:28 18:24 19:29 20:30 21:31 22:29 23:35 24:34 25:28 26:28 27:27 28:28 29:27 30:33 31:31
ECC 1:18 2:26 3:22 4:17 5:19 6:12 7:29 8:17 9:18 10:20 11:10 12:14
SNG 1:17 2:17 3:11 4:16 5:16 6:12 7:14 8:14
ISA 1:31 2:22 3:26 4:6 5:30 6:13 7:25 8:23 9:20 10:34 11:16 12:6 13:22 14:32 15:9 16:14 17:14 18:7 19:25 20:6 21:17 22:25 23:18 24:23 25:12 26:21 27:13 28:29 29:24 30:33 31:9 32:20 33:24 34:17 35:10 36:22 37:38 38:22 39:8 40:31 41:29 42:25 43:28 44:28 45:25 46:13 47:15 48:22 49:26 50:11 51:23 52:15 53:12 54:17 55:13 56:12 57:21 58:14 59:21 60:22 61:11 62:12 63:19 64:11 65:25 66:24
JER 1:19 2:37 3:25 4:31 5:31 6:30 7:34 8:23 9:25 10:25 11:23 12:17 13:27 14:22 15:21 16:21 17:27 18:23 19:15 20:18 21:14 22:30 23:40 24:10 25:38 26:24 27:22 28:17 29:32 30:24 31:40 32:44 33:26 34:22 35:19 36:32 37:21 38:28 39:18 40:16 41:18 42:22 43:13 44:30 45:5 46:28 47:7 48:47 49:39 50:46 51:64 52:34
LAM 1:22 2:22 3:66 4:22 5:22
EZK 1:28 2:10 3:27 4:17 5:17 6:14 7:27 8:18 9:11 10:22 11:25 12:28 13:23 14:23 15:8 16:63 17:24 18:32 19:14 20:44 21:37 22:31 23:49 24:27 25:17 26:21 27:36 28:26 29:21 30:26 31:18 32:32 33:33 34:31 35:15 36:38 37:28 38:23 39:29 40:49 41:26 42:20 43:27 44:31 45:25 46:24 47:23 48:35
DAN 1:21 2:49 3:33 4:34 5:30 6:29 7:28 8:27 9:27 10:21 11:45 12:13
HOS 1:9 2:25 3:5 4:19 5:15 6:11 7:16 8:14 9:17 10:15 11:11 12:15 13:15 14:10
JOL 1:20 2:27 3:5 4:21
AMO 1:15 2:16 3:15 4:13 5:27 6:14 7:17 8:14 9:15
OBA 1:21
JON 1:16 2:11 3:10 4:11
MIC 1:16 2:13 3:12 4:14 5:14 6:16 7:20
NAM 1:14 2:14 3:19
HAB 1:17 2:20 3:19
ZEP 1:18 2:15 3:20
HAG 1:15 2:23
ZEC 1:17 2:17 3:10 4:14 5:11 6:15 7:14 8:23 9:17 10:12 11:17 12:14 13:9 14:21
MAL 1:14 2:17 3:24
#---------------------------------------------------------
# New Testament books
MAT 1:25 2:23 3:17 4:25 5:48 6:34 7:29 8:34 9:38 10:42 11:30 12:50 13:58 14:36 15:39 16:28 17:27 18:35 19:30 20:34 21:46 22:46 23:39 24:51 25:46 26:75 27:66 28:20
MRK 1:45 2:28 3:35 4:41 5:43 6:56 7:37 8:38 9:50 10:52 11:33 12:44 13:37 14:72 15:47 16:20
LUK 1:80 2:52 3:38 4:44 5:39 6:49 7:50 8:56 9:62 10:42 11:54 12:59 13:35 14:35 15:32 16:31 17:37 18:43 19:48 20:47 21:38 22:71 23:56 24:53
JHN 1:51 2:25 3:36 4:54 5:47 6:71 7:53 8:59 9:41 10:42 11:57 12:50 13:38 14:31 15:27 16:33 17:26 18:40 19:42 20:31 21:25
ACT 1:26 2:47 3:26 4:37 5:42 6:15 7:60 8:40 9:43 10:48 11:30 12:25 13:52 14:28 15:41 16:40 17:34 18:28 19:40 20:38 21:40 22:30 23:35 24:27 25:27 26:32 27:44 28:31
ROM 1:32 2:29 3:31 4:25 5:21 6:23 7:25 8:39 9:33 10:21 11:36 12:21 13:14 14:23 15:33 16:27
1CO 1:31 2:16 3:23 4:21 5:13 6:20 7:40 8:13 9:27 10:33 11:34 12:31 13:13 14:40 15:58 16:24
2CO 1:24 2:17 3:18 4:18 5:21 6:18 7:16 8:24 9:15 10:18 11:33 12:21 13:13
GAL 1:24 2:21 3:29 4:31 5:26 6:18
EPH 1:23 2:22 3:21 4:32 5:33 6:24
PHP 1:30 2:30 3:21 4:23
COL 1:29 2:23 3:25 4:18
1TH 1:10 2:20 3:13 4:18 5:28
2TH 1:12 2:17 3:18
1TI 1:20 2:15 3:16 4:16 5:25 6:21
2TI 1:18 2:26 3:17 4:22
TIT 1:16 2:15 3:15
PHM 1:25
HEB 1:14 2:18 3:19 4:16 5:14 6:20 7:28 8:13 9:28 10:39 11:40 12:29 13:25
JAS 1:27 2:26 3:18 4:17 5:20
1PE 1:25 2:25 3:22 4:19 5:14
2PE 1:21 2:22 3:18
1JN 1:10 2:29 3:24 4:21 5:21
2JN 1:13
3JN 1:15
JUD 1:25
REV 1:20 2:29 3:22 4:11 5:14 6:17 7:17 8:13 9:21 10:11 11:19 12:18 13:18 14:20 15:8 16:21 17:18 18:24 19:21 20:15 21:27 22:21
#------------------------------------------------
# Deuterocanonical books from the LXX which are in the Catholic tradition
TOB 1:22 2:14 3:17 4:21 5:23 6:19 7:17 8:21 9:6 10:14 11:19 12:22 13:18 14:15
JDT 1:16 2:28 3:10 4:15 5:24 6:21 7:32 8:36 9:14 10:23 11:23 12:20 13:20 14:19 15:14 16:25
ESG 1:39 2:23 3:22 4:47 5:28 6:14 7:10 8:39 9:32 10:13
WIS 1:16 2:24 3:19 4:20 5:23 6:25 7:30 8:21 9:18 10:21 11:26 12:27 13:19 14:31 15:19 16:29 17:20 18:25 19:22
SIR 1:30 2:18 3:31 4:31 5:15 6:37 7:36 8:19 9:18 10:31 11:34 12:18 13:26 14:27 15:20 16:30 17:32 18:33 19:30 20:31 21:28 22:27 23:27 24:34 25:26 26:29 27:30 28:26 29:28 30:25 31:31 32:24 33:33 34:26 35:24 36:27 37:31 38:34 39:35 40:30 41:27 42:25 43:33 44:23 45:26 46:20 47:25 48:25 49:16 50:29 51:30
BAR 1:22 2:35 3:38 4:37 5:9
LJE 1:72
S3Y 1:67
SUS 1:64
BEL 1:42
1MA 1:64 2:70 3:60 4:61 5:68 6:63 7:50 8:32 9:73 10:89 11:74 12:53 13:53 14:49 15:41 16:24
2MA 1:36 2:32 3:40 4:50 5:27 6:31 7:42 8:36 9:29 10:38 11:38 12:45 13:26 14:46 15:39
#---------------------------------------------------
# Additional Orthodox books from the LXX
3MA 1:29 2:33 3:30 4:21 5:51 6:41 7:23
4MA 1:35 2:24 3:21 4:26 5:38 6:35 7:23 8:29 9:32 10:21 11:27 12:19 13:27 14:20 15:32 16:25 17:24 18:24
1ES 1:55 2:26 3:24 4:63 5:71 6:33 7:15 8:92 9:55
# This was the wrong definition for 2ES
# 2ES 1:11 2:70 3:13 4:24 5:17 6:22 7:28 8:36 9:15 10:44 11:11 12:20 13:37 14:17 15:19 16:19 17:73 18:18 19:37 20:40 21:36 22:47 23:31
# This is the correct definition of 2ES, the "original" book was EZA
2ES 1:40 2:48 3:36 4:52 5:56 6:59 7:140 8:63 9:47 10:59 11:46 12:51 13:58 14:48 15:63 16:78
MAN 1:15
PS2 1:7
#-------------------------------------------------------
# ODA and PSS are only in the LXX and SYR projects. 
ODA 1:19 2:43 3:10 4:19 5:12 6:8 7:20 8:37 9:22 10:9 11:11 12:15 13:4 14:46
PSS 1:8 2:37 3:12 4:25 5:19 6:6 7:10 8:34 9:11 10:8 11:9 12:6 13:12 14:10 15:13 16:15 17:46 18:12
#-------------------------------------------------------
# the following codes are for obselete LXX variants only in LXX and not supported in PT 7
JSA 1:18 2:24 3:17 4:24 5:15 6:27 7:26 8:35 9:27 10:43 11:23 12:24 13:33 14:15 15:63 16:10 17:18 18:28 19:51 20:9 21:45 22:34 23:16 24:33
JDB 1:36 2:23 3:31 4:24 5:31 6:40 7:25 8:35 9:57 10:18 11:40 12:15 13:25 14:20 15:20 16:31 17:13 18:31 19:30 20:48 21:25
TBS 1:22 2:14 3:17 4:21 5:23 6:19 7:17 8:21 9:6 10:14 11:19 12:22 13:18 14:15
SST 1:64
DNT 1:21 2:49 3:97 4:37 5:30 6:29 7:28 8:27 9:27 10:21 11:45 12:13
BLT 1:42
#
# No mappings are present for this versification since it represents
# the "standard" versification to which all OT and NT texts are mapped in these files.
# (DC texts follow the LXX)
#
#-------------------------------------------------------
# Apocalypse of Ezra [Studge]
EZA 1:36 2:52 3:56 4:59 5:139 6:63 7:47 8:60 9:46 10:51 11:58 12:48
#--------------------------------------------------------
# Jubilees and Enoch have both been found in the Hebrew [Studge]
# might be needed if we add Dead Sea Scrolls
# Jubilees (Ethiopian canon)
JUB 1:26 2:17 3:19 4:24 5:36 6:34 7:37 8:40 9:27 10:48 11:39 12:56 13:34 14:55 15:20 16:28 17:30 18:31 19:59 20:66 21:30 22:38 23:59 24:30 25:50 26:48 27:37 28:38 29:27 30:29 31:31 32:24 33:30 34:20
# Enoch (Ethiopian canon)
ENO 1:28 2:42 3:30 4:88 5:40 6:42 7:39 8:46 9:42 10:16 11:19 12:40 13:34 14:35 15:45 16:41 17:69 18:42 19:29 20:53 21:57 22:14 23:26 24:16 25:30 26:37 27:21 28:34 29:28 30:23 31:29 32:82 33:59 34:49 35:36 36:30 37:34 38:36 39:24 40:40 41:22 42:16
#
# S3Y is a small section of the DAG LXX pulled out and translated as a separate book.
# Map it back to the LXX.  This section allow's texts such as TOB (French) which do
# this to scroll correctly with the LXX.
# S3Y is not present in the GRK, HEB, or LXX(Ralphs) text.
# If a text has DAG present, this section must NOT be included in its versification file because
# that would cause references in other texts to DAG to be redirected to a non-existant S3Y.
S3Y 1:1-29 = DAG 3:24-52
S3Y 1:30-31 = DAG 3:52-53
S3Y 1:33 = DAG 3:54
S3Y 1:32 = DAG 3:55
S3Y 1:34-35 = DAG 3:56-57
S3Y 1:37 = DAG 3:58
S3Y 1:36 = DAG 3:59
S3Y 1:38-68 = DAG 3:60-90
`,Kw=`# Versification  "Russian Protestant"
# Version=1.4
#
# This is the versification used by the "Canonical" (Protestant) edition of the Russian Synodal Bible
# Initial version provided by Peter_Kirk@sil.org
# Corrected 27/May/2003 by matjaz.crnivec@drustvo-svds.si:
#   Number of vss: ISA 3; REV 12
#   Mappings: LEV 14; 1KI 22; 1CH 12; NEH 7; ISA 3; 2CO 11; REV 13
#
# List of books, chapters, verses
# One line per book.
# One entry for each chapter.
# Verse number is the maximum verse number for that chapter.
# See the lines containing ='s below for verse mappings.
#
#------------------------------------------------------------
# Old Testament
GEN 1:31 2:25 3:24 4:26 5:32 6:22 7:24 8:22 9:29 10:32 11:32 12:20 13:18 14:24 15:21 16:16 17:27 18:33 19:38 20:18 21:34 22:24 23:20 24:67 25:34 26:35 27:46 28:22 29:35 30:43 31:55 32:32 33:20 34:31 35:29 36:43 37:36 38:30 39:23 40:23 41:57 42:38 43:34 44:34 45:28 46:34 47:31 48:22 49:33 50:26
EXO 1:22 2:25 3:22 4:31 5:23 6:30 7:25 8:32 9:35 10:29 11:10 12:51 13:22 14:31 15:27 16:36 17:16 18:27 19:25 20:26 21:36 22:31 23:33 24:18 25:40 26:37 27:21 28:43 29:46 30:38 31:18 32:35 33:23 34:35 35:35 36:38 37:29 38:31 39:43 40:38
LEV 1:17 2:16 3:17 4:35 5:19 6:30 7:38 8:36 9:24 10:20 11:47 12:8 13:59 14:56 15:33 16:34 17:16 18:30 19:37 20:27 21:24 22:33 23:44 24:23 25:55 26:46 27:34
NUM 1:54 2:34 3:51 4:49 5:31 6:27 7:89 8:26 9:23 10:36 11:35 12:15 13:34 14:45 15:41 16:50 17:13 18:32 19:22 20:29 21:35 22:41 23:30 24:25 25:18 26:65 27:23 28:31 29:39 30:17 31:54 32:42 33:56 34:29 35:34 36:13
DEU 1:46 2:37 3:29 4:49 5:33 6:25 7:26 8:20 9:29 10:22 11:32 12:32 13:18 14:29 15:23 16:22 17:20 18:22 19:21 20:20 21:23 22:30 23:25 24:22 25:19 26:19 27:26 28:68 29:29 30:20 31:30 32:52 33:29 34:12
JOS 1:18 2:24 3:17 4:24 5:16 6:26 7:26 8:35 9:27 10:43 11:23 12:24 13:33 14:15 15:63 16:10 17:18 18:28 19:51 20:9 21:45 22:34 23:16 24:33
JDG 1:36 2:23 3:31 4:24 5:31 6:40 7:25 8:35 9:57 10:18 11:40 12:15 13:25 14:20 15:20 16:31 17:13 18:31 19:30 20:48 21:25
RUT 1:22 2:23 3:18 4:22
1SA 1:28 2:36 3:21 4:22 5:12 6:21 7:17 8:22 9:27 10:27 11:15 12:25 13:23 14:52 15:35 16:23 17:58 18:30 19:24 20:43 21:15 22:23 23:28 24:23 25:44 26:25 27:12 28:25 29:11 30:31 31:13
2SA 1:27 2:32 3:39 4:12 5:25 6:23 7:29 8:18 9:13 10:19 11:27 12:31 13:39 14:33 15:37 16:23 17:29 18:33 19:43 20:26 21:22 22:51 23:39 24:25
1KI 1:53 2:46 3:28 4:34 5:18 6:38 7:51 8:66 9:28 10:29 11:43 12:33 13:34 14:31 15:34 16:34 17:24 18:46 19:21 20:43 21:29 22:53
2KI 1:18 2:25 3:27 4:44 5:27 6:33 7:20 8:29 9:37 10:36 11:21 12:21 13:25 14:29 15:38 16:20 17:41 18:37 19:37 20:21 21:26 22:20 23:37 24:20 25:30
1CH 1:54 2:55 3:24 4:43 5:26 6:81 7:40 8:40 9:44 10:14 11:47 12:40 13:14 14:17 15:29 16:43 17:27 18:17 19:19 20:8 21:30 22:19 23:32 24:31 25:31 26:32 27:34 28:21 29:30
2CH 1:17 2:18 3:17 4:22 5:14 6:42 7:22 8:18 9:31 10:19 11:23 12:16 13:22 14:15 15:19 16:14 17:19 18:34 19:11 20:37 21:20 22:12 23:21 24:27 25:28 26:23 27:9 28:27 29:36 30:27 31:21 32:33 33:25 34:33 35:27 36:23
EZR 1:11 2:70 3:13 4:24 5:17 6:22 7:28 8:36 9:15 10:44
NEH 1:11 2:20 3:32 4:23 5:19 6:19 7:73 8:18 9:38 10:39 11:36 12:47 13:31
EST 1:22 2:23 3:15 4:17 5:14 6:14 7:10 8:17 9:32 10:3
JOB 1:22 2:13 3:26 4:21 5:27 6:30 7:21 8:22 9:35 10:22 11:20 12:25 13:28 14:22 15:35 16:22 17:16 18:21 19:29 20:29 21:34 22:30 23:17 24:25 25:6 26:14 27:23 28:28 29:25 30:31 31:40 32:22 33:33 34:37 35:16 36:33 37:24 38:41 39:35 40:27 41:26 42:17
PSA 1:6 2:12 3:9 4:9 5:13 6:11 7:18 8:10 9:39 10:7 11:9 12:6 13:7 14:5 15:11 16:15 17:51 18:15 19:10 20:14 21:32 22:6 23:10 24:22 25:12 26:14 27:9 28:11 29:13 30:25 31:11 32:22 33:23 34:28 35:13 36:40 37:23 38:14 39:18 40:14 41:12 42:5 43:27 44:18 45:12 46:10 47:15 48:21 49:23 50:21 51:11 52:7 53:9 54:24 55:14 56:12 57:12 58:18 59:14 60:9 61:13 62:12 63:11 64:14 65:20 66:8 67:36 68:37 69:6 70:24 71:20 72:28 73:23 74:11 75:13 76:21 77:72 78:13 79:20 80:17 81:8 82:19 83:13 84:14 85:17 86:7 87:19 88:53 89:17 90:16 91:16 92:5 93:23 94:11 95:13 96:12 97:9 98:9 99:5 100:8 101:29 102:22 103:35 104:45 105:48 106:43 107:14 108:31 109:7 110:10 111:10 112:9 113:26 114:9 115:10 116:2 117:29 118:176 119:7 120:8 121:9 122:4 123:8 124:5 125:6 126:5 127:6 128:8 129:8 130:3 131:18 132:3 133:3 134:21 135:26 136:9 137:8 138:24 139:14 140:10 141:7 142:12 143:15 144:21 145:10 146:11 147:9 148:14 149:9 150:6
PRO 1:33 2:22 3:35 4:27 5:23 6:35 7:27 8:36 9:18 10:32 11:31 12:28 13:25 14:35 15:33 16:33 17:28 18:24 19:29 20:30 21:31 22:29 23:35 24:34 25:28 26:28 27:27 28:28 29:27 30:33 31:31
ECC 1:18 2:26 3:22 4:17 5:19 6:12 7:29 8:17 9:18 10:20 11:10 12:14
SNG 1:16 2:17 3:11 4:16 5:16 6:12 7:14 8:14
ISA 1:31 2:22 3:25 4:6 5:30 6:13 7:25 8:22 9:21 10:34 11:16 12:6 13:22 14:32 15:9 16:14 17:14 18:7 19:25 20:6 21:17 22:25 23:18 24:23 25:12 26:21 27:13 28:29 29:24 30:33 31:9 32:20 33:24 34:17 35:10 36:22 37:38 38:22 39:8 40:31 41:29 42:25 43:28 44:28 45:25 46:13 47:15 48:22 49:26 50:11 51:23 52:15 53:12 54:17 55:13 56:12 57:21 58:14 59:21 60:22 61:11 62:12 63:19 64:12 65:25 66:24
JER 1:19 2:37 3:25 4:31 5:31 6:30 7:34 8:22 9:26 10:25 11:23 12:17 13:27 14:22 15:21 16:21 17:27 18:23 19:15 20:18 21:14 22:30 23:40 24:10 25:38 26:24 27:22 28:17 29:32 30:24 31:40 32:44 33:26 34:22 35:19 36:32 37:21 38:28 39:18 40:16 41:18 42:22 43:13 44:30 45:5 46:28 47:7 48:47 49:39 50:46 51:64 52:34
LAM 1:22 2:22 3:66 4:22 5:22
EZK 1:28 2:10 3:27 4:17 5:17 6:14 7:27 8:18 9:11 10:22 11:25 12:28 13:23 14:23 15:8 16:63 17:24 18:32 19:14 20:49 21:32 22:31 23:49 24:27 25:17 26:21 27:36 28:26 29:21 30:26 31:18 32:32 33:33 34:31 35:15 36:38 37:28 38:23 39:29 40:49 41:26 42:20 43:27 44:31 45:25 46:24 47:23 48:35
DAN 1:21 2:49 3:33 4:34 5:31 6:28 7:28 8:27 9:27 10:21 11:45 12:13
HOS 1:11 2:23 3:5 4:19 5:15 6:11 7:16 8:14 9:17 10:15 11:12 12:14 13:15 14:10
JOL 1:20 2:32 3:21
AMO 1:15 2:16 3:15 4:13 5:27 6:14 7:17 8:14 9:15
OBA 1:21
JON 1:16 2:11 3:10 4:11
MIC 1:16 2:13 3:12 4:13 5:15 6:16 7:20
NAM 1:15 2:13 3:19
HAB 1:17 2:20 3:19
ZEP 1:18 2:15 3:20
HAG 1:15 2:23
ZEC 1:21 2:13 3:10 4:14 5:11 6:15 7:14 8:23 9:17 10:12 11:17 12:14 13:9 14:21
MAL 1:14 2:17 3:18 4:6
#-------------------------------------------------------
# New Testament books
MAT 1:25 2:23 3:17 4:25 5:48 6:34 7:29 8:34 9:38 10:42 11:30 12:50 13:58 14:36 15:39 16:28 17:27 18:35 19:30 20:34 21:46 22:46 23:39 24:51 25:46 26:75 27:66 28:20
MRK 1:45 2:28 3:35 4:41 5:43 6:56 7:37 8:38 9:50 10:52 11:33 12:44 13:37 14:72 15:47 16:20
LUK 1:80 2:52 3:38 4:44 5:39 6:49 7:50 8:56 9:62 10:42 11:54 12:59 13:35 14:35 15:32 16:31 17:37 18:43 19:48 20:47 21:38 22:71 23:56 24:53
JHN 1:51 2:25 3:36 4:54 5:47 6:71 7:53 8:59 9:41 10:42 11:57 12:50 13:38 14:31 15:27 16:33 17:26 18:40 19:42 20:31 21:25
ACT 1:26 2:47 3:26 4:37 5:42 6:15 7:60 8:40 9:43 10:48 11:30 12:25 13:52 14:28 15:41 16:40 17:34 18:28 19:40 20:38 21:40 22:30 23:35 24:27 25:27 26:32 27:44 28:31
ROM 1:32 2:29 3:31 4:25 5:21 6:23 7:25 8:39 9:33 10:21 11:36 12:21 13:14 14:26 15:33 16:24
1CO 1:31 2:16 3:23 4:21 5:13 6:20 7:40 8:13 9:27 10:33 11:34 12:31 13:13 14:40 15:58 16:24
2CO 1:24 2:17 3:18 4:18 5:21 6:18 7:16 8:24 9:15 10:18 11:32 12:21 13:13
GAL 1:24 2:21 3:29 4:31 5:26 6:18
EPH 1:23 2:22 3:21 4:32 5:33 6:24
PHP 1:30 2:30 3:21 4:23
COL 1:29 2:23 3:25 4:18
1TH 1:10 2:20 3:13 4:18 5:28
2TH 1:12 2:17 3:18
1TI 1:20 2:15 3:16 4:16 5:25 6:21
2TI 1:18 2:26 3:17 4:22
TIT 1:16 2:15 3:15
PHM 1:25
HEB 1:14 2:18 3:19 4:16 5:14 6:20 7:28 8:13 9:28 10:39 11:40 12:29 13:25
JAS 1:27 2:26 3:18 4:17 5:20
1PE 1:25 2:25 3:22 4:19 5:14
2PE 1:21 2:22 3:18
1JN 1:10 2:29 3:24 4:21 5:21
2JN 1:13
3JN 1:15
JUD 1:25
REV 1:20 2:29 3:22 4:11 5:14 6:17 7:17 8:13 9:21 10:11 11:19 12:17 13:18 14:20 15:8 16:21 17:18 18:24 19:21 20:15 21:27 22:21
#
#------------------------------------------------------------
# Mapping
#-------------------------------------------------------------
# Russian = BHS (see org.vrs)
#
# (Note: ranges must not span a chapter, e.g. 4:10-5:11 is illegal)
#
GEN 31:55 = GEN 32:1
GEN 32:1-32 = GEN 32:2-33
EXO 8:1-4 = EXO 7:26-29
EXO 8:5-32 = EXO 8:1-28
EXO 22:1 = EXO 21:37
EXO 22:2-31 = EXO 22:1-30
LEV 6:1-7 = LEV 5:20-26
LEV 6:8-30 = LEV 6:1-23
# LEV 14:55b = LEV 14:56   # cant handle split verses yet
LEV 14:55 = LEV 14:55
LEV 14:55 = LEV 14:56
LEV 14:56 = LEV 14:57
NUM 13:1 = NUM 12:16
NUM 13:2-34 = NUM 13:1-33
NUM 16:36-50 = NUM 17:1-15
NUM 17:1-13 = NUM 17:16-28
NUM 26:1 = NUM 25:19
NUM 26:1 = NUM 26:1
DEU 12:32 = DEU 13:1
DEU 13:1-18 = DEU 13:2-19
DEU 22:30 = DEU 23:1
DEU 23:1-25 = DEU 23:2-26
DEU 29:1 = DEU 28:69
DEU 29:2-29 = DEU 29:1-28
JOS 5:16 = JOS 6:1
JOS 6:1-26 = JOS 6:2-27
1SA 20:43 = 1SA 21:1
1SA 21:1-15 = 1SA 21:2-16
2SA 18:33 = 2SA 19:1
2SA 19:1-43 = 2SA 19:2-44
1KI 4:21-34 = 1KI 5:1-14
1KI 5:1-18 = 1KI 5:15-32
#1KI 22:43b = 1KI 22:44   # cant handle split verses yet
1KI 22:43 = 1KI 22:43
1KI 22:43 = 1KI 22:44
1KI 22:44-53 = 1KI 22:45-54
2KI 11:21 = 2KI 12:1
2KI 12:1-21 = 2KI 12:2-22
1CH 6:1-15 = 1CH 5:27-41
1CH 6:16-81 = 1CH 6:1-66
# 1CH 12:4b = 1CH 12:5   # cant handle split verses yet
1CH 12:4 = 1CH 12:4
1CH 12:4 = 1CH 12:5
1CH 12:5-40 = 1CH 12:6-41
2CH 2:1 = 2CH 1:18
2CH 2:2-18 = 2CH 2:1-17
2CH 14:1 = 2CH 13:23
2CH 14:2-15 = 2CH 14:1-14
NEH 4:1-6 = NEH 3:33-38
NEH 4:7-23 = NEH 4:1-17
# NEH 7:68 = NEH 7:67b   # cant handle split verses yet
NEH 7:67 = NEH 7:67
NEH 7:68 = NEH 7:67
NEH 7:69-73 = NEH 7:68-72
NEH 9:38 = NEH 10:1
NEH 10:1-39 = NEH 10:2-40
JOB 39:31-35 = JOB 40:1-5
JOB 40:1-19 = JOB 40:6-24
JOB 40:20-27 = JOB 40:25-32
# PSA 9 = 9+10
PSA 9:22 = PSA 10:0
PSA 9:22-39 = PSA 10:1-18
PSA 10:0-7 = PSA 11:0-7
PSA 11:0-9 = PSA 12:0-9
PSA 12:0-6 = PSA 13:0-6
PSA 13:0-7 = PSA 14:0-7
PSA 14:0-5 = PSA 15:0-5
PSA 15:0-11 = PSA 16:0-11
PSA 16:0-15 = PSA 17:0-15
PSA 17:0-51 = PSA 18:0-51
PSA 18:0-15 = PSA 19:0-15
PSA 19:0-10 = PSA 20:0-10
PSA 20:0-14 = PSA 21:0-14
PSA 21:0-32 = PSA 22:0-32
PSA 22:0-6 = PSA 23:0-6
PSA 23:0-10 = PSA 24:0-10
PSA 24:0-22 = PSA 25:0-22
PSA 25:0-12 = PSA 26:0-12
PSA 26:0-14 = PSA 27:0-14
PSA 27:0-9 = PSA 28:0-9
PSA 28:0-11 = PSA 29:0-11
PSA 29:0-13 = PSA 30:0-13
PSA 30:0-25 = PSA 31:0-25
PSA 31:0-11 = PSA 32:0-11
PSA 32:0-22 = PSA 33:0-22
PSA 33:0-23 = PSA 34:0-23
PSA 34:0-28 = PSA 35:0-28
PSA 35:0-13 = PSA 36:0-13
PSA 36:0-40 = PSA 37:0-40
PSA 37:0-23 = PSA 38:0-23
PSA 38:0-14 = PSA 39:0-14
PSA 39:0-18 = PSA 40:0-18
PSA 40:0-14 = PSA 41:0-14
PSA 41:0-12 = PSA 42:0-12
PSA 42:0-5 = PSA 43:0-5
PSA 43:0-27 = PSA 44:0-27
PSA 44:0-18 = PSA 45:0-18
PSA 45:0-12 = PSA 46:0-12
PSA 46:0-10 = PSA 47:0-10
PSA 47:0-15 = PSA 48:0-15
PSA 48:0-21 = PSA 49:0-21
PSA 49:0-23 = PSA 50:0-23
PSA 50:0-21 = PSA 51:0-21
PSA 51:0-11 = PSA 52:0-11
PSA 52:0-7 = PSA 53:0-7
PSA 53:0-9 = PSA 54:0-9
PSA 54:0-24 = PSA 55:0-24
PSA 55:0-14 = PSA 56:0-14
PSA 56:0-12 = PSA 57:0-12
PSA 57:0-12 = PSA 58:0-12
PSA 58:0-18 = PSA 59:0-18
PSA 59:0-14 = PSA 60:0-14
PSA 60:0-9 = PSA 61:0-9
PSA 61:0-13 = PSA 62:0-13
PSA 62:0-12 = PSA 63:0-12
PSA 63:0-11 = PSA 64:0-11
PSA 64:0-14 = PSA 65:0-14
PSA 65:0-20 = PSA 66:0-20
PSA 66:0-8 = PSA 67:0-8
PSA 67:0-36 = PSA 68:0-36
PSA 68:0-37 = PSA 69:0-37
PSA 69:0-6 = PSA 70:0-6
PSA 70:0-24 = PSA 71:0-24
PSA 71:0-20 = PSA 72:0-20
PSA 72:0-28 = PSA 73:0-28
PSA 73:0-23 = PSA 74:0-23
PSA 74:0-11 = PSA 75:0-11
PSA 75:0-13 = PSA 76:0-13
PSA 76:0-21 = PSA 77:0-21
PSA 77:0-72 = PSA 78:0-72
PSA 78:0-13 = PSA 79:0-13
PSA 79:0-20 = PSA 80:0-20
PSA 80:0-17 = PSA 81:0-17
PSA 81:0-8 = PSA 82:0-8
PSA 82:0-19 = PSA 83:0-19
PSA 83:0-13 = PSA 84:0-13
PSA 84:0-14 = PSA 85:0-14
PSA 85:0-17 = PSA 86:0-17
PSA 86:0-1 = PSA 87:0-1
PSA 86:2 = PSA 87:1
PSA 86:2-7 = PSA 87:2-7
PSA 87:0-19 = PSA 88:0-19
PSA 88:0-53 = PSA 89:0-53
PSA 89:0-1 = PSA 90:0
PSA 89:2-6 = PSA 90:1-5
PSA 89:6 = PSA 90:6
PSA 89:7-17 = PSA 90:7-17
PSA 90:0-16 = PSA 91:0-16
PSA 91:0-16 = PSA 92:0-16
PSA 92:0-5 = PSA 93:0-5
PSA 93:0-23 = PSA 94:0-23
PSA 94:0-11 = PSA 95:0-11
PSA 95:0-13 = PSA 96:0-13
PSA 96:0-12 = PSA 97:0-12
PSA 97:0-9 = PSA 98:0-9
PSA 98:0-9 = PSA 99:0-9
PSA 99:0-5 = PSA 100:0-5
PSA 100:0-8 = PSA 101:0-8
PSA 101:0-29 = PSA 102:0-29
PSA 102:0-22 = PSA 103:0-22
PSA 103:0-35 = PSA 104:0-35
PSA 104:0-45 = PSA 105:0-45
PSA 105:0-48 = PSA 106:0-48
PSA 106:0-43 = PSA 107:0-43
PSA 107:0-14 = PSA 108:0-14
PSA 108:0-31 = PSA 109:0-31
PSA 109:0-7 = PSA 110:0-7
PSA 110:0-10 = PSA 111:0-10
PSA 111:0-10 = PSA 112:0-10
PSA 112:0-9 = PSA 113:0-9
PSA 113:0-8 = PSA 114:0-8
PSA 113:9 = PSA 115:0
PSA 113:9-26 = PSA 115:1-18
PSA 114:0-9 = PSA 116:0-9
PSA 115:0 = PSA 116:10
PSA 115:1-10 = PSA 116:10-19	
PSA 116:0-2 = PSA 117:0-2
PSA 117:0-29 = PSA 118:0-29
PSA 118:0-176 = PSA 119:0-176
PSA 119:0-7 = PSA 120:0-7
PSA 120:0-8 = PSA 121:0-8
PSA 121:0-9 = PSA 122:0-9
PSA 122:0-4 = PSA 123:0-4
PSA 123:0-8 = PSA 124:0-8
PSA 124:0-5 = PSA 125:0-5
PSA 125:0-6 = PSA 126:0-6
PSA 126:0-5 = PSA 127:0-5
PSA 127:0-6 = PSA 128:0-6
PSA 128:0-8 = PSA 129:0-8
PSA 129:0-8 = PSA 130:0-8
PSA 130:0-3 = PSA 131:0-3
PSA 131:0-18 = PSA 132:0-18
PSA 132:0-3 = PSA 133:0-3
PSA 133:0-3 = PSA 134:0-3
PSA 134:0-21 = PSA 135:0-21
PSA 135:0-26 = PSA 136:0-26
PSA 136:0-9 = PSA 137:0-9
PSA 137:0-8 = PSA 138:0-8
PSA 138:0-24 = PSA 139:0-24
PSA 139:0-14 = PSA 140:0-14
PSA 140:0-10 = PSA 141:0-10
PSA 141:0 = PSA 142:0-1
PSA 141:1-7 = PSA 142:2-8
PSA 142:0-12 = PSA 143:0-12
PSA 143:0-15 = PSA 144:0-15
PSA 144:0-21 = PSA 145:0-21
PSA 145:0-10 = PSA 146:0-10
# 146 + 147 -> 147
PSA 146:0-11 = PSA 147:0-11
PSA 147:0 = PSA 147:12
PSA 147:1-9 = PSA 147:12-20
SNG 1:1-16 = SNG 1:2-17
# ISA 3:19b = ISA 3:20   # cant handle split verses yet
ISA 3:19 = ISA 3:19
ISA 3:19 = ISA 3:20
ISA 3:20-25 = ISA 3:21-26
ISA 9:1 = ISA 8:23
ISA 9:2-21 = ISA 9:1-20
ISA 63:19 = ISA 63:19
ISA 64:1 = ISA 63:19
ISA 64:2-12 = ISA 64:1-11
JER 9:1 = JER 8:23
JER 9:2-26 = JER 9:1-25
EZK 20:45-49 = EZK 21:1-5
EZK 21:1-32 = EZK 21:6-37
DAN 5:31 = DAN 6:1
DAN 6:1-28 = DAN 6:2-29
HOS 1:10-11 = HOS 2:1-2
HOS 2:1-23 = HOS 2:3-25
HOS 11:12 = HOS 12:1
HOS 12:1-14 = HOS 12:2-15
JOL 2:28-32 = JOL 3:1-5
JOL 3:1-21 = JOL 4:1-21
MIC 5:1 = MIC 4:14
MIC 5:2-15 = MIC 5:1-14
NAM 1:15 = NAM 2:1
NAM 2:1-13 = NAM 2:2-14
ZEC 1:18-21 = ZEC 2:1-4
ZEC 2:1-13 = ZEC 2:5-17
MAL 4:1-6 = MAL 3:19-24
ROM 14:24-26 = ROM 16:25-27
# 2CO 11:32b = 2CO 11:33   # cant handle split verses yet
2CO 11:32 = 2CO 11:32
2CO 11:32 = 2CO 11:33
# REV 13:1a = REV 12:18   # cant handle split verses yet
# REV 13:1b = REV 13:1    # cant handle split verses yet
REV 13:1 = REV 12:18
REV 13:1 = REV 13:1
`,Xw=`# Versification  "Russian Orthodox"
# Version=1.3
#
# This is the versification used by the Orthodox (or "non-canonical") edition of the Russian Synodal Bible
# Initial version provided by Peter_Kirk@sil.org
# Corrected 27/May/2003 by matjaz.crnivec@drustvo-svds.si:
#   Number of vss: 2CH 37; PSA 114; ISA 3; REV 12; 2ES (whole book added),
#   Mappings: LEV 14; 1KI 22; 1CH 12; 2CH 37; NEH 7; PSA 114; ISA 3; 2CO 11; REV 13; 2ES 7; 10
#
# modifications by Studge 26/June/2009
# amended by HAB April 2010
#
# List of books, chapters, verses
# One line per book.
# One entry for each chapter.
# Verse number is the maximum verse number for that chapter.
# See the lines containing ='s below for verse mappings.
#
#----------------------------------------------------------
GEN 1:31 2:25 3:24 4:26 5:32 6:22 7:24 8:22 9:29 10:32 11:32 12:20 13:18 14:24 15:21 16:16 17:27 18:33 19:38 20:18 21:34 22:24 23:20 24:67 25:34 26:35 27:46 28:22 29:35 30:43 31:55 32:32 33:20 34:31 35:29 36:43 37:36 38:30 39:23 40:23 41:57 42:38 43:34 44:34 45:28 46:34 47:31 48:22 49:33 50:26
EXO 1:22 2:25 3:22 4:31 5:23 6:30 7:25 8:32 9:35 10:29 11:10 12:51 13:22 14:31 15:27 16:36 17:16 18:27 19:25 20:26 21:36 22:31 23:33 24:18 25:40 26:37 27:21 28:43 29:46 30:38 31:18 32:35 33:23 34:35 35:35 36:38 37:29 38:31 39:43 40:38
LEV 1:17 2:16 3:17 4:35 5:19 6:30 7:38 8:36 9:24 10:20 11:47 12:8 13:59 14:56 15:33 16:34 17:16 18:30 19:37 20:27 21:24 22:33 23:44 24:23 25:55 26:46 27:34
NUM 1:54 2:34 3:51 4:49 5:31 6:27 7:89 8:26 9:23 10:36 11:35 12:15 13:34 14:45 15:41 16:50 17:13 18:32 19:22 20:29 21:35 22:41 23:30 24:25 25:18 26:65 27:23 28:31 29:39 30:17 31:54 32:42 33:56 34:29 35:34 36:13
DEU 1:46 2:37 3:29 4:49 5:33 6:25 7:26 8:20 9:29 10:22 11:32 12:32 13:18 14:29 15:23 16:22 17:20 18:22 19:21 20:20 21:23 22:30 23:25 24:22 25:19 26:19 27:26 28:68 29:29 30:20 31:30 32:52 33:29 34:12
JOS 1:18 2:24 3:17 4:24 5:16 6:26 7:26 8:35 9:27 10:43 11:23 12:24 13:33 14:15 15:63 16:10 17:18 18:28 19:51 20:9 21:45 22:34 23:16 24:36
JDG 1:36 2:23 3:31 4:24 5:31 6:40 7:25 8:35 9:57 10:18 11:40 12:15 13:25 14:20 15:20 16:31 17:13 18:31 19:30 20:48 21:25
RUT 1:22 2:23 3:18 4:22
1SA 1:28 2:36 3:21 4:22 5:12 6:21 7:17 8:22 9:27 10:27 11:15 12:25 13:23 14:52 15:35 16:23 17:58 18:30 19:24 20:43 21:15 22:23 23:28 24:23 25:44 26:25 27:12 28:25 29:11 30:31 31:13
2SA 1:27 2:32 3:39 4:12 5:25 6:23 7:29 8:18 9:13 10:19 11:27 12:31 13:39 14:33 15:37 16:23 17:29 18:33 19:43 20:26 21:22 22:51 23:39 24:25
1KI 1:53 2:46 3:28 4:34 5:18 6:38 7:51 8:66 9:28 10:29 11:43 12:33 13:34 14:31 15:34 16:34 17:24 18:46 19:21 20:43 21:29 22:53
2KI 1:18 2:25 3:27 4:44 5:27 6:33 7:20 8:29 9:37 10:36 11:21 12:21 13:25 14:29 15:38 16:20 17:41 18:37 19:37 20:21 21:26 22:20 23:37 24:20 25:30
1CH 1:54 2:55 3:24 4:43 5:26 6:81 7:40 8:40 9:44 10:14 11:47 12:40 13:14 14:17 15:29 16:43 17:27 18:17 19:19 20:8 21:30 22:19 23:32 24:31 25:31 26:32 27:34 28:21 29:30
2CH 1:17 2:18 3:17 4:22 5:14 6:42 7:22 8:18 9:31 10:19 11:23 12:16 13:22 14:15 15:19 16:14 17:19 18:34 19:11 20:37 21:20 22:12 23:21 24:27 25:28 26:23 27:9 28:27 29:36 30:27 31:21 32:33 33:25 34:33 35:27 36:23 37:12
EZR 1:11 2:70 3:13 4:24 5:17 6:22 7:28 8:36 9:15 10:44
NEH 1:11 2:20 3:32 4:23 5:19 6:19 7:73 8:18 9:38 10:39 11:36 12:47 13:31
#--------------
# Notes EST is the Greek Esther which should have been under ESG
EST 1:22 2:23 3:15 4:17 5:14 6:14 7:10 8:17 9:32 10:3
#--------------
JOB 1:22 2:13 3:26 4:21 5:27 6:30 7:21 8:22 9:35 10:22 11:20 12:25 13:28 14:22 15:35 16:22 17:16 18:21 19:29 20:29 21:34 22:30 23:17 24:25 25:6 26:14 27:23 28:28 29:25 30:31 31:40 32:22 33:33 34:37 35:16 36:33 37:24 38:41 39:35 40:27 41:26 42:17
PSA 1:6 2:12 3:9 4:9 5:13 6:11 7:18 8:10 9:39 10:7 11:9 12:6 13:7 14:5 15:11 16:15 17:51 18:15 19:10 20:14 21:32 22:6 23:10 24:22 25:12 26:14 27:9 28:11 29:13 30:25 31:11 32:22 33:23 34:28 35:13 36:40 37:23 38:14 39:18 40:14 41:12 42:5 43:27 44:18 45:12 46:10 47:15 48:21 49:23 50:21 51:11 52:7 53:9 54:24 55:14 56:12 57:12 58:18 59:14 60:9 61:13 62:12 63:11 64:14 65:20 66:8 67:36 68:37 69:6 70:24 71:20 72:28 73:23 74:11 75:13 76:21 77:72 78:13 79:20 80:17 81:8 82:19 83:13 84:14 85:17 86:7 87:19 88:53 89:17 90:16 91:16 92:5 93:23 94:11 95:13 96:12 97:9 98:9 99:5 100:8 101:29 102:22 103:35 104:45 105:48 106:43 107:14 108:31 109:7 110:10 111:10 112:9 113:26 114:8 115:10 116:2 117:29 118:176 119:7 120:8 121:9 122:4 123:8 124:5 125:6 126:5 127:6 128:8 129:8 130:3 131:18 132:3 133:3 134:21 135:26 136:9 137:8 138:24 139:14 140:10 141:7 142:12 143:15 144:21 145:10 146:11 147:9 148:14 149:9 150:6 151:7
PRO 1:33 2:22 3:35 4:29 5:23 6:35 7:27 8:36 9:18 10:32 11:31 12:28 13:26 14:35 15:33 16:33 17:28 18:25 19:29 20:30 21:31 22:29 23:35 24:34 25:28 26:28 27:27 28:28 29:27 30:33 31:31
ECC 1:18 2:26 3:22 4:17 5:19 6:12 7:29 8:17 9:18 10:20 11:10 12:14
SNG 1:16 2:17 3:11 4:16 5:16 6:12 7:14 8:14
ISA 1:31 2:22 3:25 4:6 5:30 6:13 7:25 8:22 9:21 10:34 11:16 12:6 13:22 14:32 15:9 16:14 17:14 18:7 19:25 20:6 21:17 22:25 23:18 24:23 25:12 26:21 27:13 28:29 29:24 30:33 31:9 32:20 33:24 34:17 35:10 36:22 37:38 38:22 39:8 40:31 41:29 42:25 43:28 44:28 45:25 46:13 47:15 48:22 49:26 50:11 51:23 52:15 53:12 54:17 55:13 56:12 57:21 58:14 59:21 60:22 61:11 62:12 63:19 64:12 65:25 66:24
JER 1:19 2:37 3:25 4:31 5:31 6:30 7:34 8:22 9:26 10:25 11:23 12:17 13:27 14:22 15:21 16:21 17:27 18:23 19:15 20:18 21:14 22:30 23:40 24:10 25:38 26:24 27:22 28:17 29:32 30:24 31:40 32:44 33:26 34:22 35:19 36:32 37:21 38:28 39:18 40:16 41:18 42:22 43:13 44:30 45:5 46:28 47:7 48:47 49:39 50:46 51:64 52:34
LAM 1:22 2:22 3:66 4:22 5:22
EZK 1:28 2:10 3:27 4:17 5:17 6:14 7:27 8:18 9:11 10:22 11:25 12:28 13:23 14:23 15:8 16:63 17:24 18:32 19:14 20:49 21:32 22:31 23:49 24:27 25:17 26:21 27:36 28:26 29:21 30:26 31:18 32:32 33:33 34:31 35:15 36:38 37:28 38:23 39:29 40:49 41:26 42:20 43:27 44:31 45:25 46:24 47:23 48:35
DAN 1:21 2:49 3:100 4:34 5:31 6:28 7:28 8:27 9:27 10:21 11:45 12:13 13:64 14:42
HOS 1:11 2:23 3:5 4:19 5:15 6:11 7:16 8:14 9:17 10:15 11:12 12:14 13:15 14:10
JOL 1:20 2:32 3:21
AMO 1:15 2:16 3:15 4:13 5:27 6:14 7:17 8:14 9:15
OBA 1:21
JON 1:16 2:11 3:10 4:11
MIC 1:16 2:13 3:12 4:13 5:15 6:16 7:20
NAM 1:15 2:13 3:19
HAB 1:17 2:20 3:19
ZEP 1:18 2:15 3:20
HAG 1:15 2:23
ZEC 1:21 2:13 3:10 4:14 5:11 6:15 7:14 8:23 9:17 10:12 11:17 12:14 13:9 14:21
MAL 1:14 2:17 3:18 4:6
#----------------------------------------------------
MAT 1:25 2:23 3:17 4:25 5:48 6:34 7:29 8:34 9:38 10:42 11:30 12:50 13:58 14:36 15:39 16:28 17:27 18:35 19:30 20:34 21:46 22:46 23:39 24:51 25:46 26:75 27:66 28:20
MRK 1:45 2:28 3:35 4:41 5:43 6:56 7:37 8:38 9:50 10:52 11:33 12:44 13:37 14:72 15:47 16:20
LUK 1:80 2:52 3:38 4:44 5:39 6:49 7:50 8:56 9:62 10:42 11:54 12:59 13:35 14:35 15:32 16:31 17:37 18:43 19:48 20:47 21:38 22:71 23:56 24:53
JHN 1:51 2:25 3:36 4:54 5:47 6:71 7:53 8:59 9:41 10:42 11:57 12:50 13:38 14:31 15:27 16:33 17:26 18:40 19:42 20:31 21:25
ACT 1:26 2:47 3:26 4:37 5:42 6:15 7:60 8:40 9:43 10:48 11:30 12:25 13:52 14:28 15:41 16:40 17:34 18:28 19:40 20:38 21:40 22:30 23:35 24:27 25:27 26:32 27:44 28:31
ROM 1:32 2:29 3:31 4:25 5:21 6:23 7:25 8:39 9:33 10:21 11:36 12:21 13:14 14:26 15:33 16:24
1CO 1:31 2:16 3:23 4:21 5:13 6:20 7:40 8:13 9:27 10:33 11:34 12:31 13:13 14:40 15:58 16:24
2CO 1:24 2:17 3:18 4:18 5:21 6:18 7:16 8:24 9:15 10:18 11:32 12:21 13:13
GAL 1:24 2:21 3:29 4:31 5:26 6:18
EPH 1:23 2:22 3:21 4:32 5:33 6:24
PHP 1:30 2:30 3:21 4:23
COL 1:29 2:23 3:25 4:18
1TH 1:10 2:20 3:13 4:18 5:28
2TH 1:12 2:17 3:18
1TI 1:20 2:15 3:16 4:16 5:25 6:21
2TI 1:18 2:26 3:17 4:22
TIT 1:16 2:15 3:15
PHM 1:25
HEB 1:14 2:18 3:19 4:16 5:14 6:20 7:28 8:13 9:28 10:39 11:40 12:29 13:25
JAS 1:27 2:26 3:18 4:17 5:20
1PE 1:25 2:25 3:22 4:19 5:14
2PE 1:21 2:22 3:18
1JN 1:10 2:29 3:24 4:21 5:21
2JN 1:13
3JN 1:15
JUD 1:25
REV 1:20 2:29 3:22 4:11 5:14 6:17 7:17 8:13 9:21 10:11 11:19 12:17 13:18 14:20 15:8 16:21 17:18 18:24 19:21 20:15 21:27 22:21
#---------------------------------------------
TOB 1:22 2:14 3:17 4:21 5:22 6:18 7:17 8:21 9:6 10:13 11:18 12:22 13:18 14:15
JDT 1:16 2:28 3:10 4:15 5:24 6:21 7:32 8:36 9:14 10:23 11:23 12:20 13:20 14:19 15:14 16:25
# ESG added which ought to replace EST
ESG 1:22 2:23 3:15 4:17 5:14 6:14 7:10 8:17 9:32 10:3
WIS 1:16 2:24 3:19 4:20 5:24 6:27 7:30 8:21 9:19 10:21 11:27 12:28 13:19 14:31 15:19 16:29 17:20 18:25 19:21
SIR 1:30 2:18 3:31 4:35 5:18 6:37 7:39 8:22 9:23 10:34 11:34 12:18 13:32 14:27 15:20 16:31 17:31 18:33 19:28 20:31 21:31 22:31 23:37 24:37 25:29 26:27 27:33 28:30 29:31 30:27 31:37 32:25 33:33 34:26 35:23 36:29 37:34 38:39 39:42 40:32 41:29 42:26 43:36 44:27 45:31 46:23 47:31 48:28 49:18 50:31 51:38
BAR 1:22 2:35 3:38 4:37 5:9
LJE 1:72
1MA 1:64 2:70 3:60 4:61 5:68 6:63 7:50 8:32 9:73 10:89 11:74 12:53 13:53 14:49 15:41 16:24
2MA 1:36 2:33 3:40 4:50 5:27 6:31 7:42 8:36 9:29 10:38 11:38 12:45 13:26 14:46 15:39
3MA 1:25 2:24 3:22 4:16 5:36 6:37 7:20
1ES 1:58 2:31 3:24 4:63 5:70 6:34 7:15 8:92 9:55
# in the Russian tradition the book of 1ES is called 2 Esdras [Studge]
2ES 1:40 2:48 3:36 4:52 5:56 6:59 7:70 8:63 9:47 10:60 11:46 12:51 13:58 14:48 15:63 16:78
# in the Russian tradition the book of 2ES is called 3 Esdras [Studge]
# added Prayer of Manasseh which is appended to 2 Chronicles in RSO
MAN 1:15
#
#----------------------------------------------
# Mapping
#----------------------------------------------
# Russian = BHS (see org.vrs)
#
# (Note: ranges must not span a chapter, e.g. 4:10-5:11 is illegal)
#
GEN 31:55 = GEN 32:1
GEN 32:1-32 = GEN 32:2-33
EXO 8:1-4 = EXO 7:26-29
EXO 8:5-32 = EXO 8:1-28
EXO 22:1 = EXO 21:37
EXO 22:2-31 = EXO 22:1-30
LEV 6:1-7 = LEV 5:20-26
LEV 6:8-30 = LEV 6:1-23
# LEV 14:55 = LEV 14:55-56
LEV 14:55 = LEV 14:55
LEV 14:55 = LEV 14:56
LEV 14:56 = LEV 14:57
NUM 13:1 = NUM 12:16
NUM 13:2-34 = NUM 13:1-33
NUM 16:36-50 = NUM 17:1-15
NUM 17:1-13 = NUM 17:16-28
NUM 26:1 = NUM 25:19
NUM 26:1 = NUM 26:1
DEU 12:32 = DEU 13:1
DEU 13:1-18 = DEU 13:2-19
DEU 22:30 = DEU 23:1
DEU 23:1-25 = DEU 23:2-26
DEU 29:1 = DEU 28:69
DEU 29:2-29 = DEU 29:1-28
JOS 5:16 = JOS 6:1
JOS 6:1-26 = JOS 6:2-27
1SA 20:43 = 1SA 21:1
1SA 21:1-15 = 1SA 21:2-16
2SA 18:33 = 2SA 19:1
2SA 19:1-43 = 2SA 19:2-44
1KI 4:21-34 = 1KI 5:1-14
1KI 5:1-18 = 1KI 5:15-32
# 1KI 22:43 = 1KI 22:43-44
1KI 22:43 = 1KI 22:43
1KI 22:43 = 1KI 22:44
1KI 22:44-53 = 1KI 22:45-54
2KI 11:21 = 2KI 12:1
2KI 12:1-21 = 2KI 12:2-22
1CH 6:1-15 = 1CH 5:27-41
1CH 6:16-81 = 1CH 6:1-66
# 1CH 12:4 = 1CH 12:4-5
1CH 12:4 = 1CH 12:4
1CH 12:4 = 1CH 12:5
1CH 12:5-40 = 1CH 12:6-41
2CH 2:1 = 2CH 1:18
2CH 2:2-18 = 2CH 2:1-17
2CH 14:1 = 2CH 13:23
2CH 14:2-15 = 2CH 14:1-14
# All the 37th chapter maps across verse boundaries!
#-----------------------
# Prayer of Manasseh
2CH 37:1 = MAN 1:1
2CH 37:2 = MAN 1:2
2CH 37:2 = MAN 1:3
2CH 37:2 = MAN 1:4
2CH 37:2 = MAN 1:5
2CH 37:3 = MAN 1:5
2CH 37:4 = MAN 1:6
2CH 37:5 = MAN 1:7
2CH 37:6 = MAN 1:7
2CH 37:6 = MAN 1:8
2CH 37:7 = MAN 1:8
2CH 37:7 = MAN 1:9
2CH 37:8 = MAN 1:9
2CH 37:8 = MAN 1:10
2CH 37:9 = MAN 1:10
2CH 37:10 = MAN 1:10
2CH 37:10 = MAN 1:11
2CH 37:11 = MAN 1:12
2CH 37:11 = MAN 1:13
2CH 37:11 = MAN 1:14
2CH 37:11 = MAN 1:15
2CH 37:12 = MAN 1:15
#--------------------------
NEH 4:1-6 = NEH 3:33-38
NEH 4:7-23 = NEH 4:1-17
# NEH 7:67-68 = NEH 7:67
NEH 7:67 = NEH 7:67
NEH 7:68 = NEH 7:67
NEH 7:69-73 = NEH 7:68-72
NEH 9:38 = NEH 10:1
NEH 10:1-39 = NEH 10:2-40
JOB 39:31-35 = JOB 40:1-5
JOB 40:1-19 = JOB 40:6-24
JOB 40:20-27 = JOB 40:25-32
# PSA 9 = 9+10
PSA 9:22 = PSA 10:0
PSA 9:22-39 = PSA 10:1-18
PSA 10:0-7 = PSA 11:0-7
PSA 11:0-9 = PSA 12:0-9
PSA 12:0-6 = PSA 13:0-6
PSA 13:0-7 = PSA 14:0-7
PSA 14:0-5 = PSA 15:0-5
PSA 15:0-11 = PSA 16:0-11
PSA 16:0-15 = PSA 17:0-15
PSA 17:0-51 = PSA 18:0-51
PSA 18:0-15 = PSA 19:0-15
PSA 19:0-10 = PSA 20:0-10
PSA 20:0-14 = PSA 21:0-14
PSA 21:0-32 = PSA 22:0-32
PSA 22:0-6 = PSA 23:0-6
PSA 23:0-10 = PSA 24:0-10
PSA 24:0-22 = PSA 25:0-22
PSA 25:0-12 = PSA 26:0-12
PSA 26:0-14 = PSA 27:0-14
PSA 27:0-9 = PSA 28:0-9
PSA 28:0-11 = PSA 29:0-11
PSA 29:0-13 = PSA 30:0-13
PSA 30:0-25 = PSA 31:0-25
PSA 31:0-11 = PSA 32:0-11
PSA 32:0-22 = PSA 33:0-22
PSA 33:0-23 = PSA 34:0-23
PSA 34:0-28 = PSA 35:0-28
PSA 35:0-13 = PSA 36:0-13
PSA 36:0-40 = PSA 37:0-40
PSA 37:0-23 = PSA 38:0-23
PSA 38:0-14 = PSA 39:0-14
PSA 39:0-18 = PSA 40:0-18
PSA 40:0-14 = PSA 41:0-14
PSA 41:0-12 = PSA 42:0-12
PSA 42:0-5 = PSA 43:0-5
PSA 43:0-27 = PSA 44:0-27
PSA 44:0-18 = PSA 45:0-18
PSA 45:0-12 = PSA 46:0-12
PSA 46:0-10 = PSA 47:0-10
PSA 47:0-15 = PSA 48:0-15
PSA 48:0-21 = PSA 49:0-21
PSA 49:0-23 = PSA 50:0-23
PSA 50:0-21 = PSA 51:0-21
PSA 51:0-11 = PSA 52:0-11
PSA 52:0-7 = PSA 53:0-7
PSA 53:0-9 = PSA 54:0-9
PSA 54:0-24 = PSA 55:0-24
PSA 55:0-14 = PSA 56:0-14
PSA 56:0-12 = PSA 57:0-12
PSA 57:0-12 = PSA 58:0-12
PSA 58:0-18 = PSA 59:0-18
PSA 59:0-14 = PSA 60:0-14
PSA 60:0-9 = PSA 61:0-9
PSA 61:0-13 = PSA 62:0-13
PSA 62:0-12 = PSA 63:0-12
PSA 63:0-11 = PSA 64:0-11
PSA 64:0-14 = PSA 65:0-14
PSA 65:0-20 = PSA 66:0-20
PSA 66:0-8 = PSA 67:0-8
PSA 67:0-36 = PSA 68:0-36
PSA 68:0-37 = PSA 69:0-37
PSA 69:0-6 = PSA 70:0-6
PSA 70:0-24 = PSA 71:0-24
PSA 71:0-20 = PSA 72:0-20
PSA 72:0-28 = PSA 73:0-28
PSA 73:0-23 = PSA 74:0-23
PSA 74:0-11 = PSA 75:0-11
PSA 75:0-13 = PSA 76:0-13
PSA 76:0-21 = PSA 77:0-21
PSA 77:0-72 = PSA 78:0-72
PSA 78:0-13 = PSA 79:0-13
PSA 79:0-20 = PSA 80:0-20
PSA 80:0-17 = PSA 81:0-17
PSA 81:0-8 = PSA 82:0-8
PSA 82:0-19 = PSA 83:0-19
PSA 83:0-13 = PSA 84:0-13
PSA 84:0-14 = PSA 85:0-14
PSA 85:0-17 = PSA 86:0-17
PSA 86:0-1 = PSA 87:1
PSA 86:2 = PSA 87:1
PSA 86:2-7 = PSA 87:2-7
PSA 87:0-19 = PSA 88:0-19
PSA 88:0-53 = PSA 89:0-53
PSA 89:0-1 = PSA 90:0-1
PSA 89:2-6 = PSA 90:1-6
PSA 89:7-17 = PSA 90:7-17
PSA 90:0-16 = PSA 91:0-16
PSA 91:0-16 = PSA 92:0-16
PSA 92:0-5 = PSA 93:0-5
PSA 93:0-23 = PSA 94:0-23
PSA 94:0-11 = PSA 95:0-11
PSA 95:0-13 = PSA 96:0-13
PSA 96:0-12 = PSA 97:0-12
PSA 97:0-9 = PSA 98:0-9
PSA 98:0-9 = PSA 99:0-9
PSA 99:0-5 = PSA 100:0-5
PSA 100:0-8 = PSA 101:0-8
PSA 101:0-29 = PSA 102:0-29
PSA 102:0-22 = PSA 103:0-22
PSA 103:0-35 = PSA 104:0-35
PSA 104:0-45 = PSA 105:0-45
PSA 105:0-48 = PSA 106:0-48
PSA 106:0-43 = PSA 107:0-43
PSA 107:0-14 = PSA 108:0-14
PSA 108:0-31 = PSA 109:0-31
PSA 109:0-7 = PSA 110:0-7
PSA 110:0-10 = PSA 111:0-10
PSA 111:0-10 = PSA 112:0-10
PSA 112:0-9 = PSA 113:0-9
PSA 113:0-8 = PSA 114:0-8
PSA 113:9 = PSA 115:0
PSA 113:9-26 = PSA 115:1-18
PSA 114:0-8 = PSA 116:0-8
PSA 114:8 = PSA 116:9
PSA 115:0-10 = PSA 116:10-19	
PSA 116:0-2 = PSA 117:0-2
PSA 117:0-29 = PSA 118:0-29
PSA 118:0-176 = PSA 119:0-176
PSA 119:0-7 = PSA 120:0-7
PSA 120:0-8 = PSA 121:0-8
PSA 121:0-9 = PSA 122:0-9
PSA 122:0-4 = PSA 123:0-4
PSA 123:0-8 = PSA 124:0-8
PSA 124:0-5 = PSA 125:0-5
PSA 125:0-6 = PSA 126:0-6
PSA 126:0-5 = PSA 127:0-5
PSA 127:0-6 = PSA 128:0-6
PSA 128:0-8 = PSA 129:0-8
PSA 129:0-8 = PSA 130:0-8
PSA 130:0-3 = PSA 131:0-3
PSA 131:0-18 = PSA 132:0-18
PSA 132:0-3 = PSA 133:0-3
PSA 133:0-3 = PSA 134:0-3
PSA 134:0-21 = PSA 135:0-21
PSA 135:0-26 = PSA 136:0-26
PSA 136:0-9 = PSA 137:0-9
PSA 137:0-8 = PSA 138:0-8
PSA 138:0-24 = PSA 139:0-24
PSA 139:0-14 = PSA 140:0-14
PSA 140:0-10 = PSA 141:0-10
PSA 141:0 = PSA 142:0
PSA 141:1-7 = PSA 142:2-8
PSA 142:0-12 = PSA 143:0-12
PSA 143:0-15 = PSA 144:0-15
PSA 144:0-21 = PSA 145:0-21
PSA 145:0-10 = PSA 146:0-10
# 146 + 147 -> 147
PSA 146:0-11 = PSA 147:0-11
PSA 147:0 = PSA 147:12
PSA 147:1-9 = PSA 147:12-20
#---------------------------
# additional LXX Psalm
PSA 151:1-7 = PS2 1:1-7
#----------------------------
PRO 13:15-26 = PRO 13:14-25
PRO 18:9-25 = PRO 18:8-24
SNG 1:1-16 = SNG 1:2-17
# ISA 3:19 = ISA 3:19-20
ISA 3:19 = ISA 3:19
ISA 3:19 = ISA 3:20
ISA 3:20-25 = ISA 3:16-21
ISA 9:1 = ISA 8:23
ISA 9:2-21 = ISA 9:1-20
ISA 63:19 = ISA 63:19
ISA 64:1 = ISA 63:19
ISA 64:2-12 = ISA 64:1-11
JER 9:1 = JER 8:23
JER 9:2-26 = JER 9:1-25
EZK 20:45-49 = EZK 21:1-5
EZK 21:1-32 = EZK 21:6-37
HOS 1:10-11 = HOS 2:1-2
HOS 2:1-23 = HOS 2:3-25
HOS 11:12 = HOS 12:1
HOS 12:1-14 = HOS 12:2-15
JOL 2:28-32 = JOL 3:1-5
JOL 3:1-21 = JOL 4:1-21
MIC 5:1 = MIC 4:14
MIC 5:2-15 = MIC 5:1-14
NAM 1:15 = NAM 2:1
NAM 2:1-13 = NAM 2:2-14
ZEC 1:18-21 = ZEC 2:1-4
ZEC 2:1-13 = ZEC 2:5-17
MAL 4:1-6 = MAL 3:19-24
ROM 14:24-26 = ROM 16:25-27
# 2CO 11:32 = 2CO 11:32-33
2CO 11:32 = 2CO 11:32
2CO 11:32 = 2CO 11:33
# REV 13:1 = REV 12:18-13:1
REV 13:1 = REV 12:18
REV 13:1 = REV 13:1
#----------------------------
2ES 7:36-70 = 2ES 7:106-140
# 2ES 10:59-60 = 2ES 10:59
2ES 10:59 = 2ES 10:59
2ES 10:60 = 2ES 10:59
#---------------------------------------------------------
# Mapping 2 Esdras onto the older Apocalypse of Ezra [Studge]
2ES 3:1-36 = EZA 1:1-36
2ES 4:1-52 = EZA 2:1-52
2ES 5:1-56 = EZA 3:1-56
2ES 6:1-59 = EZA 4:1-59
2ES 7:1-35 = EZA 5:1-35
2ES 7:106-140 = EZA 5:36-70
2ES 8:1-63 = EZA 6:1-63
2ES 9:1-47 = EZA 7:1-47
2ES 10:1-60 = EZA 8:1-60
2ES 11:1-46 = EZA 9:1-46
2ES 12:1-51 = EZA 10:1-51
2ES 13:1-58 = EZA 11:1-58
2ES 14:1-48 = EZA 12:1-48
#----------------------------------------------------
# Mapping Daniel to Hebrew Daniel and Greek additions [HAB]
DAN 3:24-90 = DAG 3:24-90
DAN 3:91-100 = DAN 3:24-33
# Susanna
DAN 13:1-64 = SUS 1:1-64
# Bel and the Dragon
DAN 14:1-42 = BEL 1:1-42
#--------------------------------------------------
# Mapping Esther Greek onto LXX Esther Greek
#
# This maps the standard verses generated by Create Book
# to the actual verse numbers and segments found in the LXX
# ESG chapter 1
ESG 1:1 = ESG 1:1a
ESG 1:2 = ESG 1:1b
ESG 1:3 = ESG 1:1c
ESG 1:4 = ESG 1:1d
ESG 1:5 = ESG 1:1e
ESG 1:6 = ESG 1:1f
ESG 1:7 = ESG 1:1g
ESG 1:8 = ESG 1:1h
ESG 1:9 = ESG 1:1i
ESG 1:10 = ESG 1:1k
ESG 1:11 = ESG 1:1l
ESG 1:12 = ESG 1:1m
ESG 1:13 = ESG 1:1n
ESG 1:14 = ESG 1:1o
ESG 1:15 = ESG 1:1p
ESG 1:16 = ESG 1:1q
ESG 1:17 = ESG 1:1r
ESG 1:18 = ESG 1:1s
ESG 1:19-39 = ESG 1:2-22
# ESG chapter 3
ESG 3:14 = ESG 3:13a
ESG 3:15 = ESG 3:13b
ESG 3:16 = ESG 3:13c
ESG 3:17 = ESG 3:13d
ESG 3:18 = ESG 3:13e
ESG 3:19 = ESG 3:13f
ESG 3:20 = ESG 3:13g
ESG 3:21 = ESG 3:14
ESG 3:22 = ESG 3:15
# ESG chapter 4
ESG 4:18 = ESG 4:17a
ESG 4:19 = ESG 4:17b
ESG 4:20 = ESG 4:17c
ESG 4:21 = ESG 4:17c
ESG 4:22 = ESG 4:17d
ESG 4:23 = ESG 4:17d
ESG 4:24 = ESG 4:17e
ESG 4:25 = ESG 4:17f
ESG 4:26 = ESG 4:17g
ESG 4:27 = ESG 4:17h
ESG 4:28 = ESG 4:17i
ESG 4:29 = ESG 4:17k
ESG 4:30 = ESG 4:17k
ESG 4:31 = ESG 4:17k
ESG 4:32 = ESG 4:17l
ESG 4:33 = ESG 4:17m
ESG 4:34 = ESG 4:17n
ESG 4:35 = ESG 4:17n
ESG 4:36 = ESG 4:17o
ESG 4:37 = ESG 4:17o
ESG 4:38 = ESG 4:17p
ESG 4:39 = ESG 4:17q
ESG 4:40 = ESG 4:17r
ESG 4:41 = ESG 4:17s
ESG 4:42 = ESG 4:17t
ESG 4:43 = ESG 4:17u
ESG 4:44 = ESG 4:17w
ESG 4:45 = ESG 4:17x
ESG 4:46 = ESG 4:17y
ESG 4:47 = ESG 4:17z
# ESG chapter 5
ESG 5:2 = ESG 5:1a
ESG 5:3 = ESG 5:1a
ESG 5:4 = ESG 5:1a
ESG 5:5 = ESG 5:1b
ESG 5:6 = ESG 5:1c
ESG 5:7 = ESG 5:1d
ESG 5:8 = ESG 5:1e
ESG 5:9 = ESG 5:1f
ESG 5:10 = ESG 5:1f
ESG 5:11 = ESG 5:2
ESG 5:12 = ESG 5:2
ESG 5:13 = ESG 5:2a
ESG 5:14 = ESG 5:2a
ESG 5:15 = ESG 5:2b
ESG 5:16 = ESG 5:2b
ESG 5:17-28 = ESG 5:3-14
# ESG chapter 8
ESG 8:13 = ESG 8:12a
ESG 8:14 = ESG 8:12b
ESG 8:15 = ESG 8:12c
ESG 8:16 = ESG 8:12d
ESG 8:17 = ESG 8:12e
ESG 8:18 = ESG 8:12f
ESG 8:19 = ESG 8:12g
ESG 8:20 = ESG 8:12h
ESG 8:21 = ESG 8:12i
ESG 8:22 = ESG 8:12k
ESG 8:23 = ESG 8:12l
ESG 8:24 = ESG 8:12m
ESG 8:25 = ESG 8:12n
ESG 8:26 = ESG 8:12o
ESG 8:27 = ESG 8:12p
ESG 8:28 = ESG 8:12q
ESG 8:29 = ESG 8:12r
ESG 8:30 = ESG 8:12s
ESG 8:31 = ESG 8:12t
ESG 8:32 = ESG 8:12u
ESG 8:33 = ESG 8:12x
ESG 8:34 = ESG 8:12y
ESG 8:35 = ESG 8:12y
ESG 8:36 = ESG 8:12y
ESG 8:37-41 = ESG 8:13-17
# ESG chapter 10
ESG 10:4 = ESG 10:3a
ESG 10:5 = ESG 10:3b
ESG 10:6 = ESG 10:3c
ESG 10:7 = ESG 10:3d
ESG 10:8 = ESG 10:3e
ESG 10:9 = ESG 10:3f
ESG 10:10 = ESG 10:3g
ESG 10:11 = ESG 10:3h
ESG 10:12 = ESG 10:3i
ESG 10:13 = ESG 10:3k
ESG 10:14 = ESG 10:3l
`,zw=`# Versification  "Vulgate"
# Version=1.5
# 
# modifications by Studge 26/June/2009
# this is for Bibles which follow the versification of the Vulgate, mainly Catholic Bibles
# therefore this includes deuterocanonical books from Vulgate and Latin manuscripts
# Vulgate projects in Paratext are VUL83 (Stuttgart text) and NVL98 (Nova Vulgata) [Studge]
#
# mapping for XXA -> PSA has been deleted  [requested by RdB - Barb]
# XXB has been moved to LAO [Barb] Jan 2011
#
# No mapping done for TOB, JDT and SIR, since they seem to follow another 'vorlage' than LXX
# The versification of 2ES present here should become THE standard/original versification of this book! (Vulgate is 'the original' text of this book)
#
# List of books, chapters, verses
# One line per book.
# One entry for each chapter.
# Verse number is the maximum verse number for that chapter.
# See the lines containing ='s below for verse mappings.
#
#-----------------------------------------------------------
# Old Testament
GEN 1:31 2:25 3:24 4:26 5:32 6:22 7:24 8:22 9:29 10:32 11:32 12:20 13:18 14:24 15:21 16:16 17:27 18:33 19:38 20:18 21:34 22:24 23:20 24:67 25:34 26:35 27:46 28:22 29:35 30:43 31:55 32:32 33:20 34:31 35:29 36:43 37:36 38:30 39:23 40:23 41:57 42:38 43:34 44:34 45:28 46:34 47:31 48:22 49:32 50:25
EXO 1:22 2:25 3:22 4:31 5:23 6:30 7:25 8:32 9:35 10:29 11:10 12:51 13:22 14:31 15:27 16:36 17:16 18:27 19:25 20:26 21:36 22:31 23:33 24:18 25:40 26:37 27:21 28:43 29:46 30:38 31:18 32:35 33:23 34:35 35:35 36:38 37:29 38:31 39:43 40:36
LEV 1:17 2:16 3:17 4:35 5:19 6:30 7:38 8:36 9:24 10:20 11:47 12:8 13:59 14:57 15:33 16:34 17:16 18:30 19:37 20:27 21:24 22:33 23:44 24:23 25:55 26:45 27:34
NUM 1:54 2:34 3:51 4:49 5:31 6:27 7:89 8:26 9:23 10:36 11:34 12:15 13:34 14:45 15:41 16:50 17:13 18:32 19:22 20:30 21:35 22:41 23:30 24:25 25:18 26:65 27:23 28:31 29:39 30:17 31:54 32:42 33:56 34:29 35:34 36:13
DEU 1:46 2:37 3:29 4:49 5:33 6:25 7:26 8:20 9:29 10:22 11:32 12:32 13:18 14:29 15:23 16:22 17:20 18:22 19:21 20:20 21:23 22:30 23:25 24:22 25:19 26:19 27:26 28:68 29:29 30:20 31:30 32:52 33:29 34:12
JOS 1:18 2:24 3:17 4:25 5:16 6:27 7:26 8:35 9:27 10:43 11:23 12:24 13:33 14:15 15:63 16:10 17:18 18:28 19:51 20:9 21:43 22:34 23:16 24:33
JDG 1:36 2:23 3:31 4:24 5:32 6:40 7:25 8:35 9:57 10:18 11:40 12:15 13:25 14:20 15:20 16:31 17:13 18:31 19:30 20:48 21:24
RUT 1:22 2:23 3:18 4:22
1SA 1:28 2:36 3:21 4:22 5:12 6:21 7:17 8:22 9:27 10:27 11:15 12:25 13:23 14:52 15:35 16:23 17:58 18:30 19:24 20:43 21:15 22:23 23:28 24:23 25:44 26:25 27:12 28:25 29:11 30:31 31:13
2SA 1:27 2:32 3:39 4:12 5:25 6:23 7:29 8:18 9:13 10:19 11:27 12:31 13:39 14:33 15:37 16:23 17:29 18:33 19:43 20:26 21:22 22:51 23:39 24:25
1KI 1:53 2:46 3:28 4:34 5:18 6:38 7:51 8:66 9:28 10:29 11:43 12:33 13:34 14:31 15:34 16:34 17:24 18:46 19:21 20:43 21:29 22:54
2KI 1:18 2:25 3:27 4:44 5:27 6:33 7:20 8:29 9:37 10:36 11:21 12:21 13:25 14:29 15:38 16:20 17:41 18:37 19:37 20:21 21:26 22:20 23:37 24:20 25:30
1CH 1:54 2:55 3:24 4:43 5:26 6:81 7:40 8:40 9:44 10:14 11:46 12:40 13:14 14:17 15:29 16:43 17:27 18:17 19:19 20:7 21:30 22:19 23:32 24:31 25:31 26:32 27:34 28:21 29:30
2CH 1:17 2:18 3:17 4:22 5:14 6:42 7:22 8:18 9:31 10:19 11:23 12:16 13:22 14:15 15:19 16:14 17:19 18:34 19:11 20:37 21:20 22:12 23:21 24:27 25:28 26:23 27:9 28:27 29:36 30:27 31:21 32:33 33:25 34:33 35:27 36:23
EZR 1:11 2:70 3:13 4:24 5:17 6:22 7:28 8:36 9:15 10:44
# EZR is for the Vulgate book called 1 Esdras
NEH 1:11 2:20 3:31 4:23 5:19 6:19 7:73 8:18 9:38 10:39 11:36 12:46 13:31
# NEH is for the Vulgate book called 2 Esdras
#------------------------------------
# In the Vulgate projects VUL83 Esther is the Greek Esther not Hebrew Esther, this definition is for Greek Esther. The book has been put under EST instead of ESG [Studge]
# in VUL83 the definition of EST is
#EST 1:22 2:23 3:15 4:17 5:14 6:14 7:10 8:17 9:32 10:13 11:12 12:6 13:18 14:19 15:19 16:24
# in NVL98 Nova Vulgata the definition of EST is
EST 1:32 2:23 3:15 4:47 5:28 6:14 7:10 8:41 9:32 10:13 
# Note that chapter 3 v 15 is 15a-i
# Note that chapter 4 v 47 is 17aa-kk
#-----------------------------------
JOB 1:22 2:13 3:26 4:21 5:27 6:30 7:21 8:22 9:35 10:22 11:20 12:25 13:28 14:22 15:35 16:23 17:16 18:21 19:29 20:29 21:34 22:30 23:17 24:25 25:6 26:14 27:23 28:28 29:25 30:31 31:40 32:22 33:33 34:37 35:16 36:33 37:24 38:41 39:35 40:28 41:25 42:16
PSA 1:6 2:13 3:9 4:10 5:13 6:11 7:18 8:10 9:39 10:8 11:9 12:6 13:7 14:5 15:10 16:15 17:51 18:15 19:10 20:14 21:32 22:6 23:10 24:22 25:12 26:14 27:9 28:11 29:13 30:25 31:11 32:22 33:23 34:28 35:13 36:40 37:23 38:14 39:18 40:14 41:12 42:5 43:26 44:18 45:12 46:10 47:15 48:21 49:23 50:21 51:11 52:7 53:9 54:24 55:13 56:12 57:12 58:18 59:14 60:9 61:13 62:12 63:11 64:14 65:20 66:8 67:36 68:37 69:6 70:24 71:20 72:28 73:23 74:11 75:13 76:21 77:72 78:13 79:20 80:17 81:8 82:19 83:13 84:14 85:17 86:7 87:19 88:53 89:17 90:16 91:16 92:5 93:23 94:11 95:13 96:12 97:9 98:9 99:5 100:8 101:29 102:22 103:35 104:45 105:48 106:43 107:14 108:31 109:7 110:10 111:10 112:9 113:26 114:9 115:19 116:2 117:29 118:176 119:7 120:8 121:9 122:4 123:8 124:5 125:6 126:5 127:6 128:8 129:8 130:3 131:18 132:3 133:3 134:21 135:26 136:9 137:8 138:24 139:14 140:10 141:8 142:12 143:15 144:21 145:10 146:11 147:20 148:14 149:9 150:6
PRO 1:33 2:22 3:35 4:27 5:23 6:35 7:27 8:36 9:18 10:32 11:31 12:28 13:25 14:35 15:33 16:33 17:28 18:24 19:29 20:30 21:31 22:29 23:35 24:34 25:28 26:28 27:27 28:28 29:27 30:33 31:31
ECC 1:18 2:26 3:22 4:17 5:19 6:11 7:30 8:17 9:18 10:20 11:10 12:14
SNG 1:16 2:17 3:11 4:16 5:17 6:12 7:13 8:14
ISA 1:31 2:22 3:26 4:6 5:30 6:13 7:25 8:22 9:21 10:34 11:16 12:6 13:22 14:32 15:9 16:14 17:14 18:7 19:25 20:6 21:17 22:25 23:18 24:23 25:12 26:21 27:13 28:29 29:24 30:33 31:9 32:20 33:24 34:17 35:10 36:22 37:38 38:22 39:8 40:31 41:29 42:25 43:28 44:28 45:25 46:13 47:15 48:22 49:26 50:11 51:23 52:15 53:12 54:17 55:13 56:12 57:21 58:14 59:21 60:22 61:11 62:12 63:19 64:12 65:25 66:24
JER 1:19 2:37 3:25 4:31 5:31 6:30 7:34 8:22 9:26 10:25 11:23 12:17 13:27 14:22 15:21 16:21 17:27 18:23 19:15 20:18 21:14 22:30 23:40 24:10 25:38 26:24 27:22 28:17 29:32 30:24 31:40 32:44 33:26 34:22 35:19 36:32 37:20 38:28 39:18 40:16 41:18 42:22 43:13 44:30 45:5 46:28 47:7 48:47 49:39 50:46 51:64 52:34
LAM 1:22 2:22 3:66 4:22 5:22
EZK 1:28 2:9 3:27 4:17 5:17 6:14 7:27 8:18 9:11 10:22 11:25 12:28 13:23 14:23 15:8 16:63 17:24 18:32 19:14 20:49 21:32 22:31 23:49 24:27 25:17 26:21 27:36 28:26 29:21 30:26 31:18 32:32 33:33 34:31 35:15 36:38 37:28 38:23 39:29 40:49 41:26 42:20 43:27 44:31 45:25 46:24 47:23 48:35
#-------------------
# Daniel in NVL98 has 14 chapters and is Greek LXX Daniel
# the Additions to Daniel are repeated in S3Y, SUS and BEL in NVL98
# in NVL98 and VUL83, DAN is used for Greek Daniel and it should be under DAG
DAN 1:21 2:49 3:100 4:34 5:31 6:28 7:28 8:27 9:27 10:21 11:45 12:13 13:65 14:41
#
#--------------------
HOS 1:11 2:24 3:5 4:19 5:15 6:11 7:16 8:14 9:17 10:15 11:12 12:14 13:15 14:10
JOL 1:20 2:32 3:21
AMO 1:15 2:16 3:15 4:13 5:27 6:15 7:17 8:14 9:15
OBA 1:21
JON 1:16 2:11 3:10 4:11
MIC 1:16 2:13 3:12 4:13 5:14 6:16 7:20
NAM 1:15 2:13 3:19
HAB 1:17 2:20 3:19
ZEP 1:18 2:15 3:20
HAG 1:14 2:24
ZEC 1:21 2:13 3:10 4:14 5:11 6:15 7:14 8:23 9:17 10:12 11:17 12:14 13:9 14:21
MAL 1:14 2:17 3:18 4:6
#--------------------------------------
# New Testament books
MAT 1:25 2:23 3:17 4:25 5:48 6:34 7:29 8:34 9:38 10:42 11:30 12:50 13:58 14:36 15:39 16:28 17:26 18:35 19:30 20:34 21:46 22:46 23:39 24:51 25:46 26:75 27:66 28:20
MRK 1:45 2:28 3:35 4:40 5:43 6:56 7:37 8:39 9:49 10:52 11:33 12:44 13:37 14:72 15:47 16:20
LUK 1:80 2:52 3:38 4:44 5:39 6:49 7:50 8:56 9:62 10:42 11:54 12:59 13:35 14:35 15:32 16:31 17:37 18:43 19:48 20:47 21:38 22:71 23:56 24:53
JHN 1:51 2:25 3:36 4:54 5:47 6:72 7:53 8:59 9:41 10:42 11:57 12:50 13:38 14:31 15:27 16:33 17:26 18:40 19:42 20:31 21:25
ACT 1:26 2:47 3:26 4:37 5:42 6:15 7:59 8:40 9:43 10:48 11:30 12:25 13:52 14:27 15:41 16:40 17:34 18:28 19:40 20:38 21:40 22:30 23:35 24:27 25:27 26:32 27:44 28:31
ROM 1:32 2:29 3:31 4:25 5:21 6:23 7:25 8:39 9:33 10:21 11:36 12:21 13:14 14:23 15:33 16:27
1CO 1:31 2:16 3:23 4:21 5:13 6:20 7:40 8:13 9:27 10:33 11:34 12:31 13:13 14:40 15:58 16:24
2CO 1:24 2:17 3:18 4:18 5:21 6:18 7:16 8:24 9:15 10:18 11:33 12:21 13:13
GAL 1:24 2:21 3:29 4:31 5:26 6:18
EPH 1:23 2:22 3:21 4:32 5:33 6:24
PHP 1:30 2:30 3:21 4:23
COL 1:29 2:23 3:25 4:18
1TH 1:10 2:20 3:13 4:18 5:28
2TH 1:12 2:17 3:18
1TI 1:20 2:15 3:16 4:16 5:25 6:21
2TI 1:18 2:26 3:17 4:22
TIT 1:16 2:15 3:15
PHM 1:25
HEB 1:14 2:18 3:19 4:16 5:14 6:20 7:28 8:13 9:28 10:39 11:40 12:29 13:25
JAS 1:27 2:26 3:18 4:17 5:20
1PE 1:25 2:25 3:22 4:19 5:14
2PE 1:21 2:22 3:18
1JN 1:10 2:29 3:24 4:21 5:21
2JN 1:13
3JN 1:15
JUD 1:25
REV 1:20 2:29 3:22 4:11 5:14 6:17 7:17 8:13 9:21 10:11 11:19 12:18 13:18 14:20 15:8 16:21 17:18 18:24 19:21 20:15 21:27 22:21
#-------------------------------------------------
# Deuterocanonical books in the Catholic tradition
TOB 1:25 2:23 3:25 4:23 5:28 6:22 7:20 8:24 9:12 10:13 11:21 12:22 13:23 14:17
JDT 1:12 2:18 3:15 4:17 5:29 6:21 7:25 8:34 9:19 10:20 11:21 12:20 13:31 14:18 15:15 16:31
#---------
# ESG for Esther Greek has been put under EST in NVL98, a blank ESG was included in VUL83
# this definition for ESG is for the full Esther Greek which is in the Vulgate NVL98 [Studge]
ESG 1:39 2:23 3:22 4:47 5:28 6:14 7:10 8:39 9:32 10:13
#---------
WIS 1:16 2:25 3:19 4:20 5:24 6:27 7:30 8:21 9:19 10:21 11:27 12:27 13:19 14:31 15:19 16:29 17:20 18:25 19:20
SIR 1:40 2:23 3:34 4:36 5:18 6:37 7:40 8:22 9:25 10:34 11:36 12:19 13:32 14:27 15:22 16:31 17:31 18:33 19:28 20:33 21:31 22:33 23:38 24:47 25:36 26:28 27:33 28:30 29:35 30:27 31:42 32:28 33:33 34:31 35:26 36:28 37:34 38:39 39:41 40:32 41:28 42:26 43:37 44:27 45:31 46:23 47:31 48:28 49:19 50:31 51:38 52:13
BAR 1:22 2:35 3:38 4:37 5:9 6:72
LJE 1:72
# NB Letter of Jeremiah is chapter 6 of Baruch in the Vulgate tradition [Studge]
# the 3 additions to Daniel are part of Daniel in the Vulgate tradition [Studge]
S3Y 1:67
SUS 1:64
BEL 1:42
1MA 1:67 2:70 3:60 4:61 5:68 6:63 7:50 8:32 9:73 10:89 11:74 12:54 13:54 14:49 15:41 16:24
2MA 1:36 2:33 3:40 4:50 5:27 6:31 7:42 8:36 9:29 10:38 11:38 12:46 13:26 14:46 15:40
#--------------------------------------------------
# Note that 3MA and 4MA are in the LXX tradition but not in the Vulgate, and not in VUL83 Latin critical text, but maybe in Interconfessional editions [Studge]
3MA 1:29 2:33 3:30 4:21 5:51 6:41 7:23
4MA 1:35 2:24 3:21 4:26 5:38 6:35 7:23 8:29 9:32 10:21 11:27 12:19 13:27 14:20 15:32 16:25 17:24 18:24
#----------------------------------------------------
# 1ES, 2ES, MAN and PS2 are in the Vulgate Apocrypha, but not in modern Catholic Bibles, but maybe in Interconfessional editions [Studge]
1ES 1:58 2:31 3:24 4:63 5:73 6:34 7:15 8:97 9:56
# 1ES is for the Vulgate book called 3 Esdras
2ES 1:40 2:48 3:36 4:52 5:55 6:59 7:139 8:63 9:47 10:60 11:46 12:51 13:58 14:47 15:63 16:78
# 2ES is for the Vulgate book called 4 Esdras
MAN 1:15
PS2 1:7
#-----------------------------------------------------
# ODA and PSS are only in LXX and SYR and not needed in any Vulgate manuscripts or any Catholic Bibles, I am not convinced they are needed in this versification file [Studge]
#ODA 1:19 2:43 3:10 4:19 5:12 6:8 7:20 8:37 9:22 10:9 11:11 12:15 13:4 14:46
#PSS 1:8 2:37 3:12 4:25 5:19 6:6 7:10 8:34 9:11 10:8 11:9 12:6 13:12 14:10 15:13 16:15 17:46 18:12
#------------------------------------------------------
# Variant LXX books, only used in LXX, now obselete in Paratext 7, never part of Vulgate
# if these codes were used in any Vulgate versification projects they used the wrong code, and so the definitions are not relevant [Studge]
# JSA 1:18 2:24 3:17 4:24 5:15 6:27 7:26 8:35 9:27 10:43 11:23 12:24 13:33 14:15 15:63 16:10 17:18 18:28 19:51 20:9 21:45 22:34 23:16 24:33
# JDB 1:36 2:23 3:31 4:24 5:31 6:40 7:25 8:35 9:57 10:18 11:40 12:15 13:25 14:20 15:20 16:31 17:13 18:31 19:30 20:48 21:25
# TBS 1:22 2:14 3:17 4:21 5:23 6:19 7:17 8:21 9:6 10:14 11:19 12:22 13:18 14:15
# SST 1:64
# DNT 1:21 2:49 3:97 4:37 5:30 6:29 7:28 8:27 9:27 10:21 11:45 12:13
# BLT 1:42
#------------------------------------------------------
# add in versifications for 4,5 & 6 Ezra which are in Latin manuscripts [Studge]
5EZ 1:40 2:48 
EZA 1:36 2:52 3:55 4:59 5:139 6:63 7:47 8:60 9:46 10:51 11:58 12:47 
6EZ 1:63 12:78
#------------------------------------------------------
# XXA and XXB books in project VUL83, left for backward compatability
# XXA was used for a variant form of Psalms, but should be in a Latin Variant project [Studge]
# XXA 1:6 2:13 3:9 4:10 5:13 6:11 7:18 8:10 9:39 10:8 11:9 12:6 13:7 14:5 15:10 16:15 17:51 18:15 19:10 20:14 21:32 22:6 23:10 24:22 25:12 26:14 27:9 28:11 29:13 30:25 31:11 32:22 33:23 34:28 35:13 36:40 37:23 38:14 39:18 40:14 41:12 42:5 43:26 44:18 45:12 46:10 47:15 48:21 49:23 50:21 51:11 52:7 53:9 54:24 55:13 56:12 57:12 58:18 59:14 60:9 61:13 62:12 63:11 64:14 65:20 66:8 67:36 68:37 69:6 70:24 71:20 72:28 73:23 74:11 75:13 76:21 77:72 78:13 79:20 80:17 81:8 82:19 83:13 84:14 85:17 86:7 87:19 88:53 89:17 90:16 91:16 92:5 93:23 94:11 95:13 96:12 97:9 98:9 99:5 100:8 101:29 102:22 103:35 104:45 105:48 106:43 107:14 108:31 109:7 110:10 111:10 112:9 113:26 114:9 115:19 116:2 117:29 118:176 119:7 120:8 121:9 122:4 123:8 124:5 125:6 126:5 127:6 128:8 129:8 130:3 131:18 132:3 133:3 134:21 135:26 136:9 137:8 138:24 139:14 140:10 141:8 142:12 143:15 144:21 145:10 146:11 147:20 148:14 149:9 150:6
# XXB was used for the Letter to the Laodiceans, but should be under LAO [Studge]
# XXB 1:20
#----------------------------------------------------------
# Daniel Greek is currently under DAN [Studge]
DAG 1:21 2:49 3:97 4:37 5:31 6:28 7:28 8:27 9:27 10:21 11:45 12:13 13:64 14:42
# Letter to the Laodiceans in the VUL83 and some mediaeval translations of the Vulgate e.g. John Wycliffe's English Bible, appeared after Revelation [Studge]
LAO 1:20
#----------------------------------------------------------
# Mapping
#----------------------------------------------------------
# Vulgate = BHS (see org.vrs)
#
# (Note: for performance reasons ranges must not span a chapter, e.g. 4:10-5:11 is illegal)
#
GEN 31:55 = GEN 32:1
GEN 32:1-32 = GEN 32:2-33
# missing <- GEN 49:32
GEN 49:31 = GEN 49:31
GEN 49:31 = GEN 49:32
GEN 49:32 = GEN 49:33
# GEN 50:22 <- GEN 50:22-23
GEN 50:22 = GEN 50:22
GEN 50:22 = GEN 50:23
GEN 50:23-25 = GEN 50:24-26
EXO 8:1-4 = EXO 7:26-29
EXO 8:5-32 = EXO 8:1-28
EXO 22:1 = EXO 21:37
EXO 22:2-31 = EXO 22:1-30
# EXO 40:13 <- EXO 40:13-15
EXO 40:13 = EXO 40:13
EXO 40:13 = EXO 40:14
EXO 40:13 = EXO 40:15
EXO 40:14-36 = EXO 40:16-38
LEV 6:1-7 = LEV 5:20-26
LEV 6:8-30 = LEV 6:1-23
# LEV 26:45 <- LEV 26:45-46
LEV 26:45 = LEV 26:45
LEV 26:45 = LEV 26:46
# NUM 11:34 <- NUM 11:34-35
NUM 11:34 = NUM 11:34
NUM 11:34 = NUM 11:35
NUM 13:1 = NUM 12:16
NUM 13:2-34 = NUM 13:1-33
NUM 16:36-50 = NUM 17:1-15
NUM 17:1-13 = NUM 17:16-28
# NUM 20:28-29 -> NUM 20:28
NUM 20:28 = NUM 20:28
NUM 20:29 = NUM 20:28
NUM 20:30 = NUM 20:29
# NUM 26:1 <- NUM 25:19--26:1
NUM 26:1 = NUM 25:19
NUM 26:1 = NUM 26:1
DEU 12:32 = DEU 13:1
DEU 13:1-18 = DEU 13:2-19
DEU 22:30 = DEU 23:1
DEU 23:1-25 = DEU 23:2-26
DEU 29:1 = DEU 28:69
DEU 29:2-29 = DEU 29:1-28
# JOS 4:23-24 -> JOS 4:23
JOS 4:23 = JOS 4:23
JOS 4:24 = JOS 4:23
JOS 4:25 = JOS 4:24
# JOS 5:14-15 -> JOS 5:14
JOS 5:14 = JOS 5:14
JOS 5:15 = JOS 5:14
JOS 5:16 = JOS 5:15
# JOS 21:36 (missing) <- JOS 21:36-37
JOS 21:36 = JOS 21:36
JOS 21:36 = JOS 21:37
# JOS 21:37 <- JOS 21:38-39
JOS 21:37 = JOS 21:38
JOS 21:37 = JOS 21:39
JOS 21:38-43 = JOS 21:40-45
# JDG 5:31-32 -> JDG 5:31
JDG 5:31 = JDG 5:31
JDG 5:32 = JDG 5:31
# JDG 21:24 <- JDG 21:24-25
JDG 21:24 = JDG 21:24
JDG 21:24 = JDG 21:25
1SA 20:43 = 1SA 21:1
1SA 21:1-15 = 1SA 21:2-16
2SA 18:33 = 2SA 19:1
2SA 19:1-43 = 2SA 19:2-44
1KI 4:21-34 = 1KI 5:1-14
1KI 5:1-18 = 1KI 5:15-32
2KI 11:21 = 2KI 12:1
2KI 12:1-21 = 2KI 12:2-22
1CH 6:1-15 = 1CH 5:27-41
1CH 6:16-81 = 1CH 6:1-66
# 1CH 11:46 <- 1CH 11:46-47
1CH 11:46 = 1CH 11:46
1CH 11:46 = 1CH 11:47
# 1CH 12:4 <- 1CH 12:4-5
1CH 12:4 = 1CH 12:4
1CH 12:4 = 1CH 12:5
1CH 12:5-40 = 1CH 12:6-41
# 1CH 20:7 <- 1CH 20:7-8
1CH 20:7 = 1CH 20:7
1CH 20:7 = 1CH 20:8
2CH 2:1 = 2CH 1:18
2CH 2:2-18 = 2CH 2:1-17
2CH 14:1 = 2CH 13:23
2CH 14:2-15 = 2CH 14:1-14
# NEH 3:30 <- NEH 3:30-31
NEH 3:30 = NEH 3:30
NEH 3:30 = NEH 3:31
NEH 3:31 = NEH 3:32
NEH 4:1-6 = NEH 3:33-38
NEH 4:7-23 = NEH 4:1-17
# NEH 7:68 (missing) -> NEH 7:67b
NEH 7:67 = NEH 7:67
NEH 7:68 = NEH 7:67
NEH 7:69-73 = NEH 7:68-72
NEH 9:38 = NEH 10:1
NEH 10:1-39 = NEH 10:2-40
# NEH 12:33 <- NEH 12:33-34
NEH 12:33 = NEH 12:33
NEH 12:33 = NEH 12:34
NEH 12:34-46 = NEH 12:35-47
# mapping EST onto ESG, it should map ESG onto EST
#EST 10:4-13 = ESG 1:4-13
#EST 11:1-12 = ESG 2:1-12
#EST 12:1-6 = ESG 3:1-6
#EST 13:1-18 = ESG 4:1-18
#EST 14:1-19 = ESG 5:1-19
#EST 15:1-16 = ESG 6:1-16
#EST 16:1-24 = ESG 7:1-24
# JOB 16:4-5 -> JOB 16:4
JOB 16:4 = JOB 16:4
JOB 16:5 = JOB 16:4
JOB 16:6-23 = JOB 16:5-22
JOB 39:31-35 = JOB 40:1-5
JOB 40:1-27 = JOB 40:6-32
JOB 40:28 = JOB 41:1
JOB 41:1-25 = JOB 41:2-26
# JOB 42:16 <- JOB 42:16-17
JOB 42:16 = JOB 42:16
JOB 42:16 = JOB 42:17
# In PSA, the equivalent mappings (in chs. 1-9; 147-150) are given too, because XXA is mapped to PSA as well !!!
# There could still be some errors regarding the irregular mapping of psalm titles (like in PSA 12:1 <- PSA 13:1-2)
PSA 1:0-6 = PSA 1:0-6
PSA 2:0-11 = PSA 2:0-11
# PSA 2:12-13 -> PSA 2:12
PSA 2:12 = PSA 2:12
PSA 2:13 = PSA 2:12
PSA 3:0-9 = PSA 3:0-9
PSA 4:0-8 = PSA 4:0-8
# PSA 4:9-10 -> PSA 4:9
PSA 4:9 = PSA 4:9
PSA 4:10 = PSA 4:9
PSA 5:0-13 = PSA 5:0-13
PSA 6:0-11 = PSA 6:0-11
PSA 7:0-18 = PSA 7:0-18
PSA 8:0-10 = PSA 8:0-10
PSA 9:0-21 = PSA 9:0-21
PSA 9:22 = PSA 10:0
PSA 9:22-39 = PSA 10:1-18
# PSA 10:1-2 -> PSA 11:1
PSA 10:0-1 = PSA 11:0-1
PSA 10:2 = PSA 11:1
PSA 10:3-8 = PSA 11:2-7
PSA 11:0-9 = PSA 12:0-9
# PSA 12:1 <- PSA 13:1-2
PSA 12:0-1 = PSA 13:0-1
PSA 12:1 = PSA 13:2
# PSA 12:2-3 -> PSA 13:3
PSA 12:2 = PSA 13:3
PSA 12:3 = PSA 13:3
PSA 12:4-6 = PSA 13:4-6
PSA 13:0-7 = PSA 14:0-7
PSA 14:0-1 = PSA 15:0-1
# PSA 14:3a = PSA 15:2b
PSA 14:2 = PSA 15:2
PSA 14:3 = PSA 15:2
PSA 14:3 = PSA 15:3
PSA 14:4-5 = PSA 15:4-5
PSA 15:0-9 = PSA 16:0-9
# PSA 15:10 <- PSA 16:10-11
PSA 15:10 = PSA 16:10
PSA 15:10 = PSA 16:11
PSA 16:0-15 = PSA 17:0-15
PSA 17:0-51 = PSA 18:0-51
PSA 18:0-15 = PSA 19:0-15
PSA 19:0-10 = PSA 20:0-10
PSA 20:0-14 = PSA 21:0-14
PSA 21:0-32 = PSA 22:0-32
PSA 22:0-6 = PSA 23:0-6
PSA 23:0-10 = PSA 24:0-10
PSA 24:0-22 = PSA 25:0-22
PSA 25:0-12 = PSA 26:0-12
PSA 26:0-14 = PSA 27:0-14
PSA 27:0-9 = PSA 28:0-9
PSA 28:0-11 = PSA 29:0-11
PSA 29:0-13 = PSA 30:0-13
PSA 30:0-25 = PSA 31:0-25
PSA 31:0-11 = PSA 32:0-11
PSA 32:0-22 = PSA 33:0-22
PSA 33:0-23 = PSA 34:0-23
PSA 34:0-28 = PSA 35:0-28
PSA 35:0-13 = PSA 36:0-13
PSA 36:0-40 = PSA 37:0-40
PSA 37:0-23 = PSA 38:0-23
PSA 38:0-14 = PSA 39:0-14
PSA 39:0-18 = PSA 40:0-18
PSA 40:0-14 = PSA 41:0-14
PSA 41:0-12 = PSA 42:0-12
PSA 42:0-5 = PSA 43:0-5
PSA 43:0-21 = PSA 44:0-21
# PSA 43:22 <- PSA 44:22-23
PSA 43:22 = PSA 44:22
PSA 43:22 = PSA 44:23
PSA 43:23-26 = PSA 44:24-27
PSA 44:0-18 = PSA 45:0-18
PSA 45:0-12 = PSA 46:0-12
PSA 46:0-10 = PSA 47:0-10
PSA 47:0-15 = PSA 48:0-15
PSA 48:0-21 = PSA 49:0-21
PSA 49:0-23 = PSA 50:0-23
PSA 50:0-21 = PSA 51:0-21
PSA 51:0-11 = PSA 52:0-11
PSA 52:0-7 = PSA 53:0-7
PSA 53:0-9 = PSA 54:0-9
PSA 54:0-24 = PSA 55:0-24
PSA 55:0-10 = PSA 56:0-10
# PSA 55:11 <- PSA 56:11-12
PSA 55:11 = PSA 56:11
PSA 55:11 = PSA 56:12
PSA 55:12-13 = PSA 56:13-14
PSA 56:0-12 = PSA 57:0-12
PSA 57:0-12 = PSA 58:0-12
PSA 58:0-18 = PSA 59:0-18
PSA 59:0-14 = PSA 60:0-14
PSA 60:0-9 = PSA 61:0-9
PSA 61:0-13 = PSA 62:0-13
PSA 62:0-12 = PSA 63:0-12
PSA 63:0-11 = PSA 64:0-11
PSA 64:0-14 = PSA 65:0-14
PSA 65:0-20 = PSA 66:0-20
PSA 66:0-8 = PSA 67:0-8
PSA 67:0-36 = PSA 68:0-36
PSA 68:0-37 = PSA 69:0-37
PSA 69:0-6 = PSA 70:0-6
PSA 70:0-24 = PSA 71:0-24
PSA 71:0-20 = PSA 72:0-20
PSA 72:0-28 = PSA 73:0-28
PSA 73:0-23 = PSA 74:0-23
PSA 74:0-11 = PSA 75:0-11
PSA 75:0-13 = PSA 76:0-13
PSA 76:0-21 = PSA 77:0-21
PSA 77:0-72 = PSA 78:0-72
PSA 78:0-13 = PSA 79:0-13
PSA 79:0-20 = PSA 80:0-20
PSA 80:0-17 = PSA 81:0-17
PSA 81:0-8 = PSA 82:0-8
PSA 82:0-19 = PSA 83:0-19
PSA 83:0-13 = PSA 84:0-13
PSA 84:0-14 = PSA 85:0-14
PSA 85:0-17 = PSA 86:0-17
PSA 86:0-7 = PSA 87:0-7
PSA 87:0-19 = PSA 88:0-19
PSA 88:0-53 = PSA 89:0-53
PSA 89:0-17 = PSA 90:0-17
PSA 90:0-16 = PSA 91:0-16
PSA 91:0-16 = PSA 92:0-16
PSA 92:0-5 = PSA 93:0-5
PSA 93:0-23 = PSA 94:0-23
PSA 94:0-11 = PSA 95:0-11
PSA 95:0-13 = PSA 96:0-13
PSA 96:0-12 = PSA 97:0-12
PSA 97:0-9 = PSA 98:0-9
PSA 98:0-9 = PSA 99:0-9
PSA 99:0-5 = PSA 100:0-5
PSA 100:0-8 = PSA 101:0-8
PSA 101:0-29 = PSA 102:0-29
PSA 102:0-22 = PSA 103:0-22
PSA 103:0-35 = PSA 104:0-35
PSA 104:0-45 = PSA 105:0-45
PSA 105:0-48 = PSA 106:0-48
PSA 106:0-43 = PSA 107:0-43
PSA 107:0-14 = PSA 108:0-14
PSA 108:0-31 = PSA 109:0-31
PSA 109:0-7 = PSA 110:0-7
PSA 110:0-10 = PSA 111:0-10
PSA 111:0-10 = PSA 112:0-10
PSA 112:0-9 = PSA 113:0-9
PSA 113:0-8 = PSA 114:0-8
PSA 113:9 = PSA 115:0
PSA 113:9-26 = PSA 115:1-18
PSA 114:1-9 = PSA 116:1-9
# What does 115:1-9 map to?  this seems very wrong
PSA 115:10-19 = PSA 116:10-19
PSA 116:0-2 = PSA 117:0-2
PSA 117:0-29 = PSA 118:0-29
PSA 118:0-176 = PSA 119:0-176
PSA 119:0-7 = PSA 120:0-7
PSA 120:0-8 = PSA 121:0-8
PSA 121:0-9 = PSA 122:0-9
PSA 122:0-4 = PSA 123:0-4
PSA 123:0-8 = PSA 124:0-8
PSA 124:0-5 = PSA 125:0-5
PSA 125:0-6 = PSA 126:0-6
PSA 126:0-5 = PSA 127:0-5
PSA 127:0-6 = PSA 128:0-6
PSA 128:0-8 = PSA 129:0-8
PSA 129:0-8 = PSA 130:0-8
PSA 130:0-3 = PSA 131:0-3
PSA 131:0-18 = PSA 132:0-18
PSA 132:0-3 = PSA 133:0-3
PSA 133:0-3 = PSA 134:0-3
PSA 134:0-21 = PSA 135:0-21
PSA 135:0-26 = PSA 136:0-26
PSA 136:0-9 = PSA 137:0-9
PSA 137:0-8 = PSA 138:0-8
PSA 138:0-24 = PSA 139:0-24
PSA 139:0-14 = PSA 140:0-14
PSA 140:0-10 = PSA 141:0-10
PSA 141:0-8 = PSA 142:0-8
PSA 142:0-12 = PSA 143:0-12
PSA 143:0-15 = PSA 144:0-15
PSA 144:0-21 = PSA 145:0-21
# PSA 145:2a = PSA 146:1b
PSA 145:0-1 = PSA 146:0-1
PSA 145:2 = PSA 146:1
PSA 145:2 = PSA 146:2
PSA 145:3-10 = PSA 146:3-10
PSA 146:0-11 = PSA 147:0-11
PSA 147:12-20 = PSA 147:12-20
PSA 148:0-14 = PSA 148:0-14
PSA 149:0-9 = PSA 149:0-9
PSA 150:0-6 = PSA 150:0-6
ECC 7:1 = ECC 6:12
ECC 7:2-30 = ECC 7:1-29
SNG 1:1 = SNG 1:1
SNG 1:1-16 = SNG 1:2-17
SNG 5:17 = SNG 6:1
SNG 6:1-11 = SNG 6:2-12
# SNG 6:12 -> SNG 7:1a
# SNG 7:1 <- SNG 7:1b-2
# or:  SNG 6:12--7:1 = SNG 7:1-2
SNG 6:12 = SNG 7:1
SNG 7:1 = SNG 7:1
SNG 7:1 = SNG 7:2
SNG 7:2-13 = SNG 7:3-14
# ISA 8:22d = ISA 8:23a
ISA 8:22 = ISA 8:22
ISA 8:22 = ISA 8:23
ISA 9:1 = ISA 8:23
ISA 9:2-21 = ISA 9:1-20
# ISA 9:20d = ISA 9:20ab
ISA 9:20 = ISA 9:19
ISA 9:20 = ISA 9:20
ISA 9:21 = ISA 9:20
# ISA 64:1 -> ISA 63:19cd
ISA 63:19 = ISA 63:19
ISA 64:1 = ISA 63:19
ISA 64:2-12 = ISA 64:1-11
JER 9:1 = JER 8:23
JER 9:2-26 = JER 9:1-25
# JER 37:4 <- JER 37:4-5
JER 37:4 = JER 37:4
JER 37:4 = JER 37:5
JER 37:5-20 = JER 37:6-21
# EZK 2:9 <- EZK 2:9-10
EZK 2:9 = EZK 2:9
EZK 2:9 = EZK 2:10
EZK 20:45-49 = EZK 21:1-5
EZK 21:1-32 = EZK 21:6-37
DAN 3:24-90 = S3Y 1:1-67
DAN 3:91-100 = DAN 3:24-33
DAN 5:31 = DAN 6:1
DAN 6:1-28 = DAN 6:2-29
DAN 13:1-64 = SUS 1:1-64
DAN 13:65 = BEL 1:1
DAN 14:1 = BEL 1:1
DAN 14:2-41 = BEL 1:2-41
HOS 1:10-11 = HOS 2:1-2
HOS 2:1-22 = HOS 2:3-24
# HOS 2:23-24 -> HOS 2:25
HOS 2:23 = HOS 2:25
HOS 2:24 = HOS 2:25
HOS 11:12 = HOS 12:1
HOS 12:1-14 = HOS 12:2-15
JOL 2:28-32 = JOL 3:1-5
JOL 3:1-21 = JOL 4:1-21
# AMO 6:10-11 -> AMO 6:10
AMO 6:10 = AMO 6:10
AMO 6:11 = AMO 6:10
AMO 6:12-15 = AMO 6:11-14
MIC 5:1 = MIC 4:14
MIC 5:2-10 = MIC 5:1-9
# MIC 5:11 <- MIC 5:10-11
MIC 5:11 = MIC 5:10
MIC 5:11 = MIC 5:11
# MIC 5:12-14 = MIC 5:12-14
JON 1:17 = JON 2:1
JON 2:1-10 = JON 2:2-11
NAM 1:15 = NAM 2:1
NAM 2:1-13 = NAM 2:2-14
HAG 2:1 = HAG 1:15
HAG 2:2-24 = HAG 2:1-23
ZEC 1:18-21 = ZEC 2:1-4
ZEC 2:1-13 = ZEC 2:5-17
MAL 4:1-6 = MAL 3:19-24
#
#
# Mapping
# Vulgate = UBS GNT
#
#
# MAT 17:14 <- MAT 17:14-15
MAT 17:15-26 = MAT 17:16-27
# MRK 4:40 <- MRK 4:40-41
MRK 4:40 = MRK 4:40
MRK 4:40 = MRK 4:41
MRK 8:39 = MRK 9:1
MRK 9:1-49 = MRK 9:2-50
# JHN 6:51-52 -> JHN 6:51
JHN 6:51 = JHN 6:51
JHN 6:52 = JHN 6:51
JHN 6:53-72 = JHN 6:52-71
# ACT 7:55 <- ACT 7:55-56
ACT 7:55 = ACT 7:55
ACT 7:55 = ACT 7:56
ACT 7:56-59 = ACT 7:57-60
# ACT 14:6 <- ACT 14:6-7
ACT 14:6 = ACT 14:6
ACT 14:6 = ACT 14:7
ACT 14:7-27 = ACT 14:8-28
#
#
#
# Mapping
# Vulgate = +/-LXX
#
#
# WIS 2:24-25 -> WIS 2:24
WIS 2:24 = WIS 2:24
WIS 2:25 = WIS 2:24
# WIS 5:13-14 -> WIS 5:13
WIS 5:13 = WIS 5:13
WIS 5:14 = WIS 5:13
WIS 5:15-24 = WIS 5:14-23
# WIS 6:1 -> missing
WIS 6:2-21 = WIS 6:1-20
WIS 6:22 = WIS 6:21
WIS 6:23 = WIS 6:21
# WIS 6:23 -> missing
WIS 6:24-27 = WIS 6:22-25
# WIS 9:18-19 -> WIS 9:18
WIS 9:18 = WIS 9:18
WIS 9:19 = WIS 9:18
# WIS 11:5-6 -> WIS 11:5
WIS 11:5 = WIS 11:5
WIS 11:6 = WIS 11:5
WIS 11:7-27 = WIS 11:6-26
# WIS 19:12 <- WIS 19:12-13
WIS 19:12 = WIS 19:12
WIS 19:12 = WIS 19:13
WIS 19:13-19 = WIS 19:14-20
# WIS 19:20 <- WIS 19:21-22
WIS 19:20 = WIS 19:21
WIS 19:20 = WIS 19:22
BAR 6:1-72 = LJE 1:1-72
# 1MA 1:4-5 -> 1MA 1:4
1MA 1:4 = 1MA 1:4
1MA 1:5 = 1MA 1:4
1MA 1:6-31 = 1MA 1:5-30
# 1MA 1:31-32 -> 1MA 1:30
1MA 1:31 = 1MA 1:30
1MA 1:32 = 1MA 1:30
1MA 1:33-35 = 1MA 1:31-33
# 1MA 1:36ab <- 1MA 1:34
# 1MA 1:36bc = 1MA 1:35a
# 1MA 1:37 -> 1MA 1:35b
1MA 1:36 = 1MA 1:34
1MA 1:36 = 1MA 1:35
1MA 1:37 = 1MA 1:35
1MA 1:38-46 = 1MA 1:36-44
# 1MA 1:47-48 -> 1MA 1:45
1MA 1:47 = 1MA 1:45
1MA 1:48 = 1MA 1:45
1MA 1:49-67 = 1MA 1:46-64
# 1MA 12:53-54 -> 1MA 12:53
1MA 12:53 = 1MA 12:53
1MA 12:54 = 1MA 12:53
# 1MA 13:52-53 -> 1MA 13:52
1MA 13:52 = 1MA 13:52
1MA 13:53 = 1MA 13:52
1MA 13:54 = 1MA 13:53
# 2MA 2:18-19 -> 2MA 2:18
2MA 2:18 = 2MA 2:18
2MA 2:19 = 2MA 2:18
2MA 2:20-33 = 2MA 2:19-32
# 2MA 12:45-46 -> 2MA 12:45
2MA 12:45 = 2MA 12:45
2MA 12:46 = 2MA 12:45
# 2MA 15:36-37 -> 2MA 15:36
2MA 15:36 = 2MA 15:36
2MA 15:37 = 2MA 15:36
2MA 15:38-40 = 2MA 15:37-39
#
#
# For 1ES the mapping info is taken from the Bible Works program
# mapping Vulgate onto LXX
#
1ES 1:4 = 1ES 1:3
1ES 1:4 = 1ES 1:4
1ES 1:5 = 1ES 1:4
1ES 1:5 = 1ES 1:5
1ES 1:10 = 1ES 1:10
1ES 1:10 = 1ES 1:11
1ES 1:11 = 1ES 1:12
1ES 1:12 = 1ES 1:13
1ES 1:13 = 1ES 1:13
1ES 1:13 = 1ES 1:14
1ES 1:14 = 1ES 1:14
1ES 1:15 = 1ES 1:15
1ES 1:16 = 1ES 1:15
1ES 1:17 = 1ES 1:16
1ES 1:18 = 1ES 1:16
1ES 1:19-50 = 1ES 1:17-48
1ES 1:51 = 1ES 1:49
1ES 1:52 = 1ES 1:49
1ES 1:53-58 = 1ES 1:50-55
1ES 2:1 = 1ES 2:1
1ES 2:2 = 1ES 2:1
1ES 2:3 = 1ES 2:2
1ES 2:4 = 1ES 2:2
1ES 2:5 = 1ES 2:3
1ES 2:6 = 1ES 2:4
1ES 2:7 = 1ES 2:4
1ES 2:8 = 1ES 2:5
1ES 2:9 = 1ES 2:6
1ES 2:10 = 1ES 2:7
1ES 2:11 = 1ES 2:8
1ES 2:12 = 1ES 2:8
1ES 2:13 = 1ES 2:9
1ES 2:13 = 1ES 2:10
1ES 2:14 = 1ES 2:11
1ES 2:15 = 1ES 2:11
1ES 2:16-19 = 1ES 2:12-15
1ES 2:20 = 1ES 2:16
1ES 2:21 = 1ES 2:16
1ES 2:22 = 1ES 2:17
1ES 2:23 = 1ES 2:17
1ES 2:24 = 1ES 2:18
1ES 2:25 = 1ES 2:19
1ES 2:26 = 1ES 2:20
1ES 2:26 = 1ES 2:21
1ES 2:27 = 1ES 2:21
1ES 2:27 = 1ES 2:22
1ES 2:28 = 1ES 2:23
1ES 2:29 = 1ES 2:24
1ES 2:30 = 1ES 2:25
1ES 2:30 = 1ES 2:26
1ES 3:14 = 1ES 3:14
1ES 3:15 = 1ES 3:14
1ES 3:16 = 1ES 3:15
1ES 3:17 = 1ES 3:16
1ES 3:17 = 1ES 3:17
1ES 4:10 = 1ES 4:10
1ES 4:10 = 1ES 4:11
1ES 4:11 = 1ES 4:11
1ES 4:33 = 1ES 4:33
1ES 4:33 = 1ES 4:34
1ES 4:39 = 1ES 4:39
1ES 4:40 = 1ES 4:39
1ES 4:40 = 1ES 4:40
1ES 5:41 = 1ES 5:41
1ES 5:42 = 1ES 5:41
1ES 5:43-53 = 1ES 5:42-52
1ES 5:54 = 1ES 5:53
1ES 5:55 = 1ES 5:53
1ES 5:56 = 1ES 5:54
1ES 5:57 = 1ES 5:55
1ES 5:58 = 1ES 5:56
1ES 5:58 = 1ES 5:57
1ES 5:59 = 1ES 5:57
1ES 5:60 = 1ES 5:57
1ES 5:61-72 = 1ES 5:58-69
1ES 5:73 = 1ES 5:70
1ES 5:73 = 1ES 5:71
1ES 6:8 = 1ES 6:8
1ES 6:9 = 1ES 6:8
1ES 6:10-34 = 1ES 6:9-33
1ES 8:5 = 1ES 8:5
1ES 8:6 = 1ES 8:5
1ES 8:6 = 1ES 8:6
1ES 8:13 = 1ES 8:13
1ES 8:14 = 1ES 8:13
1ES 8:14 = 1ES 8:14
1ES 8:19 = 1ES 8:19
1ES 8:20 = 1ES 8:19
1ES 8:20 = 1ES 8:20
1ES 8:43 = 1ES 8:43
1ES 8:44 = 1ES 8:43
1ES 8:45-49 = 1ES 8:44-48
1ES 8:50 = 1ES 8:49
1ES 8:50 = 1ES 8:50
1ES 8:56 = 1ES 8:56
1ES 8:57 = 1ES 8:56
1ES 8:58-62 = 1ES 8:57-61
1ES 8:63 = 1ES 8:62
1ES 8:64 = 1ES 8:62
1ES 8:65 = 1ES 8:63
1ES 8:66 = 1ES 8:63
1ES 8:67-85 = 1ES 8:64-82
1ES 8:86 = 1ES 8:83
1ES 8:86 = 1ES 8:84
1ES 8:87 = 1ES 8:84
1ES 8:88-92 = 1ES 8:85-89
1ES 8:93 = 1ES 8:90
1ES 8:94 = 1ES 8:90
1ES 8:95 = 1ES 8:91
1ES 8:96 = 1ES 8:92
#
#--------------------------------------------------------------------------
# mapping XXA onto PSA, XXA should be in a variant Vulgate project [Studge]
# Both PSA and XXA are synchronized to PSA in the original versification.
# Is this allowed???
# by request of RdB, XXA mapping to PSA has been deleted - [Barb] 20110127
# XXA has been moved to PSA and the old PSA is now the Resource VULGP83 [Barb]
# There could still be some errors regarding the irregular mapping of psalm titles (like in PSA 12:1 <- PSA 13:1-2)
#
#
#-------------------------------------------------------
# Removing the following lines (FB 52696)
#2ES 3:1-36 = EZA 1:1-36
#2ES 4:1-52 = EZA 2:1-52
#2ES 5:1-56 = EZA 3:1-56
#2ES 6:1-59 = EZA 4:1-59
#2ES 7:1-35 = EZA 5:1-35
#2ES 7:106-140 = EZA 5:36-70
#2ES 8:1-63 = EZA 6:1-63
#2ES 9:1-47 = EZA 7:1-47
#2ES 10:1-60 = EZA 8:1-60
#2ES 11:1-46 = EZA 9:1-46
#2ES 12:1-51 = EZA 10:1-51
#2ES 13:1-58 = EZA 11:1-58
#2ES 14:1-48 = EZA 12:1-48
#-----------------------------------------------------
# map Letter to the Laodiceans [Studge]
# XXB 1:1-7 = LAO 1:1-7
#-----------------------------------------------------
# map Esther Greek onto Hebrew Esther [Studge]
# to be added in
#-----------------------------------------------------
# Mapping Additions to Daniel onto Hebrew Daniel [Studge]
DAG 1:1-21 = DAN 1:1-21
DAG 2:1-49 = DAN 2:1-49
DAG 3:24-52 = S3Y 1:1-29
DAG 3:52-23 = S3Y 1:30-31
DAG 3:54 = S3Y 1:33
DAG 3:55 = S3Y 1:32
DAG 3:56-57 = S3Y 1:34-35
DAG 3:58 = S3Y 1:37
DAG 3:59 = S3Y 1:36
DAG 3:60-90 = S3Y 1:38-68
DAG 3:91-97 = DAN 3:24-30
DAG 4:1-3 = DAN 3:31-33
DAG 4:4-37 = DAN 4:1-34
DAG 5:1-31 = DAN 5:1-31
DAG 6:1-28 = DAN 6:1-28
DAG 7:1-28 = DAN 7:1-28
DAG 8:1-27 = DAN 8:1-27
DAG 9:1-27 = DAN 9:1-27
DAG 10:1-21 = DAN 10:1-21
DAG 11:1-45 = DAN 11:1-45 
DAG 12:1-13 = DAN 12:1-13
# Susanna
DAG 13:1-63 = SUS 1:63
# Bel and the Dragon
DAG 14:1-42 = BEL 1:42
#-------------------------------------------------------
`,Oa={eng:{raw:Jw},lxx:{raw:Hw},org:{raw:Ww},rsc:{raw:Kw},rso:{raw:Xw},vul:{raw:zw}},Yw=/^([A-Z0-9]{3}) (([0-9]+:[0-9]+) ?)*$/;for(const[t,e]of Object.entries(Oa)){e.cv={};const n=e.raw.split(`
`).filter(r=>r.match(Yw));if(n)for(const r of n){const s=r.slice(0,3);e.cv[s]={};for(const o of r.substr(4).split(" ")){const[i,a]=o.split(":");e.cv[s][i]=a}}}const Zw=`
"""The top level of Proskomma queries"""
type Query {
  """The id of the processor, which is different for each Proskomma instance"""
  id: String!
  """A string describing the processor class"""
  processor: String!
  """The NPM package version"""
  packageVersion: String!
  """The selectors used to define docSets"""
  selectors: [selectorSpec!]!
  """The number of docSets"""
  nDocSets: Int!
  """The docSets in the processor"""
  docSets(
    """A whitelist of ids of docSets to include"""
    ids: [String!]
    """Only return docSets that match the list of selector values"""
    withSelectors: [InputKeyValue!]
    """Only return docSets containing a document with the specified bookCode"""
    withBook: String
    """Only return docSets with all the specified tags"""
    withTags: [String!]
    """Only return docSets with none of the specified tags"""
    withoutTags: [String!]
  ): [DocSet!]!
  """The docSet with the specified id"""
  docSet(
    """The id of the docSet"""
    id: String!
  ): DocSet
  """The number of documents in the processor"""
  nDocuments: Int!
  """The documents in the processor"""
  documents(
    """A whitelist of ids of documents to include"""
    ids: [String!]
    """Only return documents with the specified bookCode"""
    withBook: String
    """Only return documents with the specified header key/values"""
    withHeaderValues: [InputKeyValue!]
    """Only return documents with all the specified tags"""
    withTags: [String!]
    """Only return documents with none of the specified tags"""
    withoutTags: [String!]
    """Sort returned documents by the designated method (currently ${Object.keys(Wn).join(", ")})"""
    sortedBy: String
  ): [Document!]!
  """The document with the specified id, or the specified docSet and withBook"""
  document(
    """The id of the document"""
    id: String
    """The docSet of the document (use with withBook)"""
    docSetId: String
    """The book of the document (use with docSetId)"""
    withBook: String
  ) : Document
  """Reference information about standard versifications"""
  versifications: [versification!]!
  """Reference information about a named, standard versification"""
  versification(
    """The id of the versification"""
    id: String!
  ) : versification!
}
`,Qw={id:t=>t.processorId,selectors:t=>t.selectors,docSets:(t,e)=>{const n=(s,o)=>{for(const i of o)if(s.selectors[i.key].toString()!==i.value)return!1;return!0};let r=("withBook"in e?t.docSetsWithBook(e.withBook):Object.values(t.docSets)).filter(s=>!e.ids||e.ids.includes(s.id));return e.withSelectors&&(r=r.filter(s=>n(s,e.withSelectors))),e.withTags&&(r=r.filter(s=>e.withTags.filter(o=>s.tags.has(o)).length===e.withTags.length)),e.withoutTags&&(r=r.filter(s=>e.withoutTags.filter(o=>s.tags.has(o)).length===0)),r},docSet:(t,e)=>t.docSetById(e.id),documents:(t,e)=>{const n=(s,o)=>{for(const i of o||[])if(!(i.key in s)||s[i.key]!==i.value)return!1;return!0};let r=e.withBook?t.documentsWithBook(e.withBook):t.documentList();if(r=r.filter(s=>!e.ids||e.ids.includes(s.id)),e.withHeaderValues&&(r=r.filter(s=>n(s.headers,e.withHeaderValues))),e.withTags&&(r=r.filter(s=>e.withTags.filter(o=>s.tags.has(o)).length===e.withTags.length)),e.withoutTags&&(r=r.filter(s=>e.withoutTags.filter(o=>s.tags.has(o)).length===0)),e.sortedBy){if(!(e.sortedBy in Wn))throw new Error(`sortedBy value must be one of [${Object.keys(Wn).join(", ")}], not ${e.sortedBy}`);r.sort(Wn[e.sortedBy])}return r},document:(t,e)=>{if(e.id&&!e.docSetId&&!e.withBook)return t.documentById(e.id);if(!e.id&&e.docSetId&&e.withBook)return t.documentsWithBook(e.withBook).filter(n=>n.docSetId===e.docSetId)[0];throw new Error("document requires either id or both docSetId and withBook (but not all three)")},versifications:()=>Object.entries(Oa),versification:(t,e)=>Object.entries(Oa).filter(n=>n[0]===e.id)[0]},eF=`
"""Specification of a selector"""
type selectorSpec {
  """Name (ie the key)"""
  name: String!
  """Data type (string or integer)"""
  type: String!
  """Regex for validating string selector"""
  regex: String
  """Inclusive minimum value for integer selector"""
  min: String
  """Inclusive maximum value for integer selector"""
  max: String
  """Enum of permitted string values"""
  enum: [String!]
}
`,tF={regex:t=>t.regex||null,min:t=>t.min||null,max:t=>t.max||null,enum:t=>t.enum||null},nF=`
"""Input specification of a selector"""
input inputSelectorSpec {
  """Name (ie the key)"""
  name: String!
  """Data type (string or integer)"""
  type: String!
  """Regex for validating string selector"""
  regex: String
  """Inclusive minimum value for integer selector"""
  min: String
  """Inclusive maximum value for integer selector"""
  max: String
  """Enum of permitted string values"""
  enum: [String!]
}
`,$a=(t,e,n,r)=>{const s=n.blocks.length;for(let o=0;o<s;o++)e.deleteBlock(n.id,0,!1);for(let o=0;o<r.length;o++){const i=r[o];if(e.newBlock(n.id,o,i.bs.payload,null,!1),!t.updateBlockGrafts(e.id,n.id,o,i.bg)||!t.updateOpenScopes(e.id,n.id,o,i.os)||!t.updateIncludedScopes(e.id,n.id,o,i.is)||!t.updateItems(e.id,n.id,o,i.items))return!1}},rF=`
  """Adds a document which will be assigned to an existing or new docSet on the basis of the specified selectors"""
  addDocument(
    """The selectors for this document, the keys of which must match those of the Proskomma instance"""
    selectors: [InputKeyValue!]!
    """The format of the content (probably usfm or usx)"""
    contentType: String!
    """The document content as a string"""
    content: String!
    """A list of tags to be added"""
    tags: [String!]
  ): Boolean!
  """Creates a new, empty sequence"""
  newSequence(
    """The id of the document to which the sequence will be added"""
    documentId: String!
    """The type of the new sequence (main, heading...)"""
    type: String!
    """The JSON describing blocks, if any, for the new sequence"""
    blocksSpec: [inputBlockSpec!]
    """If true, graft to the first block of the main sequence"""
    graftToMain: Boolean
    """'A list of tags to be added"""
    tags: [String!]
  ): String!
  """Adds a new block to a sequence"""
  newBlock(
    """The id of the document containing the sequence to which the block will be added"""
    documentId: String!
    """The id of the sequence to which the block will be added"""
    sequenceId: String!
    """The zero-indexed position at which to add the block"""
    blockN: Int!
    """The scope to be applied to the block, eg blockScope/p"""
    blockScope: String!
  ): Boolean!
`,sF={addDocument:(t,e)=>{const n={};return e.selectors.forEach(r=>{n[r.key]=r.value}),!!t.importDocument(n,e.contentType,e.content,null,null,null,e.tags||[])},newSequence:(t,e)=>{const n=t.documents[e.documentId],r=n.processor.docSets[n.docSetId];if(!n)throw new Error(`Document '${e.documentId}' not found`);const s=n.newSequence(e.type,e.tags);if(e.blocksSpec&&($a(r,n,n.sequences[s],e.blocksSpec),n.buildChapterVerseIndex()),e.graftToMain){r.maybeBuildPreEnums();const o=n.sequences[n.mainId].blocks[0].bg,i=r.enumForCategoryValue("graftTypes",e.type,!0),a=r.enumForCategoryValue("ids",s,!0);Q.succinct.pushSuccinctGraftBytes(o,i,a)}return s},newBlock:(t,e)=>{const n=t.documents[e.documentId];if(!n)throw new Error(`Document '${e.documentId}' not found`);return n.newBlock(e.sequenceId,e.blockN,e.blockScope)}},oF=`
  """Deletes a docSet"""
  deleteDocSet(
    """The id of the docSet containing the document to be deleted"""
    docSetId: String!
  ): Boolean
  """Deletes a document"""
  deleteDocument(
    """The id of the docSet containing the document to be deleted"""
    docSetId: String!
    """The id of the document to be deleted"""
    documentId: String!
  ): Boolean
  """Deletes a sequence from a document"""
  deleteSequence(
    """The id of the document containing the sequence to be deleted"""
    documentId: String!
    """The id of the sequence to be deleted"""
    sequenceId: String!
  ): Boolean
  """Deletes a block from a sequence"""
  deleteBlock(
    """The id of the document containing the sequence from which the block will be deleted"""
    documentId: String!
    """The id of the sequence from which the block will be deleted"""
    sequenceId: String!
    """The zero-indexed number of the block to be deleted"""
    blockN: Int!
  ): Boolean
`,iF={deleteDocSet:(t,e)=>t.deleteDocSet(e.docSetId),deleteDocument:(t,e)=>t.deleteDocument(e.docSetId,e.documentId),deleteSequence:(t,e)=>{const n=t.documents[e.documentId];if(!n)throw new Error(`Document '${e.documentId}' not found`);return n.deleteSequence(e.sequenceId)},deleteBlock:(t,e)=>{const n=t.documents[e.documentId];if(!n)throw new Error(`Document '${e.documentId}' not found`);return n.deleteBlock(e.sequenceId,e.blockN)}},aF=`
  """Explicitly rebuild the text lookup tables for a docSet. (You probably don't need to do this)"""
  rehashDocSet(
    """The id of the docSet"""
    docSetId: String!
  ): Boolean!
`,uF={rehashDocSet:(t,e)=>t.rehashDocSet(e.docSetId)},cF=`
  """Add one or more tags to a docSet, if they are not already present"""
  addDocSetTags(
    """The id of the docSet to which the tags will be added"""
    docSetId: String!
    """A list of tags to be added"""
    tags: [String]!
  ): [String!]!
  """Add one or more tags to a document, if they are not already present"""
  addDocumentTags(
    """The id of the docSet containing the document to which the tags will be added"""
    docSetId: String!
    """The id of the document to which the tags will be added"""
    documentId: String!
    """A list of tags to be added"""
    tags: [String]!
  ): [String!]
  """Add one or more tags to a sequence, if they are not already present"""
  addSequenceTags(
    """The id of the docSet containing the document containing the sequence to which the tags will be added"""
    docSetId: String!
    """The id of the document containing the sequence to which the tags will be added"""
    documentId: String!
    """The id of the sequence to which the tags will be added"""
    sequenceId: String!
    """A list of tags to be added"""
    tags: [String]!
  ) : [String!]
  """Remove one or more tags from a docSet, if they are present"""
  removeDocSetTags(
    """The id of the docSet from which the tags will be removed"""
    docSetId: String!
    """A list of tags to be removed"""
    tags: [String]!
  ): [String!]
  """Remove one or more tags from a document, if they are present"""
  removeDocumentTags(
    """The id of the docSet containing the document from which the tags will be removed"""
    docSetId: String!
    """The id of the document from which the tags will be removed"""
    documentId: String!
    """A list of tags to be removed"""
    tags: [String]!
  ): [String!]
  """Remove one or more tags from a sequence, if they are present"""
  removeSequenceTags(
    """The id of the docSet containing the document containing the sequence from which the tags will be removed"""
    docSetId: String!
    """The id of the document containing the sequence from which the tags will be removed"""
    documentId: String!
    """The id of the sequence from which the tags will be removed"""
    sequenceId: String!
    """A list of tags to be removed"""
    tags: [String]!
  ) : [String!]
`,lF={addDocSetTags:(t,e)=>{const n=t.docSets[e.docSetId];for(const r of e.tags)n.addTag(r);return Array.from(n.tags)},addDocumentTags:(t,e)=>{const r=t.docSets[e.docSetId].processor.documents[e.documentId];for(const s of e.tags)r.addTag(s);return Array.from(r.tags)},addSequenceTags:(t,e)=>{const s=t.docSets[e.docSetId].processor.documents[e.documentId].sequences[e.sequenceId];for(const o of e.tags)Q.tags.addTag(s.tags,o);return Array.from(s.tags)},removeDocSetTags:(t,e)=>{const n=t.docSets[e.docSetId];for(const r of e.tags)n.removeTag(r);return Array.from(n.tags)},removeDocumentTags:(t,e)=>{const r=t.docSets[e.docSetId].processor.documents[e.documentId];for(const s of e.tags)r.removeTag(s);return Array.from(r.tags)},removeSequenceTags:(t,e)=>{const s=t.docSets[e.docSetId].processor.documents[e.documentId].sequences[e.sequenceId];for(const o of e.tags)Q.tags.removeTag(s.tags,o);return Array.from(s.tags)}},pF=`
  """Replaces the items of a block with a new set of items"""
  updateItems(
    """The id of the docSet containing the document containing the sequence containing the block for which the items will be updated"""
    docSetId: String!
    """The id of the document containing the sequence containing the block for which the items will be updated"""
    documentId: String!
    """The id of the sequence containing the block for which the items will be updated (defaults to the main sequence)"""
    sequenceId: String
    """The zero-indexed number of the block for which the items will be updated"""
    blockPosition: Int!
    """The new content for the block as item objects"""
    items: [InputItemObject!]
    """BlockGrafts for the block as item objects"""
    blockGrafts: [InputItemObject!]
    """Optional blockScope for the block as an item object"""
    blockScope: InputItemObject
  ): Boolean!
  """Replaces all the blocks of a sequence with a new set of blocks"""
  updateAllBlocks(
    """The id of the docSet containing the document containing the sequence for which the blocks will be updated"""
    docSetId: String!
    """The id of the document containing the sequence for which the blocks will be updated"""
    documentId: String!
    """The id of the sequence for which the blocks will be updated (defaults to the main sequence)"""
    sequenceId: String
    """The JSON describing blocks"""
    blocksSpec: [inputBlockSpec!]!
  ): Boolean!
  """Replaces all the blocks of a sequence with a new set of blocks derived from PERF"""
  updateSequenceFromPerf(
    """The id of the docSet containing the document containing the sequence for which the blocks will be updated"""
    docSetId: String!
    """The id of the document containing the sequence for which the blocks will be updated"""
    documentId: String!
    """The id of the sequence for which the blocks will be updated (defaults to the main sequence)"""
    sequenceId: String
    """The JSON describing blocks"""
    perf: String!
  ): Boolean!
  """Garbage collects unused sequences within a document. (You probably don\\'t need to do this.)"""
  gcSequences(
    """The id of the docSet containing the document to be garbage collected"""
    docSetId: String!
    """The id of the document to be garbage collected"""
    documentId: String!
  ) : Boolean!
 
`,dF={updateItems:(t,e)=>{const n=t.docSets[e.docSetId];if(!n)throw new Error(`DocSet '${e.docSetId}' not found`);if(!e.items)throw new Error("Must provide items");return!(!n.updateItems(e.documentId,e.sequenceId,e.blockPosition,e.items)||e.blockGrafts&&!n.updateBlockGrafts(e.documentId,e.sequenceId,e.blockPosition,e.blockGrafts)||e.blockScope&&!n.updateBlockScope(e.documentId,e.sequenceId,e.blockPosition,e.blockScope))},updateAllBlocks:(t,e)=>{const n=t.docSets[e.docSetId];if(!n)throw new Error(`DocSet '${e.docSetId}' not found`);const r=t.documents[e.documentId];if(!r)throw new Error(`Document '${e.documentId}' not found`);const s=r.sequences[e.sequenceId||r.mainId];if(!s)throw new Error(`Sequence '${e.sequenceId||r.mainId}' not found`);return $a(n,r,s,e.blocksSpec),r.buildChapterVerseIndex(),!0},updateSequenceFromPerf:async(t,e)=>{const n=t.docSets[e.docSetId];if(!n)throw new Error(`DocSet '${e.docSetId}' not found`);const r=t.documents[e.documentId];if(!r)throw new Error(`Document '${e.documentId}' not found`);const s=r.sequences[e.sequenceId||r.mainId];if(!s)throw new Error(`Sequence '${e.sequenceId||r.mainId}' not found`);const o=JSON.parse(e.perf),i={schema:{structure:"flat",structure_version:"0.3.0",constraints:[{name:"perf",version:"0.3.0"}]},metadata:{translation:{},document:{}},sequences:{},main_sequence_id:e.sequenceId};i.sequences[e.sequenceId]=o;let a={};try{const c=await new Fn.PipelineHandler({pipelines:Af,transforms:bf,proskomma:t}).runPipeline("perf2PkJsonPipeline",{perf:i});a=Object.values(c.pkJson)[0]}catch(u){return console.error(`pipelineHandler Error :
`,u),!1}return $a(n,r,s,a),r.buildChapterVerseIndex(),!0},gcSequences:(t,e)=>{const n=t.docSets[e.docSetId];if(!n)throw new Error(`DocSet '${e.docSetId}' not found`);const r=t.documents[e.documentId];if(!r)throw new Error(`Document '${e.documentId}' not found`);return r.gcSequences()?(n.rehash(),!0):!1}},fF=`
  """Adds verse mapping tables to the documents in a docSet, where the verse mapping may be provided in legacy .vrs or JSON format"""
  setVerseMapping(
    """the id of the docSet to which the verse mapping will be added"""
    docSetId: String!
    """The verse mapping, in legacy .vrs format (as a string)"""
    vrsSource: String
    """The verse mapping, in JSON format (as a string)"""
    jsonSource: String
  ): Boolean!
  """Removes verse mapping tables from the documents in a docSet"""
  unsetVerseMapping(
    """The id of the docSet from which verse mapping will be removed"""
    docSetId: String!
  ): Boolean!
`,hF={setVerseMapping:(t,e)=>{if(e.vrsSource&&e.jsonSource)throw new Error("Cannot specify both vrsSource and jsonSource");if(!e.vrsSource&&!e.jsonSource)throw new Error("Must specify either vrsSource or jsonSource");const n=t.docSets[e.docSetId];if(!n)return!1;let r;e.vrsSource?r=Q.versification.vrs2json(e.vrsSource):r=e.jsonSource;const s=Q.versification.succinctifyVerseMappings(r.mappedVerses),o=Q.versification.reverseVersification(r),i=Q.versification.succinctifyVerseMappings(o.reverseMappedVerses);for(const a of n.documents().filter(u=>"bookCode"in u.headers)){const u=a.headers.bookCode,c=n.documentWithBook(u);if(!c)continue;const l=c.sequences[c.mainId];l.verseMapping={},u in s&&(l.verseMapping.forward=s[u]),u in i&&(l.verseMapping.reversed=i[u])}return n.tags.add("hasMapping"),!0},unsetVerseMapping:(t,e)=>{const n=t.docSets[e.docSetId];if(!n)return!1;for(const r of n.documents().filter(s=>"bookCode"in s.headers)){const s=r.headers.bookCode,o=n.documentWithBook(s);if(o){const i=o.sequences[o.mainId];i.verseMapping={}}}return n.tags.delete("hasMapping"),!0}},mF=`
type Mutation {
${rF}
${oF}
${aF}
${cF}
${pF}
${fF}
}`,DF={...sF,...iF,...uF,...lF,...dF,...hF},SF=`
"""Information about a standard versification scheme"""
type versification {
  """id, derived from the Paratext vrs filename"""
  id: String!
  """A string of the original vrs file"""
  vrs: String!
  """Chapter/verse information for each book"""
  cvBooks: [cvBook!]!
  """Chapter/verse information for one book"""
  cvBook(
    """The bookCode"""
    bookCode: String!
  ): cvBook!
}
`,EF={id:t=>t[0],vrs:t=>t[1].raw,cvBooks:t=>Object.entries(t[1].cv),cvBook:(t,e)=>Object.entries(t[1].cv).filter(n=>n[0]===e.bookCode)[0]},yF=`
"""Chapter/verse information for a book"""
type cvBook {
  """The bookCode"""
  bookCode: String!
  """The chapter records"""
  chapters: [cvChapter!]!
}
`,gF={bookCode:t=>t[0],chapters:t=>Object.entries(t[1])},vF=`
"""Information for a chapter"""
type cvChapter {
  """The chapter"""
  chapter: Int!
  """The maximum verse number"""
  maxVerse: Int!
}
`,AF={chapter:t=>parseInt(t[0]),maxVerse:t=>parseInt(t[1])},bF=`
      ${Zw}
      ${mF}
      ${aT}
      ${cT}
      ${pT}
      ${fT}
      ${mT}
      ${ST}
      ${ET}
      ${yT}
      ${gT}
      ${vT}
      ${bT}
      ${kT}
      ${NT}
      ${OT}
      ${BT}
      ${RT}
      ${xT}
      ${qT}
      ${MT}
      ${jT}
      ${UT}
      ${JT}
      ${WT}
      ${XT}
      ${YT}
      ${QT}
      ${ew}
      ${nw}
      ${sw}
      ${bw}
      ${ww}
      ${_w}
      ${qw}
      ${Uw}
      ${eF}
      ${nF}
      ${SF}
      ${yF}
      ${vF}
  `,CF={Mutation:DF,Query:Qw,KeyValue:uT,KeyCount:lT,KeyCountCategory:dT,cv:hT,idParts:DT,Item:CT,ItemGroup:PT,kvEntry:_T,regexIndex:$T,verseNumber:LT,cell:GT,cIndex:VT,cvVerseElement:HT,cvVerses:KT,cvIndex:zT,cvNavigation:ZT,node:tw,kvSequence:rw,tableSequence:ow,treeSequence:Cw,Block:Fw,Sequence:Ow,Document:Mw,DocSet:Vw,selectorSpec:tF,versification:EF,cvBook:gF,cvChapter:AF},f1=YD({typeDefs:bF,resolvers:CF});class TF{constructor(e){this.processorId=Q.generateId(),this.documents={},this.docSetsBySelector={},this.docSets={},this.filters={},this.customTags={heading:[],paragraph:[],char:[],word:[],intro:[],introHeading:[]},this.emptyBlocks=[],this.selectors=e||[{name:"lang",type:"string",regex:"[a-z]{3}"},{name:"abbr",type:"string"}],this.validateSelectorSpec(this.selectors),this.mutex=new n3,this.nextPeriph=0,this.nextTable=0,this.nextNodes=0}validateSelectors(){if(this.selectors.length===0)throw new Error("No selectors found");for(const[e,n]of this.selectors.entries()){if(!("name"in n))throw new Error(`Selector ${e} has no name`);if(!("type"in n))throw new Error(`Selector ${e} has no type`);if(!["string","integer"].includes(n.type))throw new Error(`Type for selector ${e} must be string or number, not ${n.type}`);if(n.type==="string"){if("min"in n)throw new Error("String selector should not include 'min'");if("max"in n)throw new Error("String selector should not include 'max'");if("regex"in n)try{B(n.regex)}catch(r){throw new Error(`Regex '${n.regex}' is not valid: ${r}`)}if("enum"in n){for(const r of n.enum)if(typeof r!="string")throw new Error(`Enum values for selector ${n.name} should be strings, not '${r}'`)}}else{if("regex"in n)throw new Error("Integer selector should not include 'regex'");if("min"in n&&typeof n.min!="number")throw new Error(`'min' must be a number, not '${n.min}'`);if("max"in n&&typeof n.max!="number")throw new Error(`'max' must be a number, not '${n.max}'`);if("min"in n&&"max"in n&&n.min>n.max)throw new Error(`'min' cannot be greater than 'max' (${n.min} > ${n.max})`);if("enum"in n){for(const r of n.enum)if(typeof r!="number")throw new Error(`Enum values for selector ${n.name} should be numbers, not '${r}'`)}}for(const r of Object.keys(n))if(!["name","type","regex","min","max","enum"].includes(r))throw new Error(`Unexpected key '${r}' in selector ${e}`)}}validateSelectorSpec(e){for(const n of e){if(!n.name)throw new Error(`name not found in selector spec element '${JSON.stringify(n)}'`);if(!n.type)throw new Error(`type not found in selector spec element '${JSON.stringify(n)}'`);if(!["string","integer"].includes(n.type))throw new Error(`Type for spec element must be string or number, not ${n.type}`);for(const r of Object.keys(n))if(!["name","type","regex","min","max","enum"].includes(r))throw new Error(`Unexpected key '${r}' in selectorSpec`)}}selectorString(e){return this.selectors.map(n=>n.name).map(n=>`${e[n]}`).join("_")}processor(){return"Proskomma JS"}packageVersion(){return b3.version}docSetList(){return Object.values(this.docSets)}docSetsById(e){return Object.values(this.docSets).filter(n=>e.includes(n.id))}docSetById(e){return this.docSets[e]}docSetsWithBook(e){const n=Object.values(this.documents).filter(s=>"bookCode"in s.headers&&s.headers.bookCode===e).map(s=>s.id),r=s=>{for(const o of n)if(s.docIds.includes(o))return!0;return!1};return Object.values(this.docSets).filter(s=>r(s))}nDocSets(){return this.docSetList().length}nDocuments(){return this.documentList().length}documentList(){return Object.values(this.documents)}documentById(e){return this.documents[e]}documentsById(e){return Object.values(this.documents).filter(n=>e.includes(n.id))}documentsWithBook(e){return Object.values(this.documents).filter(n=>"bookCode"in n.headers&&n.headers.bookCode===e)}importDocument(e,n,r,s,o,i,a){return this.importDocuments(e,n,[r],s,o,i,a)[0]}importDocuments(e,n,r,s,o,i,a){s||(s=this.filters),o||(o=this.customTags),i||(i=this.emptyBlocks),a||(a=[]);const u=this.findOrMakeDocSet(e),c=this.docSets[u];c.buildPreEnums();const l=[];for(const p of r){let d=new u1(this,u,n,p,s,o,i,a);const f=d.headers.bookCode;if(Object.values(this.documents).filter(b=>c.docIds.includes(b.id)).map(b=>b.headers.bookCode).includes(f))throw new Error(`Attempt to import document with bookCode '${f}' which already exists in docSet ${u}`);this.addDocument(d,u),l.push(d)}return c.preEnums={},l}importUsfmPeriph(e,n,r,s,o,i){const a=n.toString().split(/[\n\r]+/),u=a[0].substring(4,7);if(!["FRT","BAK","INT"].includes(u))throw new Error(`importUsfmInt() expected bookCode of FRT, BAK or INT, not '${u}'`);let c=[];for(const l of a)if(l.substring(0,7)==="\\periph"){let p=B.exec(l,B('^\\\\periph (.*)\\|\\s*id\\s*=\\s*"([^"]+)"\\s*$'));if(!p)throw new Error(`Unable to parse periph line '${l}'`);const d=p[1],f=p[2],S=`\\id P${this.nextPeriph>9?this.nextPeriph:"0"+this.nextPeriph}`;c.push([`${S} INT ${f} - ${d}`]),this.nextPeriph++}else c.length>0&&l.substring(0,3)!=="\\id"&&c[c.length-1].push(l);this.importDocuments(e,"usfm",c.map(l=>l.join(`
`)),r,s,o,i)}cleanUsfm(e,n){n=n||{};const r=e.toString().split(/[\n\r]+/),s=[];let o=!0;const i=["\\id","\\ide","\\usfm","\\sts","\\rem","\\h","\\toc"];for(const a of r){const u=a.split(" ")[0].replace(/[0-9]+/g,"");if("remove"in n&&n.remove.includes(u))continue;const c=i.includes(u);o&&!c&&u!=="\\mt"&&s.push("\\mt1 USFM"),s.push(a),c||(o=!1)}return s.join(`
`)}deleteDocSet(e){if(!(e in this.docSets))return!1;for(const i of Object.entries(this.documents).filter(a=>a[1].docSetId===e).map(a=>a[0]))this.deleteDocument(e,i,!1,!1);let n=this.docSetsBySelector;const r=this.selectors.slice(0,this.selectors.length-1);for(const i of r)n=n[this.docSets[e].selectors[i.name]];const s=this.selectors[this.selectors.length-1].name,o=this.docSets[e].selectors[s];if(!n[o])throw new Error(`Could not find docSetId '${e}' in docSetsBySelector in deleteDocSet`);return delete n[o],delete this.docSets[e],!0}deleteDocument(e,n,r,s){return r=r===void 0?!0:r,s=s===void 0?!0:s,!(e in this.docSets)||!(n in this.documents)?!1:(delete this.documents[n],this.docSets[e].docIds.length>1?(this.docSets[e].docIds=this.docSets[e].docIds.filter(o=>o!==n),s&&this.rehashDocSet(e)):r&&this.deleteDocSet(e),!0)}rehashDocSet(e){return e in this.docSets?this.docSets[e].rehash():!1}addDocument(e,n){this.documents[e.id]=e,this.docSets[n].docIds.push(e.id),this.docSets[n].buildEnumIndexes()}loadSuccinctDocSet(e,n){const r=e.id;if(r in this.docSets&&!n)throw new Error(`Attempting to succinct load docSet ${r} which is already loaded, without bookCodes argument`);const s=new el(this,null,null,e),o=s.id;this.docSets[o]=s;let i=this.docSetsBySelector;const a=e.metadata.selectors;for(const l of this.selectors)l.name===this.selectors[this.selectors.length-1].name?a[l.name]in i||(i[a[l.name]]=s,this.docSets[s.id]=s):(a[l.name]in i||(i[a[l.name]]={}),i=i[a[l.name]]);s.buildPreEnums();const u=[],c=l=>!n||n.includes(e.docs[l].headers.bookCode);for(const l of Object.keys(e.docs).filter(c)){let p=this.newDocumentFromSuccinct(l,e);u.push(p)}return s.preEnums={},u}augmentSuccinctDocSet(e,n){if(!n||n.length===0)throw new Error("bookCodes argument must be present and contain at least one element in augmentSuccinctDocSet");const r=s=>{const o=e.docs[s];return n.includes(o.headers.bookCode)};if(!this.docSets[e.id])throw new Error(`docSet id '${e.id}' not found in Proskomma when using augmentSuccinctDocSet. Load it first with optional bookCodes argument`);for(const s of Object.keys(e.docs).filter(r))this.documents[s]||this.newDocumentFromSuccinct(s,e)}newDocumentFromSuccinct(e,n){const r=new u1(this,n.id);r.id=e;const s=n.docs[e];r.filterOptions={},r.customTags=[],r.emptyBlocks=[],r.tags=new Set(s.tags),r.headers=s.headers,r.mainId=s.mainId,r.sequences={};for(const[o,i]of Object.entries(s.sequences)){if(r.sequences[o]={id:o,type:i.type,tags:new Set(i.tags),blocks:[]},i.type==="main"){if(r.sequences[o].chapters={},!("chapters"in i))throw new Error("chapters not found in main sequence");for(const[a,u]of Object.entries(i.chapters)){const c=new Q.ByteArray;c.fromBase64(u),r.sequences[o].chapters[a]=c}if(r.sequences[o].chapterVerses={},!("chapterVerses"in i))throw new Error("chapterVerses not found in main sequence");for(const[a,u]of Object.entries(i.chapterVerses)){const c=new Q.ByteArray;c.fromBase64(u),r.sequences[o].chapterVerses[a]=c}if(!("tokensPresent"in i))throw new Error("tokensPresent not found in main sequence");r.sequences[o].tokensPresent=new Jp(i.tokensPresent)}for(const a of i.blocks){const u={};for(const[c,l]of Object.entries(a)){const p=new Q.ByteArray(256);p.fromBase64(l),u[c]=p}r.sequences[o].blocks.push(u)}}return this.addDocument(r,n.id),r}findOrMakeDocSet(e){let n=this.docSetsBySelector,r;for(const s of this.selectors)s.name===this.selectors[this.selectors.length-1].name?e[s.name]in n?r=n[e[s.name]]:(r=new el(this,e),n[e[s.name]]=r,this.docSets[r.id]=r):(e[s.name]in n||(n[e[s.name]]={}),n=n[e[s.name]]);return r.id}async gqlQuery(e,n){const r=await this.mutex.acquire();try{const s=await ym({schema:f1,source:e,rootValue:this,contextValue:{}});return n&&n(s),s}finally{r()}}gqlQuerySync(e,n){const r=gm({schema:f1,source:e,rootValue:this,contextValue:{}});return n&&n(r),r}serializeSuccinct(e){return this.docSets[e].serializeSuccinct()}checksum(){const e=Object.values(this.docSets).map(n=>n.checksum()).sort().join(" ");return Vp.calculate(e)}}class wF extends TF{constructor(){super();const e="((en-GB-oed|i-ami|i-bnn|i-default|i-enochian|i-hak|i-klingon|i-lux|i-mingo|i-navajo|i-pwn|i-tao|i-tay|i-tsu|sgn-BE-FR|sgn-BE-NL|sgn-CH-DE)|(art-lojban|cel-gaulish|no-bok|no-nyn|zh-guoyu|zh-hakka|zh-min|zh-min-nan|zh-xiang))",n="((([A-Za-z]{2,3}(-([A-Za-z]{3}(-[A-Za-z]{3}){0,2}))?)|[A-Za-z]{4}|[A-Za-z]{5,8})(-([A-Za-z]{4}))?(-([A-Za-z]{2}|[0-9]{3}))?(-([A-Za-z0-9]{5,8}|[0-9][A-Za-z0-9]{3}))*(-([0-9A-WY-Za-wy-z](-[A-Za-z0-9]{2,8})+))*(-(x(-[A-Za-z0-9]{1,8})+))?)";this.selectors=[{name:"lang",type:"string",regex:"^("+e+"|"+n+"|(x(-[A-Za-z0-9]{1,8})+))$"},{name:"abbr",type:"string",regex:"^[A-Za-z0-9 -]+$"}],this.validateSelectors(),this.filters={},this.customTags={heading:[],paragraph:[],char:[],word:[],intro:[],introHeading:[]},this.emptyBlocks=[]}validateSelectors(){super.validateSelectors()}processor(){return"Proskomma JS for Scripture App Builder"}selectorString(e){return`${e.lang}_${e.abbr}`}gqlQuery(e,n){return super.gqlQuery(e,n)}loadSuccinctDocSet(e){return super.loadSuccinctDocSet(e)}}function FF(t){return t.type==="docset-url"}class IF{constructor({outboundHandler:e,fetch:n,getImplementation:r}){Pe(this,"repo");Pe(this,"requestHandler");Pe(this,"fetch");Pe(this,"pk");Pe(this,"docSets",[]);this.requestHandler=e,this.fetch=n,this.pk=new wF,this.repo=r(this.pk)}loadDocSet(e){return this.repo.loadDocSet(e)}async queryBooks(e,n){return await this.ensureLoaded(n.docSet),this.repo.queryBooks(e,n)}async queryTokens(e,n,r){return await this.ensureLoaded(r.docSet),this.repo.queryTokens(e,n,r)}async ensureLoaded(e){if(!this.docSets.includes(e)){const n=await this.getDocsetUrl(e),s=await(await this.fetch(n)).arrayBuffer();await this.repo.loadDocSet(s),this.docSets.push(e)}}async getDocsetUrl(e){const n={type:"docset-url-request",docSet:e},r=await this.requestHandler(n);if(FF(r))return new URL(r.url,r.base);throw new Error(`Unexpected response type for docset url: ${r.type}`)}}class _f{constructor(e){Pe(this,"input");Pe(this,"buffer",[]);this.input=e}async read(e=0){for(;!this.input.done()&&!this.limitReached(e);){const n=await this.input.read(e);this.buffer.push(...n)}return this.sliceBuffer(e)}limitReached(e){return e>0&&this.buffer.length>=e}sliceBuffer(e){e<=0&&(e=this.buffer.length);const n=this.buffer.slice(0,e);return this.buffer=this.buffer.slice(e),n}}function kF(t){let e,n;for(const s of t)s.startsWith("chapter/")?n=s.split("/")[1]:s.startsWith("verses/")&&(e=s.split("/")[1]);let r=n;return e&&(r+=":"+e),r}class PF{constructor(e,n,r){Pe(this,"pk");Pe(this,"searchPhrase");Pe(this,"options");Pe(this,"books");Pe(this,"nextBook");Pe(this,"searchIsBlank");Pe(this,"verseReader",new _f({read:()=>this.queryNextBook(),done:()=>this.nextBook>=this.books.length}));this.pk=e,this.searchPhrase=n,this.options=r,this.searchIsBlank=xa.wordsOf(n).length===0}async getVerses(e=0){return this.searchIsBlank?[]:(await this.ensureBooksSet(),await this.verseReader.read(e))}async queryNextBook(){if(await this.ensureBooksSet(),this.nextBook>=this.books.length)return[];const e=this.books[this.nextBook];return this.nextBook++,this.versesOfBook(e)}async ensureBooksSet(){this.books==null&&await this.setBooks()}async setBooks(){this.nextBook=0;const e=await this.pk.queryBooks(this.searchPhrase,this.options);this.books=e}async versesOfBook(e){const n=await this.pk.queryTokens(this.searchPhrase,e.id,this.options);return this.versesFromTokens(n,e.bookCode)}versesFromTokens(e,n){const r=this.collectVerseTexts(e);return Object.keys(r).map(s=>{const o=s.split(":");return{reference:{docSet:this.options.docSet,collection:this.options.collection,bookCode:n,chapter:o[0],verses:o[1]},text:r[s]}})}collectVerseTexts(e){return e.reduce((n,r)=>{const s=kF(r.scopes);return n[s]||(n[s]=""),n[s]+=r.payload,n},{})}}class NF{constructor(e){Pe(this,"proskommaRepo");this.proskommaRepo=e}async queryVerses(e,n){return new PF(this.proskommaRepo,e,n)}}class _F{constructor(e,n,r){Pe(this,"scriptureRepository");Pe(this,"verseProvider");Pe(this,"searchPhrase");Pe(this,"options");Pe(this,"locale");Pe(this,"isComplete",!1);Pe(this,"resultsReader",new _f({read:e=>this.getOneBatch(e),done:()=>this.isComplete}));this.searchPhrase=e.trim(),this.options=n,this.locale=n.locale,this.scriptureRepository=r}async init(){this.verseProvider=await this.scriptureRepository.queryVerses(this.searchPhrase,this.options)}async getResults(e=0){return this.verseProvider||await this.init(),this.searchPhrase.trim()===""?[]:this.resultsReader.read(e)}async getOneBatch(e){const n=await this.verseProvider.getVerses(e);return n.length===0?(this.isComplete=!0,[]):n.map(r=>({reference:r.reference,chunks:this.splitChunks(r.text)})).filter(r=>r.chunks.some(s=>s.matchesQuery))}splitChunks(e){var r;return(r=this.options)!=null&&r.wholeWords?this.splitWordChunks(e):this.splitCharChunks(e)}splitWordChunks(e){var s,o;const n=mc(this.searchPhrase,{substitute:(s=this.options)==null?void 0:s.substitute,ignore:(o=this.options)==null?void 0:o.ignore,locale:this.locale}),r=this.wordMatchBoundaries(e,n);return this.chunksByIndices(e,r)}wordMatchBoundaries(e,n){const r=this.wordBoundaries(e),s=[];for(const o of e.matchAll(new RegExp(n,"g"))){const i=o.index,a=o.index+o[0].length;r.starts.includes(i)&&r.stops.includes(a)&&s.push(i,a)}return s}wordBoundaries(e){const n=/[\p{L}\p{N}]+/gu,r=[],s=[];for(const o of e.matchAll(n))r.push(o.index),s.push(o.index+o[0].length);return{starts:r,stops:s}}chunksByIndices(e,n){const r=[];let s=0,o=!1;for(const i of n)r.push({content:e.slice(s,i),matchesQuery:o}),o=!o,s=i;return r.push({content:e.slice(s),matchesQuery:o}),r}splitCharChunks(e){var s,o;const n=mc(this.searchPhrase,{ignore:(s=this.options)==null?void 0:s.ignore,substitute:(o=this.options)==null?void 0:o.substitute,capture:!0,locale:this.locale});return e.split(n).filter(i=>i).map(i=>({content:i,matchesQuery:n.test(i)}))}}function OF(t){return t.type==="new-query-request"}function $F(t){return t.type==="results-request"}class BF{constructor(e){Pe(this,"createQuery");Pe(this,"currentQueryID",-1);Pe(this,"currentQuery");this.createQuery=e}getRequestHandler(){return e=>this.onRequest(e)}async onRequest(e){if(OF(e))return this.onNewQueryRequest(e);if($F(e))return this.onResultsRequest(e)}async onNewQueryRequest(e){return this.currentQuery=await this.createQuery(e.phrase,e.options),{type:"new-query-response",queryId:++this.currentQueryID}}async onResultsRequest(e){var s;let n=[];return e.queryId===this.currentQueryID&&(n=await this.currentQuery.getResults(e.limit)),{type:"results-response",results:n,queryDone:((s=this.currentQuery)==null?void 0:s.isComplete)??!0}}}const RF={postMessage:function(t){self.postMessage(t)},setOnMessage:function(t){self.onmessage=t}},Of=new fh(RF);function xF(){const t=new IF({outboundHandler:Of.outboundHandler(),fetch:e=>fetch(e),getImplementation:e=>new Ah(e,ph)});return new NF(t)}async function qF(t,e){const n=xF();return new _F(t,e,n)}const MF=new BF(qF);Of.setInboundHandler(MF.getRequestHandler());
