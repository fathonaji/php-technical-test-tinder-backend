<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Person;
use App\Models\Interaction;
use App\Mail\PopularPersonMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class CheckPopularPeople extends Command
{
    protected $signature = 'people:check-popular';

    protected $description = 'Check if any person is liked by more than 50 unique users and send email';

    public function handle()
    {
        $popularPeople = Interaction::select('person_id', DB::raw('COUNT(DISTINCT user_id) as total_likes'))
            ->where('type', 'like')
            ->groupBy('person_id')
            ->having('total_likes', '>', 50)
            ->get();

        foreach ($popularPeople as $item) {
            $person = Person::find($item->person_id);

            if (!$person) {
                continue;
            }

            if ($person->like_alert_sent_at) {
                continue;
            }

            Mail::to('admin@example.com')->send(new PopularPersonMail($person));

            $person->like_alert_sent_at = now();
            $person->save();

            $this->info("Email sent for {$person->name}");
        }

        return 0;
    }
}
