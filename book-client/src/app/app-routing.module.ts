import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { ErrorComponent } from './component/error/error.component';
import { BookListComponent } from './component/book-list/book-list.component';
import { AddBookComponent } from './component/add-book/add-book.component';

const routes: Routes = [
  {path: 'books/list', component: BookListComponent},
  {path: 'books/add', component: AddBookComponent},
  {path: '', redirectTo: 'books/list', pathMatch: 'full'},
  {path: '**', component: ErrorComponent},
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }