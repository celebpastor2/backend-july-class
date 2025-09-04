<?php

    require "../books.php";
    $id = 0;

    if(! isset($_REQUEST['id'])){
        //redirecting
        $url = "/";
        header("Location: $url");
        exit;
    } else if( isset($_REQUEST['search'])){
        $url = "/?search=" . $_REQUEST['search'];
        header("Location: $url");
        exit;
    }
    $id    = (int) $_REQUEST['id'];
    $book  = new Books($id);

?>
<!DOCTYPE html>
<html lang="en" itemscope itemtype="https://schema.org/Product">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Product Name – Store</title>
  <meta name="description" content="Beautiful single product page template with gallery, variants, reviews, and sticky add-to-cart." />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root{
      --bg:#0b0d10;         /* page background */
      --card:#12151a;       /* surfaces */
      --muted:#80889a;      /* secondary text */
      --text:#e7edf5;       /* primary text */
      --brand:#4f8cff;      /* primary brand */
      --brand-600:#3a73df;
      --success:#2ecc71;
      --danger:#ff5c5c;
      --ring: 0 0 0 3px rgba(79,140,255,.35);
      --radius:18px;
      --shadow: 0 10px 30px rgba(0,0,0,.35), inset 0 1px 0 rgba(255,255,255,.02);
    }
    * { box-sizing:border-box }
    html,body{height:100%}
    body{margin:0; font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial; background:var(--bg); color:var(--text)}

    .container{ width:min(1200px, 94vw); margin:auto; padding:32px 0 120px }

    /* Header */
    .header{ display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:24px }
    .logo{ display:flex; align-items:center; gap:10px; font-weight:700; letter-spacing:.2px }
    .logo-badge{ width:36px; height:36px; border-radius:12px; background:linear-gradient(135deg, var(--brand), #8a7bff); display:grid; place-items:center; box-shadow:var(--shadow)}
    .logo-badge span{ font-weight:800 }
    .search{ flex:1; max-width:520px; position:relative }
    .search input{ width:100%; background:var(--card); border:1px solid #1c222d; color:var(--text); padding:12px 44px 12px 16px; border-radius:14px; outline:none }
    .search input:focus{ box-shadow:var(--ring); border-color:var(--brand) }
    .search .icon{ position:absolute; right:12px; top:50%; transform:translateY(-50%); opacity:.6 }
    .actions{ display:flex; gap:10px }
    .btn{ appearance:none; border:0; background:var(--card); color:var(--text); padding:10px 14px; border-radius:12px; cursor:pointer; display:inline-flex; align-items:center; gap:10px; box-shadow:var(--shadow); border:1px solid #1c222d }
    .btn:hover{ filter:brightness(1.05) }

    /* Layout */
    .grid{ display:grid; grid-template-columns: 1.2fr .9fr; gap:28px }
    @media (max-width: 980px){ .grid{ grid-template-columns:1fr } }

    /* Gallery */
    .gallery{ background:var(--card); border:1px solid #1c222d; border-radius:var(--radius); padding:16px; box-shadow:var(--shadow) }
    .gallery-main{ aspect-ratio: 1 / 1; border-radius:14px; overflow:hidden; background:#0a0c10; display:grid; place-items:center; position:relative }
    .gallery-main img{ width:100%; height:100%; object-fit:cover }
    .thumbs{ display:grid; grid-template-columns: repeat(6, 1fr); gap:10px; margin-top:12px }
    .thumbs button{ border:1px solid #1c222d; background:#0a0c10; padding:0; border-radius:12px; overflow:hidden; height:64px; cursor:pointer; position:relative }
    .thumbs img{ width:100%; height:100%; object-fit:cover; display:block }
    .thumbs button[aria-current="true"]{ outline: none; box-shadow:var(--ring); border-color:var(--brand) }

    /* Product Panel */
    .panel{ background:var(--card); border:1px solid #1c222d; border-radius:var(--radius); padding:22px; box-shadow:var(--shadow); position:relative }
    .breadcrumbs{ color:var(--muted); font-size:.9rem; margin-bottom:10px }
    .title{ font-size:1.8rem; line-height:1.2; margin:4px 0 8px; font-weight:700 }
    .rating{ display:flex; align-items:center; gap:8px; color:#ffd46b }
    .rating .count{ color:var(--muted) }
    .price-row{ display:flex; align-items:baseline; gap:12px; margin:16px 0 }
    .price{ font-size:2rem; font-weight:800 }
    .compare{ color:var(--muted); text-decoration:line-through }
    .badge{ background:rgba(46, 204, 113, .15); color:var(--success); border:1px solid rgba(46, 204, 113, .35); font-size:.82rem; padding:6px 10px; border-radius:999px }

    .options{ display:grid; gap:16px; margin:20px 0 }
    .opt-group label{ display:block; font-weight:600; margin-bottom:8px }
    .swatch-row{ display:flex; flex-wrap:wrap; gap:10px }
    .swatch{ border:1px solid #1c222d; background:#0a0c10; padding:8px 12px; border-radius:12px; cursor:pointer }
    .swatch[aria-pressed="true"], .swatch:focus{ outline:none; border-color:var(--brand); box-shadow:var(--ring) }

    .qty-wrap{ display:flex; gap:10px; align-items:center }
    .qty{ display:flex; align-items:center; border:1px solid #1c222d; border-radius:12px; overflow:hidden; background:#0a0c10 }
    .qty button{ width:40px; height:40px; background:transparent; color:var(--text); border:0; cursor:pointer }
    .qty input{ width:60px; height:40px; background:transparent; color:var(--text); border:0; text-align:center; font-weight:600 }

    .buy-row{ display:grid; grid-template-columns: 1fr 1fr; gap:10px; margin-top:10px }
    .btn-primary{ background:var(--brand); border-color:transparent }
    .btn-primary:hover{ background:var(--brand-600) }
    .btn-outline{ background:transparent }

    .usp{ display:flex; gap:16px; flex-wrap:wrap; margin-top:14px; color:var(--muted) }
    .usp .chip{ display:flex; gap:8px; align-items:center; padding:8px 10px; border:1px dashed #273142; border-radius:12px }

    /* Accordions */
    .accordion{ margin-top:20px; border-top:1px solid #1c222d }
    details{ border-bottom:1px solid #1c222d; padding:10px 0 }
    details summary{ cursor:pointer; list-style:none; display:flex; justify-content:space-between; align-items:center; font-weight:600 }
    details summary::-webkit-details-marker{ display:none }
    details[open] summary .caret{ transform:rotate(180deg) }
    .accordion p{ color:var(--muted); margin:10px 0 0 }

    /* Reviews */
    .reviews{ margin-top:26px; background:var(--card); border:1px solid #1c222d; border-radius:var(--radius); padding:20px; box-shadow:var(--shadow) }
    .review{ border-top:1px solid #1c222d; padding-top:14px; margin-top:14px }

    /* Related */
    .related{ margin-top:26px }
    .rel-grid{ display:grid; grid-template-columns: repeat(4, minmax(0,1fr)); gap:14px }
    .card{ background:var(--card); border:1px solid #1c222d; border-radius:16px; overflow:hidden; box-shadow:var(--shadow) }
    .card img{ width:100%; aspect-ratio:1/1; object-fit:cover }
    .card .meta{ padding:12px }
    .card .meta .name{ font-weight:600; margin:0 0 6px }
    .card .meta .price{ font-weight:700 }
    @media (max-width: 900px){ .rel-grid{ grid-template-columns: repeat(2, 1fr) } }

    /* Sticky ATC (mobile) */
    .sticky-atc{ position:fixed; bottom:0; left:0; right:0; background:rgba(12,14,18,.9); backdrop-filter: blur(8px); border-top:1px solid #1c222d; display:flex; gap:12px; align-items:center; padding:12px; z-index:50 }
    .sticky-atc .price{ font-size:1.2rem }
    .hide-sticky{ display:none }
    @media (min-width: 981px){ .sticky-atc{ display:none } }

    a { color: var(--brand) }
    .sr-only{ position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0 }
  </style>
</head>
<body>
  <header class="container header" role="banner">
    <div class="logo" aria-label="Brand">
      <div class="logo-badge" aria-hidden="true"><span>◎</span></div>
      <span>NovaStore</span>
    </div>

    <form class="search" role="search" aria-label="Site" action="<?= $_SERVER['HTTP_HOST']; ?>">
      <input type="search" placeholder="Search Books" aria-label="Search" />
      <button type="submit"><span class="icon" aria-hidden>⌕</span></button>       
    </form>

    <nav class="actions" aria-label="Quick actions">
      <button class="btn" aria-label="Open account">👤 Account</button>
      <button class="btn" aria-label="View cart">🛒 Cart</button>
    </nav>
  </header>

  <main class="container grid" role="main">
    <!-- Gallery -->
    <section class="gallery" aria-labelledby="gallery-title">
      <h2 id="gallery-title" class="sr-only">Product gallery</h2>
      <div class="gallery-main">
        <img id="mainImage" src="<?= $book->thumbnail ??= 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=1200&auto=format&fit=crop'?>" alt="Sneaker in blue colorway on dark background" itemprop="image" />
      </div>
      <div class="thumbs" role="list" aria-label="Gallery thumbnails">
        <button aria-current="true" aria-label="Blue sneaker" data-src="<?= $book->thumbnail ?>"><img src="<?= $book->thumbnail?>" alt="Blue sneaker"/></button>
        <button aria-label="Side profile" data-src="<?= $book->thumbnail ?>"><img src="<?= $book->thumbnail?>" alt="Side profile"/></button>
        <button aria-label="On foot" data-src="<?= $book->thumbnail ?>"><img src="<?= $book->thumbnail ?>" alt="On foot"/></button>
        <button aria-label="Detail" data-src="<?= $book->thumbnail ?>"><img src="<?= $book->thumbnail; ?>" alt="Detail"/></button>
        <button aria-label="Packaging" data-src="<?= $book->thumbnail ?>"><img src="<?= $book->thumbnail; ?>" alt="Packaging"/></button>
        <button aria-label="Lifestyle" data-src="<?= $book->thumbnail ?>"><img src="<?= $book->thumbnail ?>" alt="Lifestyle"/></button>
      </div>
    </section>

    <!-- Product Panel -->
    <section class="panel" aria-labelledby="product-title">
      <nav class="breadcrumbs" aria-label="Breadcrumb">
        <a href="#">Home</a> › <a href="#">Footwear</a> › <a href="#">Sneakers</a>
      </nav>

      <h1 id="product-title" class="title" itemprop="name">
        <?= $book->title; ?>
      </h1>
      <div class="rating" aria-label="Rating 4.6 out of 5">
        <span>★★★★★</span>
        <span class="count">(<?= $book->totalReviews; ?> reviews)</span>
      </div>

      <div class="price-row">
        <div class="price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
          <meta itemprop="priceCurrency" content="USD" />
          <span itemprop="price" id="price">$<?= $book->sale_price; ?></span>
        </div>
        <div class="compare">$<?= $book->price; ?></div>
        <span class="badge">In stock</span>
      </div>

      <div class="options">
        <div class="opt-group" role="group" aria-label="Color">
          <label>Pages</label>
          <div class="swatch-row" id="colorSwatches">
            <button class="swatch" aria-pressed="true" data-color="5">5</button>
            <button class="swatch" data-color="half">Half</button>
            <button class="swatch" data-color="full">Full</button>
          </div>
        </div>
        <!--<div class="opt-group" role="group" aria-label="Size">
          <label>Size</label>
          <div class="swatch-row" id="sizeSwatches">
            <button class="swatch" aria-pressed="true" data-size="40">40</button>
            <button class="swatch" data-size="41">41</button>
            <button class="swatch" data-size="42">42</button>
            <button class="swatch" data-size="43">43</button>
            <button class="swatch" data-size="44">44</button>
          </div>
        </div>-->

        <div class="qty-wrap">
          <div class="qty" aria-label="Quantity selector">
            <button type="button" id="decQty" aria-label="Decrease quantity">−</button>
            <input id="qty" type="number" value="1" min="1" inputmode="numeric" aria-live="polite"/>
            <button type="button" id="incQty" aria-label="Increase quantity">＋</button>
          </div>
          <span id="stockNote" class="badge" aria-live="polite">Ships in 24h</span>
        </div>

        <div class="buy-row">
          <button class="btn btn-primary" id="addToCart">🛒 Add to Cart</button>
          <button class="btn btn-outline" id="buyNow">⚡ Buy Now</button>
        </div>
      </div>

      <div class="usp">
        <div class="chip">🚚 Free shipping over $50</div>
        <div class="chip">↩︎ 30‑day returns</div>
        <div class="chip">🔒 Secure checkout</div>
      </div>

      <div class="accordion">
        <details open>
          <summary>Description <span class="caret">▾</span></summary>
          <p itemprop="description"><?= $book->description; ?></p>
        </details>
        <details>
          <summary>Specs <span class="caret">▾</span></summary>
          <p>Weight: 280g · Stack: 28mm · Drop: 8mm · Upper: Recycled knit · Outsole: Rubber.</p>
        </details>
        <details>
          <summary>Shipping & Returns <span class="caret">▾</span></summary>
          <p>Ships within 24 hours from local warehouse. Free returns within 30 days in original condition.</p>
        </details>
      </div>

      <section class="reviews" aria-labelledby="reviews-title">
        <h2 id="reviews-title">Customer Reviews</h2>
        <div class="review">
          <strong>Amelia</strong> – ★★★★★
          <p>Super comfy and surprisingly light. True to size for me.</p>
        </div>
        <div class="review">
          <strong>Ben</strong> – ★★★★☆
          <p>Great daily trainer. Grip could be a touch better on wet surfaces.</p>
        </div>
        <a href="#">Read all 1,248 reviews</a>
      </section>
    </section>
  </main>



  <section class="container related" aria-labelledby="related-title">
    <h2 id="related-title">You may also like</h2>
    <div class="rel-grid">
      <article class="card">
        <img src="https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=800&auto=format&fit=crop" alt="Nova Glide"/>
        <div class="meta">
          <p class="name">Nova Glide</p>
          <p class="price">$109</p>
        </div>
      </article>
      <article class="card">
        <img src="https://images.unsplash.com/photo-1520975922284-9d3d266a19a4?q=80&w=800&auto=format&fit=crop" alt="Nova Pace"/>
        <div class="meta">
          <p class="name">Nova Pace</p>
          <p class="price">$119</p>
        </div>
      </article>
      <article class="card">
        <img src="https://images.unsplash.com/photo-1526401281623-3591df6b2295?q=80&w=800&auto=format&fit=crop" alt="Nova Trail"/>
        <div class="meta">
          <p class="name">Nova Trail</p>
          <p class="price">$129</p>
        </div>
      </article>
      <article class="card">
        <img src="https://images.unsplash.com/photo-1546443046-ed1ce6ffd1dc?q=80&w=800&auto=format&fit=crop" alt="Nova Flex"/>
        <div class="meta">
          <p class="name">Nova Flex</p>
          <p class="price">$99</p>
        </div>
      </article>
    </div>
  </section>

  <!-- Sticky Add to Cart (mobile) -->
  <div class="sticky-atc" id="stickyBar" aria-live="polite">
    <div>
      <div class="title" style="font-size:1rem; margin:0">Nova Runner V3</div>
      <div class="price">$129.00</div>
    </div>
    <button class="btn btn-primary" style="flex:1" id="stickyAdd">Add to Cart</button>
  </div>

  <script>
    // Gallery switching
    const mainImage = document.getElementById('mainImage');
    document.querySelectorAll('.thumbs button').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.thumbs button').forEach(b => b.setAttribute('aria-current','false'));
        btn.setAttribute('aria-current','true');
        const src = btn.getAttribute('data-src');
        mainImage.src = src;
      })
    });

    // Swatch toggles
    function makeToggle(groupSelector, attr){
      document.querySelectorAll(groupSelector + ' .swatch').forEach(s => {
        s.addEventListener('click', () => {
          document.querySelectorAll(groupSelector + ' .swatch').forEach(x => x.setAttribute('aria-pressed','false'));
          s.setAttribute('aria-pressed','true');
          // Demo: change price by size or color
          if(attr === 'size'){
            const size = s.dataset.size;
            const base = 129; // demo base price
            const variantBump = (Number(size) >= 43) ? 10 : 0;
            const final = base + variantBump;
            document.getElementById('price').textContent = `$${final}.00`;
            document.querySelector('.sticky-atc .price').textContent = `$${final}.00`;
          }
        })
      })
    }
    makeToggle('#colorSwatches','color');
    makeToggle('#sizeSwatches','size');

    // Quantity controls
    const qty = document.getElementById('qty');
    document.getElementById('incQty').onclick = () => qty.value = Math.max(1, Number(qty.value) + 1);
    document.getElementById('decQty').onclick = () => qty.value = Math.max(1, Number(qty.value) - 1);

    // Cart actions (demo only)
    function toast(msg){
      const t = document.createElement('div');
      t.textContent = msg;
      t.style.position='fixed'; t.style.right='16px'; t.style.bottom='80px';
      t.style.padding='12px 14px'; t.style.background='rgba(20,24,30,.95)';
      t.style.border='1px solid #1c222d'; t.style.borderRadius='12px';
      t.style.boxShadow='var(--shadow)'; t.style.zIndex='99';
      document.body.appendChild(t); setTimeout(()=>t.remove(), 2200);
    }
    document.getElementById('addToCart').onclick = () => toast('Added to cart ✓');
    document.getElementById('buyNow').onclick = () => toast('Proceeding to checkout…');
    document.getElementById('stickyAdd').onclick = () => toast('Added to cart ✓');

    // Sticky bar hide/show when near main buttons
    const sticky = document.getElementById('stickyBar');
    const buyRow = document.querySelector('.buy-row');
    const io = new IntersectionObserver(([e]) => {
      sticky.classList.toggle('hide-sticky', e.isIntersecting);
    }, { rootMargin: '0px 0px -80% 0px' });
    io.observe(buyRow);
  </script>
</body>
</html>
