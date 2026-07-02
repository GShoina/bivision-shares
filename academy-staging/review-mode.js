/* Bivision Academy — Review Mode (private inline correction + track-changes + accept/reject + export)
   Activates ONLY when the URL contains ?review=1  (normal readers never see it).
   Static-site note: edits are LOCAL to this browser. Real corrections = Accept -> Export -> git commit. */
(function(){
  if (!/[?&]review=1\b/.test(location.search)) return;

  // ---- pick content blocks (skip nav/header/footer + the review UI itself) ----
  const SEL = 'p,h1,h2,h3,h4,li,blockquote,td';
  const skip = el => el.closest('nav,header,footer,script,style,.rvm-ui,button,a');
  const blocks = [...document.querySelectorAll(SEL)].filter(el =>
    !skip(el) && el.textContent.trim().length > 1 && !el.querySelector(SEL));
  blocks.forEach((b,i)=>{ b.dataset.rvmIdx=i; b.dataset.rvmOrig=b.textContent.trim(); b.dataset.rvmLoad=b.textContent.trim(); });

  // ---- styles (scoped .rvm-) ----
  const css = `
  .rvm-bar{position:fixed;top:0;left:0;right:0;z-index:99999;background:#473f80;color:#fff;
    display:flex;align-items:center;gap:14px;padding:9px 16px;font-family:'Segoe UI',sans-serif;font-size:14px}
  .rvm-bar b{font-weight:700}.rvm-bar .sp{flex:1}
  .rvm-btn{border:none;border-radius:7px;padding:7px 13px;font-weight:700;font-size:13px;cursor:pointer;font-family:inherit}
  .rvm-on{background:#00A651;color:#fff}.rvm-off{background:#fff;color:#473f80}
  body.rvm-active{padding-top:46px}
  body.rvm-active [data-rvm-idx]{outline:1px dashed #cfc7f0;outline-offset:2px;cursor:text;border-radius:4px}
  body.rvm-active [data-rvm-idx]:focus{outline:2px solid #6B63B5;background:#faf9ff}
  [data-rvm-idx].rvm-changed{background:#fff8e1 !important;outline:1px solid #f0d98a !important}
  .rvm-panel{position:fixed;top:56px;right:14px;width:330px;max-height:calc(100vh - 72px);overflow:auto;z-index:99999;
    background:#fff;border:1px solid #e5e7eb;border-radius:12px;box-shadow:0 6px 24px rgba(0,0,0,.14);
    padding:14px;font-family:'Segoe UI',sans-serif;color:#1b1e24}
  .rvm-panel h4{margin:0 0 2px;font-size:14px}.rvm-panel .s{color:#6b7280;font-size:12px;margin:0 0 12px}
  .rvm-ch{border:1px solid #e5e7eb;border-radius:9px;padding:10px;margin-bottom:10px;font-size:12.5px}
  .rvm-ch .loc{font-size:10.5px;color:#6B63B5;font-weight:700;text-transform:uppercase;margin-bottom:5px}
  .rvm-ch .df{line-height:1.6;margin-bottom:8px}
  .rvm-ch del{color:#d64545;background:#fdecec;text-decoration:line-through}
  .rvm-ch ins{color:#0f5c31;background:#e7f7ec;text-decoration:none}
  .rvm-ch .a{display:flex;gap:6px}.rvm-ch .a button{flex:1;border:none;border-radius:6px;padding:6px;font-weight:700;font-size:12px;cursor:pointer}
  .rvm-acc{background:#00A651;color:#fff}.rvm-rej{background:#fff;border:1.5px solid #e5e7eb !important;color:#6b7280}
  .rvm-empty{color:#6b7280;font-size:12.5px;text-align:center;padding:16px 0}`;
  const st=document.createElement('style'); st.textContent=css; document.head.appendChild(st);

  // ---- UI ----
  const bar=document.createElement('div'); bar.className='rvm-bar rvm-ui';
  bar.innerHTML='<b>📝 Review Mode</b><span class="sp"></span>'+
    '<button class="rvm-btn rvm-on" id="rvm-toggle">ჩასწორება ჩართულია</button>'+
    '<button class="rvm-btn rvm-off" id="rvm-export">📥 Export</button>';
  document.body.appendChild(bar);
  const panel=document.createElement('div'); panel.className='rvm-panel rvm-ui';
  panel.innerHTML='<h4>ცვლილებები</h4><p class="s">track changes · accept/reject თითოზე</p><div id="rvm-list"><div class="rvm-empty">ჯერ ცვლილება არ არის</div></div>';
  document.body.appendChild(panel);
  const listEl=panel.querySelector('#rvm-list');

  function setActive(on){
    document.body.classList.toggle('rvm-active',on);
    blocks.forEach(b=>b.contentEditable=on);
    const t=document.getElementById('rvm-toggle');
    t.textContent=on?'ჩასწორება ჩართულია':'ჩასწორება გამორთულია';
    t.className='rvm-btn '+(on?'rvm-on':'rvm-off');
  }

  function wordDiff(o,n){
    const a=o.split(/(\s+)/),b=n.split(/(\s+)/),N=a.length,M=b.length;
    const dp=Array.from({length:N+1},()=>new Array(M+1).fill(0));
    for(let i=N-1;i>=0;i--)for(let j=M-1;j>=0;j--)dp[i][j]=a[i]===b[j]?dp[i+1][j+1]+1:Math.max(dp[i+1][j],dp[i][j+1]);
    let i=0,j=0,out='';
    while(i<N&&j<M){if(a[i]===b[j]){out+=a[i];i++;j++;}else if(dp[i+1][j]>=dp[i][j+1]){out+='<del>'+a[i]+'</del>';i++;}else{out+='<ins>'+b[j]+'</ins>';j++;}}
    while(i<N)out+='<del>'+a[i++]+'</del>'; while(j<M)out+='<ins>'+b[j++]+'</ins>';
    return out;
  }
  function render(){
    const ch=blocks.filter(b=>b.classList.contains('rvm-changed'));
    if(!ch.length){listEl.innerHTML='<div class="rvm-empty">ჯერ ცვლილება არ არის</div>';return;}
    listEl.innerHTML='';
    ch.forEach(b=>{
      const d=document.createElement('div');d.className='rvm-ch';
      d.innerHTML='<div class="loc">'+b.tagName.toLowerCase()+' #'+(+b.dataset.rvmIdx+1)+'</div>'+
        '<div class="df">'+wordDiff(b.dataset.rvmOrig,b.textContent.trim())+'</div>'+
        '<div class="a"><button class="rvm-acc" data-acc="'+b.dataset.rvmIdx+'">✓ Accept</button>'+
        '<button class="rvm-rej" data-rej="'+b.dataset.rvmIdx+'">✕ Reject</button></div>';
      listEl.appendChild(d);
    });
  }
  document.addEventListener('input',e=>{
    const b=e.target.closest&&e.target.closest('[data-rvm-idx]'); if(!b)return;
    b.classList.toggle('rvm-changed', b.textContent.trim()!==b.dataset.rvmOrig); render();
  });
  listEl.addEventListener('click',e=>{
    const a=e.target.dataset.acc,r=e.target.dataset.rej;
    if(a!=null){const b=blocks[+a];b.dataset.rvmOrig=b.textContent.trim();b.classList.remove('rvm-changed');render();}
    if(r!=null){const b=blocks[+r];b.textContent=b.dataset.rvmOrig;b.classList.remove('rvm-changed');render();}
  });
  document.getElementById('rvm-toggle').addEventListener('click',()=>setActive(!document.body.classList.contains('rvm-active')));
  document.getElementById('rvm-export').addEventListener('click',()=>{
    const clean=blocks.map(b=>b.textContent.trim()).join('\n\n');
    const log=blocks.filter(b=>b.dataset.rvmOrig!==b.dataset.rvmLoad)
      .map(b=>'#'+(+b.dataset.rvmIdx+1)+' ['+b.tagName.toLowerCase()+']\n  ძველი: '+b.dataset.rvmLoad+'\n  ახალი: '+b.dataset.rvmOrig).join('\n\n');
    const out='=== '+(document.title||'Academy')+' — გასწორებული ===\n\n'+clean+
      '\n\n\n=== ცვლილებების ჟურნალი (commit-ისთვის) ===\n\n'+(log||'accepted ცვლილება არ არის');
    const b=new Blob([out],{type:'text/plain;charset=utf-8'}),u=URL.createObjectURL(b),l=document.createElement('a');
    l.href=u;l.download='academy-review-export.txt';l.click();URL.revokeObjectURL(u);
  });
  setActive(true);
})();
