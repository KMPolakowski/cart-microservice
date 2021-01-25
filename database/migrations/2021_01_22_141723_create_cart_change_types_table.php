<?php

use App\Models\CartChangeType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCartChangeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_change_types', function (Blueprint $table) {
            $table->id();
            $table->enum('type', CartChangeType::TYPES);
            $table->timestamps();
        });

        foreach (CartChangeType::TYPES as $typeName) {
            $type = new CartChangeType();
            $type->type = $typeName;
            $type->saveOrFail();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_change_types');
    }
}
