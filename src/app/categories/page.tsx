"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import CategoriesPage from "@/pages/Categories";

export default function CategoriesPageComponent() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <CategoriesPage />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 