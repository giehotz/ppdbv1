<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Seo extends Controller
{
    public function robots()
    {
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /siswa/\n";
        $content .= "Disallow: /verifikator/\n";
        $content .= "Disallow: /api/\n";
        $content .= "Disallow: /logout\n";
        $content .= "\nSitemap: " . base_url('sitemap.xml') . "\n";

        return $this->response->setHeader('Content-Type', 'text/plain')->setBody($content);
    }

    public function sitemap()
    {
        $urls = [
            ['loc' => base_url(), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => base_url('login'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => base_url('auth/register'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => base_url('pendaftar'), 'priority' => '0.7', 'changefreq' => 'daily'],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . esc($url['loc']) . "</loc>\n";
            $xml .= "    <priority>" . $url['priority'] . "</priority>\n";
            $xml .= "    <changefreq>" . $url['changefreq'] . "</changefreq>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return $this->response->setHeader('Content-Type', 'application/xml')->setBody($xml);
    }
}
