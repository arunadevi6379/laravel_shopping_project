<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;

class ProductsImport implements ToCollection
{
    /**
     * @param Collection $collection
     * @return void
     */
    public function collection(Collection $collection)
    {
        // Iterate through each row in the collection
        foreach ($collection as $index => $row) {
            // Skip the header row (index 0)
            if ($index == 0) {
                continue;
            }

            // Ensure each row has the necessary columns (name, price, quantity)
            if (count($row) < 7) { // Ensure there are at least 7 columns
                continue;
            }

            $name = isset($row[0]) ? $row[0] : '';  // Product Name (column index 0)
            $price = isset($row[1]) ? (float) $row[1] : 0.0;  // Price of the product (column index 1)
            $quantity = isset($row[2]) ? (int) $row[2] : 0;  // Quantity of the product (column index 2)
            $category = isset($row[3]) ? $row[3] : '';  // Category (column index 3)
            $description = isset($row[4]) ? $row[4] : '';  // Description (column index 4)
            $image = isset($row[5]) ? $row[5] : null;  // Image filename (optional) (column index 5)
            $rating = isset($row[6]) ? (float) $row[6] : 2.5;  // Rating (column index 6, default to 2.5 if missing)

            // Validate and cast price and quantity to the correct types
            $price = is_numeric($price) ? (float)$price : 0.0;  // Default price if invalid
            $quantity = is_numeric($quantity) ? (int)$quantity : 0;  // Default quantity if invalid

            // Ensure rating is a valid numeric value
            $rating = is_numeric($rating) ? (float)$rating : 2.5;  // Default rating if invalid

            // Insert the product into the 'products' table
            DB::table('products')->insert([
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'description' => $description,
                'category' => $category,
                'image' => $image,  // Ensure image is correctly inserted (null if missing)
                'rating' => $rating,  // Default rating if not provided
            ]);
}
}
}
