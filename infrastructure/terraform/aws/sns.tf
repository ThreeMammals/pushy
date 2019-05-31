provider "aws" {
  region = "eu-west-1"
}

resource "aws_sns_topic" "PostUpdated" {
  name = "PostUpdated"
}

resource "aws_sns_topic" "Revision" {
  name = "Revision"
}

resource "aws_sns_topic" "PostDraft" {
  name = "PostDraft"
}

resource "aws_sns_topic" "PageUpdated" {
  name = "PageUpdated"
}

resource "aws_sns_topic" "PageDraft" {
  name = "PageDraft"
}

resource "aws_sns_topic" "MenuItemPublished" {
  name = "MenuItemPublished"
}

resource "aws_sns_topic" "FuturePageUpdated" {
  name = "FuturePageUpdated"
}

resource "aws_sns_topic" "FuturePostUpdated" {
  name = "FuturePostUpdated"
}

resource "aws_sns_topic" "UnknownPost" {
  name = "UnknownPost"
}

resource "aws_sns_topic" "PostTrashed" {
  name = "PostTrashed"
}

resource "aws_sns_topic" "PostRestored" {
  name = "PostRestored"
}

resource "aws_sns_topic" "PostDeleted" {
  name = "PostDeleted"
}

resource "aws_sns_topic" "CategoriesUpdated" {
  name = "CategoriesUpdated"
}

resource "aws_sns_topic" "MenuUpdated" {
  name = "MenuUpdated"
}

resource "aws_sns_topic" "MenuDeleted" {
  name = "MenuDeleted"
}

resource "aws_sns_topic" "MediaUploaded" {
  name = "MediaUploaded"
}

resource "aws_sns_topic" "AttachmentUploaded" {
  name = "AttachmentUploaded"
}

resource "aws_sns_topic" "AttachmentDeleted" {
  name = "AttachmentDeleted"
}

resource "aws_sns_topic" "AttachmentUpdated" {
  name = "AttachmentUpdated"
}

resource "aws_sns_topic" "PagePublished" {
  name = "PagePublished"
}

resource "aws_sns_topic" "PostMetaUpdated" {
  name = "PostMetaUpdated"
}

resource "aws_sns_topic" "TagsUpdated" {
  name = "TagsUpdated"
}

resource "aws_sns_topic" "OptionUpdated" {
  name = "OptionUpdated"
}
