-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  cl1-sql22
-- Généré le :  Mar 03 Octobre 2017 à 13:56
-- Version du serveur :  10.0.32-MariaDB-1~jessie
-- Version de PHP :  5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `p6379_2`
--

-- --------------------------------------------------------

--
-- Structure de la table `ocp3_Billets`
--

CREATE TABLE `ocp3_Billets` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text,
  `extrait` text,
  `auteur_id` int(11) NOT NULL,
  `date_publie` datetime NOT NULL,
  `date_modif` datetime DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `statut` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `ocp3_Billets`
--

INSERT INTO `ocp3_Billets` (`id`, `titre`, `contenu`, `extrait`, `auteur_id`, `date_publie`, `date_modif`, `image_id`, `statut`) VALUES
(23, 'La découverte', '<p>Hac ex causa conlaticia stipe Valerius humatur ille Publicola et subsidiis amicorum mariti inops cum liberis uxor alitur Reguli et dotatur ex aerario filia Scipionis, cum nobilitas florem adultae virginis diuturnum absentia pauperis erubesceret patris.</p>\r\n<p>Saraceni tamen nec amici nobis umquam nec hostes optandi, ultro citroque discursantes quicquid inveniri poterat momento temporis parvi vastabant milvorum rapacium similes, qui si praedam dispexerint celsius, volatu rapiunt celeri, aut nisi impetraverint, non inmorantur.</p>\r\n<p>Atque, ut Tullius ait, ut etiam ferae fame monitae plerumque ad eum locum ubi aliquando pastae sunt revertuntur, ita homines instar turbinis degressi montibus impeditis et arduis loca petivere mari confinia, per quae viis latebrosis sese convallibusque occultantes cum appeterent noctes luna etiam tum cornuta ideoque nondum solido splendore fulgente nauticos observabant quos cum in somnum sentirent effusos per ancoralia, quadrupedo gradu repentes seseque suspensis passibus iniectantes in scaphas eisdem sensim nihil opinantibus adsistebant et incendente aviditate saevitiam ne cedentium quidem ulli parcendo obtruncatis omnibus merces opimas velut viles nullis repugnantibus avertebant. haecque non diu sunt perpetrata.</p>\r\n<p>Iamque lituis cladium concrepantibus internarum non celate ut antea turbidum saeviebat ingenium a veri consideratione detortum et nullo inpositorum vel conpositorum fidem sollemniter inquirente nec discernente a societate noxiorum insontes velut exturbatum e iudiciis fas omne discessit, et causarum legitima silente defensione carnifex rapinarum sequester et obductio capitum et bonorum ubique multatio versabatur per orientales provincias, quas recensere puto nunc oportunum absque Mesopotamia digesta, cum bella Parthica dicerentur, et Aegypto, quam necessario aliud reieci ad tempus.</p>\r\n<p>Iam virtutem ex consuetudine vitae sermonisque nostri interpretemur nec eam, ut quidam docti, verborum magnificentia metiamur virosque bonos eos, qui habentur, numeremus, Paulos, Catones, Galos, Scipiones, Philos; his communis vita contenta est; eos autem omittamus, qui omnino nusquam reperiuntur.</p>\r\n<p>Homines enim eruditos et sobrios ut infaustos et inutiles vitant, eo quoque accedente quod et nomenclatores adsueti haec et talia venditare, mercede accepta lucris quosdam et prandiis inserunt subditicios ignobiles et obscuros.</p>\r\n<p>Denique Antiochensis ordinis vertices sub uno elogio iussit occidi ideo efferatus, quod ei celebrari vilitatem intempestivam urgenti, cum inpenderet inopia, gravius rationabili responderunt; et perissent ad unum ni comes orientis tunc Honoratus fixa constantia restitisset.</p>\r\n<p>Post emensos insuperabilis expeditionis eventus languentibus partium animis, quas periculorum varietas fregerat et laborum, nondum tubarum cessante clangore vel milite locato per stationes hibernas, fortunae saevientis procellae tempestates alias rebus infudere communibus per multa illa et dira facinora Caesaris Galli, qui ex squalore imo miseriarum in aetatis adultae primitiis ad principale culmen insperato saltu provectus ultra terminos potestatis delatae procurrens asperitate nimia cuncta foedabat. propinquitate enim regiae stirpis gentilitateque etiam tum Constantini nominis efferebatur in fastus, si plus valuisset, ausurus hostilia in auctorem suae felicitatis, ut videbatur.</p>\r\n<p>Omitto iuris dictionem in libera civitate contra leges senatusque consulta; caedes relinquo; libidines praetereo, quarum acerbissimum extat indicium et ad insignem memoriam turpitudinis et paene ad iustum odium imperii nostri, quod constat nobilissimas virgines se in puteos abiecisse et morte voluntaria necessariam turpitudinem depulisse. Nec haec idcirco omitto, quod non gravissima sint, sed quia nunc sine teste dico.</p>\r\n<p>Quare talis improborum consensio non modo excusatione amicitiae tegenda non est sed potius supplicio omni vindicanda est, ut ne quis concessum putet amicum vel bellum patriae inferentem sequi; quod quidem, ut res ire coepit, haud scio an aliquando futurum sit. Mihi autem non minori curae est, qualis res publica post mortem meam futura, quam qualis hodie sit.</p>\r\n<p>&nbsp;</p>', 'Omitto iuris dictionem in libera civitate contra leges senatusque consulta; caedes relinquo; libidines praetereo, quarum acerbissimum extat indicium et ad insignem memoriam turpitudinis et paene ad iustum odium imperii nostri, quod constat nobilissimas virgines se in puteos abiecisse et morte voluntaria necessariam turpitudinem depulisse. Nec haec idcirco omitto, quod non gravissima sint, sed quia nunc sine teste dico.', 13, '2017-10-03 00:34:25', '2017-10-03 00:45:10', 95, 'Publication'),
(24, 'Un nouveau monde', '<p>Novo denique perniciosoque exemplo idem Gallus ausus est inire flagitium grave, quod Romae cum ultimo dedecore temptasse aliquando dicitur Gallienus, et adhibitis paucis clam ferro succinctis vesperi per tabernas palabatur et conpita quaeritando Graeco sermone, cuius erat inpendio gnarus, quid de Caesare quisque sentiret. et haec confidenter agebat in urbe ubi pernoctantium luminum claritudo dierum solet imitari fulgorem. postremo agnitus saepe iamque, si prodisset, conspicuum se fore contemplans, non nisi luce palam egrediens ad agenda quae putabat seria cernebatur. et haec quidem medullitus multis gementibus agebantur.</p>\r\n<p>&nbsp;</p>\r\n<p>Ciliciam vero, quae Cydno amni exultat, Tarsus nobilitat, urbs perspicabilis hanc condidisse Perseus memoratur, Iovis filius et Danaes, vel certe ex Aethiopia profectus Sandan quidam nomine vir opulentus et nobilis et Anazarbus auctoris vocabulum referens, et Mopsuestia vatis illius domicilium Mopsi, quem a conmilitio Argonautarum cum aureo vellere direpto redirent, errore abstractum delatumque ad Africae litus mors repentina consumpsit, et ex eo cespite punico tecti manes eius heroici dolorum varietati medentur plerumque sospitales.</p>\r\n<p>&nbsp;</p>\r\n<p>Hoc inmaturo interitu ipse quoque sui pertaesus excessit e vita aetatis nono anno atque vicensimo cum quadriennio imperasset. natus apud Tuscos in Massa Veternensi, patre Constantio Constantini fratre imperatoris, matreque Galla sorore Rufini et Cerealis, quos trabeae consulares nobilitarunt et praefecturae.</p>\r\n<p>&nbsp;</p>\r\n<p>Haec subinde Constantius audiens et quaedam referente Thalassio doctus, quem eum odisse iam conpererat lege communi, scribens ad Caesarem blandius adiumenta paulatim illi subtraxit, sollicitari se simulans ne, uti est militare otium fere tumultuosum, in eius perniciem conspiraret, solisque scholis iussit esse contentum palatinis et protectorum cum Scutariis et Gentilibus, et mandabat Domitiano, ex comite largitionum, praefecto ut cum in Syriam venerit, Gallum, quem crebro acciverat, ad Italiam properare blande hortaretur et verecunde.</p>\r\n<p>&nbsp;</p>\r\n<p>Quibus ita sceleste patratis Paulus cruore perfusus reversusque ad principis castra multos coopertos paene catenis adduxit in squalorem deiectos atque maestitiam, quorum adventu intendebantur eculei uncosque parabat carnifex et tormenta. et ex is proscripti sunt plures actique in exilium alii, non nullos gladii consumpsere poenales. nec enim quisquam facile meminit sub Constantio, ubi susurro tenus haec movebantur, quemquam absolutum.</p>\r\n<p>&nbsp;</p>\r\n<p>Accenderat super his incitatum propositum ad nocendum aliqua mulier vilis, quae ad palatium ut poposcerat intromissa insidias ei latenter obtendi prodiderat a militibus obscurissimis. quam Constantina exultans ut in tuto iam locata mariti salute muneratam vehiculoque inpositam per regiae ianuas emisit in publicum, ut his inlecebris alios quoque ad indicanda proliceret paria vel maiora.</p>\r\n<p>&nbsp;</p>\r\n<p>Itaque verae amicitiae difficillime reperiuntur in iis qui in honoribus reque publica versantur; ubi enim istum invenias qui honorem amici anteponat suo? Quid? Haec ut omittam, quam graves, quam difficiles plerisque videntur calamitatum societates! Ad quas non est facile inventu qui descendant. Quamquam Ennius recte.</p>\r\n<p>&nbsp;</p>\r\n<p>Ac ne quis a nobis hoc ita dici forte miretur, quod alia quaedam in hoc facultas sit ingeni, neque haec dicendi ratio aut disciplina, ne nos quidem huic uni studio penitus umquam dediti fuimus. Etenim omnes artes, quae ad humanitatem pertinent, habent quoddam commune vinculum, et quasi cognatione quadam inter se continentur.</p>\r\n<p>&nbsp;</p>\r\n<p>Dumque ibi diu moratur commeatus opperiens, quorum translationem ex Aquitania verni imbres solito crebriores prohibebant auctique torrentes, Herculanus advenit protector domesticus, Hermogenis ex magistro equitum filius, apud Constantinopolim, ut supra rettulimus, populari quondam turbela discerpti. quo verissime referente quae Gallus egerat, damnis super praeteritis maerens et futurorum timore suspensus angorem animi quam diu potuit emendabat.</p>\r\n<p>&nbsp;</p>\r\n<p>Et Epigonus quidem amictu tenus philosophus, ut apparuit, prece frustra temptata, sulcatis lateribus mortisque metu admoto turpi confessione cogitatorum socium, quae nulla erant, fuisse firmavit cum nec vidisset quicquam nec audisset penitus expers forensium rerum; Eusebius vero obiecta fidentius negans, suspensus in eodem gradu constantiae stetit latrocinium illud esse, non iudicium clamans.</p>\r\n<p>Novo denique perniciosoque exemplo idem Gallus ausus est inire flagitium grave, quod Romae cum ultimo dedecore temptasse aliquando dicitur Gallienus, et adhibitis paucis clam ferro succinctis vesperi per tabernas palabatur et conpita quaeritando Graeco sermone, cuius erat inpendio gnarus, quid de Caesare quisque sentiret. et haec confidenter agebat in urbe ubi pernoctantium luminum claritudo dierum solet imitari fulgorem. postremo agnitus saepe iamque, si prodisset, conspicuum se fore contemplans, non nisi luce palam egrediens ad agenda quae putabat seria cernebatur. et haec quidem medullitus multis gementibus agebantur.</p>\r\n<p>&nbsp;</p>\r\n<p>Ciliciam vero, quae Cydno amni exultat, Tarsus nobilitat, urbs perspicabilis hanc condidisse Perseus memoratur, Iovis filius et Danaes, vel certe ex Aethiopia profectus Sandan quidam nomine vir opulentus et nobilis et Anazarbus auctoris vocabulum referens, et Mopsuestia vatis illius domicilium Mopsi, quem a conmilitio Argonautarum cum aureo vellere direpto redirent, errore abstractum delatumque ad Africae litus mors repentina consumpsit, et ex eo cespite punico tecti manes eius heroici dolorum varietati medentur plerumque sospitales.</p>\r\n<p>&nbsp;</p>\r\n<p>Hoc inmaturo interitu ipse quoque sui pertaesus excessit e vita aetatis nono anno atque vicensimo cum quadriennio imperasset. natus apud Tuscos in Massa Veternensi, patre Constantio Constantini fratre imperatoris, matreque Galla sorore Rufini et Cerealis, quos trabeae consulares nobilitarunt et praefecturae.</p>\r\n<p>&nbsp;</p>\r\n<p>Haec subinde Constantius audiens et quaedam referente Thalassio doctus, quem eum odisse iam conpererat lege communi, scribens ad Caesarem blandius adiumenta paulatim illi subtraxit, sollicitari se simulans ne, uti est militare otium fere tumultuosum, in eius perniciem conspiraret, solisque scholis iussit esse contentum palatinis et protectorum cum Scutariis et Gentilibus, et mandabat Domitiano, ex comite largitionum, praefecto ut cum in Syriam venerit, Gallum, quem crebro acciverat, ad Italiam properare blande hortaretur et verecunde.</p>\r\n<p>&nbsp;</p>\r\n<p>Quibus ita sceleste patratis Paulus cruore perfusus reversusque ad principis castra multos coopertos paene catenis adduxit in squalorem deiectos atque maestitiam, quorum adventu intendebantur eculei uncosque parabat carnifex et tormenta. et ex is proscripti sunt plures actique in exilium alii, non nullos gladii consumpsere poenales. nec enim quisquam facile meminit sub Constantio, ubi susurro tenus haec movebantur, quemquam absolutum.</p>\r\n<p>&nbsp;</p>\r\n<p>Accenderat super his incitatum propositum ad nocendum aliqua mulier vilis, quae ad palatium ut poposcerat intromissa insidias ei latenter obtendi prodiderat a militibus obscurissimis. quam Constantina exultans ut in tuto iam locata mariti salute muneratam vehiculoque inpositam per regiae ianuas emisit in publicum, ut his inlecebris alios quoque ad indicanda proliceret paria vel maiora.</p>\r\n<p>&nbsp;</p>\r\n<p>Itaque verae amicitiae difficillime reperiuntur in iis qui in honoribus reque publica versantur; ubi enim istum invenias qui honorem amici anteponat suo? Quid? Haec ut omittam, quam graves, quam difficiles plerisque videntur calamitatum societates! Ad quas non est facile inventu qui descendant. Quamquam Ennius recte.</p>\r\n<p>&nbsp;</p>\r\n<p>Ac ne quis a nobis hoc ita dici forte miretur, quod alia quaedam in hoc facultas sit ingeni, neque haec dicendi ratio aut disciplina, ne nos quidem huic uni studio penitus umquam dediti fuimus. Etenim omnes artes, quae ad humanitatem pertinent, habent quoddam commune vinculum, et quasi cognatione quadam inter se continentur.</p>\r\n<p>&nbsp;</p>\r\n<p>Dumque ibi diu moratur commeatus opperiens, quorum translationem ex Aquitania verni imbres solito crebriores prohibebant auctique torrentes, Herculanus advenit protector domesticus, Hermogenis ex magistro equitum filius, apud Constantinopolim, ut supra rettulimus, populari quondam turbela discerpti. quo verissime referente quae Gallus egerat, damnis super praeteritis maerens et futurorum timore suspensus angorem animi quam diu potuit emendabat.</p>\r\n<p>&nbsp;</p>\r\n<p>Et Epigonus quidem amictu tenus philosophus, ut apparuit, prece frustra temptata, sulcatis lateribus mortisque metu admoto turpi confessione cogitatorum socium, quae nulla erant, fuisse firmavit cum nec vidisset quicquam nec audisset penitus expers forensium rerum; Eusebius vero obiecta fidentius negans, suspensus in eodem gradu constantiae stetit latrocinium illud esse, non iudicium clamans.</p>', 'Novo denique perniciosoque exemplo idem Gallus ausus est inire flagitium grave, quod Romae cum ultimo dedecore temptasse aliquando dicitur Gallienus, et adhibitis paucis clam ferro succinctis vesperi per tabernas palabatur et conpita quaeritando Graeco sermone, cuius erat inpendio gnarus, quid de Ca[...]', 13, '2017-10-03 01:00:39', '2017-10-03 14:00:13', 96, 'Publication'),
(25, 'Le voyage', '<p>Quae dum ita struuntur, indicatum est apud Tyrum indumentum regale textum occulte, incertum quo locante vel cuius usibus apparatum. ideoque rector provinciae tunc pater Apollinaris eiusdem nominis ut conscius ductus est aliique congregati sunt ex diversis civitatibus multi, qui atrocium criminum ponderibus urgebantur.</p>\r\n<p>Ut enim quisque sibi plurimum confidit et ut quisque maxime virtute et sapientia sic munitus est, ut nullo egeat suaque omnia in se ipso posita iudicet, ita in amicitiis expetendis colendisque maxime excellit. Quid enim? Africanus indigens mei? Minime hercule! ac ne ego quidem illius; sed ego admiratione quadam virtutis eius, ille vicissim opinione fortasse non nulla, quam de meis moribus habebat, me dilexit; auxit benevolentiam consuetudo. Sed quamquam utilitates multae et magnae consecutae sunt, non sunt tamen ab earum spe causae diligendi profectae.</p>\r\n<p>Sed (saepe enim redeo ad Scipionem, cuius omnis sermo erat de amicitia) querebatur, quod omnibus in rebus homines diligentiores essent; capras et oves quot quisque haberet, dicere posse, amicos quot haberet, non posse dicere et in illis quidem parandis adhibere curam, in amicis eligendis neglegentis esse nec habere quasi signa quaedam et notas, quibus eos qui ad amicitias essent idonei, iudicarent. Sunt igitur firmi et stabiles et constantes eligendi; cuius generis est magna penuria. Et iudicare difficile est sane nisi expertum; experiendum autem est in ipsa amicitia. Ita praecurrit amicitia iudicium tollitque experiendi potestatem.</p>\r\n<p>Nunc vero inanes flatus quorundam vile esse quicquid extra urbis pomerium nascitur aestimant praeter orbos et caelibes, nec credi potest qua obsequiorum diversitate coluntur homines sine liberis Romae.</p>\r\n<p>Tempore quo primis auspiciis in mundanum fulgorem surgeret victura dum erunt homines Roma, ut augeretur sublimibus incrementis, foedere pacis aeternae Virtus convenit atque Fortuna plerumque dissidentes, quarum si altera defuisset, ad perfectam non venerat summitatem.</p>\r\n<p>Ego vero sic intellego, Patres conscripti, nos hoc tempore in provinciis decernendis perpetuae pacis habere oportere rationem. Nam quis hoc non sentit omnia alia esse nobis vacua ab omni periculo atque etiam suspicione belli?</p>\r\n<p>Utque proeliorum periti rectores primo catervas densas opponunt et fortes, deinde leves armaturas, post iaculatores ultimasque subsidiales acies, si fors adegerit, iuvaturas, ita praepositis urbanae familiae suspensae digerentibus sollicite, quos insignes faciunt virgae dexteris aptatae velut tessera data castrensi iuxta vehiculi frontem omne textrinum incedit: huic atratum coquinae iungitur ministerium, dein totum promiscue servitium cum otiosis plebeiis de vicinitate coniunctis: postrema multitudo spadonum a senibus in pueros desinens, obluridi distortaque lineamentorum conpage deformes, ut quaqua incesserit quisquam cernens mutilorum hominum agmina detestetur memoriam Samiramidis reginae illius veteris, quae teneros mares castravit omnium prima velut vim iniectans naturae, eandemque ab instituto cursu retorquens, quae inter ipsa oriundi crepundia per primigenios seminis fontes tacita quodam modo lege vias propagandae posteritatis ostendit.</p>\r\n<p>Iis igitur est difficilius satis facere, qui se Latina scripta dicunt contemnere. in quibus hoc primum est in quo admirer, cur in gravissimis rebus non delectet eos sermo patrius, cum idem fabellas Latinas ad verbum e Graecis expressas non inviti legant. quis enim tam inimicus paene nomini Romano est, qui Ennii Medeam aut Antiopam Pacuvii spernat aut reiciat, quod se isdem Euripidis fabulis delectari dicat, Latinas litteras oderit?</p>\r\n<p>Nihil morati post haec militares avidi saepe turbarum adorti sunt Montium primum, qui divertebat in proximo, levi corpore senem atque morbosum, et hirsutis resticulis cruribus eius innexis divaricaturn sine spiramento ullo ad usque praetorium traxere praefecti.</p>\r\n<p>Postremo ad id indignitatis est ventum, ut cum peregrini ob formidatam haut ita dudum alimentorum inopiam pellerentur ab urbe praecipites, sectatoribus disciplinarum liberalium inpendio paucis sine respiratione ulla extrusis, tenerentur minimarum adseclae veri, quique id simularunt ad tempus, et tria milia saltatricum ne interpellata quidem cum choris totidemque remanerent magistris.</p>\r\n<p>Quae dum ita struuntur, indicatum est apud Tyrum indumentum regale textum occulte, incertum quo locante vel cuius usibus apparatum. ideoque rector provinciae tunc pater Apollinaris eiusdem nominis ut conscius ductus est aliique congregati sunt ex diversis civitatibus multi, qui atrocium criminum ponderibus urgebantur.</p>\r\n<p>Ut enim quisque sibi plurimum confidit et ut quisque maxime virtute et sapientia sic munitus est, ut nullo egeat suaque omnia in se ipso posita iudicet, ita in amicitiis expetendis colendisque maxime excellit. Quid enim? Africanus indigens mei? Minime hercule! ac ne ego quidem illius; sed ego admiratione quadam virtutis eius, ille vicissim opinione fortasse non nulla, quam de meis moribus habebat, me dilexit; auxit benevolentiam consuetudo. Sed quamquam utilitates multae et magnae consecutae sunt, non sunt tamen ab earum spe causae diligendi profectae.</p>\r\n<p>Sed (saepe enim redeo ad Scipionem, cuius omnis sermo erat de amicitia) querebatur, quod omnibus in rebus homines diligentiores essent; capras et oves quot quisque haberet, dicere posse, amicos quot haberet, non posse dicere et in illis quidem parandis adhibere curam, in amicis eligendis neglegentis esse nec habere quasi signa quaedam et notas, quibus eos qui ad amicitias essent idonei, iudicarent. Sunt igitur firmi et stabiles et constantes eligendi; cuius generis est magna penuria. Et iudicare difficile est sane nisi expertum; experiendum autem est in ipsa amicitia. Ita praecurrit amicitia iudicium tollitque experiendi potestatem.</p>\r\n<p>Nunc vero inanes flatus quorundam vile esse quicquid extra urbis pomerium nascitur aestimant praeter orbos et caelibes, nec credi potest qua obsequiorum diversitate coluntur homines sine liberis Romae.</p>\r\n<p>Tempore quo primis auspiciis in mundanum fulgorem surgeret victura dum erunt homines Roma, ut augeretur sublimibus incrementis, foedere pacis aeternae Virtus convenit atque Fortuna plerumque dissidentes, quarum si altera defuisset, ad perfectam non venerat summitatem.</p>\r\n<p>Ego vero sic intellego, Patres conscripti, nos hoc tempore in provinciis decernendis perpetuae pacis habere oportere rationem. Nam quis hoc non sentit omnia alia esse nobis vacua ab omni periculo atque etiam suspicione belli?</p>\r\n<p>Utque proeliorum periti rectores primo catervas densas opponunt et fortes, deinde leves armaturas, post iaculatores ultimasque subsidiales acies, si fors adegerit, iuvaturas, ita praepositis urbanae familiae suspensae digerentibus sollicite, quos insignes faciunt virgae dexteris aptatae velut tessera data castrensi iuxta vehiculi frontem omne textrinum incedit: huic atratum coquinae iungitur ministerium, dein totum promiscue servitium cum otiosis plebeiis de vicinitate coniunctis: postrema multitudo spadonum a senibus in pueros desinens, obluridi distortaque lineamentorum conpage deformes, ut quaqua incesserit quisquam cernens mutilorum hominum agmina detestetur memoriam Samiramidis reginae illius veteris, quae teneros mares castravit omnium prima velut vim iniectans naturae, eandemque ab instituto cursu retorquens, quae inter ipsa oriundi crepundia per primigenios seminis fontes tacita quodam modo lege vias propagandae posteritatis ostendit.</p>\r\n<p>Iis igitur est difficilius satis facere, qui se Latina scripta dicunt contemnere. in quibus hoc primum est in quo admirer, cur in gravissimis rebus non delectet eos sermo patrius, cum idem fabellas Latinas ad verbum e Graecis expressas non inviti legant. quis enim tam inimicus paene nomini Romano est, qui Ennii Medeam aut Antiopam Pacuvii spernat aut reiciat, quod se isdem Euripidis fabulis delectari dicat, Latinas litteras oderit?</p>\r\n<p>Nihil morati post haec militares avidi saepe turbarum adorti sunt Montium primum, qui divertebat in proximo, levi corpore senem atque morbosum, et hirsutis resticulis cruribus eius innexis divaricaturn sine spiramento ullo ad usque praetorium traxere praefecti.</p>\r\n<p>Postremo ad id indignitatis est ventum, ut cum peregrini ob formidatam haut ita dudum alimentorum inopiam pellerentur ab urbe praecipites, sectatoribus disciplinarum liberalium inpendio paucis sine respiratione ulla extrusis, tenerentur minimarum adseclae veri, quique id simularunt ad tempus, et tria milia saltatricum ne interpellata quidem cum choris totidemque remanerent magistris.</p>\r\n<p>Quae dum ita struuntur, indicatum est apud Tyrum indumentum regale textum occulte, incertum quo locante vel cuius usibus apparatum. ideoque rector provinciae tunc pater Apollinaris eiusdem nominis ut conscius ductus est aliique congregati sunt ex diversis civitatibus multi, qui atrocium criminum ponderibus urgebantur.</p>\r\n<p>Ut enim quisque sibi plurimum confidit et ut quisque maxime virtute et sapientia sic munitus est, ut nullo egeat suaque omnia in se ipso posita iudicet, ita in amicitiis expetendis colendisque maxime excellit. Quid enim? Africanus indigens mei? Minime hercule! ac ne ego quidem illius; sed ego admiratione quadam virtutis eius, ille vicissim opinione fortasse non nulla, quam de meis moribus habebat, me dilexit; auxit benevolentiam consuetudo. Sed quamquam utilitates multae et magnae consecutae sunt, non sunt tamen ab earum spe causae diligendi profectae.</p>\r\n<p>Sed (saepe enim redeo ad Scipionem, cuius omnis sermo erat de amicitia) querebatur, quod omnibus in rebus homines diligentiores essent; capras et oves quot quisque haberet, dicere posse, amicos quot haberet, non posse dicere et in illis quidem parandis adhibere curam, in amicis eligendis neglegentis esse nec habere quasi signa quaedam et notas, quibus eos qui ad amicitias essent idonei, iudicarent. Sunt igitur firmi et stabiles et constantes eligendi; cuius generis est magna penuria. Et iudicare difficile est sane nisi expertum; experiendum autem est in ipsa amicitia. Ita praecurrit amicitia iudicium tollitque experiendi potestatem.</p>\r\n<p>Nunc vero inanes flatus quorundam vile esse quicquid extra urbis pomerium nascitur aestimant praeter orbos et caelibes, nec credi potest qua obsequiorum diversitate coluntur homines sine liberis Romae.</p>\r\n<p>Tempore quo primis auspiciis in mundanum fulgorem surgeret victura dum erunt homines Roma, ut augeretur sublimibus incrementis, foedere pacis aeternae Virtus convenit atque Fortuna plerumque dissidentes, quarum si altera defuisset, ad perfectam non venerat summitatem.</p>\r\n<p>Ego vero sic intellego, Patres conscripti, nos hoc tempore in provinciis decernendis perpetuae pacis habere oportere rationem. Nam quis hoc non sentit omnia alia esse nobis vacua ab omni periculo atque etiam suspicione belli?</p>\r\n<p>Utque proeliorum periti rectores primo catervas densas opponunt et fortes, deinde leves armaturas, post iaculatores ultimasque subsidiales acies, si fors adegerit, iuvaturas, ita praepositis urbanae familiae suspensae digerentibus sollicite, quos insignes faciunt virgae dexteris aptatae velut tessera data castrensi iuxta vehiculi frontem omne textrinum incedit: huic atratum coquinae iungitur ministerium, dein totum promiscue servitium cum otiosis plebeiis de vicinitate coniunctis: postrema multitudo spadonum a senibus in pueros desinens, obluridi distortaque lineamentorum conpage deformes, ut quaqua incesserit quisquam cernens mutilorum hominum agmina detestetur memoriam Samiramidis reginae illius veteris, quae teneros mares castravit omnium prima velut vim iniectans naturae, eandemque ab instituto cursu retorquens, quae inter ipsa oriundi crepundia per primigenios seminis fontes tacita quodam modo lege vias propagandae posteritatis ostendit.</p>\r\n<p>Iis igitur est difficilius satis facere, qui se Latina scripta dicunt contemnere. in quibus hoc primum est in quo admirer, cur in gravissimis rebus non delectet eos sermo patrius, cum idem fabellas Latinas ad verbum e Graecis expressas non inviti legant. quis enim tam inimicus paene nomini Romano est, qui Ennii Medeam aut Antiopam Pacuvii spernat aut reiciat, quod se isdem Euripidis fabulis delectari dicat, Latinas litteras oderit?</p>\r\n<p>Nihil morati post haec militares avidi saepe turbarum adorti sunt Montium primum, qui divertebat in proximo, levi corpore senem atque morbosum, et hirsutis resticulis cruribus eius innexis divaricaturn sine spiramento ullo ad usque praetorium traxere praefecti.</p>\r\n<p>Postremo ad id indignitatis est ventum, ut cum peregrini ob formidatam haut ita dudum alimentorum inopiam pellerentur ab urbe praecipites, sectatoribus disciplinarum liberalium inpendio paucis sine respiratione ulla extrusis, tenerentur minimarum adseclae veri, quique id simularunt ad tempus, et tria milia saltatricum ne interpellata quidem cum choris totidemque remanerent magistris.</p>\r\n<p>&nbsp;</p>', 'Quae dum ita struuntur, indicatum est apud Tyrum indumentum regale textum occulte, incertum quo locante vel cuius usibus apparatum. ideoque rector provinciae tunc pater Apollinaris eiusdem nominis ut conscius ductus est aliique congregati sunt ex diversis civitatibus multi, qui atrocium criminum pon[...]', 13, '2017-10-03 01:14:44', '2017-10-03 10:45:08', 98, 'Publication'),
(26, 'Rencontre inattendue', '<p>Eodem tempore Serenianus ex duce, cuius ignavia populatam in Phoenice Celsen ante rettulimus, pulsatae maiestatis imperii reus iure postulatus ac lege, incertum qua potuit suffragatione absolvi, aperte convictus familiarem suum cum pileo, quo caput operiebat, incantato vetitis artibus ad templum misisse fatidicum, quaeritatum expresse an ei firmum portenderetur imperium, ut cupiebat, et cunctum.</p>\r\n<p>Alios autem dicere aiunt multo etiam inhumanius (quem locum breviter paulo ante perstrinxi) praesidii adiumentique causa, non benevolentiae neque caritatis, amicitias esse expetendas; itaque, ut quisque minimum firmitatis haberet minimumque virium, ita amicitias appetere maxime; ex eo fieri ut mulierculae magis amicitiarum praesidia quaerant quam viri et inopes quam opulenti et calamitosi quam ii qui putentur beati.</p>\r\n<p>Ex turba vero imae sortis et paupertinae in tabernis aliqui pernoctant vinariis, non nulli velariis umbraculorum theatralium latent, quae Campanam imitatus lasciviam Catulus in aedilitate sua suspendit omnium primus; aut pugnaciter aleis certant turpi sono fragosis naribus introrsum reducto spiritu concrepantes; aut quod est studiorum omnium maximum ab ortu lucis ad vesperam sole fatiscunt vel pluviis, per minutias aurigarum equorumque praecipua vel delicta scrutantes.</p>\r\n<p>Cumque pertinacius ut legum gnarus accusatorem flagitaret atque sollemnia, doctus id Caesar libertatemque superbiam ratus tamquam obtrectatorem audacem excarnificari praecepit, qui ita evisceratus ut cruciatibus membra deessent, inplorans caelo iustitiam, torvum renidens fundato pectore mansit inmobilis nec se incusare nec quemquam alium passus et tandem nec confessus nec confutatus cum abiecto consorte poenali est morte multatus. et ducebatur intrepidus temporum iniquitati insultans, imitatus Zenonem illum veterem Stoicum qui ut mentiretur quaedam laceratus diutius, avulsam sedibus linguam suam cum cruento sputamine in oculos interrogantis Cyprii regis inpegit.</p>\r\n<p>Iis igitur est difficilius satis facere, qui se Latina scripta dicunt contemnere. in quibus hoc primum est in quo admirer, cur in gravissimis rebus non delectet eos sermo patrius, cum idem fabellas Latinas ad verbum e Graecis expressas non inviti legant. quis enim tam inimicus paene nomini Romano est, qui Ennii Medeam aut Antiopam Pacuvii spernat aut reiciat, quod se isdem Euripidis fabulis delectari dicat, Latinas litteras oderit?</p>\r\n<p>Quam ob rem ut ii qui superiores sunt submittere se debent in amicitia, sic quodam modo inferiores extollere. Sunt enim quidam qui molestas amicitias faciunt, cum ipsi se contemni putant; quod non fere contingit nisi iis qui etiam contemnendos se arbitrantur; qui hac opinione non modo verbis sed etiam opere levandi sunt.</p>\r\n<p>Quare hoc quidem praeceptum, cuiuscumque est, ad tollendam amicitiam valet; illud potius praecipiendum fuit, ut eam diligentiam adhiberemus in amicitiis comparandis, ut ne quando amare inciperemus eum, quem aliquando odisse possemus. Quin etiam si minus felices in diligendo fuissemus, ferendum id Scipio potius quam inimicitiarum tempus cogitandum putabat.</p>\r\n<p>Unde Rufinus ea tempestate praefectus praetorio ad discrimen trusus est ultimum. ire enim ipse compellebatur ad militem, quem exagitabat inopia simul et feritas, et alioqui coalito more in ordinarias dignitates asperum semper et saevum, ut satisfaceret atque monstraret, quam ob causam annonae convectio sit impedita.</p>\r\n<p>Harum trium sententiarum nulli prorsus assentior. Nec enim illa prima vera est, ut, quem ad modum in se quisque sit, sic in amicum sit animatus. Quam multa enim, quae nostra causa numquam faceremus, facimus causa amicorum! precari ab indigno, supplicare, tum acerbius in aliquem invehi insectarique vehementius, quae in nostris rebus non satis honeste, in amicorum fiunt honestissime; multaeque res sunt in quibus de suis commodis viri boni multa detrahunt detrahique patiuntur, ut iis amici potius quam ipsi fruantur.</p>\r\n<p>Itaque tum Scaevola cum in eam ipsam mentionem incidisset, exposuit nobis sermonem Laeli de amicitia habitum ab illo secum et cum altero genero, C. Fannio Marci filio, paucis diebus post mortem Africani. Eius disputationis sententias memoriae mandavi, quas hoc libro exposui arbitratu meo; quasi enim ipsos induxi loquentes, ne \'inquam\' et \'inquit\' saepius interponeretur, atque ut tamquam a praesentibus coram haberi sermo videretur.</p>\r\n<p>Altera sententia est, quae definit amicitiam paribus officiis ac voluntatibus. Hoc quidem est nimis exigue et exiliter ad calculos vocare amicitiam, ut par sit ratio acceptorum et datorum. Divitior mihi et affluentior videtur esse vera amicitia nec observare restricte, ne plus reddat quam acceperit; neque enim verendum est, ne quid excidat, aut ne quid in terram defluat, aut ne plus aequo quid in amicitiam congeratur.</p>\r\n<p>Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res utilitatis esset habitura. Quod quidem quale sit, etiam in bestiis quibusdam animadverti potest, quae ex se natos ita amant ad quoddam tempus et ab eis ita amantur ut facile earum sensus appareat. Quod in homine multo est evidentius, primum ex ea caritate quae est inter natos et parentes, quae dirimi nisi detestabili scelere non potest; deinde cum similis sensus exstitit amoris, si aliquem nacti sumus cuius cum moribus et natura congruamus, quod in eo quasi lumen aliquod probitatis et virtutis perspicere videamur.</p>\r\n<p>Quam ob rem ut ii qui superiores sunt submittere se debent in amicitia, sic quodam modo inferiores extollere. Sunt enim quidam qui molestas amicitias faciunt, cum ipsi se contemni putant; quod non fere contingit nisi iis qui etiam contemnendos se arbitrantur; qui hac opinione non modo verbis sed etiam opere levandi sunt.</p>\r\n<p>Post haec Gallus Hierapolim profecturus ut expeditioni specie tenus adesset, Antiochensi plebi suppliciter obsecranti ut inediae dispelleret metum, quae per multas difficilisque causas adfore iam sperabatur, non ut mos est principibus, quorum diffusa potestas localibus subinde medetur aerumnis, disponi quicquam statuit vel ex provinciis alimenta transferri conterminis, sed consularem Syriae Theophilum prope adstantem ultima metuenti multitudini dedit id adsidue replicando quod invito rectore nullus egere poterit victu.</p>\r\n<p>Sed (saepe enim redeo ad Scipionem, cuius omnis sermo erat de amicitia) querebatur, quod omnibus in rebus homines diligentiores essent; capras et oves quot quisque haberet, dicere posse, amicos quot haberet, non posse dicere et in illis quidem parandis adhibere curam, in amicis eligendis neglegentis esse nec habere quasi signa quaedam et notas, quibus eos qui ad amicitias essent idonei, iudicarent. Sunt igitur firmi et stabiles et constantes eligendi; cuius generis est magna penuria. Et iudicare difficile est sane nisi expertum; experiendum autem est in ipsa amicitia. Ita praecurrit amicitia iudicium tollitque experiendi potestatem.</p>\r\n<p>Et prima post Osdroenam quam, ut dictum est, ab hac descriptione discrevimus, Commagena, nunc Euphratensis, clementer adsurgit, Hierapoli, vetere Nino et Samosata civitatibus amplis inlustris.</p>\r\n<p>Quod si rectum statuerimus vel concedere amicis, quidquid velint, vel impetrare ab iis, quidquid velimus, perfecta quidem sapientia si simus, nihil habeat res vitii; sed loquimur de iis amicis qui ante oculos sunt, quos vidimus aut de quibus memoriam accepimus, quos novit vita communis. Ex hoc numero nobis exempla sumenda sunt, et eorum quidem maxime qui ad sapientiam proxime accedunt.</p>\r\n<p>Et quia Montius inter dilancinantium manus spiritum efflaturus Epigonum et Eusebium nec professionem nec dignitatem ostendens aliquotiens increpabat, qui sint hi magna quaerebatur industria, et nequid intepesceret, Epigonus e Lycia philosophus ducitur et Eusebius ab Emissa Pittacas cognomento, concitatus orator, cum quaestor non hos sed tribunos fabricarum insimulasset promittentes armorum si novas res agitari conperissent.</p>\r\n<p>Unde Rufinus ea tempestate praefectus praetorio ad discrimen trusus est ultimum. ire enim ipse compellebatur ad militem, quem exagitabat inopia simul et feritas, et alioqui coalito more in ordinarias dignitates asperum semper et saevum, ut satisfaceret atque monstraret, quam ob causam annonae convectio sit impedita.</p>\r\n<p>Metuentes igitur idem latrones Lycaoniam magna parte campestrem cum se inpares nostris fore congressione stataria documentis frequentibus scirent, tramitibus deviis petivere Pamphyliam diu quidem intactam sed timore populationum et caedium, milite per omnia diffuso propinqua, magnis undique praesidiis conmunitam.</p>\r\n<p>&nbsp;</p>', 'Eodem tempore Serenianus ex duce, cuius ignavia populatam in Phoenice Celsen ante rettulimus, pulsatae maiestatis imperii reus iure postulatus ac lege, incertum qua potuit suffragatione absolvi, aperte convictus familiarem suum cum pileo, quo caput operiebat, incantato vetitis artibus ad templum mis[...]', 13, '2017-10-03 10:27:46', '2017-10-03 10:44:08', 99, 'Publication');

-- --------------------------------------------------------

--
-- Structure de la table `ocp3_Billets_dossiers`
--

CREATE TABLE `ocp3_Billets_dossiers` (
  `id` int(11) NOT NULL,
  `dossier` varchar(100) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ocp3_Commentaires`
--

CREATE TABLE `ocp3_Commentaires` (
  `id` int(11) NOT NULL,
  `billet_id` int(11) NOT NULL,
  `com_id` int(11) NOT NULL,
  `com_level` int(11) NOT NULL DEFAULT '0',
  `auteur_id` int(11) NOT NULL DEFAULT '0',
  `contenu` text NOT NULL,
  `date_publie` datetime NOT NULL,
  `approuve` tinyint(1) NOT NULL DEFAULT '0',
  `signalement` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ocp3_Images`
--

CREATE TABLE `ocp3_Images` (
  `id` int(11) NOT NULL,
  `source` varchar(255) DEFAULT NULL,
  `billet` varchar(255) DEFAULT NULL,
  `vignette` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `ocp3_Images`
--

INSERT INTO `ocp3_Images` (`id`, `source`, `billet`, `vignette`, `avatar`, `description`) VALUES
(1, 'http://ocp3.nicoloff.fr/upload/avatars/default.png', '', '', 'http://ocp3.nicoloff.fr/upload/avatars/default.png', 'Avatar par défaut'),
(41, '', NULL, NULL, 'http://ocp3.nicoloff.fr/upload/avatars/c51ce410c124a10e0db5e4b97fc2af39.jpg', 'Avatar de Jean-F'),
(74, '', NULL, NULL, 'http://ocp3.nicoloff.fr/upload/avatars/1f0e3dad99908345f7439f8ffabdffc4.png', 'Avatar de test'),
(78, '', NULL, NULL, 'http://ocp3.nicoloff.fr/upload/avatars/c74d97b01eae257e44aa9d5bade97baf.jpg', 'Avatar de JoKolov'),
(95, '', 'http://ocp3.nicoloff.fr/upload/billets/37693cfc748049e45d87b8c7d8b9aacd.jpg', 'http://ocp3.nicoloff.fr/upload/vignettes/37693cfc748049e45d87b8c7d8b9aacd.jpg', NULL, NULL),
(96, '', 'http://ocp3.nicoloff.fr/upload/billets/1ff1de774005f8da13f42943881c655f.jpg', 'http://ocp3.nicoloff.fr/upload/vignettes/1ff1de774005f8da13f42943881c655f.jpg', NULL, NULL),
(98, '', 'http://ocp3.nicoloff.fr/upload/billets/8e296a067a37563370ded05f5a3bf3ec.jpeg', 'http://ocp3.nicoloff.fr/upload/vignettes/8e296a067a37563370ded05f5a3bf3ec.jpeg', NULL, NULL),
(99, '', 'http://ocp3.nicoloff.fr/upload/billets/4e732ced3463d06de0ca9a15b6153677.jpeg', 'http://ocp3.nicoloff.fr/upload/vignettes/4e732ced3463d06de0ca9a15b6153677.jpeg', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `ocp3_Membres`
--

CREATE TABLE `ocp3_Membres` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_create` datetime NOT NULL,
  `date_birth` date DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `avatar_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `ocp3_Membres`
--

INSERT INTO `ocp3_Membres` (`id`, `pseudo`, `nom`, `prenom`, `email`, `password`, `date_create`, `date_birth`, `type_id`, `avatar_id`) VALUES
(13, 'Jean-F', 'Forteroche', 'Jean', 'jean@forteroche.fr', 'fa7253e5e926652bf8858cd62154b9b6c3d91fd3c7b7e569042f970ddcb9dc7d', '2017-08-07 22:24:23', '1932-04-03', 1, 41),
(15, 'thibaud', '', '', 'thibaud@dauce.fr', 'f38094614e9105f4ffcf01cd62f290440c525498dabc994349a94337b7a7eb33', '2017-08-25 11:05:58', NULL, 2, 1),
(16, 'JoKolov', 'Joffrey', 'Nicoloff', 'joffreynicoloff@gmail.com', '57438e44802e01433a402930a78345cd63facaf6bfaf0693431b4f1c0d9456ea', '2017-08-29 12:45:27', '1986-06-24', 2, 78),
(21, 'testeur', '', '', 'testeur@test.com', '0c1a6ce0f3b51b3da4deed42255531c46046101f21fe53e9794183c77f0a6b0e', '2017-09-22 15:01:48', NULL, 2, 1),
(22, 'Jojo', '', '', 'jojo@email.com', '0c1a6ce0f3b51b3da4deed42255531c46046101f21fe53e9794183c77f0a6b0e', '2017-09-25 14:23:34', NULL, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `ocp3_Membres_reseaux`
--

CREATE TABLE `ocp3_Membres_reseaux` (
  `id` int(11) NOT NULL,
  `membre_id` int(11) NOT NULL,
  `reseaux_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ocp3_Membres_types`
--

CREATE TABLE `ocp3_Membres_types` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `ocp3_Membres_types`
--

INSERT INTO `ocp3_Membres_types` (`id`, `type`, `description`) VALUES
(1, 'Administrateur', 'Accès complet à toutes les fonctionnalités du site web'),
(2, 'Abonné', 'Gestion de ses propres commentaires');

-- --------------------------------------------------------

--
-- Structure de la table `ocp3_Reseaux_sociaux`
--

CREATE TABLE `ocp3_Reseaux_sociaux` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `icone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `ocp3_Billets`
--
ALTER TABLE `ocp3_Billets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ocp3_Billets_dossiers`
--
ALTER TABLE `ocp3_Billets_dossiers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ocp3_Commentaires`
--
ALTER TABLE `ocp3_Commentaires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ocp3_Images`
--
ALTER TABLE `ocp3_Images`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ocp3_Membres`
--
ALTER TABLE `ocp3_Membres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ind_unq_user` (`email`,`password`),
  ADD UNIQUE KEY `pseudo` (`pseudo`);

--
-- Index pour la table `ocp3_Membres_reseaux`
--
ALTER TABLE `ocp3_Membres_reseaux`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ocp3_Membres_types`
--
ALTER TABLE `ocp3_Membres_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ocp3_Reseaux_sociaux`
--
ALTER TABLE `ocp3_Reseaux_sociaux`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `ocp3_Billets`
--
ALTER TABLE `ocp3_Billets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT pour la table `ocp3_Billets_dossiers`
--
ALTER TABLE `ocp3_Billets_dossiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ocp3_Commentaires`
--
ALTER TABLE `ocp3_Commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT pour la table `ocp3_Images`
--
ALTER TABLE `ocp3_Images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT pour la table `ocp3_Membres`
--
ALTER TABLE `ocp3_Membres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT pour la table `ocp3_Membres_reseaux`
--
ALTER TABLE `ocp3_Membres_reseaux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ocp3_Membres_types`
--
ALTER TABLE `ocp3_Membres_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `ocp3_Reseaux_sociaux`
--
ALTER TABLE `ocp3_Reseaux_sociaux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
