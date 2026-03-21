import React, { useRef, useState, useEffect } from 'react';
import { Heart, MessageCircle, Share2, Bookmark, Music2, Plus, CheckCircle2, Repeat } from 'lucide-react';
import { Link } from '@inertiajs/react';
import { motion, AnimatePresence } from 'framer-motion';
import axios from 'axios';

export default function VideoCard({ video }) {
    const videoRef = useRef(null);
    const [isPlaying, setIsPlaying] = useState(false);
    const [isLiked, setIsLiked] = useState(video.likes_exists || false);
    const [likesCount, setLikesCount] = useState(video.likes_count || 0);
    const [isFollowed, setIsFollowed] = useState(video.user.is_followed || false);
    const [isReposted, setIsReposted] = useState(video.reposts_exists || false);
    const [repostsCount, setRepostsCount] = useState(video.reposts_count || 0);
    const [isBookmarked, setIsBookmarked] = useState(video.bookmarks_exists || false);
    const [bookmarksCount, setBookmarksCount] = useState(video.bookmarks_count || 0);
    const [sharesCount, setSharesCount] = useState(video.shares_count || 0);
    const [commentsCount, setCommentsCount] = useState(video.comments_count || 0);

    const toggleFollow = async () => {
        try {
            const response = await axios.post(`/users/${video.user.id}/follow`);
            setIsFollowed(response.data.following);
        } catch (error) {
            console.error('Error toggling follow', error);
        }
    };

    const toggleRepost = async () => {
        try {
            const response = await axios.post(`/videos/${video.id}/repost`);
            setIsReposted(response.data.reposted);
            setRepostsCount(response.data.reposts_count);
        } catch (error) {
            console.error('Error toggling repost', error);
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

    const handleShare = async () => {
        const shareData = {
            title: 'AmazamaHub Video',
            text: video.caption,
            url: window.location.origin + `/v/${video.id}`,
        };

        try {
            if (navigator.share) {
                await navigator.share(shareData);
            } else {
                await navigator.clipboard.writeText(shareData.url);
                alert('Link copied to clipboard!');
            }
            const response = await axios.post(`/videos/${video.id}/share`);
            setSharesCount(response.data.shares_count);
        } catch (error) {
            console.error('Error sharing', error);
        }
    };
    const [showComments, setShowComments] = useState(false);
    const [comments, setComments] = useState([]);
    const [newComment, setNewComment] = useState('');
    const [isSubmitting, setIsSubmitting] = useState(false);

    const fetchComments = async () => {
        try {
            const response = await axios.get(`/videos/${video.id}/comments`);
            setComments(response.data.data);
        } catch (error) {
            console.error('Error fetching comments', error);
        }
    };

    const handlePostComment = async () => {
        if (!newComment.trim() || isSubmitting) return;
        setIsSubmitting(true);
        try {
            const response = await axios.post(`/videos/${video.id}/comment`, {
                comment_text: newComment
            });
            setComments([response.data.comment, ...comments]);
            setCommentsCount(response.data.comments_count);
            setNewComment('');
        } catch (error) {
            console.error('Error posting comment', error);
        } finally {
            setIsSubmitting(false);
        }
    };

    useEffect(() => {
        if (showComments) {
            fetchComments();
        }
    }, [showComments]);

    const toggleLike = async () => {
        try {
            const response = await axios.post(`/videos/${video.id}/like`);
            setIsLiked(response.data.liked);
            setLikesCount(response.data.likes_count);
        } catch (error) {
            console.error('Error toggling like', error);
        }
    };
    const [progress, setProgress] = useState(0);
    const [lastTap, setLastTap] = useState(0);
    const [showHeart, setShowHeart] = useState(null); // { x, y, id }

    const togglePlay = (e) => {
        // Handle double tap for like
        const now = Date.now();
        if (now - lastTap < 300) {
            handleDoubleTap(e);
            setLastTap(0);
            return;
        }
        setLastTap(now);

        if (videoRef.current.paused) {
            videoRef.current.play();
            setIsPlaying(true);
        } else {
            videoRef.current.pause();
            setIsPlaying(false);
        }
    };

    const handleDoubleTap = (e) => {
        const rect = e.currentTarget.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        if (!isLiked) {
            toggleLike();
        }
        
        const id = Math.random();
        setShowHeart({ x, y, id });

        setTimeout(() => {
            setShowHeart(prev => prev?.id === id ? null : prev);
        }, 1000);
    };

    const handleTimeUpdate = () => {
        if (videoRef.current) {
            const p = (videoRef.current.currentTime / videoRef.current.duration) * 100;
            setProgress(p);
        }
    };

    // Simple Intersection Observer to autoplay/pause video on scroll
    useEffect(() => {
        const options = { threshold: 0.6 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    videoRef.current?.play().catch(() => { });
                    setIsPlaying(true);
                } else {
                    videoRef.current?.pause();
                    setIsPlaying(false);
                }
            });
        }, options);

        if (videoRef.current) observer.observe(videoRef.current);
        return () => observer.disconnect();
    }, []);

    return (
        <div className="video-card bg-black border-b border-gray-900 md:border-none">
            <div className="relative w-full md:max-w-[420px] h-full md:h-[calc(100vh-100px)] md:my-4 md:rounded-xl overflow-hidden bg-gray-900 shadow-2xl group">
                {/* Real Video Component */}
                <video
                    ref={videoRef}
                    onClick={togglePlay}
                    onTimeUpdate={handleTimeUpdate}
                    loop
                    playsInline
                    className="w-full h-full object-cover cursor-pointer"
                    src={video.video_url}
                />

                {/* Double Tap Heart Animation */}
                <AnimatePresence>
                    {showHeart && (
                        <motion.div
                            key={showHeart.id}
                            initial={{ scale: 0, opacity: 0 }}
                            animate={{ scale: 1.5, opacity: 1 }}
                            exit={{ scale: 2, opacity: 0 }}
                            style={{ left: showHeart.x - 40, top: showHeart.y - 40 }}
                            className="absolute pointer-events-none z-50 text-primary"
                        >
                            <Heart fill="currentColor" size={80} />
                        </motion.div>
                    )}
                </AnimatePresence>

                {!isPlaying && (
                    <div className="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <motion.div
                            initial={{ scale: 0 }}
                            animate={{ scale: 1 }}
                            className="bg-black/20 p-6 rounded-full"
                        >
                            <div className="w-12 h-12 border-t-2 border-primary rounded-full animate-spin"></div>
                        </motion.div>
                    </div>
                )}

                {/* Bottom Left Info */}
                <div className="absolute bottom-4 left-4 right-16 space-y-3 z-10 text-white drop-shadow-lg">
                    <Link href={`/profile/@${video.user.username}`} className="block group/text">
                        <motion.h3
                            initial={{ opacity: 0, x: -20 }}
                            whileInView={{ opacity: 1, x: 0 }}
                            className="font-black italic text-lg hover:underline flex items-center tracking-tighter"
                        >
                            @{video.user.username}
                            {video.user.username === 'amazamahub_official' && (
                                <CheckCircle2 size={16} className="ml-1 text-cyan-400 fill-cyan-400/20" />
                            )}
                        </motion.h3>
                        <p className="text-sm font-medium line-clamp-2 pr-4">{video.caption}</p>
                    </Link>
                    <div className="flex items-center space-x-2 text-xs font-black italic tracking-tight truncate group/music">
                        <Music2 size={14} className="music-disc text-primary" />
                        <span className="hover:underline cursor-pointer">{video.music_name}</span>
                    </div>
                </div>

                {/* Right Sidebar Controls */}
                <div className="absolute bottom-8 right-2 flex flex-col items-center space-y-6 z-10">
                    {/* User Profile Info */}
                    <div className="relative mb-2">
                        <Link href={`/profile/@${video.user.username}`} className="w-12 h-12 rounded-full border-2 border-white overflow-hidden bg-gray-900 shadow-2xl hover:scale-105 transition-transform block">
                            <img src={video.user.avatar || `https://ui-avatars.com/api/?name=${video.user.username}&background=random`} className="w-full h-full object-cover" />
                        </Link>
                        <AnimatePresence>
                            {!isFollowed && (
                                <motion.button
                                    initial={{ scale: 0 }}
                                    animate={{ scale: 1 }}
                                    exit={{ scale: 0 }}
                                    onClick={toggleFollow}
                                    className="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-primary text-black rounded-full p-1.5 hover:scale-110 shadow-xl border-2 border-black"
                                >
                                    <Plus size={10} strokeWidth={4} />
                                </motion.button>
                            )}
                        </AnimatePresence>
                    </div>

                    {/* Like Button */}
                    <div className="flex flex-col items-center group cursor-pointer" onClick={toggleLike}>
                        <motion.div
                            animate={isLiked ? { scale: [1, 1.4, 1] } : {}}
                            className={`w-12 h-12 bg-gray-900/60 backdrop-blur-xl rounded-full flex items-center justify-center transition shadow-2xl ${isLiked ? 'text-primary' : 'text-white'}`}
                        >
                            <Heart size={26} fill={isLiked ? 'currentColor' : 'none'} strokeWidth={isLiked ? 0 : 2} />
                        </motion.div>
                        <span className="text-[10px] font-black mt-1 shadow-black text-white uppercase tracking-tighter">
                            {Intl.NumberFormat('en-US', { notation: 'compact' }).format(likesCount)}
                        </span>
                    </div>

                    {/* Comment Button */}
                    <div className="flex flex-col items-center group cursor-pointer" onClick={() => setShowComments(true)}>
                        <div className="w-12 h-12 bg-gray-900/60 backdrop-blur-xl rounded-full flex items-center justify-center text-white shadow-2xl transition group-hover:bg-gray-800/80">
                            <MessageCircle size={26} />
                        </div>
                        <span className="text-[10px] font-black mt-1 shadow-black text-white uppercase tracking-tighter">
                             {Intl.NumberFormat('en-US', { notation: 'compact' }).format(commentsCount)}
                        </span>
                    </div>

                    {/* Bookmark Button */}
                    <div className="flex flex-col items-center group cursor-pointer" onClick={toggleBookmark}>
                        <motion.div
                            animate={isBookmarked ? { scale: [1, 1.3, 1] } : {}}
                            className={`w-12 h-12 bg-gray-900/60 backdrop-blur-xl rounded-full flex items-center justify-center transition shadow-2xl ${isBookmarked ? 'text-yellow-400' : 'text-white'}`}
                        >
                            <Bookmark size={26} fill={isBookmarked ? 'currentColor' : 'none'} strokeWidth={isBookmarked ? 0 : 2} />
                        </motion.div>
                        <span className="text-[10px] font-black mt-1 shadow-black text-white uppercase tracking-tighter">
                            {Intl.NumberFormat('en-US', { notation: 'compact' }).format(bookmarksCount)}
                        </span>
                    </div>

                    {/* Repost Button */}
                    <div className="flex flex-col items-center group cursor-pointer" onClick={toggleRepost}>
                        <motion.div
                            animate={isReposted ? { rotate: [0, 180, 360] } : {}}
                            className={`w-12 h-12 bg-gray-900/60 backdrop-blur-xl rounded-full flex items-center justify-center transition shadow-2xl ${isReposted ? 'text-green-500' : 'text-white'}`}
                        >
                            <Repeat size={26} strokeWidth={isReposted ? 3 : 2} />
                        </motion.div>
                        <span className="text-[10px] font-black mt-1 shadow-black text-white uppercase tracking-tighter">
                            {Intl.NumberFormat('en-US', { notation: 'compact' }).format(repostsCount)}
                        </span>
                    </div>

                    {/* Share Button */}
                    <div className="flex flex-col items-center group cursor-pointer" onClick={handleShare}>
                        <div className="w-12 h-12 bg-gray-900/60 backdrop-blur-xl rounded-full flex items-center justify-center text-white shadow-2xl transition group-hover:bg-gray-800/80">
                            <Share2 size={26} />
                        </div>
                        <span className="text-[10px] font-black mt-1 shadow-black text-white uppercase tracking-tighter">
                            {Intl.NumberFormat('en-US', { notation: 'compact' }).format(sharesCount)}
                        </span>
                    </div>

                    {/* Music Disc Icon */}
                    <div className="mt-4">
                        <div className="w-12 h-12 p-2 bg-gray-800/40 backdrop-blur-md rounded-full overflow-hidden music-disc border border-gray-700">
                            <div className="w-full h-full rounded-full bg-gradient-to-tr from-gray-900 to-primary flex items-center justify-center">
                                <Music2 size={16} />
                            </div>
                        </div>
                    </div>
                </div>

                {/* Video Progress Bar */}
                <div className="absolute bottom-0 left-0 right-0 h-[2px] bg-white/20 z-20">
                    <motion.div
                        className="h-full bg-white opacity-60"
                        style={{ width: `${progress}%` }}
                    />
                </div>

                {/* Real-time Comment Modal */}
                <AnimatePresence>
                    {showComments && (
                        <div className="absolute inset-0 z-50 flex flex-col justify-end bg-black/40 backdrop-blur-sm" onClick={() => setShowComments(false)}>
                            <motion.div 
                                initial={{ y: '100%' }}
                                animate={{ y: 0 }}
                                exit={{ y: '100%' }}
                                onClick={(e) => e.stopPropagation()}
                                className="bg-gray-950 w-full h-[70vh] rounded-t-[40px] flex flex-col p-6 shadow-2xl border-t border-white/5"
                            >
                                <div className="flex items-center justify-between mb-6 px-2">
                                    <h3 className="text-sm font-black italic uppercase tracking-widest text-gray-400">
                                        {Intl.NumberFormat('en-US', { notation: 'compact' }).format(commentsCount)} Comments
                                    </h3>
                                    <button onClick={() => setShowComments(false)} className="p-2 bg-gray-900 rounded-full text-gray-400 hover:text-white transition">
                                        <Plus className="rotate-45" size={24} />
                                    </button>
                                </div>

                                <div className="flex-1 overflow-y-auto space-y-6 px-2 custom-scrollbar pb-24">
                                     {comments.length === 0 ? (
                                         <div className="flex flex-col items-center justify-center py-12 text-gray-700">
                                             <MessageCircle size={48} className="mb-4 opacity-20" />
                                             <p className="font-black italic uppercase tracking-widest text-xs">No comments yet</p>
                                             <p className="text-[10px] mt-1">Be the first to say something!</p>
                                         </div>
                                     ) : (
                                         comments.map((c, i) => (
                                             <div key={i} className="flex space-x-4">
                                                 <img src={c.user.avatar || `https://ui-avatars.com/api/?name=${c.user.username}`} className="w-10 h-10 rounded-full border border-gray-800" />
                                                 <div className="flex-1 space-y-1">
                                                     <p className="text-[10px] font-black text-gray-400 italic">@{c.user.username} <span className="font-medium text-gray-600 ml-2">Just now</span></p>
                                                     <p className="text-sm font-medium text-gray-100">{c.comment_text}</p>
                                                 </div>
                                             </div>
                                         ))
                                     )}
                                </div>

                                {/* Comment Input */}
                                <div className="absolute bottom-0 left-0 right-0 p-6 bg-gray-950 border-t border-white/5 flex items-center space-x-4">
                                     <div className="flex-1 bg-gray-900 rounded-2xl flex items-center px-4 border border-white/5 focus-within:border-primary/50 transition">
                                         <input 
                                             value={newComment}
                                             onChange={(e) => setNewComment(e.target.value)}
                                             onKeyDown={(e) => e.key === 'Enter' && handlePostComment()}
                                             placeholder="Add a real comment..." 
                                             className="bg-transparent border-none focus:ring-0 text-sm py-4 w-full"
                                         />
                                     </div>
                                     <button 
                                         onClick={handlePostComment}
                                         disabled={!newComment.trim() || isSubmitting}
                                         className="bg-primary text-black font-black italic px-6 py-4 rounded-2xl hover:scale-105 transition disabled:opacity-50"
                                     >
                                         {isSubmitting ? '...' : 'Post'}
                                     </button>
                                </div>
                            </motion.div>
                        </div>
                    )}
                </AnimatePresence>
            </div>
        </div>
    );
}
