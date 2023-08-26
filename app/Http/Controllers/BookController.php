<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

require_once app_path('Libraries/simple_html_dom.php');

class BookController extends Controller
{

    function frontEnd() {
        return view('frontEnd');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Book::orderBy('id', 'desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('books');
    }

    public function getBooks()
    {
        $books = Book::orderBy('id', 'desc')->get();

        return response()->json(['books' => $books]);
    }

    public function scrapeBooks()
    {
        $pageNumber = Book::orderBy('id', 'desc')->count();


        if ($pageNumber == 0) {
            $pageNumber = 0;
        } else {
            $pageNumber = ($pageNumber / 24) + 1;
        }

        $pageNumber = intval($pageNumber);

        $html = file_get_html('https://www.kotobati.com/section/%D8%B1%D9%88%D8%A7%D9%8A%D8%A7%D8%AA?page=' . $pageNumber);


        foreach ($html->find('.book-teaser') as $book) {

            $title = trim($book->find('.title a', 0)->plaintext);
            $checkTitleBook = Book::where('title', $title)->count();
            if ($checkTitleBook == 0) {
                $url = $book->find('.title a', 0)->href;
                $pageIn = file_get_html('https://www.kotobati.com' . $url);

                // book-p-info
                $author = trim($pageIn->find('.book-p-info', 0)->plaintext);
                $pages = trim($pageIn->find('.book-table-info span', 0)->plaintext);
                $size = trim($pageIn->find('.book-table-info span', 1)->plaintext);
                $download = trim($pageIn->find('.book-table-info span', 2)->plaintext);
                $reviews = trim($pageIn->find('.book-table-info span', 3)->plaintext);
                $reviewsMove = trim($pageIn->find('.book-table-info span', 4)->plaintext);
                $lang = trim($pageIn->find('.book-table-info p', 3)->plaintext);
                $urlRead = trim($pageIn->find('.read', 1));
                // Open Page Get PdfUrl
                $pageIn_2 = file_get_html('https://www.kotobati.com' . $urlRead);
                $pdf_url = $pageIn_2->find('iframe', 0)->src;


                // Insert To Database
                $storedBook = Book::create([
                    'title'         => $title,
                    'author'        => $author,
                    'pages'         => $pages,
                    'lang'          => $lang,
                    'size'          => $size,
                    'pdf_url'       => $pdf_url,
                    'download'      => $download,
                    'reviews'       => $reviews,
                    'reviewsMove'   => $reviewsMove,
                ]);
            }
        }
        return response()->json(['message' => 'Scraping completed successfully']);
    }
}
