# MyBB 1.8 Markdown Parser Plugin
A MyBB 1.8 plugin that allows users to use markdown within `[md][/md]` tags. This plugin uses the [Parsedown](https://parsedown.org/) library to do the markdown parsing. 

## How to install
1. Copy the inc folder into MyBB.
2. Activate the plugin.
3. Any posts with `[md]` tags should now be rendering markdown into formatted HTML.

## Examples
Here are some example inputs.

### BBCode example
This example includes some BBCode within the `[md]` tags.

```[md]# header
some text. [a link](https://google.com).

> testing with **bold markdown text**

# 

> testing a quote [color=red]with red bbcode text[/color]

# 

> testing a quote with **bold markdown text** and [color=red]red bbcode text[/color]

-----

[quote="ATHOR2"]AUTHR QUOE[/quote]

[color=red]red text[/color]

new line

## a 2nd header
[another link](https://google.com)
[/md]
```

![image](https://github.com/volkbarks/mybb-markdown-parser/blob/main/example%20basic.png)

-----

### Ipsum example
Thanks to [Lorem Markdownum](https://jaspervdj.be/lorem-markdownum/) for generating this!

```[md]# Ignes non nec mandat

## Annis doceo restet audax ferrumque Triones

Lorem markdownum retenta timerent, sunt [Paraetonium](http://ductum-cum.io/) similes grates colla; nec at fata primamque. Rapuere tepente, viri enim victoria!

    third_encryption_rw(access, 2, 2 + 64);
    if (clock_leak * vaporwareThyristorExabyte - dvd >= mount_only_udp) {
        p += mailSecondary.ddrDesktopDuplex(sata + bittorrentJpegKilohertz,
                golden_file, petabyte(ctr));
    }
    ldap_piracy(89);

Bellator tenuavit cuncta undas temptant, ne vomunt capillos satiatae pete, est ut cognovit Haec naides. Contraria longum, gente est exitus, urbe nati Aeetias lacerto largoque ros.

- list 1a
    - list 2a
    - list 2b
- list 1b

Populis deos Aquilone. Nostra Themis, ostendunt adacto; stamen vero verbis. Nisi faciam conspectior iaculum insequitur videtur poposcerat cura; est. Verba capit Athamanteosque potitur [proelia accedat inquit](http://www.acta-passa.com/adspexit.html) post est, nam medio qui quam, hoc. In regione animum capillis; Danae unde motae pellis Echo posuere dic.

## Obstrepuere in deus possunt

Celasse **pennas** vitamque propioris puer, illic spectare brevis Capetusque vulnera protectum a rebelles adhuc Pellaeus! Dixit simul aequore dicentem mutare, quos Stygio antemnas Theron, hoc quamvis currus velat, mox. Seu iuvenci Antiphataeque nihil pumice virtus aures eas [spectare](http://www.rursusauro.com/suos.html), causa vir non duo iras desolatas conpleat iuvenaliter. Evadere fine ille, sunt fuerunt pascitur ut modus socero anhelanti loqui vitae, et [nuper](http://www.ubi.com/non.html).

1. Superi rotarum
2. Timor faxo manu arsit umero plagarum gyrum
3. In si residens tantae in portae coronis
4. Tendebat a edidit potest
5. Centum dixit relinqui pittheam verso

> Urbis nondum lunam; [adsuerant aspicit](http://sigea.com/volentemcorporis), Aeneae formam lacertis **videres pedum** ardescit prensoque! Crescunt enim vertuntur fulsit nostro, clipeo, quid, tenues serpente.

Super saturos moveri sed omni dique Orithyia quoque? Tuos meae infelix. Foedat cognoscenda genu sparsos luctisono recepto erat horrifer illa fratris [est si locus](http://www.aurum.com/et.aspx) incrementa. Latus naufragus sumptis favent Aeoliique *in* breve mersis ergo moveri *fibris* et odoribus fugere, utilibus et prior patrem.[/md]
```

![image](https://github.com/volkbarks/mybb-markdown-parser/blob/main/example%20ipsum.png)
