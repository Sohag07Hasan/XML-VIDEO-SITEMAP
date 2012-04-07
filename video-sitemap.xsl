<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0" 
    xmlns:html="http://www.w3.org/TR/REC-html40"
    xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
  <xsl:template match="/">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <title>XML Video Sitemap</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
body {
	font-family:Georgia, "Times New Roman", Times, serif;
	font-size:11px;
	background: url(http://img.labnol.org/files/qcpgwkr.png) repeat;
	margin: 10px;
}
a {
	border:none;
}
a:link {
	color:#fff;
	text-decoration:none;
}
.labnol {
	position: relative;
	float:left;
	border: 2px solid #000;
	margin: 5px;
}
p {
	position: absolute;
	top: 215px;
	width: 90%;
	color: #ddd;
	padding: 10px;
	background: #222;
	font-style: italic;
	line-height: 18px;
	opacity:0.9;
	filter:alpha(opacity=90);
}
p strong {
	font-size: 16px;
	color: #FFF;
	line-height: 30px;
	font-style: normal;
}
</style>
    </head>
    <body>
    <xsl:for-each select="sitemap:urlset/sitemap:url">
      <xsl:variable name="u"> <xsl:value-of select="sitemap:loc"/> </xsl:variable>
      <xsl:variable name="t"> <xsl:value-of select="video:video/video:thumbnail_loc"/> </xsl:variable>
      <a href="{$u}" target="_blank">
      <div class="labnol"><img src="{$t}" width="480" height="360" />
        <p><strong><xsl:value-of select="video:video/video:title"/></strong><br />
          <xsl:variable name="d"><xsl:value-of select="video:video/video:description"/> </xsl:variable>
          <xsl:choose>
            <xsl:when test="string-length($d) &lt; 100">
              <xsl:value-of select="$d"/>
            </xsl:when>
            <xsl:otherwise>
              <xsl:value-of select="concat(substring($d,1,100),' ...')"/>
            </xsl:otherwise>
          </xsl:choose>
        </p>
      </div>
      </a>
    </xsl:for-each>
    </body>
    </html>
  </xsl:template>
</xsl:stylesheet>