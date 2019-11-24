
<div id="site-container">

    <!--
    Yes, this is allowed:
    https://www.w3.org/TR/html5/document-metadata.html#the-style-element
    -->
    <style>
        .rnd-col { font-size: 2rem; cursor: default; transition: 1s; }
        .rnd-col:hover { font-weight: bold; }
        .rnd-col-1:hover{ color: <?php echo sprintf('#%06X', mt_rand(0, 0xFFFFFF)) ?>; }
        .rnd-col-2:hover{ color: <?php echo sprintf('#%06X', mt_rand(0, 0xFFFFFF)) ?>; }
        .rnd-col-3:hover{ color: <?php echo sprintf('#%06X', mt_rand(0, 0xFFFFFF)) ?>; }
    </style>

    <header>
        <div>
            <div id="header-title">
                <a href="?"><?php echo LOGMD_HEADER_TITLE ?></a>
            </div>
            <div id="header-subtitle"><?php echo LOGMD_HEADER_SUBTITLE ?></div>
        </div>
        <div>
            <span class="rnd-col rnd-col-1" title="Ooohh!">&olcir;</span>
            <span class="rnd-col rnd-col-2" title="Uhh!">&ofcir;</span>
            <span class="rnd-col rnd-col-3" title="&Wfr; &Ofr; &Wfr; !">&cirscir;</span>
        </div>
    </header>

    <main>