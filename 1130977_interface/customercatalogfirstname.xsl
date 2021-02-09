<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:output method="xml" omit-xml-declaration="yes" />

<xsl:template match="/">
  <html>
  <body>
  <h2>Customers</h2>
  <table border="1">
  <tbody>
    <tr bgcolor="#9acd32">
      <th>Company</th>
      <th>Lastname</th>
      <th>Firstname</th>
    </tr>
    <xsl:for-each select="catalog/customer">
    <tr>
      <td><xsl:value-of select="company"/></td>
      <td><xsl:value-of select="lastname"/></td>
	  <td><xsl:value-of select="firstname"/></td>
    </tr>
    </xsl:for-each>
    </tbody>
  </table>
  </body>
  </html>
</xsl:template>

</xsl:stylesheet> 
