(function(){
"use strict";
const LUMO={
  name:"Ihya Ulumuddin",
  firstName:"Ihya",
  email:"ihya@email.com",
  status:null,
  lessons:null,
  achievements:null,
  target:null,
  activity:null,
  csrf:{name:"csrf_token_name",value:""},
  flash:null
};

const $=s=>document.querySelector(s);
const reduce=matchMedia("(prefers-reduced-motion: reduce)").matches;

function renderIdentity(){
  const h=$("#hello");
  h.setAttribute("aria-label","Halo, "+LUMO.firstName+"!");
  h.textContent="";
  Array.from("Halo, "+LUMO.firstName+"!").forEach((ch,i)=>{
    const s=document.createElement("span");
    s.textContent=ch===" "?"\u00A0":ch;
    s.setAttribute("aria-hidden","true");
    s.style.animationDelay=(0.25+i*0.05)+"s";
    h.appendChild(s);
  });
  $("#fullname").textContent=LUMO.name;
  $("#email").textContent=LUMO.email;
  if(LUMO.status){const st=$("#status");st.textContent=LUMO.status;st.hidden=false}
  const c=$("#csrf");
  c.name=LUMO.csrf.name;
  c.value=LUMO.csrf.value;
}

function countUp(el,to){
  if(to===null||to===undefined){el.textContent="–";return}
  if(reduce){el.textContent=to;return}
  const t0=performance.now(),d=1400;
  const step=t=>{
    const p=Math.min((t-t0)/d,1),e=1-Math.pow(1-p,4);
    el.textContent=Math.round(to*e);
    if(p<1)requestAnimationFrame(step);
  };
  requestAnimationFrame(step);
}

function renderStats(){
  countUp($("#lessons"),LUMO.lessons);
  countUp($("#achievements"),LUMO.achievements);
  const t=LUMO.target;
  if(t&&t.total>0){
    const pct=Math.min(100,Math.round(t.done/t.total*100));
    $("#target").hidden=false;
    $("#targetLabel").textContent=t.label;
    $("#targetPct").textContent=pct+"%";
    $("#targetTrack").setAttribute("aria-valuenow",pct);
    $("#targetTrack").setAttribute("aria-label",t.label);
    requestAnimationFrame(()=>setTimeout(()=>{$("#targetFill").style.width=pct+"%"},200));
  }
}

function renderChart(data){
  const svg=$("#chart"),empty=$("#empty"),tip=$("#tip");
  const has=Array.isArray(data)&&data.length===7&&data.some(d=>d.value>0);
  if(!has){svg.hidden=true;empty.hidden=false;return}
  empty.hidden=true;svg.hidden=false;
  const W=700,H=280,pt=28,pb=44,pl=34,pr=12;
  const max=Math.max(...data.map(d=>d.value),4);
  const ch=H-pt-pb,slot=(W-pl-pr)/7,bw=Math.min(46,slot*.56);
  svg.setAttribute("viewBox","0 0 "+W+" "+H);
  svg.setAttribute("preserveAspectRatio","xMidYMid meet");
  let out='<defs><linearGradient id="g" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#E88A4D"/><stop offset="1" stop-color="#C85F1B"/></linearGradient></defs>';
  for(let i=0;i<=4;i++){
    const y=pt+ch-ch*i/4,v=Math.round(max*i/4);
    out+='<line x1="'+pl+'" x2="'+(W-pr)+'" y1="'+y+'" y2="'+y+'" stroke="#ECE8DC" stroke-dasharray="4 6"/>';
    out+='<text x="'+(pl-8)+'" y="'+(y+4)+'" text-anchor="end" font-size="12" fill="#62626E" font-family="Inter,sans-serif">'+v+'</text>';
  }
  data.forEach((d,i)=>{
    const h=Math.max(d.value/max*ch,d.value>0?10:4),x=pl+slot*i+(slot-bw)/2,y=pt+ch-h;
    out+='<rect class="bar" x="'+x+'" y="'+y+'" width="'+bw+'" height="'+h+'" rx="'+Math.min(14,bw/2)+'" fill="'+(d.value>0?'url(#g)':'#FCE3CF')+'" style="animation-delay:'+(i*0.09)+'s"/>';
    out+='<rect class="bar-hit" x="'+(pl+slot*i)+'" y="'+pt+'" width="'+slot+'" height="'+ch+'" data-i="'+i+'"/>';
    out+='<text x="'+(x+bw/2)+'" y="'+(H-16)+'" text-anchor="middle" font-size="13" font-weight="600" fill="#62626E" font-family="Inter,sans-serif">'+d.label+'</text>';
  });
  svg.innerHTML=out;
  svg.querySelectorAll(".bar-hit").forEach(r=>{
    const show=()=>{
      const d=data[+r.dataset.i],bb=r.getBoundingClientRect(),pb2=svg.parentElement.getBoundingClientRect();
      tip.textContent=d.value+" pelajaran";
      tip.style.left=(bb.left-pb2.left+bb.width/2)+"px";
      tip.style.top=(bb.top-pb2.top+20)+"px";
      tip.classList.add("on");
    };
    r.addEventListener("mouseenter",show);
    r.addEventListener("click",show);
    r.addEventListener("mouseleave",()=>tip.classList.remove("on"));
  });
}

function sampleWeek(){
  const names=["Sen","Sel","Rab","Kam","Jum","Sab","Min"],v=[2,4,1,5,3,6,4];
  return names.map((n,i)=>({label:n,value:v[i]}));
}

let previewOn=false;
$("#preview").addEventListener("click",e=>{
  previewOn=!previewOn;
  e.currentTarget.textContent=previewOn?"Tutup contoh tampilan":"Lihat contoh tampilan";
  renderChart(previewOn?sampleWeek():LUMO.activity);
  toast(previewOn?"Ini hanya contoh tampilan, bukan datamu.":"Kembali ke data aslimu.");
});

const toastEl=$("#toast");let toastTimer;
function toast(msg){
  toastEl.textContent=msg;
  toastEl.classList.add("on");
  clearTimeout(toastTimer);
  toastTimer=setTimeout(()=>toastEl.classList.remove("on"),3200);
}

document.querySelectorAll("[data-ripple]").forEach(b=>{
  b.addEventListener("pointerdown",e=>{
    const r=b.getBoundingClientRect(),s=Math.max(r.width,r.height),sp=document.createElement("span");
    sp.className="ripple";
    sp.style.width=sp.style.height=s+"px";
    sp.style.left=(e.clientX-r.left-s/2)+"px";
    sp.style.top=(e.clientY-r.top-s/2)+"px";
    b.appendChild(sp);
    setTimeout(()=>sp.remove(),700);
  });
});

const io=new IntersectionObserver(es=>{
  es.forEach(en=>{
    if(en.isIntersecting){en.target.classList.add("in");io.unobserve(en.target)}
  });
},{threshold:.12});
document.querySelectorAll(".reveal").forEach((el,i)=>{
  el.style.transitionDelay=(i*0.08)+"s";
  io.observe(el);
});

if(!reduce&&matchMedia("(hover:hover)").matches){
  document.querySelectorAll("[data-tilt]").forEach(c=>{
    c.addEventListener("pointermove",e=>{
      const r=c.getBoundingClientRect(),x=(e.clientX-r.left)/r.width-.5,y=(e.clientY-r.top)/r.height-.5;
      c.style.transition="transform .1s linear,opacity .9s,box-shadow .3s";
      c.style.transform="perspective(1100px) rotateX("+(-y*3)+"deg) rotateY("+(x*4)+"deg)";
    });
    c.addEventListener("pointerleave",()=>{
      c.style.transition="transform .8s cubic-bezier(.22,1,.36,1),opacity .9s";
      c.style.transform="";
    });
  });
  const blobs=document.querySelectorAll(".blob");
  addEventListener("pointermove",e=>{
    const x=e.clientX/innerWidth-.5,y=e.clientY/innerHeight-.5;
    blobs.forEach(b=>{
      const d=+b.dataset.depth;
      b.style.transform="translate("+(x*d*2)+"px,"+(y*d*2)+"px)";
    });
  });
}

renderIdentity();
renderStats();
renderChart(LUMO.activity);
if(LUMO.flash)toast(LUMO.flash);
})();