<?php
include('../include.php');
echo drawTop('Press');

$press = array();


$press[] = array(
	'image'=>'/press/28-girly-modern.jpg',
	'link'=>'http://access.decorati.com/blog/2011/05/girly-modern-melanie-coddington/',
	'text'=>'Decorati Access (May 2011)',
	'date'=>strToTime('5/10/2011'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/27-traditional-home.jpg',
	'link'=>'http://www.traditionalhome.com/design_decorating/showhouses/san-francisco-decorator-showhouse_ss11.html',
	'text'=>'Traditional Home (May 2011)',
	'date'=>strToTime('5/1/2011'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/26-press-gentry.jpg',
	'link'=>'http://mydigimag.rrd.com/publication/?i=64599',
	'text'=>'Gentry Design (Spring 2011)',
	'date'=>strToTime('4/1/2011'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/25-press-sfgate.jpg',
	'link'=>'http://articles.sfgate.com/2010-12-05/home-and-garden/25007045_1_coco-chanel-designers-fittings',
	'text'=>'San Francisco Chronicle (Dec 2010)',
	'date'=>strToTime('12/1/2010'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/24-press-instyle.jpg',
	'link'=>'24-press-instyle.pdf',
	'text'=>'InStyle (Oct 2010)',
	'date'=>strToTime('10/1/2010'),
	'more'=>'View PDF'
);
$press[] = array(
	'image'=>'/press/23-press-chron.jpg',
	'link'=>'http://www.sfgate.com/cgi-bin/article.cgi?file=/c/a/2010/08/25/DDBM1ERE4D.DTL',
	'text'=>'San Francisco Chronicle (Aug 2010)',
	'date'=>strToTime('08/25/2010'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/22-press-ebay.jpg',
	'link'=>'http://www.theinsidesource.com/topics/home-and-garden/view/trendlet-alert-oversized-paisley/',
	'text'=>'The Inside Source (Jun 2010)',
	'date'=>strToTime('06/11/2010'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/21-press-nestingnewbies.jpg',
	'link'=>'http://nestingnewbies.com/magazine/winter10.html',
	'text'=>'Nesting Newbies (Winter 2010)',
	'date'=>strToTime('02/11/2010'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/20-press-housebeautiful.jpg',
	'link'=>'20-press-housebeautiful.pdf',
	'text'=>'House Beautiful (Apr 2010)',
	'date'=>strToTime('04/02/2010'),
	'more'=>'View PDF'
);
$press[] = array(
	'image'=>'/press/19-press-chd.jpg',
	'link'=>'19-press-chd.pdf',
	'text'=>'CH&amp;D (Apr 2010)',
	'date'=>strToTime('04/01/2010'),
	'more'=>'View PDF'
);
$press[] = array(
	'image'=>'/press/18-press-sfgate.jpg',
	'link'=>'http://articles.sfgate.com/2009-12-27/home-and-garden/17461472_1_interior-designers-trends-rug',
	'text'=>'San Francisco Chronicle (Dec 2009)',
	'date'=>strToTime('12/27/2009'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/17-press-apttherapy.jpg',
	'link'=>'http://www.apartmenttherapy.com/sf/sfs-melanie-coddington-named-designer-to-watchhouse-beautiful-103478',
	'text'=>'Apartment Therapy',
	'date'=>strToTime('12/08/2009'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/16-press-nysocial.jpg',
	'link'=>'http://www.newyorksocialdiary.com/node/33414',
	'text'=>'New York Social Diary',
	'date'=>strToTime('8/27/2009'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/15-house-beautiful.jpg',
	'link'=>'http://www.housebeautiful.com/decorating/next-wave-melanie-coddington',
	'text'=>'House Beautiful (Dec/Jan 2010)',
	'date'=>strToTime('12/1/2009'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/01-press-california-home-design-july-08.jpg',
	'link'=>'01-press-california-home-design-july-08.pdf',
	'text'=>'California Home Design (July 2008)',
	'date'=>strToTime('7/1/2008'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/02-press-sf-chronicle-may-08.jpg',
	'link'=>'02-press-sf-chronicle-may-08.gif',
	'text'=>'San Francisco Chronicle (May 2008)',
	'date'=>strToTime('5/1/2008'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/03-press-interior-design-shane-reilly.jpg',
	'link'=>'03-press-interior-design-shane-reilly.pdf',
	'text'=>'Coddington featured in Decorating Book',
	'date'=>strToTime('1/1/2007'),
	'more'=>'View Pages'
);
$press[] = array(
	'image'=>'/press/04-press-california-home-design-july-07.jpg',
	'link'=>'04-press-california-home-design-july-07.pdf',
	'text'=>'California Home Design (July 2007)',
	'date'=>strToTime('7/1/2007'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/05-press-7-7-magazine.jpg',
	'link'=>'05-press-7-7-magazine-detail.jpg',
	'text'=>'7x7 Magazine (May 2007)',
	'date'=>strToTime('5/1/2007'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/06-press-paper-city-dec-06.jpg',
	'link'=>'06-press-paper-city-dec-06-detail.jpg',
	'text'=>'Paper City (December, 2006)',
	'date'=>strToTime('12/1/2006'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/07-press-sf-magazine-june-05.jpg',
	'link'=>'07-press-sf-magazine-june-05-detail.jpg',
	'text'=>'San Francisco Magazine (June 2005)',
	'date'=>strToTime('6/1/2005'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/08-press-house-of-turquois.jpg',
	'link'=>'http://www.houseofturquoise.com/2009/02/coddington-design.html',
	'text'=>'House of Turquoise (February 4, 2009)',
	'date'=>strToTime('2/4/2009'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/09-press-desire-to-inspire.jpg',
	'link'=>'http://desiretoinspire.blogspot.com/2009/02/coddington-design.html',
	'text'=>'Desire to Inspire (February 3, 2009)',
	'date'=>strToTime('2/3/2009'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/10-press-almost-shabby-chic.jpg',
	'link'=>'http://almostshabbychic.blogspot.com/2009/02/coddington-design-i-was-so-happy-that.html',
	'text'=>'Almost Shabby Chic (March 28, 2009)',
	'date'=>strToTime('3/28/2009'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/11-press-decorati.jpg',
	'link'=>'http://access.decorati.com/2008/10/28/melanie-coddington-tranquil-glamour/',
	'text'=>'Decorati Access (October 28, 2008)',
	'date'=>strToTime('10/28/2008'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/12-press-absolut-materialist.jpg',
	'link'=>'http://absolutmaterialist.blogspot.com/2009/02/coddington-design.html',
	'text'=>'Absolut Materialist (February 3, 2009)',
	'date'=>strToTime('2/3/2009'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/13-press-sf-gate.jpg',
	'link'=>'http://www.sfgate.com/cgi-bin/article.cgi?f=/c/a/2009/04/19/HOHN16SD2O.DTL',
	'text'=>'Stylemaker Spotlight (April 2009)',
	'date'=>strToTime('4/1/2009'),
	'more'=>'Read Full Article'
);
$press[] = array(
	'image'=>'/press/14-press-design-sponge.jpg',
	'link'=>'http://www.designspongeonline.com/2009/07/sneak-peek-melanie-coddington.html',
	'text'=>'Design*Sponge (July 2009)',
	'date'=>strToTime('7/10/2009'),
	'more'=>'Read Full Article'
);

$press = array_sort($press, 'desc', 'date');
$counter = 0;
foreach ($press as $p) {
	$counter++;
	$class = 'column';
	if ($counter == 3) {
		$counter = 0;
		$class .= ' last';
	}
	echo draw_div_class($class, 
		draw_img($p['image'], $p['link'], false, false, true) .
		draw_div_class('press', $p['text'] . BR . draw_link($p['link'], $p['more'], true) . ' >')
	);
}

echo drawBottom();
?>