<?xml version="1.0" encoding="UTF-8"?>

<!--
    Document   : champions.xsl
    Created on : March 30, 2014, 4:49 PM
    Author     : Taylor
    Description:
        Produces a League of Legends Champions report based on styles below.
-->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:template match="/">
        <!-- 
        First gets the year at the root element
        -->
        <h2>Champions by pick rate and ban rate for the year <xsl:value-of select="league/@year"/></h2>
        <table class="table_trends">
            <!-- 
            Goes through each source getting the lane type
            -->
            <xsl:for-each select="league/sources/source">
                <tr>
                    <td style="text-transform:capitalize;">
                        <h3>
                            <xsl:value-of select="@metalane"/> Lane</h3>
                    </td>    
                </tr>
                <tr>
                    <td>
                        <span class="table_content">
                            <b>
                                <u>Name:</u>
                            </b>
                        </span>
                    </td>
                    <td class="table_td_pickrate">
                        <span class="table_content">
                            <b>
                                <u>Pick rate:</u>
                            </b>
                        </span>
                    </td>
                    <td>
                        <span class="table_content">
                            <b>
                                <u>Ban rate:</u>
                            </b>
                        </span>
                    </td>
                </tr>
                <!-- 
                Goes through each champion of each source, getting its name, popularity/pickrate, and banrate.
                -->
                <xsl:for-each select="champion">
                    <tr>
                        <td>
                            <span class="table_content">
                                <xsl:value-of select="@name"/>
                            </span>
                        </td>
                        <td class="table_td_pickrate">
                            <span class="table_content">
                                <xsl:value-of select="popularity"/>
                            </span>
                        </td>
                        <td>
                            <span class="table_content">
                                <xsl:value-of select="banrate"/>
                            </span>
                        </td>
                    </tr>
                </xsl:for-each>
                <!-- Get most picked and banned champion for this lane -->
                <tr>
                    <td>
                        <span class="table_content">
                            <b>
                                <u>Most picked champion in this lane:</u>
                            </b>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="table_content">
                            <b>
                                <xsl:for-each select="champion">
                                    <xsl:sort select="popularity" data-type="number" order="descending" />
                                    <xsl:if test="position() = 1">
                                        <xsl:value-of select="@name" />
                                    </xsl:if>
                                </xsl:for-each>
                            </b>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="table_content">
                            <b>
                                <u>Most banned champion in this lane:</u>
                            </b>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="table_content">
                            <b>
                                <xsl:for-each select="champion">
                                    <xsl:sort select="banrate" data-type="number" order="descending" />
                                    <xsl:if test="position() = 1">
                                        <xsl:value-of select="@name" />
                                    </xsl:if>
                                </xsl:for-each>
                            </b>
                        </span>
                    </td>
                </tr>   
            </xsl:for-each>
            
            <!-- Get most picked and banned champion overall -->
            <tr>
                <td>
                    <h3>Most picked champion overall:</h3>
                </td>    
            </tr>
            <tr>
                <td>
                    <span class="table_content">
                        <b>
                            <xsl:for-each select="league/sources/source/champion">
                                <xsl:sort select="popularity" data-type="number" order="descending" />
                                <xsl:if test="position() = 1">
                                    <xsl:value-of select="@name" />
                                </xsl:if>
                            </xsl:for-each>
                        </b>
                    </span>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>Most banned champion overall:</h3>
                </td>    
            </tr>
            <tr>
                <td>
                    <span class="table_content">
                        <b>
                            <xsl:for-each select="league/sources/source/champion">
                                <xsl:sort select="banrate" data-type="number" order="descending" />
                                <xsl:if test="position() = 1">
                                    <xsl:value-of select="@name" />
                                </xsl:if>
                            </xsl:for-each>
                        </b>
                    </span>
                </td>
            </tr>
        </table>

    </xsl:template>
</xsl:stylesheet>
