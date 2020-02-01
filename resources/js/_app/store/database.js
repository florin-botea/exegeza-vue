import VuexORM from '@vuex-orm/core';

import notifications from '@/_modules/notifications/_store';
import Notification from '@/models/Notification.js';

import comments from '@/_modules/comments/_store';
import Comment from '@/models/Comment.js';

import User from '@/models/User'

import DeletionRequest from '@/models/DeletionRequest'

import Reply from '@/models/Reply'
import replies from '@/_modules/replies/_store'

import Tag from '@/models/Tag'
import tags from '@/_modules/tags/_store'

const database = new VuexORM.Database();
database.register(Notification, notifications)
database.register(Comment, comments)
database.register(User)
database.register(DeletionRequest)
database.register(Reply, replies)
database.register(Tag, tags)

export default database;