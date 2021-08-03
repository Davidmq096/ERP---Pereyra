# angular-directive-utils

A series of directives for Angular 2.x so you don't have to write them.

* [Installation](#installation)
* [Usage](#usage)
* [FAQ](#FAQ)

## Installation

First you need to install the npm module:

```sh
npm install angular-directive-utils --save
```

## Usage

#### 1. Import the `DirectiveUtilModule`:

It is advised you use: `DirectiveUtilModule.forRoot()`

```ts
import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';
import {HttpModule} from '@angular/http';
import {DirectiveUtilModule} from 'angular-directive-utils';

@NgModule({
    imports: [
        BrowserModule,
        HttpModule,
        DirectiveUtilModule.forRoot()
    ],
    bootstrap: [AppComponent]
})
export class AppModule { }
```


#### 4. Use the directives:

```html
<input type="text" class="your-class" formControlName="exampleText" lowercase> </input>
```

```html
<input type="text" class="your-class" formControlName="exampleText" uppercase> </input>
```

```html
<input type="text" class="your-class" formControlName="exampleText" input-mask="**/**/****"> </input>
```

## FAQ

#### The mask only takes *'s?

I'm still working on this, for now it is only formatted with * and any other character besides _ is allowed.

