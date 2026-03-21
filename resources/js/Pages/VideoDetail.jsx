import React, { useState } from 'react';
import AppLayout from '../Components/AppLayout';
import { Head, Link, usePage } from '@inertiajs/react';
import { Heart, MessageCircle, Share2, Music, Flag, MoreHorizontal, Send, Bookmark, X } from 'lucide-react';
import { motion, AnimatePresence } from 'framer-motion';
import axios from 'axios';

export default function VideoDetail({ video }) {
    const { auth } = usePage().props;
    const [isLiked, setIsLiked] = useState(video.likes_exists || false);
    const [likesCount, setLikesCount] = useState(video.likes_count || 0);
    const [isFollowed, setIsFollowed] = useState(video.user.is_followed || false);
    const [isBookmarked, setIsBookmarked] = useState(video.bookmarks_exists || false);
    const [bookmarksCount, setBookmarksCount] = useState(video.bookmarks_count || 0);
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [commentText, setCommentText] = useState('');
    const [commentsCount, setCommentsCount] = useState(video.comments_count || 0);
    const [comments, setComments] = useState(video.comments || []);

    const toggleLike = async () => {
        try {
            const response = await axios.post(`/videos/${video.id}/like`);
            setIsLiked(response.data.liked);
            setLikesCount(response.data.likes_count);
        } catch (error) {
            console.error('Error toggling like', error);
        }
    };

    const toggleFollow = async () => {
        try {
            const response = await axios.post(`/users/${video.user.id}/follow`);
            setIsFollowed(response.data.following);
        } catch (error) {
            console.error('Error toggling follow', error);
        }
    };

    const toggleBookmark = async () => {
        try {
            const response = await axios.post(`/videos/${video.id}/bookmark`);
            setIsBookmarked(response.data.bookmarked);
            setBookmarksCount(response.data.bookmarks_count);
        } catch (error) {
            console.error('Error toggling bookmark', error);
        }
    };

    const handlePostComment = async () => {
        if (!commentText.trim() || isSubmitting) return;
        setIsSubmitting(true);
        try {
            const response = await axios.post(`/videos/${video.id}/comment`, {
                comment_text: commentText
            });
            setComments([response.data.comment, ...comments]);
            setCommentsCount(response.data.comments_count);
            setCommentText('');
        } catch (error) {
            console.error('Error posting comment', error);
        } finally {
            setIsSubmitting(false);
        }
    };

    return (
        <AppLayout>
            <Head title={`${video.caption} - AmazamaHub`} />

            <div className="flex flex-col lg:flex-row h-full bg-black">
                {/* Left: Video Player */}
                <div className="w-full lg:w-[65%] h-[60vh] lg:h-full bg-black relative flex items-center justify-center group overflow-hidden">
                    <video
                        src={video.video_url}
                        controls
                        autoPlay
                        loop
                        className="max-h-full max-w-full object-contain"
                    />
                    <Link href="/explore" className="absolute top-6 left-6 text-white hover:bg-white/10 p-2 rounded-full cursor-pointer transition">
                        <X size={28} />
                    </Link>
                </div>

                {/* Right: Info & Comments */}
                <div className="w-full lg:w-[35%] h-full bg-black lg:border-l border-gray-900 flex flex-col">
                    <div className="p-8 border-b border-gray-900 bg-gray-950/20">
                        <div className="flex items-center justify-between mb-8">
                            <Link href={`/profile/@${video.user.username}`} className="flex items-center space-x-4">
                                <div className="w-12 h-12 rounded-full overflow-hidden border border-primary/20 bg-gray-800">
                                    <img src={video.user.avatar || `https://ui-avatars.com/api/?name=${video.user.username}`} className="w-full h-full object-cover" />
                                </div>
                                <div className="space-y-0.5">
                                    <p className="font-black italic text-lg tracking-tight">@{video.user.username}</p>
                                    <p className="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{video.user.name}</p>
                                </div>
                            </Link>
                            {video.user.id !== auth.user.id && (
                                <button
                                    onClick={toggleFollow}
                                    className={`font-black px-6 py-2 rounded-lg text-sm transition transform hover:scale-105 active:scale-95 ${isFollowed ? 'bg-gray-800 text-white' : 'bg-primary text-black'}`}
                                >
                                    {isFollowed ? 'Following' : 'Follow'}
                                </button>
                            )}
                        </div>

                        <p className="text-sm font-medium leading-relaxed text-gray-200 mb-6">{video.caption}</p>

                        <div className="flex items-center space-x-2 text-primary font-black italic text-sm mb-6">
                            <Music size={16} />
                            <span>{video.music_name || 'Original Sound'}</span>
                        </div>

                        <div className="flex items-center justify-between">
                            <div className="flex space-x-6">
                                <div className="flex items-center space-x-2">
                                    <div
                                        onClick={toggleLike}
                                        className={`p-2.5 bg-gray-900 rounded-full cursor-pointer transition ${isLiked ? 'text-primary' : 'text-white hover:text-red-500'}`}
                                    >
                                        <Heart size={20} fill={isLiked ? 'currentColor' : 'none'} />
                                    </div>
                                    <span className="text-xs font-black italic">{Intl.NumberFormat('en-US', { notation: 'compact' }).format(likesCount)}</span>
                                </div>
                                <div className="flex items-center space-x-2">
                                    <div className="p-2.5 bg-gray-900 rounded-full text-white cursor-pointer hover:text-primary transition"><MessageCircle size={20} /></div>
                                    <span className="text-xs font-black italic">{Intl.NumberFormat('en-US', { notation: 'compact' }).format(commentsCount)}</span>
                                </div>
                                <div className="flex items-center space-x-2">
                                    <div
                                        onClick={toggleBookmark}
                                        className={`p-2.5 bg-gray-900 rounded-full cursor-pointer transition ${isBookmarked ? 'text-yellow-400' : 'text-white hover:text-yellow-400'}`}
                                    >
                                        <Bookmark size={20} fill={isBookmarked ? 'currentColor' : 'none'} />
                                    </div>
                                    <span className="text-xs font-black italic">{Intl.NumberFormat('en-US', { notation: 'compact' }).format(bookmarksCount)}</span>
                                </div>
                            </div>
                            <div className="p-2.5 bg-gray-900 rounded-full text-white cursor-pointer hover:text-primary transition"><Share2 size={20} /></div>
                        </div>
                    </div>

                    <div className="flex-1 overflow-y-auto p-6 space-y-8 custom-scrollbar bg-black/40">
                        {comments.length === 0 ? (
                            <div className="text-center py-20 opacity-30">
                                <MessageCircle size={48} className="mx-auto mb-4" />
                                <p className="text-xs font-black italic uppercase tracking-widest">No comments yet. Be the first!</p>
                            </div>
                        ) : (
                            comments.map((comment) => (
                                <div key={comment.id} className="flex space-x-4 group">
                                    <Link href={`/profile/@${comment.user.username}`} className="w-10 h-10 rounded-full overflow-hidden flex-shrink-0 bg-gray-900 border border-gray-800">
                                        <img src={comment.user.avatar || `https://ui-avatars.com/api/?name=${comment.user.username}`} className="w-full h-full object-cover" />
                                    </Link>
                                    <div className="flex-1 space-y-1">
                                        <div className="flex items-center justify-between">
                                            <p className="text-xs font-black italic text-gray-400 uppercase tracking-widest">@{comment.user.username}</p>
                                            <Heart size={14} className="text-gray-700 hover:text-red-500 cursor-pointer transition" />
                                        </div>
                                        <p className="text-sm font-medium text-gray-200">{comment.comment_text}</p>
                                        <div className="flex items-center space-x-4 pt-1">
                                            <span className="text-[10px] text-gray-600 font-bold truncate">Just now</span>
                                            <span className="text-[10px] text-gray-500 font-black cursor-pointer hover:underline">Reply</span>
                                        </div>
                                    </div>
                                </div>
                            ))
                        )}
                    </div>

                    {/* Input Area */}
                    <div className="p-6 border-t border-gray-900 bg-black">
                        <div className="relative">
                            <input
                                value={commentText}
                                onChange={(e) => setCommentText(e.target.value)}
                                onKeyDown={(e) => e.key === 'Enter' && handlePostComment()}
                                type="text"
                                placeholder="Add real comment..."
                                className="w-full bg-gray-900 border border-transparent focus:border-primary/50 py-4 px-6 pr-14 rounded-2xl text-sm font-medium transition"
                            />
                            <button
                                onClick={handlePostComment}
                                disabled={!commentText.trim() || isSubmitting}
                                className="absolute right-4 top-1/2 -translate-y-1/2 text-primary font-black italic px-2 py-1 hover:scale-110 active:scale-95 transition disabled:opacity-50"
                            >
                                {isSubmitting ? '...' : 'Post'}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
