+++
date = "2016-02-06T10:37:39-05:00"
title = "How a useless feature contribution taught me how to use Go forks"
excerpt = "I spend most of my days writing PHP. Because of that I am used to composer for dealing with dependency management, and using namespacing to encapuslate vendor packages. The advent of composer has made dealing with dependencies in PHP extremely easy, portable, and really takes any guess work out of contributing to an open source package. That was not my experience with Go."
tags = ["programming", "hugo", "go", "php", "javascript"]
categories = ["programming"]
+++
## What I'm used to
I spend most of my days writing PHP. Because of that I am used to [composer](http://www.getcomposer.org) for dealing with dependency management,
and using [namespacing ](http://php.net/manual/en/language.namespaces.rationale.php) to encapuslate vendor packages. The advent of composer 
has made dealing with dependencies in PHP extremely easy, portable, and really takes any guess work out of contributing to an open source package. That was not my experience with Go.

## Why
I rebuilt this site using Hugo, and added this blog. After a few days I thought it would be nice to add relative dates to my posts to be a little more informal. My first
thought was to use [moment.js](http://momentjs.com/) as I've used it in previous projects to parse the `data` attribute from a span, and display a relative
time using `moment().fromNow()`. It works pretty damn well, and I should have went with my gut. However, I decided it would be awesome to learn a little bit about Go, and try to contribute something to the [Hugo](http://gohugo.io) library. That's where I threw logic out of the window.

## Static == static
I should have realized right away, that realative dates wouldn't work with a static site generator. The relative date would only update when I pushed new 
updates, kind of useless. I wouldn't realize this until hours later when my buddy [Trevor](http://github.com/rican7) pointed it out, well past the point of humilitation.

## Writing Go
I asked Trevor if he knew of any realtive date packages for Go. He pointed me to [go-humanize](https://github.com/dustin/go-humanize) 
and I set out to implement it into Hugo. I added the code as a template function, wrote a test, and everything seemed fine. The tests passed as expected,
and all seemed great. Until I built the project into a binary.

My changes didn't seem to be making into the binary. I tinkered with my `$GOPATH` for a
while, and checked my Go configuration as defined in the [How to Write Go Code](https://golang.org/doc/code.html) guide. I could see the build time updating when I ran
`go version`, but when I ran `hugo` inside of my site's directory, it would throw an error about the missing function. I dealt with this for hours, trying
to figure out what was going on.

With me being so new to Go development, I assumed what I had done was wrong and would throw an error. 
![Hugo Error](/img/hugo-error.png)

I noticed the line: `ERROR: 2016/02/05 15:42:03 template.go:350`. So I updated template.go and added some extra spaces, rebuilt, and noticed the line number didn't change.

## The Real Problem
After working through this problem with Trevor, he stumbled on an [article](http://www.personal.psu.edu/bam49/notebook/gopath-github-fork/) where someone had this exact problem, and it was even with Hugo. As it turns out it was building the code that was in `~/go/src/github.com/spf13/hugo` rather than `~/go/src/github.com/doctorallen/hugo` like I would expect. It wasn't clear from verbose output, or really anything else that Go was going this.

As per the article mentioned above, the way to solve this is to do the work for a forked package in the `$GOPATH` that matches the upstream (original repository) path, rather than your fork.

## How I Solved The Problem
1. Clone the original respository into the correct Go path (in this case)
`$GOPATH/src/github.com/spf13/hugo`

2. Rename the origin remote to the upstream remote
```bash
git remote rename origin upstream
```

3. Add a new remote pointing at your fork
```bash
git remote add origin <your repo url>
```

Now you can fetch from your repository using `origin` as the remote, but because your code lives in the vendor's Go directory, the binary will build the dependencies from your code, rather than from an unexpected location.

If you run `git remote -v` you should see the original repository as upstream, and your fork as origin.

![Hugo Remotes](/img/hugo-remotes.png)