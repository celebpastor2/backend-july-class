<?php
//require "books.php";

$books = json_decode( file_get_contents("books.json"), true );

?>

<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Leaf & Ink — Bookstore</title>
  <style>
    :root{
      --bg: #0f172a;          /* slate-900 */
      --bg-soft:#111827;      /* gray-900 */
      --panel:#111827;
      --muted:#94a3b8;        /* slate-400 */
      --text:#e5e7eb;         /* gray-200 */
      --primary:#22c55e;      /* green-500 */
      --primary-700:#15803d;  /* green-700 */
      --ring: rgba(34,197,94,.35);
      --card:#0b1220;
      --accent:#38bdf8;       /* sky-400 */
      --danger:#ef4444;       /* red-500 */
      --shadow: 0 10px 30px rgba(0,0,0,.45);
      --radius: 18px;
    }
    *{box-sizing:border-box}
    html,body{margin:0;background:linear-gradient(180deg,#0b1220, #0f172a 30%, #0b1220);color:var(--text);font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,"Helvetica Neue",Arial,"Noto Sans","Apple Color Emoji","Segoe UI Emoji";}
    a{color:inherit}
    .container{max-width:1200px;margin:0 auto;padding:0 20px}
    header{position:sticky;top:0;z-index:40;background:rgba(11,18,32,.8);backdrop-filter:blur(8px);border-bottom:1px solid rgba(148,163,184,.1)}
    .nav{display:flex;align-items:center;justify-content:space-between;height:72px}
    .brand{display:flex;align-items:center;gap:.6rem;font-weight:700;letter-spacing:.2px}
    .badge{display:inline-flex;align-items:center;gap:.35rem;padding:.35rem .6rem;border-radius:999px;background:rgba(56,189,248,.12);color:#bae6fd;font-size:.75rem;border:1px solid rgba(56,189,248,.25)}
    .controls{display:flex;align-items:center;gap:.6rem}
    .btn{display:inline-flex;align-items:center;gap:.5rem;border:1px solid rgba(148,163,184,.15);background:rgba(255,255,255,.02);color:var(--text);padding:.6rem .9rem;border-radius:12px;font-weight:600;cursor:pointer;transition:.2s;box-shadow:0 0 0 0 var(--ring)}
    .btn:hover{transform:translateY(-1px);background:rgba(255,255,255,.04)}
    .btn.primary{background:linear-gradient(90deg, var(--primary), #16a34a);border-color:transparent;color:white}
    .btn.primary:hover{filter:saturate(1.1)}
    .btn.icon{padding:.55rem .7rem}
    .cart-indicator{position:relative}
    .cart-count{position:absolute;top:-6px;right:-6px;background:var(--danger);color:white;font-size:.7rem;width:18px;height:18px;border-radius:999px;display:grid;place-items:center}

    /* Hero */
    .hero{display:grid;grid-template-columns:1.2fr .8fr;gap:24px;padding:36px 0 18px}
    .hero-card{position:relative;border:1px solid rgba(148,163,184,.12);background:radial-gradient(1100px 400px at 10% -20%, rgba(56,189,248,.18), transparent 40%), linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,.01));border-radius:var(--radius);overflow:hidden;padding:28px;box-shadow:var(--shadow)}
    .hero h1{font-size:clamp(1.8rem, 1.2rem + 2vw, 3rem);margin:0 0 8px}
    .hero p{color:var(--muted);margin:0}
    .searchbar{display:flex;gap:10px;margin-top:18px}
    .input{flex:1;background:#0a1020;border:1px solid rgba(148,163,184,.18);border-radius:14px;padding:.9rem 1rem;color:var(--text);outline:none;transition:.15s;}
    .input:focus{border-color:var(--accent);box-shadow:0 0 0 6px rgba(56,189,248,.08)}

    .highlights{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:16px}
    .highlight{border:1px solid rgba(148,163,184,.12);background:rgba(255,255,255,.02);border-radius:16px;padding:14px}
    .highlight small{display:block;color:var(--muted)}
    .highlight strong{font-size:1.05rem}

    .promo{border:1px dashed rgba(34,197,94,.4);border-radius:var(--radius);padding:22px;background:linear-gradient(145deg, rgba(34,197,94,.08), rgba(34,197,94,.02));display:flex;flex-direction:column;gap:10px;justify-content:center}

    /* Filters */
    .toolbar{display:flex;gap:12px;flex-wrap:wrap;align-items:center;margin:26px 0}
    .chip{padding:.45rem .8rem;border-radius:999px;border:1px solid rgba(148,163,184,.2);background:rgba(255,255,255,.02);cursor:pointer}
    .chip.active{border-color:var(--accent);box-shadow:0 0 0 6px rgba(56,189,248,.08)}
    select{appearance:none;background:#0a1020;border:1px solid rgba(148,163,184,.18);color:var(--text);padding:.6rem .9rem;border-radius:12px}

    /* Grid */
    .grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
    .card{border:1px solid rgba(148,163,184,.12);background:linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,.01));border-radius:18px;overflow:hidden;display:flex;flex-direction:column}
    .cover{height:180px;background:linear-gradient(120deg, rgba(56,189,248,.15), rgba(34,197,94,.12)), radial-gradient(800px 200px at -20% 20%, rgba(56,189,248,.25), transparent 40%), #0a1020;display:grid;place-items:center}
    .cover img{max-height:100%;max-width:100%;object-fit:cover}
    .content{padding:14px;display:flex;flex-direction:column;gap:8px}
    .title{font-weight:700}
    .meta{color:var(--muted);font-size:.9rem}
    .price{font-weight:800}

    /* Cart */
    .drawer{position:fixed;inset:0;pointer-events:none}
    .drawer .backdrop{position:absolute;inset:0;background:rgba(2,6,23,.6);opacity:0;transition:.2s}
    .drawer.open .backdrop{opacity:1;pointer-events:auto}
    .panel{position:absolute;right:-420px;top:0;height:100%;width:400px;background:#0a1020;border-left:1px solid rgba(148,163,184,.12);box-shadow:var(--shadow);transition:.3s;display:flex;flex-direction:column}
    .drawer.open .panel{right:0;pointer-events:auto}
    .panel header{position:sticky;top:0;background:rgba(10,16,32,.9);backdrop-filter:blur(6px);border-bottom:1px solid rgba(148,163,184,.12)}
    .panel h3{margin:0;padding:18px}
    .cart-list{flex:1;overflow:auto;padding:12px;display:flex;flex-direction:column;gap:10px}
    .cart-item{display:grid;grid-template-columns:56px 1fr auto;gap:10px;align-items:center;border:1px solid rgba(148,163,184,.12);border-radius:14px;padding:8px;background:rgba(255,255,255,.02)}
    .qty{display:inline-flex;align-items:center;border:1px solid rgba(148,163,184,.2);border-radius:10px}
    .qty button{background:none;border:none;color:var(--text);padding:.2rem .55rem;cursor:pointer}
    .panel footer{border-top:1px solid rgba(148,163,184,.12);padding:14px;display:grid;gap:10px}
    .summary{display:flex;justify-content:space-between}

    /* Footer */
    footer{margin:40px 0 80px;color:var(--muted);font-size:.95rem}

    /* Responsive */
    @media (max-width: 1024px){
      .grid{grid-template-columns:repeat(3,1fr)}
      .hero{grid-template-columns:1fr;}
    }
    @media (max-width: 680px){
      .grid{grid-template-columns:repeat(2,1fr)}
      .controls .hide-sm{display:none}
    }
    @media (max-width: 420px){
      .grid{grid-template-columns:1fr}
    }
  </style>
</head>
<body>
  <header>
    <div class="container nav">
      <div class="brand">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path d="M3 6.5C3 5.119 4.119 4 5.5 4H9c1.657 0 3 1.343 3 3v12.5c0-1.933-1.567-3.5-3.5-3.5H5.5A2.5 2.5 0 0 0 3 18.5V6.5Z" fill="url(#g1)"/>
          <path d="M12 7c0-1.657 1.343-3 3-3h3.5A2.5 2.5 0 0 1 21 6.5v12c0 1.105-.895 2-2 2h-3.5c-1.657 0-3-1.343-3-3V7Z" fill="url(#g2)"/>
          <defs>
            <linearGradient id="g1" x1="3" x2="12" y1="4" y2="18" gradientUnits="userSpaceOnUse">
              <stop stop-color="#38bdf8"/><stop offset="1" stop-color="#22c55e"/>
            </linearGradient>
            <linearGradient id="g2" x1="12" x2="21" y1="4" y2="18" gradientUnits="userSpaceOnUse">
              <stop stop-color="#22c55e"/><stop offset="1" stop-color="#16a34a"/>
            </linearGradient>
          </defs>
        </svg>
        <span>Leaf & Ink</span>
        <span class="badge">New: Summer Reads</span>
      </div>
      <div class="controls">
        <button class="btn hide-sm" id="themeBtn" title="Toggle theme">Theme</button>
        <div class="cart-indicator">
          <button class="btn icon" id="openCart" aria-label="Open cart">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 3h2l.4 2M7 13h10l3-7H6.4M7 13l-2-8H3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="19" r="1.5" fill="currentColor"/><circle cx="17" cy="19" r="1.5" fill="currentColor"/></svg>
          </button>
          <span class="cart-count" id="cartCount">0</span>
        </div>
        <button class="btn primary" id="cta">Sign In</button>
      </div>
    </div>
  </header>

  <main class="container">
    <section class="hero">
      <div class="hero-card">
        <h1>Find your next favorite book</h1>
        <p>Discover bestsellers, indie gems, and timeless classics. Curated by humans, loved by readers.</p>
        <div class="searchbar">
          <input id="search" class="input" placeholder="Search title, author, or ISBN…" />
          <button class="btn" id="searchBtn">Search</button>
        </div>
        <div class="highlights">
          <div class="highlight"><small>Trending</small><strong>#BookTok Darlings</strong></div>
          <div class="highlight"><small>Deal</small><strong>Buy 2 Get 1 Free</strong></div>
          <div class="highlight"><small>New</small><strong>Signed Editions</strong></div>
        </div>
      </div>
      <aside class="promo">
        <h3 style="margin:0">Local Bookstore Week</h3>
        <p style="margin:0;color:var(--muted)">Show love to indie shops — extra 10% off on selected titles at checkout.</p>
        <button class="btn primary" onclick="alert('Applied! Use code INDIELOVE at checkout.')">Get Code</button>
      </aside>
    </section>

    <section class="toolbar" aria-label="Filters and sort">
      <div id="categoryChips" class="chips" style="display:flex;gap:8px;flex-wrap:wrap"></div>
      <div style="margin-left:auto;display:flex;gap:8px">
        <select id="priceFilter">
          <option value="">Price</option>
          <option value="0-10">Under $10</option>
          <option value="10-20">$10–$20</option>
          <option value="20-40">$20–$40</option>
          <option value="40-1000">$40+</option>
        </select>
        <select id="sort">
          <option value="featured">Sort: Featured</option>
          <option value="price-asc">Price: Low to High</option>
          <option value="price-desc">Price: High to Low</option>
          <option value="rating-desc">Rating: Top Rated</option>
          <option value="newest">Newest</option>
        </select>
      </div>
    </section>

    <section>
      <div id="grid" class="grid" aria-live="polite">
        <?php foreach( $books as $book) : ?>
            
            <div class="cover" aria-hidden="true">
        <!--<svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H14a3 3 0 0 1 3 3v14.5c0-1.933-1.567-3.5-3.5-3.5H6.5A2.5 2.5 0 0 1 4 19.5V5.5Z" fill="url(#gc1)"/>
          <path d="M17 6a3 3 0 0 1 3-3" stroke="#22c55e" stroke-width="1.5"/>
          <defs>
            <linearGradient id="gc1" x1="4" x2="17" y1="3" y2="18" gradientUnits="userSpaceOnUse">
              <stop stop-color="#38bdf8"/><stop offset="1" stop-color="#22c55e"/>
            </linearGradient>
          </defs>
        </svg>-->
        <?php if( isset( $book['thumbnailUrl'] ) ) : ?>
             <img src="<?= $book['thumbnailUrl']; ?>" alt="">
        <?php else : ?>
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H14a3 3 0 0 1 3 3v14.5c0-1.933-1.567-3.5-3.5-3.5H6.5A2.5 2.5 0 0 1 4 19.5V5.5Z" fill="url(#gc1)"/>
          <path d="M17 6a3 3 0 0 1 3-3" stroke="#22c55e" stroke-width="1.5"/>
          <defs>
            <linearGradient id="gc1" x1="4" x2="17" y1="3" y2="18" gradientUnits="userSpaceOnUse">
              <stop stop-color="#38bdf8"/><stop offset="1" stop-color="#22c55e"/>
            </linearGradient>
          </defs>
        </svg>
        <?php endif; ?>
      </div>
      <div class="content">
        <div class="title"><?= $book['title']; ?></div>
        <div class="meta"><?= implode(' ', $book['authors'] )  . ' • ' . implode(',', $book['categories'] ); ?></div>
        <div class="meta" aria-label="Rating">⭐ 4.5 <span style="margin-left:6px;padding:2px 6px;border:1px solid rgba(148,163,184,.25);border-radius:999px">New</span></div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:4px">
          <span class="price">$<?= rand(50, 100); ?></span>
          <button class="btn" aria-label="Add <?= $book['title'] ?> to cart">Add</button>
        </div>
      </div>
        <?php endforeach; ?>
      </div>
    </section>

    <footer class="container">
      <div style="display:grid;grid-template-columns:2fr 1fr 1fr;gap:16px">
        <div>
          <strong>Leaf & Ink</strong>
          <p>Independent bookstore template. Replace this text with your shop story, pickup options, and hours.</p>
        </div>
        <div>
          <strong>Help</strong>
          <ul style="list-style:none;padding-left:0;line-height:2">
            <li><a href="#">Shipping & Returns</a></li>
            <li><a href="#">Gift Cards</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </div>
        <div>
          <strong>Newsletter</strong>
          <div class="searchbar" style="margin-top:8px">
            <input class="input" placeholder="you@example.com" />
            <button class="btn">Subscribe</button>
          </div>
        </div>
      </div>
    </footer>
  </main>

  <!-- Cart Drawer -->
  <div class="drawer" id="drawer" aria-hidden="true">
    <div class="backdrop" id="closeCart"></div>
    <aside class="panel" role="dialog" aria-modal="true" aria-labelledby="cartTitle">
      <header><h3 id="cartTitle">Your Cart</h3></header>
      <div id="cartList" class="cart-list"></div>
      <footer>
        <div class="summary"><span>Subtotal</span><strong id="subtotal">$0.00</strong></div>
        <button class="btn primary" id="checkoutBtn">Checkout</button>
      </footer>
    </aside>
  </div>

<script>
  // --- Demo data ---
  const CATEGORIES = [
    'All','Fiction','Non‑Fiction','Sci‑Fi','Fantasy','Mystery','Romance','Young Adult','Business','Self‑Help'
  ];
  const BOOKS = JSON.parse( "<?= json_encode( $books ); ?>" ) ?? [
    {id:1,title:'The Silent Library',author:'A. Winters',category:'Mystery',price:16.99,rating:4.5,new:true,cover:''},
    {id:2,title:'Nebula Drift',author:'Kai Morgan',category:'Sci‑Fi',price:22.00,rating:4.8,new:false,cover:''},
    {id:3,title:'Fires of Alder',author:'M. Rowan',category:'Fantasy',price:18.50,rating:4.2,new:true,cover:''},
    {id:4,title:'Hearts at Dawn',author:'J. Vale',category:'Romance',price:12.99,rating:4.1,new:false,cover:''},
    {id:5,title:'Atomic Habits 2.0',author:'J. Clear-ish',category:'Self‑Help',price:24.00,rating:4.9,new:true,cover:''},
    {id:6,title:'Start Smart',author:'R. Patel',category:'Business',price:28.00,rating:4.3,new:false,cover:''},
    {id:7,title:'Windswept Shore',author:'L. Reyes',category:'Fiction',price:14.00,rating:4.0,new:false,cover:''},
    {id:8,title:'The Teen Mind',author:'C. Osei',category:'Young Adult',price:11.00,rating:3.9,new:false,cover:''},
    {id:9,title:'Deep Work (Expanded)',author:'C. Newport‑ish',category:'Business',price:30.00,rating:4.7,new:true,cover:''},
    {id:10,title:'Beyond the Vale',author:'S. Akande',category:'Fantasy',price:19.99,rating:4.6,new:false,cover:''},
    {id:11,title:'Galactic Courier',author:'N. Chen',category:'Sci‑Fi',price:9.99,rating:3.8,new:false,cover:''},
    {id:12,title:'The Clue in Blue',author:'R. Okafor',category:'Mystery',price:17.75,rating:4.4,new:false,cover:''},
  ];

  const state = {
    query: '',
    category: 'All',
    price: '',
    sort: 'featured',
    cart: new Map(),
  };

  // --- UI helpers ---
  const $ = (sel, el=document) => el.querySelector(sel);
  const $$ = (sel, el=document) => Array.from(el.querySelectorAll(sel));

  function money(n){return `$${n.toFixed(2)}`}

  function renderChips(){
    const wrap = document.getElementById('categoryChips');
    wrap.innerHTML = '';
    CATEGORIES.forEach(cat=>{
      const btn = document.createElement('button');
      btn.className = 'chip' + (state.category===cat?' active':'');
      btn.textContent = cat;
      btn.onclick = () => {state.category = cat; render();}
      wrap.appendChild(btn);
    });
  }

  function matchesFilters(b){
    const q = state.query.toLowerCase();
    if(q && !(b.title.toLowerCase().includes(q) || b.author.toLowerCase().includes(q))) return false;
    if(state.category !== 'All' && b.category !== state.category) return false;
    if(state.price){
      const [min,max] = state.price.split('-').map(parseFloat);
      if(!(b.price >= min && b.price <= max)) return false;
    }
    return true;
  }

  function sortBooks(list){
    switch(state.sort){
      case 'price-asc': return list.sort((a,b)=>a.price-b.price);
      case 'price-desc': return list.sort((a,b)=>b.price-a.price);
      case 'rating-desc': return list.sort((a,b)=>b.rating-a.rating);
      case 'newest': return list.sort((a,b)=> (b.new?1:0) - (a.new?1:0));
      default: return list; // featured
    }
  }

  function bookCard(b){
    const el = document.createElement('article');
    el.className = 'card';
    el.innerHTML = `
      <div class="cover" aria-hidden="true">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H14a3 3 0 0 1 3 3v14.5c0-1.933-1.567-3.5-3.5-3.5H6.5A2.5 2.5 0 0 1 4 19.5V5.5Z" fill="url(#gc1)"/>
          <path d="M17 6a3 3 0 0 1 3-3" stroke="#22c55e" stroke-width="1.5"/>
          <defs>
            <linearGradient id="gc1" x1="4" x2="17" y1="3" y2="18" gradientUnits="userSpaceOnUse">
              <stop stop-color="#38bdf8"/><stop offset="1" stop-color="#22c55e"/>
            </linearGradient>
          </defs>
        </svg>
      </div>
      <div class="content">
        <div class="title">${b.title}</div>
        <div class="meta">${b.author} • ${b.category}</div>
        <div class="meta" aria-label="Rating">⭐ ${b.rating.toFixed(1)} ${b.new?'<span style="margin-left:6px;padding:2px 6px;border:1px solid rgba(148,163,184,.25);border-radius:999px">New</span>':''}</div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:4px">
          <span class="price">${money(b.price)}</span>
          <button class="btn" aria-label="Add ${b.title} to cart">Add</button>
        </div>
      </div>`;
    el.querySelector('button').onclick = () => addToCart(b);
    return el;
  }

  function renderGrid(){
    const grid = document.getElementById('grid');
    grid.innerHTML = '';
    const filtered = sortBooks(BOOKS.filter(matchesFilters));
    if(!filtered.length){
      const empty = document.createElement('div');
      empty.style.cssText = 'grid-column:1/-1;text-align:center;padding:40px;border:1px solid rgba(148,163,184,.12);border-radius:16px;background:rgba(255,255,255,.02)';
      empty.innerHTML = 'No books found. Try different filters.';
      grid.appendChild(empty);
      return;
    }
    filtered.forEach(b=> grid.appendChild(bookCard(b)));
  }

  // --- Cart ---
  function addToCart(b){
    const curr = state.cart.get(b.id) || { book:b, qty:0 };
    curr.qty += 1;
    state.cart.set(b.id, curr);
    updateCartUI();
  }
  function changeQty(id, delta){
    const item = state.cart.get(id);
    if(!item) return;
    item.qty += delta;
    if(item.qty <= 0) state.cart.delete(id);
    updateCartUI();
  }
  function updateCartUI(){
    const list = document.getElementById('cartList');
    list.innerHTML = '';
    let total = 0, count = 0;
    for(const {book, qty} of state.cart.values()){
      total += book.price * qty; count += qty;
      const row = document.createElement('div');
      row.className = 'cart-item';
      row.innerHTML = `
        <div class="thumb" style="height:56px;background:linear-gradient(120deg, rgba(56,189,248,.15), rgba(34,197,94,.12));border-radius:10px;display:grid;place-items:center">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 7a2 2 0 0 1 2-2h6a3 3 0 0 1 3 3v11c0-1.657-1.343-3-3-3H7a2 2 0 0 1-2 2V7Z" fill="#38bdf8"/></svg>
        </div>
        <div>
          <div style="font-weight:700">${book.title}</div>
          <div class="meta">${book.author}</div>
          <div class="meta">${money(book.price)}</div>
        </div>
        <div style="display:flex;flex-direction:column;gap:6px;align-items:end">
          <div class="qty"><button onclick="changeQty(${book.id},-1)">−</button><span style="padding:0 .5rem">${qty}</span><button onclick="changeQty(${book.id},1)">+</button></div>
          <button class="btn icon" title="Remove" onclick="removeItem(${book.id})">✕</button>
        </div>`;
      list.appendChild(row);
    }
    document.getElementById('subtotal').textContent = money(total);
    document.getElementById('cartCount').textContent = count;
    if($$('#drawer.open').length===0 && count>0){ openDrawer(); }
  }
  function removeItem(id){ state.cart.delete(id); updateCartUI(); }

  // --- Drawer ---
  const drawer = document.getElementById('drawer');
  function openDrawer(){ drawer.classList.add('open'); drawer.setAttribute('aria-hidden','false'); }
  function closeDrawer(){ drawer.classList.remove('open'); drawer.setAttribute('aria-hidden','true'); }

  // --- Render pipeline ---
  function render(){ renderChips(); persistURL(); }

  // --- Persist state to URL for shareable filters ---
  function persistURL(){
    const params = new URLSearchParams();
    if(state.query) params.set('q', state.query);
    if(state.category!=='All') params.set('cat', state.category);
    if(state.price) params.set('price', state.price);
    if(state.sort!=='featured') params.set('sort', state.sort);
    history.replaceState(null, '', `${location.pathname}?${params.toString()}`);
  }
  function loadFromURL(){
    const p = new URLSearchParams(location.search);
    state.query = p.get('q')||''; state.category = p.get('cat')||'All'; state.price = p.get('price')||''; state.sort = p.get('sort')||'featured';
    document.getElementById('search').value = state.query;
    document.getElementById('priceFilter').value = state.price;
    document.getElementById('sort').value = state.sort;
  }

  // --- Events ---
  document.getElementById('search').addEventListener('input', e=>{state.query=e.target.value; renderGrid(); persistURL();});
  document.getElementById('searchBtn').addEventListener('click', ()=>{ renderGrid(); });
  document.getElementById('priceFilter').addEventListener('change', e=>{state.price=e.target.value; renderGrid(); persistURL();});
  document.getElementById('sort').addEventListener('change', e=>{state.sort=e.target.value; renderGrid(); persistURL();});
  document.getElementById('openCart').addEventListener('click', openDrawer);
  document.getElementById('closeCart').addEventListener('click', closeDrawer);
  document.getElementById('checkoutBtn').addEventListener('click', ()=> alert('This is a template — wire to your checkout.'));

  // Simple theme toggle demo
  document.getElementById('themeBtn').addEventListener('click', ()=>{
    const dark = getComputedStyle(document.documentElement).getPropertyValue('--bg').trim() === '#0f172a';
    if(dark){
      document.documentElement.style.setProperty('--bg', '#f8fafc');
      document.documentElement.style.setProperty('--bg-soft', '#ffffff');
      document.documentElement.style.setProperty('--panel', '#ffffff');
      document.documentElement.style.setProperty('--text', '#0f172a');
      document.documentElement.style.setProperty('--card', '#ffffff');
      document.body.style.background = 'linear-gradient(180deg,#f8fafc,#eef2ff)';
    } else {
      document.documentElement.style.setProperty('--bg', '#0f172a');
      document.documentElement.style.setProperty('--bg-soft', '#111827');
      document.documentElement.style.setProperty('--panel', '#111827');
      document.documentElement.style.setProperty('--text', '#e5e7eb');
      document.documentElement.style.setProperty('--card', '#0b1220');
      document.body.style.background = 'linear-gradient(180deg,#0b1220,#0f172a,#0b1220)';
    }
  });

  // Init
  loadFromURL();
  render();
</script>
</body>
</html>
