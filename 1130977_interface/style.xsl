<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">

<xsl:template match="/">
  <html>
	<body>
	<table bgcolor="red">
	<tr bgcolor="yellow">
	<td><font color="blue"><strong>Name</strong></font></td>
	<td><font color="blue"><strong>Position</strong></font></td>
	</tr>
	<xsl:apply-templates/>
	</table>
  	</body>
  </html>
</xsl:template>

<xsl:template match="worker">
  <tr>
    <xsl:apply-templates/>
  </tr>
</xsl:template>

<xsl:template match="name">
  <td>
    <xsl:apply-templates/>
  </td>
</xsl:template>

<xsl:template match="position">
  <td>
    <xsl:apply-templates/>
  </td>
</xsl:template>

</xsl:stylesheet>
