/**
 * Funny Bingo
 * * © 2025 Ryan Jison de la Gente. All Rights Reserved.
 * Unauthorized copying of this file, via any medium, is strictly prohibited.
 * Proprietary and confidential.
 * Written by Ryan Jison de la Gente, [December, 2025]
 */

const patterns = {
    "X-Shape": [0,4,6,8,12,16,18,20,24],
    "Blackout": Array.from({length:25},(_,i)=>i), 
    "Corners": [0,4,20,24],
    "Letter L": [0,5,10,15,20,21,22,23,24],
    "Letter T": [0,1,2,3,4,7,12,17,22],
    "Plus Sign": [2,7,10,11,12,13,14,17,22],
    "Diamond": [2,6,8,10,14,16,18,22],
    "Small Frame": [6,7,8,11,13,16,17,18],
    "Large Frame": [0,1,2,3,4,5,9,10,14,15,19,20,21,22,23,24],
    "Sputnik": [0,4,12,20,24,2,10,14,22],
    "Zig Zag": [0,1,2,8,12,16,22,23,24],
    "Letter H": [0,5,10,15,20,4,9,14,19,24,11,12,13],
    "Chevron": [0,6,12,8,4],
    "Heart": [1,3,5,6,7,8,9,10,11,12,13,14,16,17,18,22],
    "Arrow": [2,7,12,17,22,6,8]
};

// This function clears and rebuilds the pattern preview grid
function updatePreview() {
    const pre = document.getElementById('p-preview');
    if (!pre) return;
    document.getElementById('p-name').textContent = currentP;
    pre.innerHTML = '';
    for(let i=0; i<25; i++) {
        const dot = document.createElement('div');
        // Adds 'active' class if the index is part of the pattern
        dot.className = `p-dot ${patterns[currentP].includes(i) ? 'active' : ''}`;
        pre.appendChild(dot);
    }
}

let drawnSet = new Set(), history = [], currentP = "X-Shape", autoInterval = null;
const letters = ['B','I','N','G','O'], rowCls = ['row-b','row-i','row-n','row-g','row-o'];

function speak(text) {
    const toggle = document.getElementById('voice-toggle');
    if (toggle && toggle.checked) {
        window.speechSynthesis.cancel();
        const msg = new SpeechSynthesisUtterance(text);
        msg.rate = 0.9;
        window.speechSynthesis.speak(msg);
    }
}

function init() {
    if (document.body.classList.contains('player-mode')) {
        generatePlayerCard();
        return;
    }

    const grid = document.getElementById('master-grid');
    if (grid) {
        grid.innerHTML = '';
        letters.forEach((l, i) => {
            const head = document.createElement('div');
            head.className = `cell letter-cell ${rowCls[i]}`;
            head.textContent = l; grid.appendChild(head);
            for(let n=1; n<=15; n++) {
                const div = document.createElement('div');
                div.className = `cell ${rowCls[i]}`;
                div.id = `ball-${(i*15)+n}`;
                div.textContent = (i*15)+n; grid.appendChild(div);
            }
        });
    }

    const list = document.getElementById('p-scroll');
    if (list) {
        list.innerHTML = '';
        Object.keys(patterns).forEach(k => {
            const btn = document.createElement('button');
            btn.className = `p-btn ${k === currentP ? 'selected' : ''}`;
            btn.textContent = k;
            btn.onclick = () => { 
                currentP = k; 
                document.querySelectorAll('.p-btn').forEach(b => b.classList.remove('selected')); 
                btn.classList.add('selected'); 
                updatePreview(); 
            };
            list.appendChild(btn);
        });
        updatePreview();
    }

    setInterval(() => {
        const timeEl = document.getElementById('stat-time');
        if (timeEl) timeEl.textContent = new Date().toLocaleTimeString();
    }, 1000);
}

function updatePreview() {
    const pre = document.getElementById('p-preview');
    if (!pre) return;
    document.getElementById('p-name').textContent = currentP;
    pre.innerHTML = '';
    for(let i=0; i<25; i++) {
        const dot = document.createElement('div');
        dot.className = `p-dot ${patterns[currentP].includes(i) ? 'active' : ''}`;
        pre.appendChild(dot);
    }
}

function drawBall() {
    if(drawnSet.size >= 75) {
        if(autoInterval) toggleAutoCall();
        return;
    }
    let n; do { n = Math.floor(Math.random()*75)+1; } while(drawnSet.has(n));
    
    drawnSet.add(n);
    const l = letters[Math.floor((n-1)/15)];
    history.unshift({n, l});
    if(history.length > 5) history.pop();

    updateHistory();
    showPop(n, l);
    speak(`${l} ... ${n}`);

    const color = `var(--color-${l.toLowerCase()})`;
    const ballCircle = document.getElementById('ball-circle');
    const callText = document.getElementById('call-text');
    
    ballCircle.textContent = n;
    ballCircle.style.borderColor = color;
    callText.textContent = `${l}-${n}`;
    callText.style.color = color;
    
    const masterCell = document.getElementById(`ball-${n}`);
    if(masterCell) masterCell.classList.add('active');
    
    document.getElementById('stat-count').textContent = drawnSet.size;
}

function showPop(n, l) {
    const pop = document.getElementById('pop-ball');
    document.getElementById('pop-l').textContent = l;
    document.getElementById('pop-n').textContent = n;
    pop.style.borderColor = `var(--color-${l.toLowerCase()})`;
    pop.classList.remove('fade'); pop.classList.add('active');
    setTimeout(() => { pop.classList.add('fade'); setTimeout(() => pop.classList.remove('active'), 600); }, 2500);
}

function resetGame() {
    if(!confirm("Reset current game?")) return;
    drawnSet.clear(); history = [];
    if(autoInterval) toggleAutoCall();
    document.querySelectorAll('.cell').forEach(c => c.classList.remove('active'));
    document.getElementById('history-tray').innerHTML = '';
    document.getElementById('ball-circle').textContent = "--";
    document.getElementById('call-text').textContent = "READY";
    document.getElementById('stat-count').textContent = "0";
    speak("Game Reset");
}

function toggleAutoCall() {
    const btn = document.getElementById('auto-btn');
    if(autoInterval) {
        clearInterval(autoInterval); autoInterval = null;
        btn.textContent = "AUTO OFF";
    } else {
        const sec = document.getElementById('auto-speed').value;
        autoInterval = setInterval(drawBall, sec * 1000);
        btn.textContent = "AUTO ON";
    }
}

function generatePlayerCard() {
    const grid = document.getElementById('player-card-grid');
    if (!grid) return;
    grid.innerHTML = '';
    const ranges = [{m:1,x:15},{m:16,x:30},{m:31,x:45},{m:46,x:60},{m:61,x:75}];
    const cols = ranges.map(r => {
        let n = []; while(n.length<5){ let v=Math.floor(Math.random()*(r.x-r.m+1))+r.m; if(!n.includes(v))n.push(v); }
        return n.sort((a,b)=>a-b);
    });
    for(let r=0; r<5; r++){
        for(let c=0; c<5; c++){
            const d = document.createElement('div');
            d.className = 'player-cell';
            if(r===2 && c===2){ d.textContent="FREE"; d.classList.add('free-space','marked'); }
            else { d.textContent=cols[c][r]; d.onclick=function(){this.classList.toggle('marked');}; }
            grid.appendChild(d);
        }
    }
}

function triggerBingo() {
    speak("BINGO! We have a winner!");
    for(let i=0; i<50; i++) {
        const c = document.createElement('div');
        c.style.cssText = `position:fixed; width:8px; height:8px; left:${Math.random()*100}vw; top:-10px; background:hsl(${Math.random()*360},100%,50%); animation: fall 3s linear forwards; z-index:100;`;
        document.body.appendChild(c); setTimeout(()=>c.remove(), 3000);
    }
}

function toggleTheme() { document.body.classList.toggle('hall-theme'); }

function updateHistory() {
    const tray = document.getElementById('history-tray');
    if(!tray) return;
    tray.innerHTML = '';
    history.forEach((item, i) => {
        const b = document.createElement('div');
        b.className = 'hist-ball';
        b.textContent = item.n;
        b.style.opacity = 1 - (i * 0.15);
        b.style.borderColor = `var(--color-${item.l.toLowerCase()})`;
        tray.appendChild(b);
    });
}

document.getElementById('auto-speed').oninput = function() { document.getElementById('speed-label').textContent = this.value + 's'; };

init();