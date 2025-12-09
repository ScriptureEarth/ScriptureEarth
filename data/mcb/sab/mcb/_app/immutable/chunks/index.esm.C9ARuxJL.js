import{r as T,d as A,C as v,c as k,E as ne,F as ie,L as Re,f as ae,g as Pe,h as Me,j as Oe,k as z,l as _e,v as Fe,m as Le}from"./index.esm2017.C_GP4Y1N.js";const je=(e,t)=>t.some(n=>e instanceof n);let G,K;function Ne(){return G||(G=[IDBDatabase,IDBObjectStore,IDBIndex,IDBCursor,IDBTransaction])}function xe(){return K||(K=[IDBCursor.prototype.advance,IDBCursor.prototype.continue,IDBCursor.prototype.continuePrimaryKey])}const re=new WeakMap,L=new WeakMap,se=new WeakMap,R=new WeakMap,x=new WeakMap;function Be(e){const t=new Promise((n,i)=>{const a=()=>{e.removeEventListener("success",r),e.removeEventListener("error",s)},r=()=>{n(h(e.result)),a()},s=()=>{i(e.error),a()};e.addEventListener("success",r),e.addEventListener("error",s)});return t.then(n=>{n instanceof IDBCursor&&re.set(n,e)}).catch(()=>{}),x.set(t,e),t}function $e(e){if(L.has(e))return;const t=new Promise((n,i)=>{const a=()=>{e.removeEventListener("complete",r),e.removeEventListener("error",s),e.removeEventListener("abort",s)},r=()=>{n(),a()},s=()=>{i(e.error||new DOMException("AbortError","AbortError")),a()};e.addEventListener("complete",r),e.addEventListener("error",s),e.addEventListener("abort",s)});L.set(e,t)}let j={get(e,t,n){if(e instanceof IDBTransaction){if(t==="done")return L.get(e);if(t==="objectStoreNames")return e.objectStoreNames||se.get(e);if(t==="store")return n.objectStoreNames[1]?void 0:n.objectStore(n.objectStoreNames[0])}return h(e[t])},set(e,t,n){return e[t]=n,!0},has(e,t){return e instanceof IDBTransaction&&(t==="done"||t==="store")?!0:t in e}};function qe(e){j=e(j)}function Ve(e){return e===IDBDatabase.prototype.transaction&&!("objectStoreNames"in IDBTransaction.prototype)?function(t,...n){const i=e.call(P(this),t,...n);return se.set(i,t.sort?t.sort():[t]),h(i)}:xe().includes(e)?function(...t){return e.apply(P(this),t),h(re.get(this))}:function(...t){return h(e.apply(P(this),t))}}function Ue(e){return typeof e=="function"?Ve(e):(e instanceof IDBTransaction&&$e(e),je(e,Ne())?new Proxy(e,j):e)}function h(e){if(e instanceof IDBRequest)return Be(e);if(R.has(e))return R.get(e);const t=Ue(e);return t!==e&&(R.set(e,t),x.set(t,e)),t}const P=e=>x.get(e);function ze(e,t,{blocked:n,upgrade:i,blocking:a,terminated:r}={}){const s=indexedDB.open(e,t),o=h(s);return i&&s.addEventListener("upgradeneeded",c=>{i(h(s.result),c.oldVersion,c.newVersion,h(s.transaction),c)}),n&&s.addEventListener("blocked",c=>n(c.oldVersion,c.newVersion,c)),o.then(c=>{r&&c.addEventListener("close",()=>r()),a&&c.addEventListener("versionchange",u=>a(u.oldVersion,u.newVersion,u))}).catch(()=>{}),o}const Ge=["get","getKey","getAll","getAllKeys","count"],Ke=["put","add","delete","clear"],M=new Map;function W(e,t){if(!(e instanceof IDBDatabase&&!(t in e)&&typeof t=="string"))return;if(M.get(t))return M.get(t);const n=t.replace(/FromIndex$/,""),i=t!==n,a=Ke.includes(n);if(!(n in(i?IDBIndex:IDBObjectStore).prototype)||!(a||Ge.includes(n)))return;const r=async function(s,...o){const c=this.transaction(s,a?"readwrite":"readonly");let u=c.store;return i&&(u=u.index(o.shift())),(await Promise.all([u[n](...o),a&&c.done]))[0]};return M.set(t,r),r}qe(e=>({...e,get:(t,n,i)=>W(t,n)||e.get(t,n,i),has:(t,n)=>!!W(t,n)||e.has(t,n)}));const oe="@firebase/installations",B="0.6.8";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const ce=1e4,ue=`w:${B}`,le="FIS_v2",We="https://firebaseinstallations.googleapis.com/v1",He=60*60*1e3,Ye="installations",Je="Installations";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Xe={"missing-app-config-values":'Missing App configuration value: "{$valueName}"',"not-registered":"Firebase Installation is not registered.","installation-not-found":"Firebase Installation not found.","request-failed":'{$requestName} request failed with error "{$serverCode} {$serverStatus}: {$serverMessage}"',"app-offline":"Could not process request. Application offline.","delete-pending-registration":"Can't delete installation while there is a pending registration request."},w=new ne(Ye,Je,Xe);function de(e){return e instanceof ie&&e.code.includes("request-failed")}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function fe({projectId:e}){return`${We}/projects/${e}/installations`}function pe(e){return{token:e.token,requestStatus:2,expiresIn:Ze(e.expiresIn),creationTime:Date.now()}}async function he(e,t){const i=(await t.json()).error;return w.create("request-failed",{requestName:e,serverCode:i.code,serverMessage:i.message,serverStatus:i.status})}function ge({apiKey:e}){return new Headers({"Content-Type":"application/json",Accept:"application/json","x-goog-api-key":e})}function Qe(e,{refreshToken:t}){const n=ge(e);return n.append("Authorization",et(t)),n}async function me(e){const t=await e();return t.status>=500&&t.status<600?e():t}function Ze(e){return Number(e.replace("s","000"))}function et(e){return`${le} ${e}`}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function tt({appConfig:e,heartbeatServiceProvider:t},{fid:n}){const i=fe(e),a=ge(e),r=t.getImmediate({optional:!0});if(r){const u=await r.getHeartbeatsHeader();u&&a.append("x-firebase-client",u)}const s={fid:n,authVersion:le,appId:e.appId,sdkVersion:ue},o={method:"POST",headers:a,body:JSON.stringify(s)},c=await me(()=>fetch(i,o));if(c.ok){const u=await c.json();return{fid:u.fid||n,registrationStatus:2,refreshToken:u.refreshToken,authToken:pe(u.authToken)}}else throw await he("Create Installation",c)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function we(e){return new Promise(t=>{setTimeout(t,e)})}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function nt(e){return btoa(String.fromCharCode(...e)).replace(/\+/g,"-").replace(/\//g,"_")}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const it=/^[cdef][\w-]{21}$/,N="";function at(){try{const e=new Uint8Array(17);(self.crypto||self.msCrypto).getRandomValues(e),e[0]=112+e[0]%16;const n=rt(e);return it.test(n)?n:N}catch{return N}}function rt(e){return nt(e).substr(0,22)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function C(e){return`${e.appName}!${e.appId}`}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Ie=new Map;function ye(e,t){const n=C(e);be(n,t),st(n,t)}function be(e,t){const n=Ie.get(e);if(n)for(const i of n)i(t)}function st(e,t){const n=ot();n&&n.postMessage({key:e,fid:t}),ct()}let m=null;function ot(){return!m&&"BroadcastChannel"in self&&(m=new BroadcastChannel("[Firebase] FID Change"),m.onmessage=e=>{be(e.data.key,e.data.fid)}),m}function ct(){Ie.size===0&&m&&(m.close(),m=null)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const ut="firebase-installations-database",lt=1,I="firebase-installations-store";let O=null;function $(){return O||(O=ze(ut,lt,{upgrade:(e,t)=>{switch(t){case 0:e.createObjectStore(I)}}})),O}async function S(e,t){const n=C(e),a=(await $()).transaction(I,"readwrite"),r=a.objectStore(I),s=await r.get(n);return await r.put(t,n),await a.done,(!s||s.fid!==t.fid)&&ye(e,t.fid),t}async function Te(e){const t=C(e),i=(await $()).transaction(I,"readwrite");await i.objectStore(I).delete(t),await i.done}async function D(e,t){const n=C(e),a=(await $()).transaction(I,"readwrite"),r=a.objectStore(I),s=await r.get(n),o=t(s);return o===void 0?await r.delete(n):await r.put(o,n),await a.done,o&&(!s||s.fid!==o.fid)&&ye(e,o.fid),o}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function q(e){let t;const n=await D(e.appConfig,i=>{const a=dt(i),r=ft(e,a);return t=r.registrationPromise,r.installationEntry});return n.fid===N?{installationEntry:await t}:{installationEntry:n,registrationPromise:t}}function dt(e){const t=e||{fid:at(),registrationStatus:0};return Ae(t)}function ft(e,t){if(t.registrationStatus===0){if(!navigator.onLine){const a=Promise.reject(w.create("app-offline"));return{installationEntry:t,registrationPromise:a}}const n={fid:t.fid,registrationStatus:1,registrationTime:Date.now()},i=pt(e,n);return{installationEntry:n,registrationPromise:i}}else return t.registrationStatus===1?{installationEntry:t,registrationPromise:ht(e)}:{installationEntry:t}}async function pt(e,t){try{const n=await tt(e,t);return S(e.appConfig,n)}catch(n){throw de(n)&&n.customData.serverCode===409?await Te(e.appConfig):await S(e.appConfig,{fid:t.fid,registrationStatus:0}),n}}async function ht(e){let t=await H(e.appConfig);for(;t.registrationStatus===1;)await we(100),t=await H(e.appConfig);if(t.registrationStatus===0){const{installationEntry:n,registrationPromise:i}=await q(e);return i||n}return t}function H(e){return D(e,t=>{if(!t)throw w.create("installation-not-found");return Ae(t)})}function Ae(e){return gt(e)?{fid:e.fid,registrationStatus:0}:e}function gt(e){return e.registrationStatus===1&&e.registrationTime+ce<Date.now()}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function mt({appConfig:e,heartbeatServiceProvider:t},n){const i=wt(e,n),a=Qe(e,n),r=t.getImmediate({optional:!0});if(r){const u=await r.getHeartbeatsHeader();u&&a.append("x-firebase-client",u)}const s={installation:{sdkVersion:ue,appId:e.appId}},o={method:"POST",headers:a,body:JSON.stringify(s)},c=await me(()=>fetch(i,o));if(c.ok){const u=await c.json();return pe(u)}else throw await he("Generate Auth Token",c)}function wt(e,{fid:t}){return`${fe(e)}/${t}/authTokens:generate`}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function V(e,t=!1){let n;const i=await D(e.appConfig,r=>{if(!ve(r))throw w.create("not-registered");const s=r.authToken;if(!t&&bt(s))return r;if(s.requestStatus===1)return n=It(e,t),r;{if(!navigator.onLine)throw w.create("app-offline");const o=At(r);return n=yt(e,o),o}});return n?await n:i.authToken}async function It(e,t){let n=await Y(e.appConfig);for(;n.authToken.requestStatus===1;)await we(100),n=await Y(e.appConfig);const i=n.authToken;return i.requestStatus===0?V(e,t):i}function Y(e){return D(e,t=>{if(!ve(t))throw w.create("not-registered");const n=t.authToken;return vt(n)?Object.assign(Object.assign({},t),{authToken:{requestStatus:0}}):t})}async function yt(e,t){try{const n=await mt(e,t),i=Object.assign(Object.assign({},t),{authToken:n});return await S(e.appConfig,i),n}catch(n){if(de(n)&&(n.customData.serverCode===401||n.customData.serverCode===404))await Te(e.appConfig);else{const i=Object.assign(Object.assign({},t),{authToken:{requestStatus:0}});await S(e.appConfig,i)}throw n}}function ve(e){return e!==void 0&&e.registrationStatus===2}function bt(e){return e.requestStatus===2&&!Tt(e)}function Tt(e){const t=Date.now();return t<e.creationTime||e.creationTime+e.expiresIn<t+He}function At(e){const t={requestStatus:1,requestTime:Date.now()};return Object.assign(Object.assign({},e),{authToken:t})}function vt(e){return e.requestStatus===1&&e.requestTime+ce<Date.now()}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function St(e){const t=e,{installationEntry:n,registrationPromise:i}=await q(t);return i?i.catch(console.error):V(t).catch(console.error),n.fid}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Et(e,t=!1){const n=e;return await kt(n),(await V(n,t)).token}async function kt(e){const{registrationPromise:t}=await q(e);t&&await t}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Ct(e){if(!e||!e.options)throw _("App Configuration");if(!e.name)throw _("App Name");const t=["projectId","apiKey","appId"];for(const n of t)if(!e.options[n])throw _(n);return{appName:e.name,projectId:e.options.projectId,apiKey:e.options.apiKey,appId:e.options.appId}}function _(e){return w.create("missing-app-config-values",{valueName:e})}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Se="installations",Dt="installations-internal",Rt=e=>{const t=e.getProvider("app").getImmediate(),n=Ct(t),i=k(t,"heartbeat");return{app:t,appConfig:n,heartbeatServiceProvider:i,_delete:()=>Promise.resolve()}},Pt=e=>{const t=e.getProvider("app").getImmediate(),n=k(t,Se).getImmediate();return{getId:()=>St(n),getToken:a=>Et(n,a)}};function Mt(){A(new v(Se,Rt,"PUBLIC")),A(new v(Dt,Pt,"PRIVATE"))}Mt();T(oe,B);T(oe,B,"esm2017");/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const E="analytics",Ot="firebase_id",_t="origin",Ft=60*1e3,Lt="https://firebase.googleapis.com/v1alpha/projects/-/apps/{app-id}/webConfig",U="https://www.googletagmanager.com/gtag/js";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const l=new Re("@firebase/analytics");/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const jt={"already-exists":"A Firebase Analytics instance with the appId {$id}  already exists. Only one Firebase Analytics instance can be created for each appId.","already-initialized":"initializeAnalytics() cannot be called again with different options than those it was initially called with. It can be called again with the same options to return the existing instance, or getAnalytics() can be used to get a reference to the already-initialized instance.","already-initialized-settings":"Firebase Analytics has already been initialized.settings() must be called before initializing any Analytics instanceor it will have no effect.","interop-component-reg-failed":"Firebase Analytics Interop Component failed to instantiate: {$reason}","invalid-analytics-context":"Firebase Analytics is not supported in this environment. Wrap initialization of analytics in analytics.isSupported() to prevent initialization in unsupported environments. Details: {$errorInfo}","indexeddb-unavailable":"IndexedDB unavailable or restricted in this environment. Wrap initialization of analytics in analytics.isSupported() to prevent initialization in unsupported environments. Details: {$errorInfo}","fetch-throttle":"The config fetch request timed out while in an exponential backoff state. Unix timestamp in milliseconds when fetch request throttling ends: {$throttleEndTimeMillis}.","config-fetch-failed":"Dynamic config fetch failed: [{$httpStatus}] {$responseMessage}","no-api-key":'The "apiKey" field is empty in the local Firebase config. Firebase Analytics requires this field tocontain a valid API key.',"no-app-id":'The "appId" field is empty in the local Firebase config. Firebase Analytics requires this field tocontain a valid app ID.',"no-client-id":'The "client_id" field is empty.',"invalid-gtag-resource":"Trusted Types detected an invalid gtag resource: {$gtagURL}."},d=new ne("analytics","Analytics",jt);/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Nt(e){if(!e.startsWith(U)){const t=d.create("invalid-gtag-resource",{gtagURL:e});return l.warn(t.message),""}return e}function Ee(e){return Promise.all(e.map(t=>t.catch(n=>n)))}function xt(e,t){let n;return window.trustedTypes&&(n=window.trustedTypes.createPolicy(e,t)),n}function Bt(e,t){const n=xt("firebase-js-sdk-policy",{createScriptURL:Nt}),i=document.createElement("script"),a=`${U}?l=${e}&id=${t}`;i.src=n?n==null?void 0:n.createScriptURL(a):a,i.async=!0,document.head.appendChild(i)}function $t(e){let t=[];return Array.isArray(window[e])?t=window[e]:window[e]=t,t}async function qt(e,t,n,i,a,r){const s=i[a];try{if(s)await t[s];else{const c=(await Ee(n)).find(u=>u.measurementId===a);c&&await t[c.appId]}}catch(o){l.error(o)}e("config",a,r)}async function Vt(e,t,n,i,a){try{let r=[];if(a&&a.send_to){let s=a.send_to;Array.isArray(s)||(s=[s]);const o=await Ee(n);for(const c of s){const u=o.find(g=>g.measurementId===c),f=u&&t[u.appId];if(f)r.push(f);else{r=[];break}}}r.length===0&&(r=Object.values(t)),await Promise.all(r),e("event",i,a||{})}catch(r){l.error(r)}}function Ut(e,t,n,i){async function a(r,...s){try{if(r==="event"){const[o,c]=s;await Vt(e,t,n,o,c)}else if(r==="config"){const[o,c]=s;await qt(e,t,n,i,o,c)}else if(r==="consent"){const[o,c]=s;e("consent",o,c)}else if(r==="get"){const[o,c,u]=s;e("get",o,c,u)}else if(r==="set"){const[o]=s;e("set",o)}else e(r,...s)}catch(o){l.error(o)}}return a}function zt(e,t,n,i,a){let r=function(...s){window[i].push(arguments)};return window[a]&&typeof window[a]=="function"&&(r=window[a]),window[a]=Ut(r,e,t,n),{gtagCore:r,wrappedGtag:window[a]}}function Gt(e){const t=window.document.getElementsByTagName("script");for(const n of Object.values(t))if(n.src&&n.src.includes(U)&&n.src.includes(e))return n;return null}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Kt=30,Wt=1e3;class Ht{constructor(t={},n=Wt){this.throttleMetadata=t,this.intervalMillis=n}getThrottleMetadata(t){return this.throttleMetadata[t]}setThrottleMetadata(t,n){this.throttleMetadata[t]=n}deleteThrottleMetadata(t){delete this.throttleMetadata[t]}}const ke=new Ht;function Yt(e){return new Headers({Accept:"application/json","x-goog-api-key":e})}async function Jt(e){var t;const{appId:n,apiKey:i}=e,a={method:"GET",headers:Yt(i)},r=Lt.replace("{app-id}",n),s=await fetch(r,a);if(s.status!==200&&s.status!==304){let o="";try{const c=await s.json();!((t=c.error)===null||t===void 0)&&t.message&&(o=c.error.message)}catch{}throw d.create("config-fetch-failed",{httpStatus:s.status,responseMessage:o})}return s.json()}async function Xt(e,t=ke,n){const{appId:i,apiKey:a,measurementId:r}=e.options;if(!i)throw d.create("no-app-id");if(!a){if(r)return{measurementId:r,appId:i};throw d.create("no-api-key")}const s=t.getThrottleMetadata(i)||{backoffCount:0,throttleEndTimeMillis:Date.now()},o=new en;return setTimeout(async()=>{o.abort()},Ft),Ce({appId:i,apiKey:a,measurementId:r},s,o,t)}async function Ce(e,{throttleEndTimeMillis:t,backoffCount:n},i,a=ke){var r;const{appId:s,measurementId:o}=e;try{await Qt(i,t)}catch(c){if(o)return l.warn(`Timed out fetching this Firebase app's measurement ID from the server. Falling back to the measurement ID ${o} provided in the "measurementId" field in the local Firebase config. [${c==null?void 0:c.message}]`),{appId:s,measurementId:o};throw c}try{const c=await Jt(e);return a.deleteThrottleMetadata(s),c}catch(c){const u=c;if(!Zt(u)){if(a.deleteThrottleMetadata(s),o)return l.warn(`Failed to fetch this Firebase app's measurement ID from the server. Falling back to the measurement ID ${o} provided in the "measurementId" field in the local Firebase config. [${u==null?void 0:u.message}]`),{appId:s,measurementId:o};throw c}const f=Number((r=u==null?void 0:u.customData)===null||r===void 0?void 0:r.httpStatus)===503?z(n,a.intervalMillis,Kt):z(n,a.intervalMillis),g={throttleEndTimeMillis:Date.now()+f,backoffCount:n+1};return a.setThrottleMetadata(s,g),l.debug(`Calling attemptFetch again in ${f} millis`),Ce(e,g,i,a)}}function Qt(e,t){return new Promise((n,i)=>{const a=Math.max(t-Date.now(),0),r=setTimeout(n,a);e.addEventListener(()=>{clearTimeout(r),i(d.create("fetch-throttle",{throttleEndTimeMillis:t}))})})}function Zt(e){if(!(e instanceof ie)||!e.customData)return!1;const t=Number(e.customData.httpStatus);return t===429||t===500||t===503||t===504}class en{constructor(){this.listeners=[]}addEventListener(t){this.listeners.push(t)}abort(){this.listeners.forEach(t=>t())}}async function tn(e,t,n,i,a){if(a&&a.global){e("event",n,i);return}else{const r=await t,s=Object.assign(Object.assign({},i),{send_to:r});e("event",n,s)}}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function nn(){if(_e())try{await Fe()}catch(e){return l.warn(d.create("indexeddb-unavailable",{errorInfo:e==null?void 0:e.toString()}).message),!1}else return l.warn(d.create("indexeddb-unavailable",{errorInfo:"IndexedDB is not available in this environment."}).message),!1;return!0}async function an(e,t,n,i,a,r,s){var o;const c=Xt(e);c.then(p=>{n[p.measurementId]=p.appId,e.options.measurementId&&p.measurementId!==e.options.measurementId&&l.warn(`The measurement ID in the local Firebase config (${e.options.measurementId}) does not match the measurement ID fetched from the server (${p.measurementId}). To ensure analytics events are always sent to the correct Analytics property, update the measurement ID field in the local config or remove it from the local config.`)}).catch(p=>l.error(p)),t.push(c);const u=nn().then(p=>{if(p)return i.getId()}),[f,g]=await Promise.all([c,u]);Gt(r)||Bt(r,f.measurementId),a("js",new Date);const b=(o=s==null?void 0:s.config)!==null&&o!==void 0?o:{};return b[_t]="firebase",b.update=!0,g!=null&&(b[Ot]=g),a("config",f.measurementId,b),f.measurementId}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class rn{constructor(t){this.app=t}_delete(){return delete y[this.app.options.appId],Promise.resolve()}}let y={},J=[];const X={};let F="dataLayer",sn="gtag",Q,De,Z=!1;function on(){const e=[];if(Oe()&&e.push("This is a browser extension environment."),Le()||e.push("Cookies are not available."),e.length>0){const t=e.map((i,a)=>`(${a+1}) ${i}`).join(" "),n=d.create("invalid-analytics-context",{errorInfo:t});l.warn(n.message)}}function cn(e,t,n){on();const i=e.options.appId;if(!i)throw d.create("no-app-id");if(!e.options.apiKey)if(e.options.measurementId)l.warn(`The "apiKey" field is empty in the local Firebase config. This is needed to fetch the latest measurement ID for this Firebase app. Falling back to the measurement ID ${e.options.measurementId} provided in the "measurementId" field in the local Firebase config.`);else throw d.create("no-api-key");if(y[i]!=null)throw d.create("already-exists",{id:i});if(!Z){$t(F);const{wrappedGtag:r,gtagCore:s}=zt(y,J,X,F,sn);De=r,Q=s,Z=!0}return y[i]=an(e,J,X,t,Q,F,n),new rn(e)}function pn(e=Pe()){e=ae(e);const t=k(e,E);return t.isInitialized()?t.getImmediate():un(e)}function un(e,t={}){const n=k(e,E);if(n.isInitialized()){const a=n.getImmediate();if(Me(t,n.getOptions()))return a;throw d.create("already-initialized")}return n.initialize({options:t})}function ln(e,t,n,i){e=ae(e),tn(De,y[e.app.options.appId],t,n,i).catch(a=>l.error(a))}const ee="@firebase/analytics",te="0.10.7";function dn(){A(new v(E,(t,{options:n})=>{const i=t.getProvider("app").getImmediate(),a=t.getProvider("installations-internal").getImmediate();return cn(i,a,n)},"PUBLIC")),A(new v("analytics-internal",e,"PRIVATE")),T(ee,te),T(ee,te,"esm2017");function e(t){try{const n=t.getProvider(E).getImmediate();return{logEvent:(i,a,r)=>ln(n,i,a,r)}}catch(n){throw d.create("interop-component-reg-failed",{reason:n})}}}dn();export{pn as getAnalytics,un as initializeAnalytics,ln as logEvent};
