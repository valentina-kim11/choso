<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TranslateToVietnamese extends Command
{
    protected $signature = 'translate:vi';
    protected $description = 'Tự động dịch các chuỗi tiếng Anh sang tiếng Việt và lưu vào database';

    public function handle()
    {
        $this->info('🔥 Đã chạy đúng bản mới TranslateToVietnamese');
        $this->info('🔄 Bắt đầu dịch chuỗi sang tiếng Việt...');

        // Dịch bảng home_contents
        $homeContents = DB::table('home_contents')->get();
        foreach ($homeContents as $item) {
            $viHeading = $this->translate($item->heading);
            $viSub = $this->translate($item->sub_heading);
            DB::table('home_contents')->where('id', $item->id)->update([
                'heading_vi' => $viHeading,
                'sub_heading_vi' => $viSub,
            ]);
        }

        // Dịch bảng pages
        $pages = DB::table('pages')->get();
        foreach ($pages as $item) {
            DB::table('pages')->where('id', $item->id)->update([
                'heading_vi' => $this->translate($item->heading),
                'sub_heading_vi' => $this->translate($item->sub_heading),
                'description_vi' => $this->translate(strip_tags($item->description)),
            ]);
        }

        // Dịch bảng settings (1 số trường cơ bản)
        $settings = DB::table('settings')->get();
        foreach ($settings as $item) {
            if (in_array($item->key, ['site_title', 'site_meta_desc', 'footer_text', 'newsletter_text'])) {
                DB::table('settings')->where('id', $item->id)->update([
                    'short_value_vi' => $this->translate($item->short_value),
                    'long_value_vi' => $this->translate($item->long_value),
                ]);
            }
        }

        $this->info('✅ Đã dịch xong toàn bộ nội dung sang tiếng Việt!');
    }

    private function translate($text)
    {
        if (!$text) return null;

        // Bản đồ dịch tạm (mock AI)
        $dictionary = [
            'Start Selling Product' => 'Bắt đầu bán sản phẩm',
            'Earn Money' => 'Kiếm tiền',
            'Track Stats' => 'Theo dõi thống kê',
            'Get latest news in your inbox' => 'Nhận thông tin mới nhất trong hộp thư',
            'About Us' => 'Về chúng tôi',
            'Privacy Policy' => 'Chính sách bảo mật',
            'Terms and Conditions' => 'Điều khoản sử dụng',
            'Top Selling WP Theme Of All Time' => 'Theme WP bán chạy nhất mọi thời đại',
            'New Product Weekly' => 'Sản phẩm mới mỗi tuần',
            'Fully Responsive' => 'Tương thích mọi thiết bị',
            'Check Out Our Newest Item' => 'Khám phá sản phẩm mới nhất',
            'All Categories' => 'Tất cả danh mục',
            'View All' => 'Xem tất cả'
        ];

        foreach ($dictionary as $en => $vi) {
            if (stripos($text, $en) !== false) {
                return str_ireplace($en, $vi, $text);
            }
        }

        return $text;
    }
}
