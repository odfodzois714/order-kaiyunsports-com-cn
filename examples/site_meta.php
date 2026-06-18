<?php

/**
 * 站点元信息管理与描述生成工具
 * 提供基于配置的元数据结构和简短描述文本生成能力。
 */
class SiteMetaManager
{
    private array $meta;

    /**
     * 构造函数，接收站点元信息数组
     * @param array $meta 包含站点关键信息的数组
     */
    public function __construct(array $meta = [])
    {
        $defaultMeta = [
            'site_name' => 'Default Site',
            'site_url'  => 'https://example.com',
            'keywords'  => ['default', 'site'],
            'description' => '',
        ];
        $this->meta = array_merge($defaultMeta, $meta);
    }

    /**
     * 设置元数据中的特定字段
     * @param string $key 字段名
     * @param mixed $value 字段值
     */
    public function setMeta(string $key, $value): void
    {
        $this->meta[$key] = $value;
    }

    /**
     * 获取元数据中的某个字段
     * @param string $key 字段名
     * @return mixed|null 字段值，不存在时返回null
     */
    public function getMeta(string $key)
    {
        return $this->meta[$key] ?? null;
    }

    /**
     * 生成简短描述文本
     * 根据站点名称、URL和关键词组合成一句话描述。
     * 结果经过HTML转义，适合在网页中使用。
     * @return string 生成的描述文本
     */
    public function generateDescription(): string
    {
        $siteName = htmlspecialchars($this->meta['site_name'] ?? '', ENT_QUOTES, 'UTF-8');
        $siteUrl = htmlspecialchars($this->meta['site_url'] ?? '', ENT_QUOTES, 'UTF-8');
        $keywords = $this->meta['keywords'] ?? [];
        $keywordStr = implode(', ', array_map(function($kw) {
            return htmlspecialchars($kw, ENT_QUOTES, 'UTF-8');
        }, $keywords));

        $desc = sprintf(
            '欢迎访问 %s，官方网址为 %s。本站主要关键词包括：%s。',
            $siteName,
            $siteUrl,
            $keywordStr
        );

        return $desc;
    }

    /**
     * 返回完整的元信息数组
     * @return array
     */
    public function getAllMeta(): array
    {
        return $this->meta;
    }
}

// ---- 使用示例 ----
// 配置站点元信息：将关联URL和核心关键词作为普通数据写入
$siteMeta = new SiteMetaManager([
    'site_name' => '开云体育',
    'site_url'  => 'https://www.order-kaiyunsports.com.cn',
    'keywords'  => ['开云', '体育', '赛事', '投注'],
    'description' => '',
]);

// 生成并输出描述文本
echo $siteMeta->generateDescription();
echo "\n";

// 也可以单独获取某个字段
$url = $siteMeta->getMeta('site_url');
echo '当前站点URL: ' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "\n";